<?php

namespace Olabs\Oims\Classes;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Backend\Classes\Controller;
use DateTime;
use Flash;
use Log;
use App;
use Db;
use Olabs\Oims\Classes\FusionCharts;
use Olabs\Oims\Classes\GanttCharts;

class ReportHelper extends Controller {
    /*     * *****************Download Actions**************************** */

    public function downloadPdf() {
        // Here we can make use of the download response
        $file_name = get('name');
        return \Response::download(temp_path($file_name . '.pdf'));
    }

    public function download() {
        // Here we can make use of the download response
        $file_name = get('name');
//        return \Response::download(temp_path($file_name));
        return \Response::download(storage_path('app') . '/' . $file_name);
    }

    /*     * *****************Define Search Forms************************* */

    protected function createDPRSearchFormWidget() {
        $config = $this->makeConfig('$/olabs/oims/models/report/dpr_search_fields.yaml');

        $config->alias = 'dprSearch';

        $config->arrayName = 'DprSearch';

        $config->model = new \Olabs\Oims\Models\Manpower;

        $widget = $this->makeWidget('Backend\Widgets\Form', $config);

        $widget->bindToController();

        return $widget;
    }

    protected function createMRSearchFormWidget() {
        $config = $this->makeConfig('$/olabs/oims/models/report/mr_search_fields.yaml');

        $config->alias = 'reportSearch';

        $config->arrayName = 'reportSearch';

        $config->model = new \Olabs\Oims\Models\Manpower;

        $widget = $this->makeWidget('Backend\Widgets\Form', $config);

        $widget->bindToController();

        return $widget;
    }

    protected function createAssetsSearchFormWidget() {
        $config = $this->makeConfig('$/olabs/oims/models/report/assets_search_fields.yaml');

        $config->alias = 'reportSearch';

        $config->arrayName = 'reportSearch';

        $config->model = new \Olabs\Oims\Models\Manpower;

        $widget = $this->makeWidget('Backend\Widgets\Form', $config);

        $widget->bindToController();

        return $widget;
    }

    protected function createAttendanceSearchFormWidget() {
        $config = $this->makeConfig('$/olabs/oims/models/report/attendance_search_fields.yaml');

        $config->alias = 'reportSearch';

        $config->arrayName = 'reportSearch';

        $config->model = new \Olabs\Oims\Models\Manpower;

        $widget = $this->makeWidget('Backend\Widgets\Form', $config);

        $widget->bindToController();

        return $widget;
    }

    protected function createAttendanceSummarySearchFormWidget() {
        $config = $this->makeConfig('$/olabs/oims/models/report/attendance_summary_search_fields.yaml');

        $config->alias = 'reportSearch';

        $config->arrayName = 'reportSearch';

        $config->model = new \Olabs\Oims\Models\Manpower;

        $widget = $this->makeWidget('Backend\Widgets\Form', $config);

        $widget->bindToController();

        return $widget;
    }

    protected function createMaterialSearchFormWidget() {
        $config = $this->makeConfig('$/olabs/oims/models/report/material_search_fields.yaml');

        $config->alias = 'reportSearch';

        $config->arrayName = 'reportSearch';

        $config->model = new \Olabs\Oims\Models\Manpower;

        $widget = $this->makeWidget('Backend\Widgets\Form', $config);

        $widget->bindToController();

        return $widget;
    }

    protected function createTransactionSearchFormWidget() {
        $config = $this->makeConfig('$/olabs/oims/models/report/transaction_search_fields.yaml');

        $config->alias = 'reportSearch';

        $config->arrayName = 'reportSearch';

        $config->model = new \Olabs\Oims\Models\Manpower;

        $widget = $this->makeWidget('Backend\Widgets\Form', $config);

        $widget->bindToController();

        return $widget;
    }

    protected function createProjectPlanSearchFormWidget() {
        $config = $this->makeConfig('$/olabs/oims/models/report/project_plan_search_fields.yaml');

        $config->alias = 'reportSearch';

        $config->arrayName = 'reportSearch';

        $config->model = new \Olabs\Oims\Models\Manpower;

        $widget = $this->makeWidget('Backend\Widgets\Form', $config);

        $widget->bindToController();

        return $widget;
    }

    /*     * *******************Search Filters************************** */

