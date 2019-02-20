<?php

namespace Olabs\Oims\Controllers;

use BackendMenu;
use Backend;
use Backend\Classes\Controller;
use Flash;
/**
 * Orders Back-end Controller
 */
class ExpenseOnMaterials extends Controller {

    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend\Behaviors\ReorderController',
        'Backend.Behaviors.RelationController',
    ];
    public $requiredPermissions = ['olabs.oims.expenseonmaterials'];
    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $reorderConfig = 'config_reorder.yaml';
    public $relationConfig = 'config_relation.yaml';

    protected $productFormWidget;
    
    public function __construct() {
        parent::__construct();

        BackendMenu::setContext('Olabs.Oims', 'projectprogress', 'expenseonmaterials');
        
        $this->productFormWidget = $this->createExpenseOnMaterialProductFormWidget();
    }

    public function onLoadCreateProductForm()
    {
        $this->vars['productFormWidget'] = $this->productFormWidget;

        $this->vars['expenseOnMaterialId'] = post('expense_on_material_id');

        return $this->makePartial('product_create_form');
    }

    public function onLoadUpdateProductForm() {
        $recordId = post('record_id');
        $this->vars['productFormWidget'] = $this->createExpenseOnMaterialProductFormWidget($recordId);

        $this->vars['expenseOnMaterialId'] = post('expense_on_material_id');
        $this->vars['recordId'] = $recordId;

        return $this->makePartial('product_update_form');
    }
    
    public function onCreateProduct()
    {
        $data = $this->productFormWidget->getSaveData();

        $model = new \Olabs\Oims\Models\ExpenseOnMaterialProduct;

        $model->fill($data);

        $model->save();

        $order = $this->getExpenseOnMaterialModel();

//        $order->products()->add($model, $this->itemFormWidget->getSessionKey());
        $order->products()->add($model, $this->productFormWidget->getSessionKey());

        return $this->refreshExpenseOnMaterialProductList();
    }

    public function onUpdateProduct() {
        $recordId = post('record_id');
        $data = $this->productFormWidget->getSaveData();
        
        $model = \Olabs\Oims\Models\ExpenseOnMaterialProduct::find($recordId);

        $model->fill($data);

        $model->save();
        
        return $this->refreshExpenseOnMaterialProductList();
    }
    
    public function onDeleteProduct()
    {
        $recordId = post('record_id');

        $model = \Olabs\Oims\Models\ExpenseOnMaterialProduct::find($recordId);

        $order = $this->getExpenseOnMaterialModel();

        $order->products()->remove($model, $this->productFormWidget->getSessionKey());

        return $this->refreshExpenseOnMaterialProductList();
    }

    protected function refreshExpenseOnMaterialProductList()
    {
        $products = $this->getExpenseOnMaterialModel()
            ->products()
            ->withDeferred($this->productFormWidget->getSessionKey())
            ->get()
        ;

        $this->vars['items'] = $products;
        
        $total_price = 0;
        foreach($products as $product){
//            dd($product);
            $total_price += $product->total_price;
        }
        
        $this->vars['total_price'] = $total_price;
        $this->vars['formContext'] = 'update';

        return ['#productList' => $this->makePartial('product_list')];
    }

    protected function getExpenseOnMaterialModel()
    {
        $manageId = post('expense_on_material_id');

        $order = $manageId? \Olabs\Oims\Models\ExpenseOnMaterial::find($manageId) : new \Olabs\Oims\Models\ExpenseOnMaterial;

        return $order;
    }
    
   /**
     * Extend supplied model used by create and update actions, the model can
     * be altered by overriding it in the controller.
     * @param Model $model
     * @return Model
     */
    public function formAfterCreate($model)
    {
//        dd($model->id);
         $products = $this->getExpenseOnMaterialModel()
            ->products()
            ->withDeferred($this->productFormWidget->getSessionKey())
            ->get()
        ;
         
        foreach ($products as $product){
            $product->expense_on_material_id = $model->id;
            $product->save();
        }
         
        //$model->genereateInvoice();
                 
    }

    

    
    protected function createExpenseOnMaterialProductFormWidget($recordId = 0)
    {
        $config = $this->makeConfig('$/olabs/oims/models/expenseonmaterialproduct/fields.yaml');

        $config->alias = 'expenseOnMaterialProduct';

        $config->arrayName = 'ExpenseOnMaterialProduct';

        if($recordId){
            $config->model = \Olabs\Oims\Models\ExpenseOnMaterialProduct::find($recordId);
        }else{
            $config->model = new \Olabs\Oims\Models\ExpenseOnMaterialProduct;
        }
 
        $widget = $this->makeWidget('Backend\Widgets\Form', $config);

        $widget->bindToController();

        return $widget;
    }
    
    public function onSubmitForApproval(){
        $id = post('id');
        
        $model = \Olabs\Oims\Models\ExpenseOnMaterial::find($id);
        
        $model->comment = post('comment');
        
        $msg = $model->onSubmitForApproval();
        
        if($msg['s']){
            Flash::success($msg['m']);
            
            $redirectUrl = 'olabs/oims/expenseonmaterials/preview/'.$id;
            return Backend::redirect($redirectUrl);
            
        }else{
            Flash::warning($msg['m']);
        }
        
        return ["#object-status"=>$model->objectstatus->name];
    }
    
    public function onApproved(){
        $id = post('id');
        
        $model = \Olabs\Oims\Models\ExpenseOnMaterial::find($id);
        
        $model->comment = post('comment');
        
        $msg = $model->onApproved();
        
        if($msg['s']){
            Flash::success($msg['m']);
            
            $redirectUrl = 'olabs/oims/expenseonmaterials/preview/'.$id;
            return Backend::redirect($redirectUrl);
            
        }else{
            Flash::warning($msg['m']);
        }
        
        return ["#object-status"=>$model->objectstatus->name];
    }
    
    public function onRejected(){
        $id = post('id');
        
        $model = \Olabs\Oims\Models\ExpenseOnMaterial::find($id);
        
        $model->comment = post('comment');
        
        $msg = $model->onRejected();
        
        if($msg['s']){
            Flash::success($msg['m']);
            
            $redirectUrl = 'olabs/oims/expenseonmaterials/preview/'.$id;
            return Backend::redirect($redirectUrl);
            
        }else{
            Flash::warning($msg['m']);
        }
        
        return ["#object-status"=>$model->objectstatus->name];
    }
    
    //Extend user list by associated project list
    public function listExtendQuery($query, $scope)
    {
        
        if(!$this->user->isAdmin()){
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

    public function update_onSave($recordId)
    {
 
       $context = 'update';
       $result = $this->asExtension('FormController')->update_onSave($recordId, $context);
       //$model = \Olabs\Oims\Models\ExpenseOnMaterial::find($recordId);
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
                if ($contextDate && date('Y-m-d H:i:s',strtotime($contextDate)) >= date('Y-m-d 00:00:00', strtotime('today -1 days'))) {
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
                }else if(!$contextDate){
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