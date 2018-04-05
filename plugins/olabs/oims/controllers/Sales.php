<?php

namespace Olabs\Oims\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Flash;
/**
 * Orders Back-end Controller
 */
class Sales extends Controller {

    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend\Behaviors\ReorderController',
        'Backend.Behaviors.RelationController',
    ];
    public $requiredPermissions = ['olabs.oims.sales'];
    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $reorderConfig = 'config_reorder.yaml';
    public $relationConfig = 'config_relation.yaml';

    protected $productFormWidget;
    
    public function __construct() {
        parent::__construct();

        BackendMenu::setContext('Olabs.Oims', 'master_register', 'stock_register');
        
        $this->productFormWidget = $this->createSalesProductFormWidget();
    }

    public function onLoadCreateProductForm()
    {
        $this->vars['productFormWidget'] = $this->productFormWidget;

        $this->vars['salesId'] = post('sales_id');

        return $this->makePartial('product_create_form');
    }

    public function onLoadUpdateProductForm() {
        $recordId = post('record_id');
        $this->vars['productFormWidget'] = $this->createSalesProductFormWidget($recordId);

        $this->vars['salesId'] = post('sales_id');
        $this->vars['recordId'] = $recordId;

        return $this->makePartial('product_update_form');
    }
    
    public function onCreateProduct()
    {
        $data = $this->productFormWidget->getSaveData();

        $model = new \Olabs\Oims\Models\SalesProduct;

        $model->fill($data);

        $model->save();

        $order = $this->getSalesModel();

//        $order->products()->add($model, $this->itemFormWidget->getSessionKey());
        $order->products()->add($model, $this->productFormWidget->getSessionKey());

        return $this->refreshSalesProductList();
    }

    public function onUpdateProduct() {
        $recordId = post('record_id');
        $data = $this->productFormWidget->getSaveData();
        
        $model = \Olabs\Oims\Models\SalesProduct::find($recordId);

        $model->fill($data);

        $model->save();
        
        return $this->refreshSalesProductList();
    }
    
    public function onDeleteProduct()
    {
        $recordId = post('record_id');

        $model = \Olabs\Oims\Models\SalesProduct::find($recordId);

        $order = $this->getSalesModel();

        $order->products()->remove($model, $this->productFormWidget->getSessionKey());

        return $this->refreshSalesProductList();
    }

    protected function refreshSalesProductList()
    {
        $products = $this->getSalesModel()
            ->products()
            ->withDeferred($this->productFormWidget->getSessionKey())
            ->get()
        ;

        $this->vars['items'] = $products;
        $this->vars['formContext'] = 'update';

        return ['#productList' => $this->makePartial('product_list')];
    }

    protected function getSalesModel()
    {
        $manageId = post('sales_id');

        $order = $manageId? \Olabs\Oims\Models\Sales::find($manageId) : new \Olabs\Oims\Models\Sales;

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
         $products = $this->getSalesModel()
            ->products()
            ->withDeferred($this->productFormWidget->getSessionKey())
            ->get()
        ;
         
        foreach ($products as $product){
            $product->sales_id = $model->id;
            $product->save();
        }
         
    }

    
    protected function createSalesProductFormWidget($recordId = 0)
    {
        $config = $this->makeConfig('$/olabs/oims/models/salesproduct/fields.yaml');

        $config->alias = 'salesProduct';

        $config->arrayName = 'SalesProduct';

        if($recordId){
            $config->model = \Olabs\Oims\Models\SalesProduct::find($recordId);
        }else{
            $config->model = new \Olabs\Oims\Models\SalesProduct;
        }

        $widget = $this->makeWidget('Backend\Widgets\Form', $config);

        $widget->bindToController();

        return $widget;
    }
    
    public function onSubmitForApproval(){
        $id = post('id');
        
        $model = \Olabs\Oims\Models\Sales::find($id);
        
        $model->comment = post('comment');
        
        $msg = $model->onSubmitForApproval();
        
        if($msg['s']){
            Flash::success($msg['m']);
            
            $redirectUrl = 'olabs/oims/sales/preview/'.$id;
            return Backend::redirect($redirectUrl);
            
        }else{
            Flash::warning($msg['m']);
        }
        
        return ["#object-status"=>$model->objectstatus->name];
    }
    
    public function onApproved(){
        $id = post('id');
        
        $model = \Olabs\Oims\Models\Sales::find($id);
        
        $model->comment = post('comment');
        
        $msg = $model->onApproved();
        
        if($msg['s']){
            Flash::success($msg['m']);
            
            $redirectUrl = 'olabs/oims/sales/preview/'.$id;
            return Backend::redirect($redirectUrl);
            
        }else{
            Flash::warning($msg['m']);
        }
        
        return ["#object-status"=>$model->objectstatus->name];
    }
    
    public function onRejected(){
        $id = post('id');
        
        $model = \Olabs\Oims\Models\Sales::find($id);
        
        $model->comment = post('comment');
        
        $msg = $model->onRejected();
        
        if($msg['s']){
            Flash::success($msg['m']);
            
            $redirectUrl = 'olabs/oims/sales/preview/'.$id;
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
    
}