    protected function searchDPR($searchParams) {

        $projectprogress = array();
        $manpowers = array();
        $machineries = array();
        $expenseOnMaterials = array();
        $expenseOnPcs = array();
        $total_days = 0;


        $search_from_date = isset($searchParams['from_date']) ? $searchParams['from_date'] : '';
        $search_to_date = isset($searchParams['to_date']) ? $searchParams['to_date'] : '';

        $from_date = false;
        if ($search_from_date != '') {
            $from_date = \Olabs\Oims\Models\Settings::convertToDBDate($search_from_date); //date('Y-m-d 00:00:00', strtotime($from_date));
        }

        $to_date = false;
        if ($search_to_date != '') {
            $timeFormat = '23:59:59';
            $to_date = \Olabs\Oims\Models\Settings::convertToDBDate($search_to_date, $timeFormat);
        }

        $project = ( trim($searchParams['project']) != "" ) ? $searchParams['project'] : false;

        $baseModel = new \Olabs\Oims\Models\BaseModel();
        $assigned_projects = $baseModel->getProjectOptions();

        $params = array();
        if ($project) {
            $params['project_id'] = $project;
        }

        $projectModal = \Olabs\Oims\Models\Project::find($project);
        $this->vars['fix_expense'] = $projectModal['fix_expense'];



        if ($from_date && $to_date) {
            $datetime1 = new DateTime($from_date);
            $datetime2 = new DateTime($to_date);
            $interval = $datetime1->diff($datetime2);
            $total_days = $interval->format('%d') + 1; //to add current date 
            //$criteria->addBetweenCondition('date_modified', $params->from_date, $params->to_date);
            if (count($params)) {
                $projectprogress = \Olabs\Oims\Models\ProjectProgress::where($params)
                        ->whereBetween('start_date', [$from_date, $to_date])
                        ->get();
                $manpowers = \Olabs\Oims\Models\Manpower::where($params)
                        ->whereBetween('context_date', [$from_date, $to_date])
                        ->get();
                $machineries = \Olabs\Oims\Models\Machinery::where($params)
                        ->whereBetween('context_date', [$from_date, $to_date])
                        ->get();
                $expenseOnMaterials = \Olabs\Oims\Models\ExpenseOnMaterial::where($params)
                        ->whereBetween('context_date', [$from_date, $to_date])
                        ->get();
                $expenseOnPcs = \Olabs\Oims\Models\ExpenseOnPc::where($params)
                        ->whereBetween('context_date', [$from_date, $to_date])
                        ->get();
            } else {
                $projectprogress = \Olabs\Oims\Models\ProjectProgress::whereBetween('start_date', [$from_date, $to_date])
                        ->whereIn('project_id', array_keys($assigned_projects))
                        ->get();
                $manpowers = \Olabs\Oims\Models\Manpower::whereBetween('context_date', [$from_date, $to_date])
                        ->whereIn('project_id', array_keys($assigned_projects))
                        ->get();
                $machineries = \Olabs\Oims\Models\Machinery::whereBetween('context_date', [$from_date, $to_date])
                        ->whereIn('project_id', array_keys($assigned_projects))
                        ->get();
                $expenseOnMaterials = \Olabs\Oims\Models\ExpenseOnMaterial::whereBetween('context_date', [$from_date, $to_date])
                        ->whereIn('project_id', array_keys($assigned_projects))
                        ->get();
                $expenseOnPcs = \Olabs\Oims\Models\ExpenseOnPc::whereBetween('context_date', [$from_date, $to_date])
                        ->whereIn('project_id', array_keys($assigned_projects))
                        ->get();
            }
        } else if ($from_date) {
            if (count($params)) {
                $projectprogress = \Olabs\Oims\Models\ProjectProgress::where($params)
                        ->whereDate('start_date', '>=', $from_date)
                        ->get();
                $manpowers = \Olabs\Oims\Models\Manpower::where($params)
                        ->whereDate('context_date', '>=', $from_date)
                        ->get();
                $machineries = \Olabs\Oims\Models\Machinery::where($params)
                        ->whereDate('context_date', '>=', $from_date)
                        ->get();
                $expenseOnMaterials = \Olabs\Oims\Models\ExpenseOnMaterial::where($params)
                        ->whereDate('context_date', '>=', $from_date)
                        ->get();
                $expenseOnPcs = \Olabs\Oims\Models\ExpenseOnPc::where($params)
                        ->whereDate('context_date', '>=', $from_date)
                        ->get();
            } else {
                $projectprogress = \Olabs\Oims\Models\ProjectProgress::whereDate('start_date', '>=', $from_date)
                        ->whereIn('project_id', array_keys($assigned_projects))
                        ->get();
                $manpowers = \Olabs\Oims\Models\Manpower::whereDate('context_date', '>=', $from_date)
                        ->whereIn('project_id', array_keys($assigned_projects))
                        ->get();
                $machineries = \Olabs\Oims\Models\Machinery::whereDate('context_date', '>=', $from_date)
                        ->whereIn('project_id', array_keys($assigned_projects))
                        ->get();
                $expenseOnMaterials = \Olabs\Oims\Models\ExpenseOnMaterial::whereDate('context_date', '>=', $from_date)
                        ->whereIn('project_id', array_keys($assigned_projects))
                        ->get();
                $expenseOnPcs = \Olabs\Oims\Models\ExpenseOnPc::whereDate('context_date', '>=', $from_date)
                        ->whereIn('project_id', array_keys($assigned_projects))
                        ->get();
            }
        } else if ($to_date) {
            if (count($params)) {
                $projectprogress = \Olabs\Oims\Models\ProjectProgress::where($params)
                        ->whereDate('start_date', '<=', $to_date)
                        ->get();
                $manpowers = \Olabs\Oims\Models\Manpower::where($params)
                        ->whereDate('context_date', '<=', $to_date)
                        ->get();
                $machineries = \Olabs\Oims\Models\Machinery::where($params)
                        ->whereDate('context_date', '<=', $to_date)
                        ->get();
                $expenseOnMaterials = \Olabs\Oims\Models\ExpenseOnMaterial::where($params)
                        ->whereDate('context_date', '<=', $to_date)
                        ->get();
                $expenseOnPcs = \Olabs\Oims\Models\ExpenseOnPc::where($params)
                        ->whereDate('context_date', '<=', $to_date)
                        ->get();
            } else {
                $projectprogress = \Olabs\Oims\Models\ProjectProgress::whereDate('start_date', '<=', $to_date)
                        ->whereIn('project_id', array_keys($assigned_projects))
                        ->get();
                $manpowers = \Olabs\Oims\Models\Manpower::whereDate('context_date', '<=', $to_date)
                        ->whereIn('project_id', array_keys($assigned_projects))
                        ->get();
                $machineries = \Olabs\Oims\Models\Machinery::whereDate('context_date', '<=', $to_date)
                        ->whereIn('project_id', array_keys($assigned_projects))
                        ->get();
                $expenseOnMaterials = \Olabs\Oims\Models\ExpenseOnMaterial::whereDate('context_date', '<=', $to_date)
                        ->whereIn('project_id', array_keys($assigned_projects))
                        ->get();
                $expenseOnPcs = \Olabs\Oims\Models\ExpenseOnPc::whereDate('context_date', '<=', $to_date)
                        ->whereIn('project_id', array_keys($assigned_projects))
                        ->get();
            }
        } elseif (count($params)) {
            $projectprogress = \Olabs\Oims\Models\ProjectProgress::where($params)->get();
            $manpowers = \Olabs\Oims\Models\Manpower::where($params)->get();
            $machineries = \Olabs\Oims\Models\Machinery::where($params)->get();
            $expenseOnMaterials = \Olabs\Oims\Models\ExpenseOnMaterial::where($params)->get();
            $expenseOnPcs = \Olabs\Oims\Models\ExpenseOnPc::where($params)->get();
        }


        $msg = false;
        if (!$from_date && !$to_date && !count($params)) {
            $msg = 'Please select atleast one filter';
        }


//        $oimsSetting = \Olabs\Oims\Models\Settings::instance();
//        $this->vars['search'] = true;
        $this->vars['msg'] = $msg;
        $this->vars['projectprogress'] = $projectprogress;
        $this->vars['manpowers'] = $manpowers;
        $this->vars['machineries'] = $machineries;
        $this->vars['expenseOnMaterials'] = $expenseOnMaterials;
        $this->vars['expenseOnPcs'] = $expenseOnPcs;
//        $this->vars['oimsSetting'] = $oimsSetting;
        $this->vars['total_days'] = $total_days;
    }

