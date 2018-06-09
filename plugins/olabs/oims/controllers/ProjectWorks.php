<?php namespace Olabs\Oims\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class ProjectWorks extends Controller
{
    public $implement = [
        'Backend\Behaviors\ListController',
        'Backend\Behaviors\FormController',
        'Backend\Behaviors\ReorderController',
        'Backend.Behaviors.RelationController',
        ];
    
    protected $productFormWidget;
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $reorderConfig = 'config_reorder.yaml';
    public $relationConfig = 'config_relation.yaml';

    public $requiredPermissions = ['olabs.oims.projectworks'];
    
    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Olabs.Oims', 'oims_projects', 'project_works');
        $this->productFormWidget = $this->createProjectWorkProductFormWidget();
    }
    
    
    public function onLoadCreateProductForm()
    {
        $this->vars['productFormWidget'] = $this->productFormWidget;

        $this->vars['project_work_id'] = post('project_work_id');

        return $this->makePartial('product_create_form');
    }

    public function onLoadUpdateProductForm() {
        $recordId = post('record_id');
        $this->vars['productFormWidget'] = $this->createProjectWorkProductFormWidget($recordId);

        $this->vars['project_work_id'] = post('project_work_id');
        $this->vars['recordId'] = $recordId;

        return $this->makePartial('product_update_form');
    }

    
    public function onCreateProduct()
    {
        $data = $this->productFormWidget->getSaveData();

        $model = new \Olabs\Oims\Models\ProjectWorkProduct;

        $model->fill($data);
//dd($model);
        $model->save();
        
        $order = $this->getProjectWorkModel();

//        $order->products()->add($model, $this->itemFormWidget->getSessionKey());
        $order->products()->add($model, $this->productFormWidget->getSessionKey());

        return $this->refreshProjectWorkProductList();
    }
    
    public function onUpdateProduct() {
        $recordId = post('record_id');
        $data = $this->productFormWidget->getSaveData();

        $model = \Olabs\Oims\Models\ProjectWorkProduct::find($recordId);

        $model->fill($data);

        $model->save();

//
//        $order->products()->add($model, $this->productFormWidget->getSessionKey());

        return $this->refreshProjectWorkProductList();
    }
    
    public function onDeleteProduct()
    {
        $recordId = post('record_id');

        $model = \Olabs\Oims\Models\ProjectWorkProduct::find($recordId);

        $order = $this->getProjectWorkModel();

        $order->products()->remove($model, $this->productFormWidget->getSessionKey());

        return $this->refreshProjectWorkProductList();
    }

    protected function refreshProjectWorkProductList()
    {
        $products = $this->getProjectWorkModel()
            ->products()
            ->withDeferred($this->productFormWidget->getSessionKey())
            ->get()
        ;

        $this->vars['items'] = $products;
        $this->vars['formContext'] = 'update';

        return ['#productList' => $this->makePartial('product_list')];
    }

    protected function getProjectWorkModel()
    {
        $manageId = post('project_work_id');

        $order = $manageId? \Olabs\Oims\Models\ProjectWork::find($manageId) : new \Olabs\Oims\Models\ProjectWork;

        return $order;
    }
    

    
    protected function createProjectWorkProductFormWidget($recordId = 0)
    {
        $config = $this->makeConfig('$/olabs/oims/models/projectworkproduct/fields.yaml');

        $config->alias = 'projectWorkProduct';

        $config->arrayName = 'projectWorkProduct';

//        $config->model = new \Olabs\Oims\Models\ProjectWorkProduct;
        if ($recordId) {
            $config->model = \Olabs\Oims\Models\ProjectWorkProduct::find($recordId);
        } else {
            $config->model = new \Olabs\Oims\Models\ProjectWorkProduct;
        }

        $postParams = post();
        $project_work_quantity = 0;
        if(isset($postParams['ProjectWork']['quantity'])){
            $project_work_quantity = $postParams['ProjectWork']['quantity']; // initialise at the time of form create
        }
//        elseif (isset($postParams['ProjectProgressProduct']['project_id'])) {
//            $project_work_quantity = $postParams['ProjectProgressProduct']['project_id']; // set at the time of record finder call
//        }
        if($project_work_quantity){
            //Save search basic value in session
            \Session::put('projectWork_quantity', $project_work_quantity);
        }
//         session(['key' => 'value']);
        $config->model->project_work_quantity = $project_work_quantity; // set the work quantity for ProjectWorkProduct
        
        
        $widget = $this->makeWidget('Backend\Widgets\Form', $config);

        $widget->bindToController();

        return $widget;
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