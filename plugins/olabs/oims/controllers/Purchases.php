<?php

namespace Olabs\Oims\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Flash;
use Log;
use Backend;
use Olabs\Oims\Models\Status;

/**
 * Orders Back-end Controller
 */
class Purchases extends Controller {

    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend\Behaviors\ReorderController',
        'Backend.Behaviors.RelationController',
    ];
    public $requiredPermissions = ['olabs.oims.purchases'];
    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $reorderConfig = 'config_reorder.yaml';
    public $relationConfig = 'config_relation.yaml';
    protected $productFormWidget;

    public function __construct() {
        parent::__construct();

        BackendMenu::setContext('Olabs.Oims', 'master_register', 'material_receipt');

        $this->productFormWidget = $this->createPurchaseProductFormWidget();
    }

    public function onAddWorkOrderProducts() {
        $this->vars['productFormWidget'] = $this->productFormWidget;

        $recordId = post('purchase_id');

        $this->vars['purchaseId'] = $recordId;

        $data = post('Purchase');

//        $model = $this->getPurchaseModel();
//        $model->fill($data);

        $quote_id = $data['quote'];

        $quote_model = \Olabs\Oims\Models\Quote::find($quote_id);

//        Flash::error('Work Order not found! for ' . $quote_id);

        if ($quote_model) {

            foreach ($quote_model->products as $product) {

                $pc_product_model = new \Olabs\Oims\Models\PurchaseProduct;

                $pc_product_model->product = $product->product;
                $pc_product_model->quote_product_id = $product->id;
                $pc_product_model->unit_code = $product->unit_code;
                $pc_product_model->quantity = $product->quantity;
                $pc_product_model->unit_price = $product->unit_price;
                $pc_product_model->total_price = $pc_product_model->quantity * $pc_product_model->unit_price;

                $pc_product_model->save();

                $order = $this->getPurchaseModel();

                $order->products()->add($pc_product_model, $this->productFormWidget->getSessionKey());
            }

            Flash::success('Work Order Items added.');
        } else {
            Flash::error('Work Order not found!');
        }

        return $this->refreshPurchaseProductList();
    }

    public function onLoadCreateProductForm() {
        $this->vars['productFormWidget'] = $this->productFormWidget;

        $this->vars['purchaseId'] = post('purchase_id');

        return $this->makePartial('product_create_form');
    }

    public function onLoadUpdateProductForm() {
        $recordId = post('record_id');
        $this->vars['productFormWidget'] = $this->createPurchaseProductFormWidget($recordId);

        $this->vars['purchaseId'] = post('purchase_id');
        $this->vars['recordId'] = $recordId;

        return $this->makePartial('product_update_form');
    }

    public function onCreateProduct() {
        $data = $this->productFormWidget->getSaveData();

        $model = new \Olabs\Oims\Models\PurchaseProduct;

        $model->fill($data);

        $model->save();

        $order = $this->getPurchaseModel();

//        $order->products()->add($model, $this->itemFormWidget->getSessionKey());
        $order->products()->add($model, $this->productFormWidget->getSessionKey());

        return $this->refreshPurchaseProductList();
    }

    public function onUpdateProduct() {
        $recordId = post('record_id');
        $data = $this->productFormWidget->getSaveData();

        $model = \Olabs\Oims\Models\PurchaseProduct::find($recordId);

        $model->fill($data);

        $model->save();

//        $order = $this->getPurchaseModel();
//
//        $order->products()->save($model, $this->productFormWidget->getSessionKey());

        return $this->refreshPurchaseProductList();
    }

    public function onDeleteProduct() {
        $recordId = post('record_id');

        $model = \Olabs\Oims\Models\PurchaseProduct::find($recordId);

        $order = $this->getPurchaseModel();

        $order->products()->remove($model, $this->productFormWidget->getSessionKey());

        return $this->refreshPurchaseProductList();
    }

    protected function refreshPurchaseProductList() {
        $products = $this->getPurchaseModel()
                ->products()
                ->withDeferred($this->productFormWidget->getSessionKey())
                ->get();

        $this->vars['items'] = $products;

        $total_price = 0;
        $total_tax = 0;
        foreach($products as $product){
//            dd($product);
            $total_price += $product->total_price;
            $total_tax += $product->total_tax;
        }
        
        $this->vars['total_price_without_tax'] = $total_price - $total_tax;
        $this->vars['total_tax'] = $total_tax;
        $this->vars['total_price'] = $total_price;
        
        $this->vars['formContext'] = 'update';
        

        return ['#productList' => $this->makePartial('product_list')];
    }

    protected function getPurchaseModel() {
        $manageId = post('purchase_id');

        $order = $manageId ? \Olabs\Oims\Models\Purchase::find($manageId) : new \Olabs\Oims\Models\Purchase;

        return $order;
    }

    /**
     * Extend supplied model used by create and update actions, the model can
     * be altered by overriding it in the controller.
     * @param Model $model
     * @return Model
     */
    public function formAfterCreate($model) {
//        dd($model->id);
        $products = $this->getPurchaseModel()
                ->products()
                ->withDeferred($this->productFormWidget->getSessionKey())
                ->get()
        ;

        foreach ($products as $product) {
            $product->purchase_id = $model->id;
            $product->save();
        }
        
        $model->recalculateAmounts();
        $model->updateProjectBookBalance();
        
        //$purchaseModel = \Olabs\Oims\Models\Purchase::find($manageId);
//        $model->genereateInvoice(); //Invoice is now generate on click
    }
    
        /**
     * Ajax handler for updating the form.
     * @param int $recordId The model primary key to update.
     * @return mixed
     */
    public function update_onSave($recordId) {

        $context = 'update';
        $result = $this->asExtension('FormController')->update_onSave($recordId, $context);
        $model = \Olabs\Oims\Models\Purchase::find($recordId);
        $model->recalculateAmounts();
        $model->updateProjectBookBalance();
        
//        $model->genereateInvoice();
        return $result;
    }


    protected function createPurchaseProductFormWidget($recordId = 0) {
        $config = $this->makeConfig('$/olabs/oims/models/purchaseproduct/fields.yaml');

        $config->alias = 'purchaseProduct';

        $config->arrayName = 'PurchaseProduct';

        if ($recordId) {
            $config->model = \Olabs\Oims\Models\PurchaseProduct::find($recordId);
        } else {
            $config->model = new \Olabs\Oims\Models\PurchaseProduct;
        }

        $widget = $this->makeWidget('Backend\Widgets\Form', $config);

        $widget->bindToController();

        return $widget;
    }

    public function onSubmitForApproval() {
        $id = post('id');

        $model = \Olabs\Oims\Models\Purchase::find($id);

        $model->comment = post('comment');

        $msg = $model->onSubmitForApproval();

        if ($msg['s']) {

            Flash::success($msg['m']);
            $redirectUrl = 'olabs/oims/purchases/preview/' . $id;
            return Backend::redirect($redirectUrl);
        } else {
            Flash::warning($msg['m']);
        }

        return ["#object-status" => $model->objectstatus->name];
    }

    public function onApproved() {
        $id = post('id');

        $model = \Olabs\Oims\Models\Purchase::find($id);

        $model->comment = post('comment');

        $msg = $model->onApproved();

        if ($msg['s']) {
            Flash::success($msg['m']);

            $redirectUrl = 'olabs/oims/purchases/preview/' . $id;
            return Backend::redirect($redirectUrl);
        } else {
            Flash::warning($msg['m']);
        }

        return ["#object-status" => $model->objectstatus->name];
    }

    public function onRejected() {
        $id = post('id');

        $model = \Olabs\Oims\Models\Purchase::find($id);

        $model->comment = post('comment');

        $msg = $model->onRejected();

        if ($msg['s']) {
            Flash::success($msg['m']);

            $redirectUrl = 'olabs/oims/purchases/preview/' . $id;
            return Backend::redirect($redirectUrl);
        } else {
            Flash::warning($msg['m']);
        }

        return ["#object-status" => $model->objectstatus->name];
    }

    public function onSubmitForHOApproval() {
        $id = post('id');

        $model = \Olabs\Oims\Models\Purchase::find($id);

        $model->comment = post('comment');

        $msg = $model->onSubmitForHOApproval();

        if ($msg['s']) {

            Flash::success($msg['m']);
            $redirectUrl = 'olabs/oims/purchases/preview/' . $id;
            return Backend::redirect($redirectUrl);
        } else {
            Flash::warning($msg['m']);
        }

        return ["#object-status" => $model->objectstatus->name];
    }

    public function onHOApproved() {
        $id = post('id');

        $model = \Olabs\Oims\Models\Purchase::find($id);

        $model->comment = post('comment');

        $msg = $model->onHOApproved();

        if ($msg['s']) {
            Flash::success($msg['m']);

            $redirectUrl = 'olabs/oims/purchases/preview/' . $id;
            return Backend::redirect($redirectUrl);
        } else {
            Flash::warning($msg['m']);
        }

        return ["#object-status" => $model->objectstatus->name];
    }

    public function onHORejected() {
        $id = post('id');

        $model = \Olabs\Oims\Models\Purchase::find($id);

        $model->comment = post('comment');

        $msg = $model->onHORejected();

        if ($msg['s']) {
            Flash::success($msg['m']);

            $redirectUrl = 'olabs/oims/purchases/preview/' . $id;
            return Backend::redirect($redirectUrl);
        } else {
            Flash::warning($msg['m']);
        }

        return ["#object-status" => $model->objectstatus->name];
    }

    //Extend user list by associated project list
    public function listExtendQuery($query, $scope) {

        if (!$this->user->isAdmin()) {
            $baseModel = new \Olabs\Oims\Models\BaseModel();
            $assigned_projects = $baseModel->getProjectOptions();
            $query->whereIn('project_id', array_keys($assigned_projects));
            
            $status = [];
            
            //Show lists for only actionable items
            if($this->user->hasAccess('olabs.oims.record_submit_for_approval')){
//                $query->whereIn('status', [Status::STATUS_SUBMITTED, Status::STATUS_APPROVED, Status::STATUS_REJECTED, Status::STATUS_HO_REJECTED]);
                
//                $query->whereIn('status', [Status::STATUS_NEW,  Status::STATUS_REJECTED]);
                $status[] =  Status::STATUS_NEW;
                $status[] =  Status::STATUS_REJECTED;
            }
            
            if($this->user->hasAccess('olabs.oims.record_approval')){
//                $query->whereIn('status', [Status::STATUS_SUBMITTED, Status::STATUS_APPROVED, Status::STATUS_REJECTED, Status::STATUS_HO_REJECTED]);
                
//                $query->whereIn('status', [Status::STATUS_SUBMITTED,  Status::STATUS_HO_REJECTED]);
                $status[] =  Status::STATUS_SUBMITTED;
                $status[] =  Status::STATUS_HO_REJECTED;
            }
            
            if($this->user->hasAccess('olabs.oims.record_ho_approval')){
//                $query->whereIn('status', [Status::STATUS_APPROVED, Status::STATUS_HO_SUBMITTED, Status::STATUS_HO_APPROVED]);
                $status[] =  Status::STATUS_APPROVED;
                $status[] =  Status::STATUS_HO_SUBMITTED;
                $status[] =  Status::STATUS_HO_APPROVED;
            }
            
//            $query->whereIn('status', $status);
            
        }
    }

    public function update($recordId = null, $context = null) {
        parent::update($recordId, $context);
        //check if form is editable
        $model = \Olabs\Oims\Models\Purchase::find($recordId);
        if (!$model->isEditable()) {
            Flash::warning('You are not permitted for update record!');
//            redirect('purchases');
            $redirectUrl = 'olabs/oims/purchases'; // . $id;
            return Backend::redirect($redirectUrl);
        }
//        var_dump();exit();
    }


    //handle back date entry :

    public function formExtendFields($form) {

        //Get if field have already value (EDIT MODE)
        $contextDate = isset($form->data->attributes['context_date']) ? $form->data->attributes['context_date'] : false;
        if ($form->removeField('context_date')) {


            // Handle context date field        
            if ($this->user->isAdmin() OR $this->user->hasAccess('olabs.oims.record_back_date_entry')) {
                //Is Admin OR have back Date date entry permission
                $form->addFields([
                    'context_date' => [
                        'label' => 'Date',
                        'oc.commentPosition' => '',
                        'mode' => 'date',
                        'span' => 'auto',
                        'format' => 'd/m/Y',
                        'required' => 1,
                        'type' => 'datepicker',
                        'default' => 'today',
                        'attributes' => [
                        ]
                    ]
                ]);
            } else {
                //Dont have back date entry permission
                if ($contextDate && date('Y-m-d H:i:s', strtotime($contextDate)) >= date('Y-m-d 00:00:00', strtotime('today'))) {
                    //Make Readonly
                    $form->addFields([
                        'context_date' => [
                            'label' => 'Date',
                            'oc.commentPosition' => '',
                            'mode' => 'date',
                            'span' => 'auto',
                            'default' => 'today',
                            'format' => 'd/m/Y',
                            'required' => 1,
                            'type' => 'datepicker',
                            'minDate' => 'today',
                            'attributes' => [
                            ]
                        ]
                    ]);
                } else if (!$contextDate) {
                    $form->addFields([
                        'context_date' => [
                            'label' => 'Date',
                            'oc.commentPosition' => '',
                            'mode' => 'date',
                            'span' => 'auto',
                            'default' => 'today',
                            'format' => 'd/m/Y',
                            'required' => 1,
                            'type' => 'datepicker',
                            'minDate' => 'today',
                            'attributes' => [
                            ]
                        ]
                    ]);
                } else {
                    $form->addFields([
                        'context_date' => [
                            'label' => 'Date',
                            'oc.commentPosition' => '',
                            'mode' => 'date',
                            'span' => 'auto',
                            'default' => 'today',
                            'format' => 'd/m/Y',
                            'required' => 1,
                            'type' => 'datepicker',
                            'attributes' => [
                                'disabled' => true,
                            ]
                        ]
                    ]);
                }
            }
        }
    }
    
    public function onSyncMobileData($record_id) {
        $status = "";
        $model = new \Olabs\Social\Models\EntityRelations();

//        if($id){
//        $record = \Olabs\Social\Models\EntityRelations::whereIn('target_type', array(\Olabs\Social\Models\EntityRelations::TARGET_TYPE_ATTENDANCE, \Olabs\Social\Models\EntityRelations::TARGET_TYPE_MR_ENTRY, \Olabs\Social\Models\EntityRelations::TARGET_TYPE_VOUCHERS))
//                        ->where('status', \Olabs\Social\Models\EntityRelations::STATUS_LIVE)->where('id', $record_id)->first();
//        $record = \Olabs\Social\Models\EntityRelations::whereIn('target_type', array(\Olabs\Social\Models\EntityRelations::TARGET_TYPE_ATTENDANCE, \Olabs\Social\Models\EntityRelations::TARGET_TYPE_MR_ENTRY, \Olabs\Social\Models\EntityRelations::TARGET_TYPE_VOUCHERS))
//                        ->whereIn('status', array(\Olabs\Social\Models\EntityRelations::STATUS_LIVE, \Olabs\Social\Models\EntityRelations::STATUS_DONE))->where('id', $record_id)->first();
        $record = \Olabs\Social\Models\EntityRelations::where('target_id', $record_id)->where('target_type', \Olabs\Social\Models\EntityRelations::TARGET_TYPE_MR_ENTRY)->first();
        if ($record) {
            $status = $model->SyncDataRecord($record);
            Flash::success('Recored Synced.');
//        echo $status;
            return ["#object-status" => "Record Synced. Kindly reload the page."];
        }else{
            Flash::success('Recored not found.');
            return ["#object-status" => "Record not found."];
        }
        
        
    }

    public function download_invoice($id) {
//        $id = get('id');

        $model = \Olabs\Oims\Models\Purchase::find($id);

        $fileName = $model->genereateInvoice(true);

//        dd($fileName);
        return \Redirect::to('/backend/olabs/oims/reports/downloadPdf?name=' . $fileName);
    }

}