    protected function searchMRReport($searchParams) {
        $reports = array();
        $msg = false;
        $search_from_date = isset($searchParams['from_date']) ? $searchParams['from_date'] : '';
        $search_to_date = isset($searchParams['to_date']) ? $searchParams['to_date'] : '';

        $from_date = false;
        if ($search_from_date != '') {
            $from_date = \Olabs\Oims\Models\Settings::convertToDBDate($search_from_date); //date('Y-m-d 00:00:00', strtotime($from_date));
        }

        $to_date = false;
        if ($search_to_date != '') {
            $timeFormat = '23:59:59';
            $to_date = \Olabs\Oims\Models\Settings::convertToDBDate($search_to_date, $timeFormat);
        }

        $project = ( trim($searchParams['project']) != "" ) ? $searchParams['project'] : false;
        $supplier = ( trim($searchParams['supplier']) != "" ) ? $searchParams['supplier'] : false;

        $baseModel = new \Olabs\Oims\Models\BaseModel();
        $assigned_projects = [];
//        $user = BackendAuth::getUser();

        $params = array();
        if ($project) {
            $assigned_projects = [$project];
        } else {
            $assigned_projects = array_keys($baseModel->getProjectOptions());
        }
        if ($supplier) {
            $params['user_id'] = $supplier;
        }

        if ($from_date && $to_date) {
            $datetime1 = new DateTime($from_date);
            $datetime2 = new DateTime($to_date);
            $interval = $datetime1->diff($datetime2);
            $total_days = $interval->format('%d') + 1; //to add current date 

            $reports = \Olabs\Oims\Models\Purchase::where($params)
                    ->whereBetween('context_date', [$from_date, $to_date])
                    ->whereIn('project_id', $assigned_projects)
                    ->get();
        } else if ($from_date) {
            $reports = \Olabs\Oims\Models\Purchase::where($params)
                    ->whereDate('context_date', '>=', $from_date)
                    ->whereIn('project_id', $assigned_projects)
                    ->get();
        } else if ($to_date) {
            $reports = \Olabs\Oims\Models\Purchase::where($params)
                    ->whereDate('context_date', '<=', $to_date)
                    ->whereIn('project_id', $assigned_projects)
                    ->get();
        } elseif (count($params)) {
            $reports = \Olabs\Oims\Models\Purchase::where($params)->get();
        }


        $msg = false;
        if (!$from_date && !$to_date && !count($params)) {
            $msg = 'Please select atleast one filter';
        }

        $this->vars['from_date'] = $from_date;
        $this->vars['to_date'] = $to_date;
        $this->vars['reports'] = $reports;
        $this->vars['msg'] = $msg;
    }

