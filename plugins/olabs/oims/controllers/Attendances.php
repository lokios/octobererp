<?php namespace Olabs\Oims\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Attendances extends Controller
{
     public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend\Behaviors\ReorderController',
        'Backend.Behaviors.RelationController',
    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $reorderConfig = 'config_reorder.yaml';
    public $relationConfig = 'config_relation.yaml';

    public $requiredPermissions = ['olabs.oims.attendances'];
    
    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Olabs.Oims', 'master_register', 'attendances');
    }
    
    //Extend user list by associated project list
    public function listExtendQuery($query, $scope) {

        if (!$this->user->isAdmin()) {
            $baseModel = new \Olabs\Oims\Models\BaseModel();
            $assigned_projects = $baseModel->getProjectOptions();
            $query->whereIn('project_id', array_keys($assigned_projects));
        }
    }
    
    
    //handle back date entry :

    public function formExtendFields($form) {

        //Get if field have already value (EDIT MODE)
        $checkOutDate = isset($form->data->attributes['check_out']) ? $form->data->attributes['check_out'] : false;
        if ($form->removeField('check_out')) {
            // Handle check in date field        
            if ($this->user->isAdmin() OR $this->user->hasAccess('olabs.oims.record_back_date_entry')) {
                //Is Admin OR have back Date date entry permission
                $form->addFields([
                    'check_out' => [
                        'label' => 'Check Out Date',
                        'oc.commentPosition' => '',
                        'mode' => 'datetime',
                        'span' => 'auto',
                        'format' => 'd/m/Y',
                        'required' => 1,
                        'type' => 'datepicker',
                        'default' => 'today + 18 hours',
                        'attributes' => [
                        ]
                    ]
                ]);
            } else {
                //Dont have back date entry permission
                //&& date('Y-m-d',strtotime($checkOutDate)) == date('Y-m-d', strtotime('today'))
                 if ($checkOutDate && date('Y-m-d H:i:s',strtotime($checkOutDate)) >= date('Y-m-d 00:00:00', strtotime('today'))) {
                    //Make Readonly
                    $form->addFields([
                        'check_out' => [
                            'label' => 'Check Out Date',
                            'oc.commentPosition' => '',
                            'mode' => 'datetime',
                            'span' => 'auto',
                            'default' => 'today + 18 hours',
                            'format' => 'd/m/Y',
                            'required' => 1,
                            'type' => 'datepicker',
                            'minDate' => 'today',
                            'attributes' => [
                            ]
                        ]
                    ]);
                }else if(!$checkOutDate){
                    //Make Readonly
                    $form->addFields([
                        'check_out' => [
                            'label' => 'Check Out Date',
                            'oc.commentPosition' => '',
                            'mode' => 'datetime',
                            'span' => 'auto',
                            'default' => 'today + 18 hours',
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
                        'check_out' => [
                            'label' => 'Check Out Date',
                            'oc.commentPosition' => '',
                            'mode' => 'datetime',
                            'span' => 'auto',
                            'default' => 'today + 18 hours',
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
        
        //Get if field have already value (EDIT MODE)
        $checkInDate = isset($form->data->attributes['check_in']) ? $form->data->attributes['check_in'] : false;
        if ($form->removeField('check_in')) {
            // Handle check in date field        
            if ($this->user->isAdmin() OR $this->user->hasAccess('olabs.oims.record_back_date_entry')) {
                //Is Admin OR have back Date date entry permission
                $form->addFields([
                    'check_in' => [
                        'label' => 'Check In Date',
                        'oc.commentPosition' => '',
                        'mode' => 'datetime',
                        'span' => 'auto',
                        'format' => 'd/m/Y',
                        'required' => 1,
                        'type' => 'datepicker',
                        'default' => 'today + 9 hours',
                        'comment' => "Deafult working hour is 09:00 to 18:00",
                        'attributes' => [
                        ]
                    ]
                ]);
            } else {
                //Dont have back date entry permission
                //date('Y-m-d',strtotime($checkInDate)) == date('Y-m-d', strtotime('today'))
//                var_dump(date('Y-m-d 00:00:00', strtotime('today')));
//                var_dump(date('Y-m-d H:i:s',strtotime($checkInDate)));
//                exit();
                if ($checkInDate && date('Y-m-d H:i:s',strtotime($checkInDate)) >= date('Y-m-d 00:00:00', strtotime('today'))) {
                    //Make Readonly
                    $form->addFields([
                        'check_in' => [
                            'label' => 'Check In Date',
                            'oc.commentPosition' => '',
                            'mode' => 'datetime',
                            'span' => 'auto',
                            'default' => 'today + 9 hours',
                            'format' => 'd/m/Y',
                            'required' => 1,
                            'type' => 'datepicker',
                            'minDate' => 'today',
                            'comment' => "Deafult working hour is 09:00 to 18:00",
                            'attributes' => [
                            ]
                        ]
                    ]);
                }else if(!$checkInDate){
                    //Make Readonly
                    $form->addFields([
                        'check_in' => [
                            'label' => 'Check In Date',
                            'oc.commentPosition' => '',
                            'mode' => 'datetime',
                            'span' => 'auto',
                            'default' => 'today + 9 hours',
                            'format' => 'd/m/Y',
                            'required' => 1,
                            'type' => 'datepicker',
                            'minDate' => 'today',
                            'comment' => "Deafult working hour is 09:00 to 18:00",
                            'attributes' => [
                            ]
                        ]
                    ]);
                } else {
                    $form->addFields([
                        'check_in' => [
                            'label' => 'Check In Date',
                            'oc.commentPosition' => '',
                            'mode' => 'datetime',
                            'span' => 'auto',
                            'default' => 'today + 9 hours',
                            'format' => 'd/m/Y',
                            'required' => 1,
                            'type' => 'datepicker',
                            'comment' => "Deafult working hour is 09:00 to 18:00",
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