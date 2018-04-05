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
class PCAttendances extends Controller {

    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend\Behaviors\ReorderController',
        'Backend.Behaviors.RelationController',
    ];
    public $requiredPermissions = ['olabs.oims.pc_attendances'];
    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $reorderConfig = 'config_reorder.yaml';
    public $relationConfig = 'config_relation.yaml';

    protected $productFormWidget;
    
    public function __construct() {
        parent::__construct();

        BackendMenu::setContext('Olabs.Oims', 'master_register', 'pc_attendances');
        
        $this->productFormWidget = $this->createPCAttendanceDetailFormWidget();
    }

    public function onLoadCreateProductForm()
    {
        $this->vars['productFormWidget'] = $this->productFormWidget;

        $this->vars['attendanceId'] = post('attendance_id');

        return $this->makePartial('product_create_form');
    }

    public function onLoadUpdateProductForm() {
        $recordId = post('record_id');
        $this->vars['productFormWidget'] = $this->createPCAttendanceDetailFormWidget($recordId);

        $this->vars['attendanceId'] = post('attendance_id');
        $this->vars['recordId'] = $recordId;

        return $this->makePartial('product_update_form');
    }
    
    public function onCreateProduct()
    {
        $data = $this->productFormWidget->getSaveData();
        
        $model = new \Olabs\Oims\Models\PCAttendanceDetail;
//        dd($data);
        $model->fill($data);
        $model->calculateWages();
//        dd($data);
        $model->save();
        
        $order = $this->getPCAttendanceModel();

//        $order->products()->add($model, $this->itemFormWidget->getSessionKey());
        $order->products()->add($model, $this->productFormWidget->getSessionKey());

        return $this->refreshPCAttendanceDetailList();
    }

    public function onUpdateProduct() {
        $recordId = post('record_id');
        $data = $this->productFormWidget->getSaveData();
        
        $model = \Olabs\Oims\Models\PCAttendanceDetail::find($recordId);

        $model->fill($data);
        $model->calculateWages();
        $model->save();
        
        return $this->refreshPCAttendanceDetailList();
    }
    
    public function onDeleteProduct()
    {
        $recordId = post('record_id');

        $model = \Olabs\Oims\Models\PCAttendanceDetail::find($recordId);

        $order = $this->getPCAttendanceModel();

        $order->products()->remove($model, $this->productFormWidget->getSessionKey());

        return $this->refreshPCAttendanceDetailList();
    }

    protected function refreshPCAttendanceDetailList()
    {
        $products = $this->getPCAttendanceModel()
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

    protected function getPCAttendanceModel()
    {
        $manageId = post('attendance_id');

        $order = $manageId? \Olabs\Oims\Models\PCAttendance::find($manageId) : new \Olabs\Oims\Models\PCAttendance;

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
         $products = $this->getPCAttendanceModel()
            ->products()
            ->withDeferred($this->productFormWidget->getSessionKey())
            ->get()
        ;
         
        foreach ($products as $product){
            $product->attendance_id = $model->id;
            $product->save();
        }
         
    }

    
    protected function createPCAttendanceDetailFormWidget($recordId = 0)
    {
        $config = $this->makeConfig('$/olabs/oims/models/pcattendancedetail/fields.yaml');

        $config->alias = 'pcAttendanceDetail';

        $config->arrayName = 'PCAttendanceDetail';

        if($recordId){
            $config->model = \Olabs\Oims\Models\PCAttendanceDetail::find($recordId);
        }else{
            $config->model = new \Olabs\Oims\Models\PCAttendanceDetail;
        }

        $widget = $this->makeWidget('Backend\Widgets\Form', $config);

        $widget->bindToController();

        return $widget;
    }
    
    public function onSubmitForApproval(){
        $id = post('id');
        
        $model = \Olabs\Oims\Models\PCAttendance::find($id);
        
        $model->comment = post('comment');
        
        $msg = $model->onSubmitForApproval();
        
        if($msg['s']){
            Flash::success($msg['m']);
            
            $redirectUrl = 'olabs/oims/pcattendances/preview/'.$id;
            return Backend::redirect($redirectUrl);
            
        }else{
            Flash::warning($msg['m']);
        }
        
        return ["#object-status"=>$model->objectstatus->name];
    }
    
    public function onApproved(){
        $id = post('id');
        
        $model = \Olabs\Oims\Models\PCAttendance::find($id);
        
        $model->comment = post('comment');
        
        $msg = $model->onApproved();
        
        if($msg['s']){
            Flash::success($msg['m']);
            
            $redirectUrl = 'olabs/oims/pcattendances/preview/'.$id;
            return Backend::redirect($redirectUrl);
            
        }else{
            Flash::warning($msg['m']);
        }
        
        return ["#object-status"=>$model->objectstatus->name];
    }
    
    public function onRejected(){
        $id = post('id');
        
        $model = \Olabs\Oims\Models\PCAttendance::find($id);
        
        $model->comment = post('comment');
        
        $msg = $model->onRejected();
        
        if($msg['s']){
            Flash::success($msg['m']);
            
            $redirectUrl = 'olabs/oims/pcattendances/preview/'.$id;
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