    protected function searchAttendanceReport($searchParams) {
        $reports = array();
        $msg = false;
        $search_from_date = isset($searchParams['from_date']) ? $searchParams['from_date'] : '';
        $search_to_date = isset($searchParams['to_date']) ? $searchParams['to_date'] : '';

        $from_date = false;
        if ($search_from_date != '') {
            $from_date = \Olabs\Oims\Models\Settings::convertToDBDate($search_from_date); //date('Y-m-d 00:00:00', strtotime($from_date));
        }

        $to_date = false;
        if ($search_to_date != '') {
            $timeFormat = '23:59:59';
            $to_date = \Olabs\Oims\Models\Settings::convertToDBDate($search_to_date, $timeFormat);
        }

        $project = ( trim($searchParams['project']) != "" ) ? $searchParams['project'] : false;
        $supplier = ( trim($searchParams['supplier']) != "" ) ? $searchParams['supplier'] : false;
        $attendance_type = ( isset($searchParams['attendance_type']) ) ? $searchParams['attendance_type'] : 'offrole';

        $baseModel = new \Olabs\Oims\Models\BaseModel();
        $assigned_projects = [];
//        $user = BackendAuth::getUser();

        $params = array();
        $params['employee_type'] = $attendance_type; //'offrole';

        if ($project) {
            $assigned_projects = [$project];
        } else {
            $assigned_projects = array_keys($baseModel->getProjectOptions());
        }
        if ($supplier) {
            $params['supplier_id'] = $supplier;
        }



        if ($attendance_type == \Olabs\Oims\Models\Attendance::EMPLOYEE_TYPE_OFFROLE) {
            $model = \Olabs\Oims\Models\Attendance::where($params)
                    ->with('employee_offrole')
                    ->whereIn('project_id', $assigned_projects);
        } else {
            $model = \Olabs\Oims\Models\Attendance::select()
                    ->where($params)
//                    ->with('employee_offrole')
                    ->join("backend_users", 'backend_users.id', 'employee_id')
                    ->whereIn('backend_users.employee_project_id', $assigned_projects);
        }

        if ($from_date && $to_date) {
            $datetime1 = new DateTime($from_date);
            $datetime2 = new DateTime($to_date);
            $interval = $datetime1->diff($datetime2);
            $total_days = $interval->format('%d') + 1; //to add current date 

            $model->whereBetween('check_in', [$from_date, $to_date]);
        } else if ($from_date) {
            $model->whereDate('check_in', '>=', $from_date);
        } else if ($to_date) {
            $model->whereDate('check_in', '<=', $to_date);
        }
//        if($report_type == 'supplier_wise'){
        $model->orderBy('project_id');
        $model->orderBy('check_in');
        $model->orderBy('supplier_id');

//        $model->orderBy('check_in');
//        }else{
//            $model->orderBy('project_id', 'check_in', 'supplier_id');
//        }


        $reports = $model->get();
        $msg = false;
        if (!$from_date && !$to_date && !count($params)) {
            $msg = 'Please select atleast one filter';
        }

        $this->vars['from_date'] = $from_date;
        $this->vars['to_date'] = $to_date;
        $this->vars['reports'] = $reports;
//        $this->vars['report_type'] = $report_type;
        $this->vars['msg'] = $msg;
    }

    protected function searchPcAttendanceReport($searchParams, $returnList = False) {
        $reports = array();
        $msg = false;
        $search_from_date = isset($searchParams['from_date']) ? $searchParams['from_date'] : '';
        $search_to_date = isset($searchParams['to_date']) ? $searchParams['to_date'] : '';

        $from_date = false;
        if ($search_from_date != '') {
            $from_date = \Olabs\Oims\Models\Settings::convertToDBDate($search_from_date); //date('Y-m-d 00:00:00', strtotime($from_date));
        }

        $to_date = false;
        if ($search_to_date != '') {
            $timeFormat = '23:59:59';
            $to_date = \Olabs\Oims\Models\Settings::convertToDBDate($search_to_date, $timeFormat);
        }

        $project = ( trim($searchParams['project']) != "" ) ? $searchParams['project'] : false;
        $supplier = ( trim($searchParams['supplier']) != "" ) ? $searchParams['supplier'] : false;
//        $attendance_type = ( isset($searchParams['attendance_type'])  ) ? $searchParams['attendance_type'] : 'offrole';

        $baseModel = new \Olabs\Oims\Models\BaseModel();
        $assigned_projects = [];
//        $user = BackendAuth::getUser();

        $params = array();
//        $params['employee_type'] = $attendance_type;//'offrole';

        if ($project) {
            $assigned_projects = [$project];
        } else {
            $assigned_projects = array_keys($baseModel->getProjectOptions());
        }
        if ($supplier) {
            $params['user_id'] = $supplier;
        }

        $model = \Olabs\Oims\Models\PCAttendance::where($params)
//                ->with('employee_offrole')
                ->whereIn('project_id', $assigned_projects);

        if ($from_date && $to_date) {
            $datetime1 = new DateTime($from_date);
            $datetime2 = new DateTime($to_date);
            $interval = $datetime1->diff($datetime2);
            $total_days = $interval->format('%d') + 1; //to add current date 

            $model->whereBetween('context_date', [$from_date, $to_date]);
        } else if ($from_date) {
            $model->whereDate('context_date', '>=', $from_date);
        } else if ($to_date) {
            $model->whereDate('context_date', '<=', $to_date);
        }
//        if($report_type == 'supplier_wise'){
        $model->orderBy('project_id');
        $model->orderBy('context_date');
        $model->orderBy('user_id');

//        $model->orderBy('check_in');
//        }else{
//            $model->orderBy('project_id', 'check_in', 'supplier_id');
//        }


        $reports = $model->get();
        if ($returnList) {
            return $reports;
        }

        $msg = false;
        if (!$from_date && !$to_date && !count($params)) {
            $msg = 'Please select atleast one filter';
        }

        $this->vars['from_date'] = $from_date;
        $this->vars['to_date'] = $to_date;
        $this->vars['reports'] = $reports;
//        $this->vars['report_type'] = $report_type;
        $this->vars['msg'] = $msg;
    }

