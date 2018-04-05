<?php namespace Olabs\Oims\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Flash;

class ProjectProgress extends Controller
{
    public $implement = [
        'Backend\Behaviors\ListController',
        'Backend\Behaviors\FormController',
        'Backend\Behaviors\ReorderController',
        'Backend\Behaviors\RelationController',
        ];
    
        
    public $requiredPermissions = ['olabs.oims.projectprogress'];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $reorderConfig = 'config_reorder.yaml';
    public $relationConfig = 'config_relation.yaml';

    protected $productFormWidget;
    
    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Olabs.Oims', 'dpr_report', 'project_progress');
        
        $this->productFormWidget = $this->createProjectProgressProductFormWidget();
    }
    
    public function onLoadCreateProductForm()
    {
        $this->vars['productFormWidget'] = $this->productFormWidget;

        $this->vars['project_progress_id'] = post('project_progress_id');

        return $this->makePartial('product_create_form');
    }

    public function onLoadUpdateProductForm() {
        $recordId = post('record_id');
        $this->vars['productFormWidget'] = $this->createProjectProgressProductFormWidget($recordId);

        $this->vars['project_progress_id'] = post('project_progress_id');
        $this->vars['recordId'] = $recordId;

        return $this->makePartial('product_update_form');
    }

    
    public function onCreateProduct()
    {
        $data = $this->productFormWidget->getSaveData();

        $model = new \Olabs\Oims\Models\ProjectProgressItem;

        if(isset($data['project_id'])){
            unset($data['project_id']); // projecct id used only for project related work search
        }

        $model->fill($data);

        $model->save();

        $order = $this->getProjectProgressModel();

//        $order->products()->add($model, $this->itemFormWidget->getSessionKey());
        $order->products()->add($model, $this->productFormWidget->getSessionKey());

        return $this->refreshProjectProgressProductList();
    }
    
    public function onUpdateProduct() {
        $recordId = post('record_id');
        $data = $this->productFormWidget->getSaveData();
        
        if(isset($data['project_id'])){
            unset($data['project_id']); // projecct id used only for project related work search
        }

        $model = \Olabs\Oims\Models\ProjectProgressItem::find($recordId);

        $model->fill($data);

        $model->save();
        
        return $this->refreshProjectProgressProductList();
    }

    public function onDeleteProduct()
    {
        $recordId = post('record_id');

        $model = \Olabs\Oims\Models\ProjectProgressItem::find($recordId);

        $order = $this->getProjectProgressModel();

        $order->products()->remove($model, $this->productFormWidget->getSessionKey());

        return $this->refreshProjectProgressProductList();
    }

    protected function refreshProjectProgressProductList()
    {
        $products = $this->getProjectProgressModel()
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

    protected function getProjectProgressModel()
    {
        $manageId = post('project_progress_id');

        $order = $manageId? \Olabs\Oims\Models\ProjectProgress::find($manageId) : new \Olabs\Oims\Models\ProjectProgress;

        return $order;
    }
    

    
    protected function createProjectProgressProductFormWidget($recordId = 0)
    {
        $config = $this->makeConfig('$/olabs/oims/models/projectprogressitem/fields.yaml');

        $config->alias = 'projectProgressProduct';

        $config->arrayName = 'ProjectProgressProduct';

        if($recordId){
            $config->model = \Olabs\Oims\Models\ProjectProgressItem::find($recordId);
        }else{ 
            $config->model = new \Olabs\Oims\Models\ProjectProgressItem;
        }

        $postParams = post();
        $projectId = 0;
        if(isset($postParams['ProjectProgress']['project'])){
            $projectId = $postParams['ProjectProgress']['project']; // initialise at the time of form create
        }elseif (isset($postParams['ProjectProgressProduct']['project_id'])) {
            $projectId = $postParams['ProjectProgressProduct']['project_id']; // set at the time of record finder call
        }
        if($projectId){
            //Save search basic value in session
            \Session::put('projectProgress_ProjectId', $projectId);
        }
//         session(['key' => 'value']);
        $config->model->project_id = $projectId; // set the project id for ProjectProgressItem

        $widget = $this->makeWidget('Backend\Widgets\Form', $config);

        $widget->bindToController();

        return $widget;
    }
    
    public function onSubmitForApproval(){
        $id = post('id');
        
        $model = \Olabs\Oims\Models\ProjectProgress::find($id);
        
        $model->comment = post('comment');
        
        $msg = $model->onSubmitForApproval();
        
        if($msg['s']){
            Flash::success($msg['m']);
            
            $redirectUrl = 'olabs/oims/sales/projectprogress/'.$id;
            return Backend::redirect($redirectUrl);
            
        }else{
            Flash::warning($msg['m']);
        }
        
        return ["#object-status"=>$model->objectstatus->name];
    }
    
    public function onApproved(){
        $id = post('id');
        
        $model = \Olabs\Oims\Models\ProjectProgress::find($id);
        
        $model->comment = post('comment');
        
        $msg = $model->onApproved();
        
        if($msg['s']){
            Flash::success($msg['m']);
            
            $redirectUrl = 'olabs/oims/sales/projectprogress/'.$id;
            return Backend::redirect($redirectUrl);
            
        }else{
            Flash::warning($msg['m']);
        }
        
        return ["#object-status"=>$model->objectstatus->name];
    }
    
    public function onRejected(){
        $id = post('id');
        
        $model = \Olabs\Oims\Models\ProjectProgress::find($id);
        
        $model->comment = post('comment');
        
        $msg = $model->onRejected();
        
        if($msg['s']){
            Flash::success($msg['m']);
            
            $redirectUrl = 'olabs/oims/sales/projectprogress/'.$id;
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
    
    //handle back date entry :

    public function formExtendFields($form) {

        //Get if field have already value (EDIT MODE)
        $contextDate = isset($form->data->attributes['start_date']) ? $form->data->attributes['start_date'] : false;
        if ($form->removeField('start_date')) {


            // Handle context date field        
            if ($this->user->isAdmin() OR $this->user->hasAccess('olabs.oims.record_back_date_entry')) {
                //Is Admin OR have back Date date entry permission
                $form->addFields([
                    'start_date' => [
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
                        'start_date' => [
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
                } else if(!$contextDate){
                    $form->addFields([
                        'start_date' => [
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
                }else {
                    $form->addFields([
                        'start_date' => [
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