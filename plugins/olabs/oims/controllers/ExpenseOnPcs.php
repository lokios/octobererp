<?php

namespace Olabs\Oims\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Flash;
use Backend;

/**
 * Orders Back-end Controller
 */
class ExpenseOnPcs extends Controller {

    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend\Behaviors\ReorderController',
        'Backend.Behaviors.RelationController',
    ];
    public $requiredPermissions = ['olabs.oims.expenseonpcs'];
    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $reorderConfig = 'config_reorder.yaml';
    public $relationConfig = 'config_relation.yaml';
    protected $productFormWidget;

    public function __construct() {
        parent::__construct();

        BackendMenu::setContext('Olabs.Oims', 'dpr_report', 'expenseonpcs');

        $this->productFormWidget = $this->createExpenseOnPcProductFormWidget();
    }

    public function onAddWorkOrderProducts() {
        $this->vars['productFormWidget'] = $this->productFormWidget;

        $recordId = post('expense_on_pc_id');

        $this->vars['expenseOnPcId'] = $recordId;

        $data = post('ExpenseOnPc');

//        $model = $this->getExpenseOnPcModel();
//        $model->fill($data);

        $quote_id = $data['quote'];

        $quote_model = \Olabs\Oims\Models\Quote::find($quote_id);

//        Flash::error('Work Order not found! for ' . $quote_id);

        if ($quote_model) {

            foreach ($quote_model->products as $product) {

                $pc_product_model = new \Olabs\Oims\Models\ExpenseOnPcProduct;

                $pc_product_model->product = $product->product;
                $pc_product_model->quote_product_id = $product->id;
                $pc_product_model->unit_code = $product->unit_code;
                $pc_product_model->quantity = 1;
                $pc_product_model->unit_price = $product->unit_price;
                $pc_product_model->total_price = $pc_product_model->quantity * $pc_product_model->unit_price;

                $pc_product_model->save();

                $order = $this->getExpenseOnPcModel();

                $order->products()->add($pc_product_model, $this->productFormWidget->getSessionKey());
            }
            
            Flash::success('Work Order Items added.');
            
        } else {
            Flash::error('Work Order not found!');
        }

        return $this->refreshExpenseOnPcProductList();
    }

    public function onLoadCreateProductForm() {
        $this->vars['productFormWidget'] = $this->productFormWidget;

        $this->vars['expenseOnPcId'] = post('expense_on_pc_id');

        return $this->makePartial('product_create_form');
    }

    public function onLoadUpdateProductForm() {
        $recordId = post('record_id');
        $this->vars['productFormWidget'] = $this->createExpenseOnPcProductFormWidget($recordId);

        $this->vars['expenseOnPcId'] = post('expense_on_pc_id');
        $this->vars['recordId'] = $recordId;

        return $this->makePartial('product_update_form');
    }

    public function onCreateProduct() {
        $data = $this->productFormWidget->getSaveData();

        $model = new \Olabs\Oims\Models\ExpenseOnPcProduct;

        $model->fill($data);

        $model->save();

        $order = $this->getExpenseOnPcModel();

        $order->products()->add($model, $this->productFormWidget->getSessionKey());

        return $this->refreshExpenseOnPcProductList();
    }

    public function onUpdateProduct() {
        $recordId = post('record_id');
        $data = $this->productFormWidget->getSaveData();

        $model = \Olabs\Oims\Models\ExpenseOnPcProduct::find($recordId);

        $model->fill($data);

        $model->save();

        return $this->refreshExpenseOnPcProductList();
    }

    public function onDeleteProduct() {
        $recordId = post('record_id');

        $model = \Olabs\Oims\Models\ExpenseOnPcProduct::find($recordId);

        $order = $this->getExpenseOnPcModel();

        $order->products()->remove($model, $this->productFormWidget->getSessionKey());

        return $this->refreshExpenseOnPcProductList();
    }

    protected function refreshExpenseOnPcProductList() {
        $products = $this->getExpenseOnPcModel()
                ->products()
                ->withDeferred($this->productFormWidget->getSessionKey())
                ->get()
        ;

        $this->vars['items'] = $products;

        $total_price = 0;
        foreach ($products as $product) {
//            dd($product);
            $total_price += $product->total_price;
        }

        $this->vars['total_price'] = $total_price;
        $this->vars['formContext'] = 'update';

        return ['#productList' => $this->makePartial('product_list')];
    }

    protected function getExpenseOnPcModel() {
        $manageId = post('expense_on_pc_id');

        $order = $manageId ? \Olabs\Oims\Models\ExpenseOnPc::find($manageId) : new \Olabs\Oims\Models\ExpenseOnPc;

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
        $products = $this->getExpenseOnPcModel()
                ->products()
                ->withDeferred($this->productFormWidget->getSessionKey())
                ->get()
        ;

        foreach ($products as $product) {
            $product->expense_on_pc_id = $model->id;
            $product->save();
        }

        //$model->genereateInvoice();
    }

    protected function createExpenseOnPcProductFormWidget($recordId = 0) {
        $config = $this->makeConfig('$/olabs/oims/models/expenseonpcproduct/fields.yaml');

        $config->alias = 'expenseOnPcProduct';

        $config->arrayName = 'ExpenseOnPcProduct';

        if ($recordId) {
            $config->model = \Olabs\Oims\Models\ExpenseOnPcProduct::find($recordId);
        } else {
            $config->model = new \Olabs\Oims\Models\ExpenseOnPcProduct;
        }

        $widget = $this->makeWidget('Backend\Widgets\Form', $config);

        $widget->bindToController();

        return $widget;
    }

    public function onSubmitForApproval() {
        $id = post('id');

        $model = \Olabs\Oims\Models\ExpenseOnPc::find($id);

        $model->comment = post('comment');

        $msg = $model->onSubmitForApproval();

        if ($msg['s']) {
            Flash::success($msg['m']);

            $redirectUrl = 'olabs/oims/expenseonpcs/preview/' . $id;
            return Backend::redirect($redirectUrl);
        } else {
            Flash::warning($msg['m']);
        }

        return ["#object-status" => $model->objectstatus->name];
    }

    public function onApproved() {
        $id = post('id');

        $model = \Olabs\Oims\Models\ExpenseOnPc::find($id);

        $model->comment = post('comment');

        $msg = $model->onApproved();

        if ($msg['s']) {
            Flash::success($msg['m']);

            $redirectUrl = 'olabs/oims/expenseonpcs/preview/' . $id;
            return Backend::redirect($redirectUrl);
        } else {
            Flash::warning($msg['m']);
        }

        return ["#object-status" => $model->objectstatus->name];
    }

    public function onRejected() {
        $id = post('id');

        $model = \Olabs\Oims\Models\ExpenseOnPc::find($id);

        $model->comment = post('comment');

        $msg = $model->onRejected();

        if ($msg['s']) {
            Flash::success($msg['m']);

            $redirectUrl = 'olabs/oims/expenseonpcs/preview/' . $id;
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
        }
    }

    /**
     * Ajax handler for updating the form.
     * @param int $recordId The model primary key to update.
     * @return mixed
     */
    public function update_onSave($recordId) {

        $context = 'update';
        $result = $this->asExtension('FormController')->update_onSave($recordId, $context);
        //$model = \Olabs\Oims\Models\ExpenseOnPc::find($recordId);
        //$model->genereateInvoice();
        return $result;
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
                if ($contextDate && date('Y-m-d H:i:s', strtotime($contextDate)) >= date('Y-m-d 00:00:00', strtotime('today -1 days'))) {
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
                            'minDate' => 'today -1 days',
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
                            'minDate' => 'today -1 days',
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

}