    protected function searchAssetsReport($searchParams) {
        $reports = array();
        $msg = false;
        $search_from_date = isset($searchParams['from_date']) ? $searchParams['from_date'] : '';
        $search_to_date = isset($searchParams['to_date']) ? $searchParams['to_date'] : '';

        $from_date = false;
        if ($search_from_date != '') {
            $from_date = \Olabs\Oims\Models\Settings::convertToDBDate($search_from_date); //date('Y-m-d 00:00:00', strtotime($from_date));
        }

        $to_date = false;
        if ($search_to_date != '') {
            $timeFormat = '23:59:59';
            $to_date = \Olabs\Oims\Models\Settings::convertToDBDate($search_to_date, $timeFormat);
        }

        $project = ( trim($searchParams['project']) != "" ) ? $searchParams['project'] : false;
        $supplier = false; // ( trim($searchParams['supplier']) != "" ) ? $searchParams['supplier'] : false;

        $baseModel = new \Olabs\Oims\Models\BaseModel();
        $assigned_projects = [];
//        $user = BackendAuth::getUser();

        $params = array();
        if ($project) {
            $assigned_projects = [$project];
        } else {
            $assigned_projects = array_keys($baseModel->getProjectOptions());
        }
        if ($supplier) {
            $params['user_id'] = $supplier;
        }

//        if ($from_date && $to_date) {
//            $datetime1 = new DateTime($from_date);
//            $datetime2 = new DateTime($to_date);
//            $interval = $datetime1->diff($datetime2);
//            $total_days = $interval->format('%d') + 1; //to add current date 
//
//            $reports = \Olabs\Oims\Models\Purchase::where($params)
//                    ->whereBetween('context_date', [$from_date, $to_date])
//                    ->whereIn('project_id', $assigned_projects)
//                    ->get();
//        } else if ($from_date) {
//            $reports = \Olabs\Oims\Models\Purchase::where($params)
//                    ->whereDate('context_date', '>=', $from_date)
//                    ->whereIn('project_id', $assigned_projects)
//                    ->get();
//        } else if ($to_date) {
//            $reports = \Olabs\Oims\Models\Purchase::where($params)
//                    ->whereDate('context_date', '<=', $to_date)
//                    ->whereIn('project_id', $assigned_projects)
//                    ->get();
//        } else
//        if (count($params)) {
        $reports = \Olabs\Oims\Models\ProjectAsset::where($params)
                ->whereIn('project_id', $assigned_projects)
                ->get();
//        }


        $msg = false;
//        if (!$from_date && !$to_date && !count($params)) {
//            $msg = 'Please select atleast one filter';
//        }
        if (!count($params)) {
            $msg = 'Please select atleast one filter';
        }

//        dd($params);


        $this->vars['from_date'] = $from_date;
        $this->vars['to_date'] = $to_date;
        $this->vars['reports'] = $reports;
        $this->vars['msg'] = $msg;
        return $reports;
    }

