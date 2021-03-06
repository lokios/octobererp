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
class Vouchers extends Controller {

    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend\Behaviors\ReorderController',
        'Backend.Behaviors.RelationController',
    ];
    public $requiredPermissions = ['olabs.oims.vouchers'];
    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $reorderConfig = 'config_reorder.yaml';
    public $relationConfig = 'config_relation.yaml';
    protected $productFormWidget;

    public function __construct() {
        parent::__construct();

        BackendMenu::setContext('Olabs.Oims', 'master_register', 'vouchers');

        $this->productFormWidget = $this->createVoucherProductFormWidget();
    }

//    public function onAddWorkOrderProducts() {
//        $this->vars['productFormWidget'] = $this->productFormWidget;
//
//        $recordId = post('voucher_id');
//
//        $this->vars['voucherId'] = $recordId;
//
//        $data = post('Voucher');
//
////        $model = $this->getVoucherModel();
////        $model->fill($data);
//
//        $quote_id = $data['quote'];
//
//        $quote_model = \Olabs\Oims\Models\Quote::find($quote_id);
//
////        Flash::error('Work Order not found! for ' . $quote_id);
//
//        if ($quote_model) {
//
//            foreach ($quote_model->products as $product) {
//
//                $pc_product_model = new \Olabs\Oims\Models\VoucherProduct;
//
//                $pc_product_model->product = $product->product;
//                $pc_product_model->quote_product_id = $product->id;
//                $pc_product_model->unit_code = $product->unit_code;
//                $pc_product_model->quantity = $product->quantity;
//                $pc_product_model->unit_price = $product->unit_price;
//                $pc_product_model->total_price = $pc_product_model->quantity * $pc_product_model->unit_price;
//
//                $pc_product_model->save();
//
//                $order = $this->getVoucherModel();
//
//                $order->products()->add($pc_product_model, $this->productFormWidget->getSessionKey());
//            }
//
//            Flash::success('Work Order Items added.');
//        } else {
//            Flash::error('Work Order not found!');
//        }
//
//        return $this->refreshVoucherProductList();
//    }

    public function onLoadCreateProductForm() {
        $this->vars['productFormWidget'] = $this->productFormWidget;

        $this->vars['voucherId'] = post('voucher_id');

        return $this->makePartial('product_create_form');
    }

    public function onLoadUpdateProductForm() {
        $recordId = post('record_id');
        $this->vars['productFormWidget'] = $this->createVoucherProductFormWidget($recordId);

        $this->vars['voucherId'] = post('voucher_id');
        $this->vars['recordId'] = $recordId;

        return $this->makePartial('product_update_form');
    }

    public function onCreateProduct() {
        $data = $this->productFormWidget->getSaveData();

        $model = new \Olabs\Oims\Models\VoucherProduct;

        $model->fill($data);

        $model->save();

        $order = $this->getVoucherModel();

//        $order->products()->add($model, $this->itemFormWidget->getSessionKey());
        $order->products()->add($model, $this->productFormWidget->getSessionKey());

        return $this->refreshVoucherProductList();
    }

    public function onUpdateProduct() {
        $recordId = post('record_id');
        $data = $this->productFormWidget->getSaveData();

        $model = \Olabs\Oims\Models\VoucherProduct::find($recordId);

        $model->fill($data);

        $model->save();

//        $order = $this->getVoucherModel();
//
//        $order->products()->save($model, $this->productFormWidget->getSessionKey());

        return $this->refreshVoucherProductList();
    }

    public function onDeleteProduct() {
        $recordId = post('record_id');

        $model = \Olabs\Oims\Models\VoucherProduct::find($recordId);

        $order = $this->getVoucherModel();

        $order->products()->remove($model, $this->productFormWidget->getSessionKey());

        return $this->refreshVoucherProductList();
    }

    protected function refreshVoucherProductList() {
        $products = $this->getVoucherModel()
                ->products()
                ->withDeferred($this->productFormWidget->getSessionKey())
                ->get();

        $this->vars['items'] = $products;

        $total_price = 0;
        foreach ($products as $product) {
//            dd($product);
            $total_price += $product->total_price;
        }
        $this->vars['formContext'] = 'update';
        $this->vars['total_price'] = $total_price;

        return ['#productList' => $this->makePartial('product_list')];
    }

    protected function getVoucherModel() {
        $manageId = post('voucher_id');

        $order = $manageId ? \Olabs\Oims\Models\Voucher::find($manageId) : new \Olabs\Oims\Models\Voucher;

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
        $products = $this->getVoucherModel()
                ->products()
                ->withDeferred($this->productFormWidget->getSessionKey())
                ->get()
        ;

        foreach ($products as $product) {
            $product->voucher_id = $model->id;
            $product->save();
        }

        //$voucherModel = \Olabs\Oims\Models\Voucher::find($manageId);
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
        $model = \Olabs\Oims\Models\Voucher::find($recordId);
//        $model->genereateInvoice();
        return $result;
    }


    protected function createVoucherProductFormWidget($recordId = 0) {
        $config = $this->makeConfig('$/olabs/oims/models/voucherproduct/fields.yaml');

        $config->alias = 'voucherProduct';

        $config->arrayName = 'VoucherProduct';

        if ($recordId) {
            $config->model = \Olabs\Oims\Models\VoucherProduct::find($recordId);
        } else {
            $config->model = new \Olabs\Oims\Models\VoucherProduct;
        }

        $widget = $this->makeWidget('Backend\Widgets\Form', $config);

        $widget->bindToController();

        return $widget;
    }

    public function onSubmitForApproval() {
        $id = post('id');

        $model = \Olabs\Oims\Models\Voucher::find($id);

        $model->comment = post('comment');

        $msg = $model->onSubmitForApproval();

        if ($msg['s']) {

            Flash::success($msg['m']);
            $redirectUrl = 'olabs/oims/vouchers/preview/' . $id;
            return Backend::redirect($redirectUrl);
        } else {
            Flash::warning($msg['m']);
        }

        return ["#object-status" => $model->objectstatus->name];
    }

    public function onApproved() {
        $id = post('id');

        $model = \Olabs\Oims\Models\Voucher::find($id);

        $model->comment = post('comment');

        $msg = $model->onApproved();

        if ($msg['s']) {
            Flash::success($msg['m']);

            $redirectUrl = 'olabs/oims/vouchers/preview/' . $id;
            return Backend::redirect($redirectUrl);
        } else {
            Flash::warning($msg['m']);
        }

        return ["#object-status" => $model->objectstatus->name];
    }

    public function onRejected() {
        $id = post('id');

        $model = \Olabs\Oims\Models\Voucher::find($id);

        $model->comment = post('comment');

        $msg = $model->onRejected();

        if ($msg['s']) {
            Flash::success($msg['m']);

            $redirectUrl = 'olabs/oims/vouchers/preview/' . $id;
            return Backend::redirect($redirectUrl);
        } else {
            Flash::warning($msg['m']);
        }

        return ["#object-status" => $model->objectstatus->name];
    }

    public function onSubmitForHOApproval() {
        $id = post('id');

        $model = \Olabs\Oims\Models\Voucher::find($id);

        $model->comment = post('comment');

        $msg = $model->onSubmitForHOApproval();

        if ($msg['s']) {

            Flash::success($msg['m']);
            $redirectUrl = 'olabs/oims/vouchers/preview/' . $id;
            return Backend::redirect($redirectUrl);
        } else {
            Flash::warning($msg['m']);
        }

        return ["#object-status" => $model->objectstatus->name];
    }

    public function onHOApproved() {
        $id = post('id');

        $model = \Olabs\Oims\Models\Voucher::find($id);

        $model->comment = post('comment');

        $msg = $model->onHOApproved();

        if ($msg['s']) {
            Flash::success($msg['m']);

            $redirectUrl = 'olabs/oims/vouchers/preview/' . $id;
            return Backend::redirect($redirectUrl);
        } else {
            Flash::warning($msg['m']);
        }

        return ["#object-status" => $model->objectstatus->name];
    }

    public function onHORejected() {
        $id = post('id');

        $model = \Olabs\Oims\Models\Voucher::find($id);

        $model->comment = post('comment');

        $msg = $model->onHORejected();

        if ($msg['s']) {
            Flash::success($msg['m']);

            $redirectUrl = 'olabs/oims/vouchers/preview/' . $id;
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
            
            //Show lists for only actionable items
            if($this->user->hasAccess('olabs.oims.record_submit_for_approval')){
//                $query->whereIn('status', [Status::STATUS_SUBMITTED, Status::STATUS_APPROVED, Status::STATUS_REJECTED, Status::STATUS_HO_REJECTED]);
                $query->whereIn('status', [Status::STATUS_NEW,  Status::STATUS_REJECTED]);
            }
            
            if($this->user->hasAccess('olabs.oims.record_approval')){
//                $query->whereIn('status', [Status::STATUS_SUBMITTED, Status::STATUS_APPROVED, Status::STATUS_REJECTED, Status::STATUS_HO_REJECTED]);
                $query->whereIn('status', [Status::STATUS_SUBMITTED,  Status::STATUS_HO_REJECTED]);
            }
            
            if($this->user->hasAccess('olabs.oims.record_ho_approval')){
                $query->whereIn('status', [Status::STATUS_APPROVED, Status::STATUS_HO_SUBMITTED, Status::STATUS_HO_APPROVED]);
            }
            
        }
    }

    public function update($recordId = null, $context = null) {
        parent::update($recordId, $context);
        //check if form is editable
        $model = \Olabs\Oims\Models\Voucher::find($recordId);
        if (!$model->isEditable()) {
            Flash::warning('You are not permitted for update record!');
//            redirect('vouchers');
            $redirectUrl = 'olabs/oims/vouchers'; // . $id;
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

    public function download_invoice($id) {
//        $id = get('id');

        $model = \Olabs\Oims\Models\Voucher::find($id);

        $fileName = $model->genereateInvoice(true);

//        dd($fileName);
        return \Redirect::to('/backend/olabs/oims/reports/downloadPdf?name=' . $fileName);
    }

}