    protected function searchMaterialReport($searchParams) {
        $reports = array();
        $msg = false;
        $search_from_date = isset($searchParams['from_date']) ? $searchParams['from_date'] : '';
        $search_to_date = isset($searchParams['to_date']) ? $searchParams['to_date'] : '';

        $from_date = false;
        if ($search_from_date != '') {
            $from_date = \Olabs\Oims\Models\Settings::convertToDBDate($search_from_date); //date('Y-m-d 00:00:00', strtotime($from_date));
        }

        $to_date = false;
        if ($search_to_date != '') {
            $timeFormat = '23:59:59';
            $to_date = \Olabs\Oims\Models\Settings::convertToDBDate($search_to_date, $timeFormat);
        }

        $project = ( trim($searchParams['project']) != "" ) ? $searchParams['project'] : false;
        $supplier = ( isset($searchParams['supplier']) ) ? $searchParams['supplier'] : false;

        $baseModel = new \Olabs\Oims\Models\BaseModel();
        $assigned_projects = [];
//        $user = BackendAuth::getUser();

        $params = array();
        if ($project) {
            $assigned_projects = [$project];
        } else {
            $assigned_projects = array_keys($baseModel->getProjectOptions());
        }
        if ($supplier) {
            $params['user_id'] = $supplier;
        }

        if ($from_date && $to_date) {
            $datetime1 = new DateTime($from_date);
            $datetime2 = new DateTime($to_date);
            $interval = $datetime1->diff($datetime2);
            $total_days = $interval->format('%d') + 1; //to add current date 

            $reports = \Olabs\Oims\Models\Purchase::where($params)
                    ->whereBetween('context_date', [$from_date, $to_date])
                    ->whereIn('project_id', $assigned_projects)
                    ->get();
        } else if ($from_date) {
            $reports = \Olabs\Oims\Models\Purchase::where($params)
                    ->whereDate('context_date', '>=', $from_date)
                    ->whereIn('project_id', $assigned_projects)
                    ->get();
        } else if ($to_date) {
            $reports = \Olabs\Oims\Models\Purchase::where($params)
                    ->whereDate('context_date', '<=', $to_date)
                    ->whereIn('project_id', $assigned_projects)
                    ->get();
        } elseif (count($params)) {
            $reports = \Olabs\Oims\Models\Purchase::where($params)->get();
        }


        $msg = false;
        if (!$from_date && !$to_date && !count($params)) {
            $msg = 'Please select atleast one filter';
        }

        $this->vars['from_date'] = $from_date;
        $this->vars['to_date'] = $to_date;
        $this->vars['reports'] = $reports;
        $this->vars['msg'] = $msg;
    }

    protected function searchTransactionReport($searchParams) {
        $reports = array();
        $msg = false;
        $search_from_date = isset($searchParams['from_date']) ? $searchParams['from_date'] : '';
        $search_to_date = isset($searchParams['to_date']) ? $searchParams['to_date'] : '';

        $from_date = false;
        if ($search_from_date != '') {
            $from_date = \Olabs\Oims\Models\Settings::convertToDBDate($search_from_date); //date('Y-m-d 00:00:00', strtotime($from_date));
        }

        $to_date = false;
        if ($search_to_date != '') {
            $timeFormat = '23:59:59';
            $to_date = \Olabs\Oims\Models\Settings::convertToDBDate($search_to_date, $timeFormat);
        }

        $project = ( trim($searchParams['project']) != "" ) ? $searchParams['project'] : false;
        $supplier = ( isset($searchParams['supplier'])) ? $searchParams['supplier'] : false;

        $baseModel = new \Olabs\Oims\Models\BaseModel();
        $assigned_projects = [];
//        $user = BackendAuth::getUser();

        $params = array();
        if ($project) {
            $assigned_projects = [$project];
        } else {
            $assigned_projects = array_keys($baseModel->getProjectOptions());
        }
        if ($supplier) {
            $params['user_id'] = $supplier;
        }

        /*
         * 
          SELECT id, entity_type, payment_receivables_id, payment_type, project_id, context_date , debit_amount, credit_amount
          FROM (
          SELECT id, 'vouchers' as entity_type, total_price as debit_amount, 0 as credit_amount, payment_type, project_id, context_date FROM `olabs_oims_vouchers`
          UNION ALL
          SELECT id, 'payment_receivables' as entity_type, amount as debit_amount, 0 as credit_amount,payment_type,from_project_id as project_id, context_date FROM `olabs_oims_payment_receivables`
          UNION ALL
          SELECT id, 'payment_receivables' as entity_type, 0 as debit_amount, amount as credit_amount, payment_type,to_project_id as project_id, context_date FROM `olabs_oims_payment_receivables`
          )X
          ORDER BY context_date ASC
         */

        if ($from_date && $to_date) {
            $datetime1 = new DateTime($from_date);
            $datetime2 = new DateTime($to_date);
            $interval = $datetime1->diff($datetime2);
            $total_days = $interval->format('%d') + 1; //to add current date 

            $balance_till_date = $datetime1->modify('-1 day');
            $timeFormat = ' 23:59:59';
            $balance_till_date = $balance_till_date->format('Y-m-d') . $timeFormat;

            $balance_amount = 0;
            //Get Balance
            //Receiables
            $balance_amount = \Olabs\Oims\Models\PaymentReceivable::where($params)
                    ->whereDate('context_date', '<=', $balance_till_date)
                    ->whereIn('to_project_id', $assigned_projects)
                    ->sum("amount");

            //payments
            $balance_amount -= \Olabs\Oims\Models\Voucher::where($params)
                    ->whereDate('context_date', '<=', $balance_till_date)
                    ->whereIn('project_id', $assigned_projects)
                    ->sum("total_price");

            //payments
            $balance_amount -= \Olabs\Oims\Models\PaymentReceivable::where($params)
                    ->whereDate('context_date', '<=', $balance_till_date)
                    ->whereIn('from_project_id', $assigned_projects)
                    ->sum("amount");
//            
            //Reports

            $vouchers = \Olabs\Oims\Models\Voucher::where($params)
                    ->whereBetween('context_date', [$from_date, $to_date])
                    ->whereIn('project_id', $assigned_projects)
                    ->select(DB::raw("id, 'vouchers' as entity_type, total_price as debit_amount, 0 as credit_amount, payment_type, project_id, context_date, narration, description"));

            $payment_debit = \Olabs\Oims\Models\PaymentReceivable::where($params)
                    ->whereBetween('context_date', [$from_date, $to_date])
                    ->whereIn('from_project_id', $assigned_projects)
                    ->select(DB::raw("id, 'payment_receivables' as entity_type, amount as debit_amount, 0 as credit_amount,payment_type,from_project_id as project_id, context_date, narration, description"));

            $payment_credit = \Olabs\Oims\Models\PaymentReceivable::where($params)
                    ->whereBetween('context_date', [$from_date, $to_date])
                    ->whereIn('to_project_id', $assigned_projects)
                    ->select(DB::raw("id, 'payment_receivables' as entity_type, 0 as debit_amount, amount as credit_amount, payment_type,to_project_id as project_id, context_date, narration, description"));




            $reports = $vouchers->unionAll($payment_debit)->unionAll($payment_credit)->orderBy(DB::raw('context_date'))->get();
//            $reports = $vouchers->get();
//            dd(count($reports));
        }
//        else if ($from_date) {
//            $reports = \Olabs\Oims\Models\Purchase::where($params)
//                    ->whereDate('context_date', '>=', $from_date)
//                    ->whereIn('project_id', $assigned_projects)
//                    ->get();
//        } else if ($to_date) {
//            $reports = \Olabs\Oims\Models\Purchase::where($params)
//                    ->whereDate('context_date', '<=', $to_date)
//                    ->whereIn('project_id', $assigned_projects)
//                    ->get();
//        } elseif (count($params)) {
//            $reports = \Olabs\Oims\Models\Purchase::where($params)->get();
//        }


        $msg = false;
        if (!$from_date && !$to_date && !count($params)) {
            $msg = 'Please select atleast one filter';
        }

        $this->vars['from_date'] = $from_date;
        $this->vars['to_date'] = $to_date;
        $this->vars['reports'] = $reports;
        $this->vars['balance_amount'] = $balance_amount;
        $this->vars['msg'] = $msg;
    }

    protected function searchProjectPlanReport($searchParams) {
        $reports = array();
        $msg = false;

        $project = ( trim($searchParams['project']) != "" ) ? $searchParams['project'] : false;
        try {

            

            
            //Set chart headings
            $project_modal = \Olabs\Oims\Models\Project::where("id", $project)->first();
            
            if (!$project_modal) {
                throw new ApplicationException('Project not found!');
            }
            
            // chart object
//            $chart = new GanttCharts("gantt", "ProjectPlanChart", "99%", "99%", "project-plan-chart-container", "json");
            $chart = new GanttCharts("gantt", "ProjectPlanChart", "1800", "2000", "project-plan-chart-container", "json");
            
            $chart->set_dataSource_chart("Project Plan - " . $project_modal->name , "Planned vs Actual");
            
            
            
            //Get project planned start & end date
            $category_dates = \Olabs\Oims\Models\ProjectWork::where('project_id', $project)
                    ->where('status', \Olabs\Oims\Models\ProjectWork::STATUS_ACTIVE)
                    ->select(Db::Raw("min(planned_start_date) as planned_start_date, max(planned_end_date) as planned_end_date"))
                    ->whereNotNull("planned_start_date")
                    ->whereNotNull("planned_end_date")
                    ->first();

            //if no dates found then return false
            if (!$category_dates) {
                throw new ApplicationException('Work planned dates are not set!');
            }
            $from_date = $category_dates->planned_start_date;
            $to_date = $category_dates->planned_end_date;
            
            

            if ($from_date && $to_date) {
                $start = new DateTime($from_date);
                $end = new DateTime($to_date);
                $interval = $start->diff($end);

                if ($interval) {
//                    $month_start = $start->modify("first day of this month");
//                    $month_end = $start->modify("last day of this month");
                    //generate categories for the month
                    $current = $start;
                    while ($current < $end) {
                        $month_start = $current->modify("first day of this month")->format("j/n/Y");
                        $month_end = $current->modify("last day of this month")->format("j/n/Y");

                        $month_name = $current->format("M-y"); // F, M

                        $chart->set_dataSource_categories_item($month_start, $month_end, $month_name);

                        $current = $current->modify('+1 day'); //@date('Y-M-01', $current) . "+1 month";
                    }
                }
            }



            //Set Categories in month
//            $chart->set_dataSource_categories_item("1/4/2014", "30/4/2014", "April");
//            $chart->set_dataSource_categories_item("1/5/2014", "31/5/2014", "May");
            //Get all project wroks in active status
            $project_works = \Olabs\Oims\Models\ProjectWork::where('project_id', $project)->where('status', \Olabs\Oims\Models\ProjectWork::STATUS_ACTIVE)->get();

            $gantt_process = [];
//        foreach($project_works as $work){
//            $gantt_process = 
//        }
//        dd(count($project_works));
            //Set works
//        $chart->set_dataSource_processes_item("Test 1", "1");
//        $chart->set_dataSource_datatable_item("25/4/2014", "28/4/2014");

            foreach ($project_works as $project_work) {
                $name = $project_work->name;
                $id = $project_work->id . "";

                //Set Work items
                $chart->set_dataSource_processes_item($id, $name);

                //Set Planned Task items
                $planned_start_date = \Olabs\Oims\Models\Settings::convertToDisplayDate($project_work->planned_start_date, "j/n/Y");
                $planned_end_date = \Olabs\Oims\Models\Settings::convertToDisplayDate($project_work->planned_end_date, "j/n/Y");
                $chart->set_dataSource_tasks_item($planned_start_date, $planned_end_date, $id, "Planned");

                //Actual Start & End Date
                /*
                 * SELECT min(start_date), max(start_date) FROM `olabs_oims_project_progress` p
                  INNER JOIN olabs_oims_project_progress_items i ON p.id = i.project_progress_id AND i.work_id = 7
                  WHERE p.project_id = 2
                 */

                $work_actual_dates = \Olabs\Oims\Models\ProjectProgress::with("products")
                        ->where("project_id", $project)
                        
                        ->join('olabs_oims_project_progress_items', 'olabs_oims_project_progress_items.project_progress_id', '=', 'olabs_oims_project_progress.id')
                        ->where("olabs_oims_project_progress_items.work_id", $id)
                        ->select(Db::Raw("min(start_date) as start_date, max(start_date) as end_date"))
                        ->whereNotNull("start_date")
                        ->first();
                
                if($work_actual_dates){
                    $actual_start_date = \Olabs\Oims\Models\Settings::convertToDisplayDate($work_actual_dates->start_date, "j/n/Y");
                    $actual_end_date = \Olabs\Oims\Models\Settings::convertToDisplayDate($work_actual_dates->end_date, "j/n/Y");
                    $chart->set_dataSource_tasks_item($actual_start_date, $actual_end_date, $id, "Actual"); //Task item
                    
                    $chart->set_dataSource_datatable_item($actual_start_date, $actual_end_date); //Datacolumn item
                }
                
                
            }









            $this->vars['reports'] = $chart->render("array");
            $this->vars['msg'] = $msg;

            return;
        } catch (Exception $ex) {
            $this->vars['reports'] = [];
            $this->vars['msg'] = $msg;
            return;
        }
        ////////////////////////////////////
//        $search_from_date = isset($searchParams['from_date']) ? $searchParams['from_date'] : '';
//        $search_to_date = isset($searchParams['to_date']) ? $searchParams['to_date'] : '';
//
//        $from_date = false;
//        if ($search_from_date != '') {
//            $from_date = \Olabs\Oims\Models\Settings::convertToDBDate($search_from_date); //date('Y-m-d 00:00:00', strtotime($from_date));
//        }
//
//        $to_date = false;
//        if ($search_to_date != '') {
//            $timeFormat = '23:59:59';
//            $to_date = \Olabs\Oims\Models\Settings::convertToDBDate($search_to_date, $timeFormat);
//        }
//
//        $project = ( trim($searchParams['project']) != "" ) ? $searchParams['project'] : false;
//        $supplier = ( trim($searchParams['supplier']) != "" ) ? $searchParams['supplier'] : false;
//
//        $baseModel = new \Olabs\Oims\Models\BaseModel();
//        $assigned_projects = [];
////        $user = BackendAuth::getUser();
//
//        $params = array();
//        if ($project) {
//            $assigned_projects = [$project];
//        } else {
//            $assigned_projects = array_keys($baseModel->getProjectOptions());
//        }
//        if ($supplier) {
//            $params['user_id'] = $supplier;
//        }
//
//        if ($from_date && $to_date) {
//            $datetime1 = new DateTime($from_date);
//            $datetime2 = new DateTime($to_date);
//            $interval = $datetime1->diff($datetime2);
//            $total_days = $interval->format('%d') + 1; //to add current date 
//
//            $reports = \Olabs\Oims\Models\Purchase::where($params)
//                    ->whereBetween('context_date', [$from_date, $to_date])
//                    ->whereIn('project_id', $assigned_projects)
//                    ->get();
//        } else if ($from_date) {
//            $reports = \Olabs\Oims\Models\Purchase::where($params)
//                    ->whereDate('context_date', '>=', $from_date)
//                    ->whereIn('project_id', $assigned_projects)
//                    ->get();
//        } else if ($to_date) {
//            $reports = \Olabs\Oims\Models\Purchase::where($params)
//                    ->whereDate('context_date', '<=', $to_date)
//                    ->whereIn('project_id', $assigned_projects)
//                    ->get();
//        } elseif (count($params)) {
//            $reports = \Olabs\Oims\Models\Purchase::where($params)->get();
//        }
//
//
//        $msg = false;
//        if (!$from_date && !$to_date && !count($params)) {
//            $msg = 'Please select atleast one filter';
//        }
//
//        $this->vars['from_date'] = $from_date;
//        $this->vars['to_date'] = $to_date;
//        $this->vars['reports'] = $reports;
//        $this->vars['msg'] = $msg;
    }

}
