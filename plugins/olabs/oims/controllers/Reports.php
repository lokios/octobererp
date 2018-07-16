<?php

namespace Olabs\Oims\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use BackendAuth;
use DateTime;
use Flash;
use Log;
use App;
use Db;
use Vdomah\Excel\Classes\Excel;

class Reports extends Controller {

    public $implement = [];
    protected $searchFormWidget;

    public function __construct() {
        parent::__construct();
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 600);
        $this->searchFormWidget = $this->createDPRSearchFormWidget();
        BackendMenu::setContext('Olabs.Oims', 'reports', 'drp_report');
    }

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

    public function dpr() {
        BackendMenu::setContext('Olabs.Oims', 'reports', 'drp_report');
        $this->pageTitle = 'DRP Report';
        $projectprogress = array();
        $manpowers = array();
        $machineries = array();
        $expenseOnMaterials = array();
        $expenseOnPcs = array();

//        $oimsSetting = '';
        $oimsSetting = \Olabs\Oims\Models\Settings::instance();

        $searchForm = $this->searchFormWidget;

        $this->vars['search'] = false;
        $this->vars['msg'] = false;
        $this->vars['searchFormWidget'] = $searchForm;
        $this->vars['projectprogress'] = $projectprogress;
        $this->vars['manpowers'] = $manpowers;
        $this->vars['machineries'] = $machineries;
        $this->vars['expenseOnMaterials'] = $expenseOnMaterials;
        $this->vars['expenseOnPcs'] = $expenseOnPcs;
        $this->vars['oimsSetting'] = $oimsSetting;
        $this->vars['grand_total'] = 0;
        $this->vars['progress_total'] = 0;
        $this->vars['fix_expense'] = 0;
        $this->vars['total_days'] = 0;
    }

    public function onDprSearch() {
        $projectprogress = array();
        $manpowers = array();
        $machineries = array();
        $expenseOnMaterials = array();
        $expenseOnPcs = array();
        $total_days = 0;

        $this->vars['grand_total'] = 0;
        $this->vars['progress_total'] = 0;
        $this->vars['fix_expense'] = 0;

        if (post('DprSearch')) {

            $searchParams = post('DprSearch');

            // get dpr components
            $this->searchDPR($searchParams);
        }

        $oimsSetting = \Olabs\Oims\Models\Settings::instance();

        $this->vars['search'] = true;
        $this->vars['oimsSetting'] = $oimsSetting;
    }

//    public function onDprExport_BIN() {
//
//
//        //generate PDF html
//        $projectprogress = array();
//        $manpowers = array();
//        $machineries = array();
//        $expenseOnMaterials = array();
//        $expenseOnPcs = array();
//        $total_days = 0;
//
//        $this->vars['grand_total'] = 0;
//        $this->vars['progress_total'] = 0;
//        $this->vars['fix_expense'] = 0;
//
//        if (post('DprSearch')) {
//
//            $searchParams = post('DprSearch');
//
//            // get dpr components
//            $this->searchDPR($searchParams);
//
//            $search_from_date = isset($searchParams['from_date']) ? $searchParams['from_date'] : '';
//            $search_to_date = isset($searchParams['to_date']) ? $searchParams['to_date'] : '';
////
//            $from_date = false;
//            if ($search_from_date != '') {
//                $from_date = \Olabs\Oims\Models\Settings::convertToDBDate($search_from_date); //date('Y-m-d 00:00:00', strtotime($from_date));
//            }
//
//            $to_date = false;
//            if ($search_to_date != '') {
//                $timeFormat = '23:59:59';
//                $to_date = \Olabs\Oims\Models\Settings::convertToDBDate($search_to_date, $timeFormat);
//            }
//
//            $project = ( trim($searchParams['project']) != "" ) ? $searchParams['project'] : false;
//
//            $projectModal = \Olabs\Oims\Models\Project::find($project);
//        }
//
//        $oimsSetting = \Olabs\Oims\Models\Settings::instance();
//
//        $this->vars['search'] = true;
//
//        $projectprogress = $this->vars['projectprogress'];
//        $manpowers = $this->vars['manpowers'];
//        $machineries = $this->vars['machineries'];
//        $expenseOnMaterials = $this->vars['expenseOnMaterials'];
//        $expenseOnPcs = $this->vars['expenseOnPcs'];
//
//        $total_days = $this->vars['total_days'];
//
//        $style = ".product-title { width: 315px; display: inline-block; }
//.product-quantity { width: 50px; display: inline-block; }
//.product-price-without-tax { width: 100px; display: inline-block; text-align: right; }
//.product-tax { width: 100px; display: inline-block; text-align: right; }
//.product-price { width: 130px; display: inline-block; text-align: right; }
//table { width: 100%; border-collapse: collapse; font-size:12px;}
//td, th { border: 1px solid #ccc; }";
//
//        $html = "<html><head><style>" . $style . "</style></head><body>";
//
//        $html .= "<h3>DPR Report for Project : " . $projectModal['name'] . ", From : " . \Olabs\Oims\Models\Settings::convertToDisplayDate($from_date) . " To : " . \Olabs\Oims\Models\Settings::convertToDisplayDate($to_date) . "</h3>";
//
//        $html .= $this->makePartial('dpr_projectprogress_list', ['projectprogress' => $projectprogress, 'oimsSetting' => $oimsSetting]);
//
//
//        $html .= $this->makePartial('dpr_manpower_list', ['manpowers' => $manpowers, 'oimsSetting' => $oimsSetting]);
//        $html .= $this->makePartial('dpr_machinery_list', ['machineries' => $machineries, 'oimsSetting' => $oimsSetting]);
//        $html .= $this->makePartial('dpr_expense_on_pc_list', ['expenseOnPcs' => $expenseOnPcs, 'oimsSetting' => $oimsSetting]);
//        $html .= $this->makePartial('dpr_expense_on_material_list', ['expenseOnMaterials' => $expenseOnMaterials, 'oimsSetting' => $oimsSetting]);
//        $html .= $this->makePartial('dpr_summary', ['grand_total' => $this->vars['grand_total'], 'progress_total' => $this->vars['progress_total'], 'fix_expense' => $this->vars['fix_expense'], 'oimsSetting' => $oimsSetting]);
//
//        $html .= "</body></html>";
//
//
//        // Generate invoice
//        $fileName = 'dpr_report_' . time();
//        $invoiceTempFile = temp_path() . "/" . $fileName . ".pdf";
//        $pdf = App::make('dompdf.wrapper');
//
//
//        $pdf->loadHtml($html);
//
//        // (Optional) Setup the paper size and orientation
//        $pdf->setPaper('A4', 'portrait'); //landscape
//        // Output the generated PDF to Browser
//        $pdf->save($invoiceTempFile);
//
//        return \Redirect::to('/backend/olabs/oims/reports/downloadPdf?name=' . $fileName);
//    }

    public function onDprExportExcel() {

        $file_type = '.' . post('type');

        ////////Generate Excel Data
        $projectprogress = array();
        $manpowers = array();
        $machineries = array();
        $expenseOnMaterials = array();
        $expenseOnPcs = array();
        $total_days = 0;

        $this->vars['grand_total'] = 0;
        $this->vars['progress_total'] = 0;
        $this->vars['fix_expense'] = 0;

        if (post('DprSearch')) {

            $searchParams = post('DprSearch');

            // get dpr components
            $this->searchDPR($searchParams);

            $search_from_date = isset($searchParams['from_date']) ? $searchParams['from_date'] : '';
            $search_to_date = isset($searchParams['to_date']) ? $searchParams['to_date'] : '';
//
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

            $projectModal = \Olabs\Oims\Models\Project::find($project);
        }

        $oimsSetting = \Olabs\Oims\Models\Settings::instance();

        $this->vars['search'] = true;

        $projectprogress = $this->vars['projectprogress'];
        $manpowers = $this->vars['manpowers'];
        $machineries = $this->vars['machineries'];
        $expenseOnMaterials = $this->vars['expenseOnMaterials'];
        $expenseOnPcs = $this->vars['expenseOnPcs'];

        $total_days = $this->vars['total_days'];
        $progress_total = 0;
        $grand_total = 0;
        $export_data = [];

        //Generating Excel
        $header_columns = ['Id', 'Project', 'Entry Date', 'Product', 'Quantity', 'Unit Price', 'Total Price'];

        //Project Progress
        $excel_rows = [];
        foreach ($projectprogress as $progress) {
            $products = $progress->products ? $progress->products : array();
            foreach ($products as $product) {
                $temp = [];
                $temp['id'] = $progress->id;
                $temp['project'] = $progress->project->name;
                $temp['entry_date'] = date("d-m-Y", strtotime($progress->start_date));
                $temp['product'] = $product->work ? $product->work->name : '';
                $temp['quantity'] = $product->quantity;
                $temp['unit_price'] = $oimsSetting->getPriceFormattedWithoutCurrency($product->unit_price);
                $temp['total_price'] = $oimsSetting->getPriceFormattedWithoutCurrency($product->total_price);
                $excel_rows[] = $temp;
                $progress_total += $product->total_price;
            }
        }

        $export_data[] = ['title' => 'Our Billing', 'header' => $header_columns, 'rows' => $excel_rows];

        //Manpower
        $excel_rows = [];
        foreach ($manpowers as $manpower) {
            $products = $manpower->products ? $manpower->products : array();
            foreach ($products as $product) {
                $temp = [];
                $temp['id'] = $manpower->id;
                $temp['project'] = $manpower->project->name;
                $temp['entry_date'] = date("d-m-Y", strtotime($manpower->context_date));
                $temp['product'] = $product->product ? $product->product->title : '';
                $temp['quantity'] = $product->quantity;
                $temp['unit_price'] = $oimsSetting->getPriceFormattedWithoutCurrency($product->unit_price);
                $temp['total_price'] = $oimsSetting->getPriceFormattedWithoutCurrency($product->total_price);
                $excel_rows[] = $temp;
                $grand_total += $product->total_price;
            }
        }
        $export_data[] = ['title' => 'Consumed Manpower', 'header' => $header_columns, 'rows' => $excel_rows];

        //Machinery
        $excel_rows = [];
        foreach ($machineries as $machinery) {
            $products = $machinery->products ? $machinery->products : array();
            foreach ($products as $product) {
                $temp = [];
                $temp['id'] = $machinery->id;
                $temp['project'] = $machinery->project->name;
                $temp['entry_date'] = date("d-m-Y", strtotime($machinery->context_date));
                $temp['product'] = $product->product ? $product->product->title : '';
                $temp['quantity'] = $product->quantity;
                $temp['unit_price'] = $oimsSetting->getPriceFormattedWithoutCurrency($product->unit_price);
                $temp['total_price'] = $oimsSetting->getPriceFormattedWithoutCurrency($product->total_price);
                $excel_rows[] = $temp;
                $grand_total += $product->total_price;
            }
        }
        $export_data[] = ['title' => 'Machinery Expenditure', 'header' => $header_columns, 'rows' => $excel_rows];

        //Expense On PC
        $excel_rows = [];
        foreach ($expenseOnPcs as $expenseOnPc) {
            $products = $expenseOnPc->products ? $expenseOnPc->products : array();
            foreach ($products as $product) {
                $temp = [];
                $temp['id'] = $expenseOnPc->id;
                $temp['project'] = $expenseOnPc->project->name;
                $temp['entry_date'] = date("d-m-Y", strtotime($expenseOnPc->context_date));
                $temp['product'] = $product->product ? $product->product->title : '';
                $temp['quantity'] = $product->quantity;
                $temp['unit_price'] = $oimsSetting->getPriceFormattedWithoutCurrency($product->unit_price);
                $temp['total_price'] = $oimsSetting->getPriceFormattedWithoutCurrency($product->total_price);
                $excel_rows[] = $temp;
                $grand_total += $product->total_price;
            }
        }
        $export_data[] = ['title' => 'Expense Against PC', 'header' => $header_columns, 'rows' => $excel_rows];

        //Expense On Materials
        $excel_rows = [];
        foreach ($expenseOnMaterials as $expenseOnMaterial) {
            $products = $expenseOnMaterial->products ? $expenseOnMaterial->products : array();
            foreach ($products as $product) {
                $temp = [];
                $temp['id'] = $expenseOnMaterial->id;
                $temp['project'] = $expenseOnMaterial->project->name;
                $temp['entry_date'] = date("d-m-Y", strtotime($expenseOnMaterial->context_date));
                $temp['product'] = $product->product ? $product->product->title : '';
                $temp['quantity'] = $product->quantity;
                $temp['unit_price'] = $oimsSetting->getPriceFormattedWithoutCurrency($product->unit_price);
                $temp['total_price'] = $oimsSetting->getPriceFormattedWithoutCurrency($product->total_price);
                $excel_rows[] = $temp;
                $grand_total += $product->total_price;
            }
        }
        $export_data[] = ['title' => 'Expense Against Material', 'header' => $header_columns, 'rows' => $excel_rows];


        //Summary
        $fix_expense = $this->vars['fix_expense'] * $total_days;
        $total_expense = $fix_expense + $grand_total;
        $net_profit = $progress_total - $total_expense;
        $profit_percentage = 0;
        if ($progress_total > 0) {
            $profit_percentage = $net_profit / $progress_total * 100;
        }

        $temp = [];
        $temp['title'] = 'Summary';
        $temp['header'] = ['DESCRIPTION', 'AMOUNT'];
        $temp['rows'] = [
            ['TOTAL EXPENSE (B+C+D+E)', $oimsSetting->getPriceFormattedWithoutCurrency($grand_total)],
            ["TOTAL FIX EXPENSE (Total Days $total_days)", $oimsSetting->getPriceFormattedWithoutCurrency($fix_expense)],
            ['GRAND TOTAL EXPENSE', $oimsSetting->getPriceFormattedWithoutCurrency($total_expense)],
            ['NET WORK DONE(A)', $oimsSetting->getPriceFormattedWithoutCurrency($progress_total)],
            ['NET PROFIT & LOSS', $oimsSetting->getPriceFormattedWithoutCurrency($net_profit)],
            ['NET PROFIT & LOSS IN %AGE', $oimsSetting->getPriceFormattedWithoutCurrency($profit_percentage)]
        ];
        $export_data[] = $temp;
        ////////////////////////////////////////////////////////////
        $fileName = 'dpr_report_' . time() . $file_type;

        Excel::excel()->store(new \Olabs\Oims\Exports\ReportsExport($export_data), $fileName, 'local');

        return \Redirect::to('/backend/olabs/oims/reports/download?name=' . $fileName);
    }

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

    public function progress_report() {
        BackendMenu::setContext('Olabs.Oims', 'reports', 'progress_report');
        $this->pageTitle = 'Progress Report';
        $projectprogress = array();
        $manpowers = array();
        $machineries = array();
        $expenseOnMaterials = array();
        $expenseOnPcs = array();

//        $oimsSetting = '';
        $oimsSetting = \Olabs\Oims\Models\Settings::instance();

        $searchForm = $this->searchFormWidget;

        $this->vars['search'] = false;
        $this->vars['msg'] = false;
        $this->vars['searchFormWidget'] = $searchForm;
        $this->vars['projectprogress'] = $projectprogress;
        $this->vars['manpowers'] = $manpowers;
        $this->vars['machineries'] = $machineries;
        $this->vars['expenseOnMaterials'] = $expenseOnMaterials;
        $this->vars['expenseOnPcs'] = $expenseOnPcs;
        $this->vars['oimsSetting'] = $oimsSetting;
        $this->vars['grand_total'] = 0;
        $this->vars['progress_total'] = 0;
        $this->vars['fix_expense'] = 0;
        $this->vars['total_days'] = 0;
        $this->vars['from_date'] = 0;
        $this->vars['to_date'] = 0;
    }

    public function onProgressSearch() {
        $projectprogress = array();
        $manpowers = array();
        $machineries = array();
        $expenseOnMaterials = array();
        $expenseOnPcs = array();
        $total_days = 0;

        $this->vars['grand_total'] = 0;
        $this->vars['progress_total'] = 0;
        $this->vars['fix_expense'] = 0;

        if (post('DprSearch')) {

            $searchParams = post('DprSearch');

            // get dpr components
            $this->searchDPR($searchParams);

            $search_from_date = isset($searchParams['from_date']) ? $searchParams['from_date'] : '';
            $search_to_date = isset($searchParams['to_date']) ? $searchParams['to_date'] : '';
//
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

            $projectModal = \Olabs\Oims\Models\Project::find($project);
        }

        $oimsSetting = \Olabs\Oims\Models\Settings::instance();

        $this->vars['search'] = true;
        $this->vars['oimsSetting'] = $oimsSetting;
        $this->vars['from_date'] = $from_date;
        $this->vars['to_date'] = $to_date;
    }

//    public function onProgressExport_BIN() {
//
//
//        //generate PDF html
//        $projectprogress = array();
//        $manpowers = array();
//        $machineries = array();
//        $expenseOnMaterials = array();
//        $expenseOnPcs = array();
//        $total_days = 0;
//
//        $this->vars['grand_total'] = 0;
//        $this->vars['progress_total'] = 0;
//        $this->vars['fix_expense'] = 0;
//
//        if (post('DprSearch')) {
//
//            $searchParams = post('DprSearch');
//
//            // get dpr components
//            $this->searchDPR($searchParams);
//
//            $search_from_date = isset($searchParams['from_date']) ? $searchParams['from_date'] : '';
//            $search_to_date = isset($searchParams['to_date']) ? $searchParams['to_date'] : '';
////
//            $from_date = false;
//            if ($search_from_date != '') {
//                $from_date = \Olabs\Oims\Models\Settings::convertToDBDate($search_from_date); //date('Y-m-d 00:00:00', strtotime($from_date));
//            }
//
//            $to_date = false;
//            if ($search_to_date != '') {
//                $timeFormat = '23:59:59';
//                $to_date = \Olabs\Oims\Models\Settings::convertToDBDate($search_to_date, $timeFormat);
//            }
//
//            $project = ( trim($searchParams['project']) != "" ) ? $searchParams['project'] : false;
//
//            $projectModal = \Olabs\Oims\Models\Project::find($project);
//        }
//
//        $oimsSetting = \Olabs\Oims\Models\Settings::instance();
//
//        $this->vars['search'] = true;
//        $this->vars['from_date'] = $from_date;
//        $this->vars['to_date'] = $to_date;
//
//        $projectprogress = $this->vars['projectprogress'];
//        $manpowers = $this->vars['manpowers'];
//        $machineries = $this->vars['machineries'];
//        $expenseOnMaterials = $this->vars['expenseOnMaterials'];
//        $expenseOnPcs = $this->vars['expenseOnPcs'];
//        $fix_expense = $this->vars['fix_expense'];
//
//        $total_days = $this->vars['total_days'];
//
//        $style = ".product-title { width: 315px; display: inline-block; }
//.product-quantity { width: 50px; display: inline-block; }
//.product-price-without-tax { width: 100px; display: inline-block; text-align: right; }
//.product-tax { width: 100px; display: inline-block; text-align: right; }
//.product-price { width: 130px; display: inline-block; text-align: right; }
//table { width: 100%; border-collapse: collapse; font-size:12px;}
//td, th { border: 1px solid #ccc; }";
//
//        $html = "<html><head><style>" . $style . "</style></head><body>";
//
//        $html .= "<h3>Progress Report for Project : " . $projectModal['name'] . ", From : " . \Olabs\Oims\Models\Settings::convertToDisplayDate($from_date) . " To : " . \Olabs\Oims\Models\Settings::convertToDisplayDate($to_date) . "</h3>";
//
//        $html .= $this->makePartial('progress_projectprogress_list', [
//            'projectprogress' => $projectprogress,
//            'manpowers' => $manpowers,
//            'machineries' => $machineries,
//            'expenseOnPcs' => $expenseOnPcs,
//            'expenseOnMaterials' => $expenseOnMaterials,
//            'from_date' => $from_date,
//            'to_date' => $to_date,
//            'total_days' => $total_days,
//            'fix_expense' => $fix_expense,
//            'oimsSetting' => $oimsSetting]);
//
//        $html .= "</body></html>";
//
//
//        // Generate invoice
//        $fileName = 'progress_report_' . time();
//        $invoiceTempFile = temp_path() . "/" . $fileName . ".pdf";
//        $pdf = App::make('dompdf.wrapper');
//
//
//        $pdf->loadHtml($html);
//
//        // (Optional) Setup the paper size and orientation
//        $pdf->setPaper('A4', 'landscape'); //landscape  portrait
//        // Output the generated PDF to Browser
//        $pdf->save($invoiceTempFile);
//
//        return \Redirect::to('/backend/olabs/oims/reports/downloadPdf?name=' . $fileName);
//    }

    public function onProgressExportExcel() {

        $file_type = '.' . post('type');

        ////////Generate Excel Data
        //generate PDF html
        $projectprogress = array();
        $manpowers = array();
        $machineries = array();
        $expenseOnMaterials = array();
        $expenseOnPcs = array();
        $total_days = 0;

        $this->vars['grand_total'] = 0;
        $this->vars['progress_total'] = 0;
        $this->vars['fix_expense'] = 0;

        if (post('DprSearch')) {

            $searchParams = post('DprSearch');

            // get dpr components
            $this->searchDPR($searchParams);

            $search_from_date = isset($searchParams['from_date']) ? $searchParams['from_date'] : '';
            $search_to_date = isset($searchParams['to_date']) ? $searchParams['to_date'] : '';
//
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

            $projectModal = \Olabs\Oims\Models\Project::find($project);
        }

        $oimsSetting = \Olabs\Oims\Models\Settings::instance();

        $this->vars['search'] = true;
        $this->vars['from_date'] = $from_date;
        $this->vars['to_date'] = $to_date;

        $projectprogress = $this->vars['projectprogress'];
        $manpowers = $this->vars['manpowers'];
        $machineries = $this->vars['machineries'];
        $expenseOnMaterials = $this->vars['expenseOnMaterials'];
        $expenseOnPcs = $this->vars['expenseOnPcs'];
        $fix_expense = $this->vars['fix_expense'];

        $total_days = $this->vars['total_days'];
        /////////////////////////////////////////////////////////////
        //Generate Rows
        $progress_items = [];
        $progress_rows = [];

        foreach ($projectprogress as $progress) {
            $products = $progress->products ? $progress->products : array();
            foreach ($products as $product) {
                $work_name = '';
                if ($product->work) {
                    $work_name = $product->work->name . " ({$product->work->unit})";
                }
                $progress_items[$product->work_id] = $work_name;
            }
        }

        //make date rows

        $from_date = strtotime($from_date);

        $summary_row = array();
        $summary_row['date'] = 'Total';
        $summary_row['total_spent'] = 0;
        $summary_row['total_billing'] = 0;

        foreach ($progress_items as $key => $progress_item) {
            $summary_row[$key] = 0;
        }

        for ($i = 0; $i < $total_days; $i++) {
            $today_date = date('Y-m-d', strtotime("+{$i} day", $from_date));

            //clone items;
            $items = $progress_items;

            $total_billing = 0;
            $total_spent = 0;
            $temp_row = [];
            $temp_row['date'] = date("d-m-Y", strtotime($today_date));
            $temp_row['total_spent'] = 0;
            $temp_row['total_billing'] = 0;

            foreach ($progress_items as $key => $progress_item) {
                $temp_row[$key] = 0;
            }



            //Total Billing   
            foreach ($projectprogress as $progress) {
                $entry_date = date('Y-m-d', strtotime($progress->start_date));
                if ($entry_date == $today_date) {
                    $products = $progress->products ? $progress->products : array();
                    foreach ($products as $product) {
                        $temp_row[$product->work_id] += $product->quantity;
                        $total_billing += $product->total_price;

                        //Summary Total
                        $summary_row[$product->work_id] += $product->quantity;
                    }
                }
            }

            //Total Spent
            foreach ($manpowers as $data) {
                $products = $data->products ? $data->products : array();
                $entry_date = date('Y-m-d', strtotime($data->context_date));
                if ($entry_date == $today_date) {
                    $total_spent += $data->total_price;
                }
            }
            foreach ($machineries as $data) {
                $products = $data->products ? $data->products : array();
                $entry_date = date('Y-m-d', strtotime($data->context_date));
                if ($entry_date == $today_date) {
                    $total_spent += $data->total_price;
                }
            }
            foreach ($expenseOnPcs as $data) {
                $products = $data->products ? $data->products : array();
                $entry_date = date('Y-m-d', strtotime($data->context_date));
                if ($entry_date == $today_date) {
                    $total_spent += $data->total_price;
                }
            }
            foreach ($expenseOnMaterials as $data) {
                $products = $data->products ? $data->products : array();
                $entry_date = date('Y-m-d', strtotime($data->context_date));
                if ($entry_date == $today_date) {
                    $total_spent += $data->total_price;
                }
            }

            //Fix Expense
            $total_spent += $fix_expense;

            $temp_row['total_spent'] = $total_spent;
            $temp_row['total_billing'] = $total_billing;

            //Grand Total
            $summary_row['total_spent'] += $total_spent;
            $summary_row['total_billing'] += $total_billing;

            $progress_rows[$today_date] = $temp_row;
        }


        $net_profit = $summary_row['total_billing'] - $summary_row['total_spent'];
        $profit_percentage = 0;
        $row_class = '';
        if ($summary_row['total_spent'] > 0) {
            // $profit_percentage = $net_profit / $summary_row['total_spent'] * 100;
            $profit_percentage = $net_profit / $summary_row['total_billing'] * 100;
        }


        $header_columns = ['Date', 'Total Amount Spent', 'Billing Amount'];


        $header_columns = array_merge($header_columns, $progress_items);

        $export_data = [];
        $temp = [];
        $temp['title'] = 'Project Progress';
        $temp['header'] = $header_columns;
        $temp['rows'] = $progress_rows;
        $export_data[] = $temp;

        $temp = [];
        $temp['title'] = 'Net Profile & Loss';
        $temp['header'] = ['DESCRIPTION', 'AMOUNT'];
        $temp['rows'] = [['NET PROFIT & LOSS', $net_profit], ['NET PROFIT & LOSS IN %AGE', $profit_percentage]];
        $export_data[] = $temp;

        ////////////////////////////////////////////////////////////
        $fileName = 'progress_report_' . time() . $file_type;

        Excel::excel()->store(new \Olabs\Oims\Exports\ReportsExport($export_data), $fileName, 'local');

        return \Redirect::to('/backend/olabs/oims/reports/download?name=' . $fileName);
    }

    //MR Report
    public function mr_report() {
        BackendMenu::setContext('Olabs.Oims', 'reports', 'mr_report');
        $this->searchFormWidget = $this->createMRSearchFormWidget();
        $this->pageTitle = 'MR Report';
        $reports = array();

        $oimsSetting = \Olabs\Oims\Models\Settings::instance();

        $searchForm = $this->searchFormWidget;

        $this->vars['search'] = false;
        $this->vars['msg'] = false;
        $this->vars['searchFormWidget'] = $searchForm;
        $this->vars['reports'] = $reports;

        $this->vars['oimsSetting'] = $oimsSetting;
    }

    public function onMrSearch() {
        $reports = array();

        if (post('reportSearch')) {

            $searchParams = post('reportSearch');

            // get dpr components
            $this->searchMRReport($searchParams);
        }

        $oimsSetting = \Olabs\Oims\Models\Settings::instance();

        $this->vars['search'] = true;
        $this->vars['oimsSetting'] = $oimsSetting;
    }

//    public function onMrReportExport_BIN() {
//
//
//        //generate PDF html
//        $report = array();
//
//        if (post('reportSearch')) {
//
//            $searchParams = post('reportSearch');
//
//            // get dpr components
//            $this->searchMRReport($searchParams);
//
//            $search_from_date = isset($searchParams['from_date']) ? $searchParams['from_date'] : '';
//            $search_to_date = isset($searchParams['to_date']) ? $searchParams['to_date'] : '';
////
//            $from_date = false;
//            if ($search_from_date != '') {
//                $from_date = \Olabs\Oims\Models\Settings::convertToDBDate($search_from_date); //date('Y-m-d 00:00:00', strtotime($from_date));
//            }
//
//            $to_date = false;
//            if ($search_to_date != '') {
//                $timeFormat = '23:59:59';
//                $to_date = \Olabs\Oims\Models\Settings::convertToDBDate($search_to_date, $timeFormat);
//            }
//
//            $project = ( trim($searchParams['project']) != "" ) ? $searchParams['project'] : false;
//
//            $projectModal = \Olabs\Oims\Models\Project::find($project);
//        }
//
//        $oimsSetting = \Olabs\Oims\Models\Settings::instance();
//
//        $this->vars['search'] = true;
//        $this->vars['from_date'] = $from_date;
//        $this->vars['to_date'] = $to_date;
//
//        $reports = $this->vars['reports'];
////        $manpowers = $this->vars['manpowers'];
////        $machineries = $this->vars['machineries'];
////        $expenseOnMaterials = $this->vars['expenseOnMaterials'];
////        $expenseOnPcs = $this->vars['expenseOnPcs'];
////        $fix_expense = $this->vars['fix_expense'];
////
////        $total_days = $this->vars['total_days'];
//
//        $style = ".product-title { width: 315px; display: inline-block; }
//.product-quantity { width: 50px; display: inline-block; }
//.product-price-without-tax { width: 100px; display: inline-block; text-align: right; }
//.product-tax { width: 100px; display: inline-block; text-align: right; }
//.product-price { width: 130px; display: inline-block; text-align: right; }
//table { width: 100%; border-collapse: collapse; font-size:12px;}
//td, th { border: 1px solid #ccc; }";
//
//        $html = "<html><head><style>" . $style . "</style></head><body>";
//
//        $html .= "<h3>MR Report From : " . \Olabs\Oims\Models\Settings::convertToDisplayDate($from_date) . " To : " . \Olabs\Oims\Models\Settings::convertToDisplayDate($to_date) . "</h3>";
//
//        $html .= $this->makePartial('mr_report_list', [
//            'reports' => $reports,
////            'manpowers' => $manpowers,
////            'machineries' => $machineries,
////            'expenseOnPcs' => $expenseOnPcs,
////            'expenseOnMaterials' => $expenseOnMaterials,
//            'from_date' => $from_date,
//            'to_date' => $to_date,
////            'total_days' => $total_days,
////            'fix_expense' => $fix_expense,
//            'oimsSetting' => $oimsSetting]);
//
//        $html .= "</body></html>";
//
//
//        // Generate invoice
//        $fileName = 'mr_report_' . time();
//        $invoiceTempFile = temp_path() . "/" . $fileName . ".pdf";
//        $pdf = App::make('dompdf.wrapper');
//
//
//        $pdf->loadHtml($html);
//
//        // (Optional) Setup the paper size and orientation
//        $pdf->setPaper('A4', 'portrait'); //landscape
//        // Output the generated PDF to Browser
//        $pdf->save($invoiceTempFile);
//
//        return \Redirect::to('/backend/olabs/oims/reports/downloadPdf?name=' . $fileName);
//    }

    public function onMRExportExcel() {
        $file_type = '.' . post('type');

        ////////Generate Excel Data
        $report = array();

        if (post('reportSearch')) {

            $searchParams = post('reportSearch');

            $this->searchMRReport($searchParams);

            $search_from_date = isset($searchParams['from_date']) ? $searchParams['from_date'] : '';
            $search_to_date = isset($searchParams['to_date']) ? $searchParams['to_date'] : '';
//
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

            $projectModal = \Olabs\Oims\Models\Project::find($project);
        }

        $oimsSetting = \Olabs\Oims\Models\Settings::instance();

        $this->vars['search'] = true;
        $this->vars['from_date'] = $from_date;
        $this->vars['to_date'] = $to_date;

        $reports = $this->vars['reports'];

        //Generating Excel
        $header_columns = ['MR No.', 'Project', 'Entry Date', 'Status', 'Supplier', 'Product', 'Quantity', 'Unit', 'Unit Price', 'Total Price'];

        //MR Report
        $excel_rows = [];
        $status_count = [];
        $grand_total = 0;
        $count = 0;
        foreach ($reports as $report) {
            $count++;
            $grand_total += $report->total_price;
            $products = $report->products ? $report->products : array();
            $status_count[$report->status_name] = isset($status_count[$report->status_name]) ? $status_count[$report->status_name] + 1 : 1;
            foreach ($products as $product) {
                $temp = [];
                $temp['mr_no'] = $report->reference_number;
                $temp['project'] = $report->project->name;
                $temp['entry_date'] = date("d-m-Y", strtotime($report->context_date));
                $temp['status'] = $report->status_name;
                $temp['supplier'] = $report->supplier ? $report->supplier->fullname : '--';
                $temp['product'] = $product->product ? $product->product->title : '';
                $temp['quantity'] = $product->quantity;
                $temp['unit'] = $product->unit;
                $temp['unit_price'] = $oimsSetting->getPriceFormattedWithoutCurrency($product->unit_price);
                $temp['total_price'] = $oimsSetting->getPriceFormattedWithoutCurrency($product->total_price);
                $excel_rows[] = $temp;
            }
        }

        $export_data[] = ['title' => 'MR Report', 'header' => $header_columns, 'rows' => $excel_rows];


        //Summary
        $temp = [];
        $temp['title'] = 'Summary';
        $temp['header'] = ['DESCRIPTION', 'AMOUNT / COUNT'];
        $temp['rows'] = [
            ['TOTAL MR ENTRY', $count],
            ["TOTAL MR AMOUNT", $oimsSetting->getPriceFormattedWithoutCurrency($grand_total)],
        ];
        foreach ($status_count as $k => $v) {
            $temp['rows'][] = [$k . ' MR Count', $v];
        }
        $export_data[] = $temp;
        ////////////////////////////////////////////////////////////
        $fileName = 'mr_report_' . time() . $file_type;

        Excel::excel()->store(new \Olabs\Oims\Exports\ReportsExport($export_data), $fileName, 'local');

        return \Redirect::to('/backend/olabs/oims/reports/download?name=' . $fileName);
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

    //Attendance Report
    public function attendance_report() {
        BackendMenu::setContext('Olabs.Oims', 'reports', 'attendance_report');
        $this->searchFormWidget = $this->createAttendanceSearchFormWidget();
        $this->pageTitle = 'Attendance Report';
        $reports = array();

        $oimsSetting = \Olabs\Oims\Models\Settings::instance();

        $searchForm = $this->searchFormWidget;

        $this->vars['search'] = false;
        $this->vars['msg'] = false;
        $this->vars['searchFormWidget'] = $searchForm;
        $this->vars['reports'] = $reports;

        $this->vars['oimsSetting'] = $oimsSetting;
    }

    public function onAttendanceSearch() {
        $reports = array();

        if (post('reportSearch')) {

            $searchParams = post('reportSearch');

            // get dpr components
            $this->searchAttendanceReport($searchParams);
        }

        $oimsSetting = \Olabs\Oims\Models\Settings::instance();

        $this->vars['search'] = true;
        $this->vars['oimsSetting'] = $oimsSetting;
    }

//    public function onAttendanceReportExport_BIN() {
//
//
//        //generate PDF html
//        $report = array();
//
//        if (post('reportSearch')) {
//
//            $searchParams = post('reportSearch');
//
//            // get dpr components
//            $this->searchAttendanceReport($searchParams);
//
//            $search_from_date = isset($searchParams['from_date']) ? $searchParams['from_date'] : '';
//            $search_to_date = isset($searchParams['to_date']) ? $searchParams['to_date'] : '';
////
//            $from_date = false;
//            if ($search_from_date != '') {
//                $from_date = \Olabs\Oims\Models\Settings::convertToDBDate($search_from_date); //date('Y-m-d 00:00:00', strtotime($from_date));
//            }
//
//            $to_date = false;
//            if ($search_to_date != '') {
//                $timeFormat = '23:59:59';
//                $to_date = \Olabs\Oims\Models\Settings::convertToDBDate($search_to_date, $timeFormat);
//            }
//
//            $project = ( trim($searchParams['project']) != "" ) ? $searchParams['project'] : false;
//
//            $projectModal = \Olabs\Oims\Models\Project::find($project);
//        }
//
//        $oimsSetting = \Olabs\Oims\Models\Settings::instance();
//
//        $this->vars['search'] = true;
//        $this->vars['from_date'] = $from_date;
//        $this->vars['to_date'] = $to_date;
//
//        $reports = $this->vars['reports'];
////        $manpowers = $this->vars['manpowers'];
////        $machineries = $this->vars['machineries'];
////        $expenseOnMaterials = $this->vars['expenseOnMaterials'];
////        $expenseOnPcs = $this->vars['expenseOnPcs'];
////        $fix_expense = $this->vars['fix_expense'];
////
////        $total_days = $this->vars['total_days'];
//
//        $style = ".product-title { width: 315px; display: inline-block; }
//.product-quantity { width: 50px; display: inline-block; }
//.product-price-without-tax { width: 100px; display: inline-block; text-align: right; }
//.product-tax { width: 100px; display: inline-block; text-align: right; }
//.product-price { width: 130px; display: inline-block; text-align: right; }
//table { width: 100%; border-collapse: collapse; font-size:12px;}
//td, th { border: 1px solid #ccc; }";
//
//        $html = "<html><head><style>" . $style . "</style></head><body>";
//
//        $html .= "<h3>Attendance Report From : " . \Olabs\Oims\Models\Settings::convertToDisplayDate($from_date) . " To : " . \Olabs\Oims\Models\Settings::convertToDisplayDate($to_date) . "</h3>";
//
//        $html .= $this->makePartial('attendance_report_list', [
//            'reports' => $reports,
////            'manpowers' => $manpowers,
////            'machineries' => $machineries,
////            'expenseOnPcs' => $expenseOnPcs,
////            'expenseOnMaterials' => $expenseOnMaterials,
//            'from_date' => $from_date,
//            'to_date' => $to_date,
////            'total_days' => $total_days,
////            'fix_expense' => $fix_expense,
//            'oimsSetting' => $oimsSetting]);
//
//        $html .= "</body></html>";
//
//
//        // Generate invoice
//        $fileName = 'attendance_report_' . time();
//        $invoiceTempFile = temp_path() . "/" . $fileName . ".pdf";
//        $pdf = App::make('dompdf.wrapper');
//
//
//        $pdf->loadHtml($html);
//
//        // (Optional) Setup the paper size and orientation
//        $pdf->setPaper('A4', 'portrait'); //landscape
//        // Output the generated PDF to Browser
//        $pdf->save($invoiceTempFile);
//
//        return \Redirect::to('/backend/olabs/oims/reports/downloadPdf?name=' . $fileName);
//    }

    public function onAttendanceExportExcel() {
        $file_type = '.' . post('type');

        ////////Generate Excel Data
        $report = array();

        if (post('reportSearch')) {

            $searchParams = post('reportSearch');

            // get dpr components
            $this->searchAttendanceReport($searchParams);

            $search_from_date = isset($searchParams['from_date']) ? $searchParams['from_date'] : '';
            $search_to_date = isset($searchParams['to_date']) ? $searchParams['to_date'] : '';
//
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

            $projectModal = \Olabs\Oims\Models\Project::find($project);
        }

        $oimsSetting = \Olabs\Oims\Models\Settings::instance();

        $this->vars['search'] = true;
        $this->vars['from_date'] = $from_date;
        $this->vars['to_date'] = $to_date;

        $reports = $this->vars['reports'];

        //Generating Excel
        $header_columns = ['Project', 'Supplier', 'Employee', 'Employee Type', 'Attendance Date', 'Check-In', 'Check-Out', 'Daily Wages', 'Total Hours', 'Over Time', 'Total Wages'];

        //MR Report
        $excel_rows = [];
        $grand_total = 0;
        $count = 0;

        foreach ($reports as $report) {
            $count++;
            $grand_total += $report->total_wages;

            $temp = [];
            $temp['project'] = isset($report->project->name) ? $report->project->name : '';
            $temp['supplier'] = isset($report->supplier->fullname) ? $report->supplier->fullname : '';
            $temp['employee'] = $report->getEmployeeName();
            $temp['employee_type'] = $report->getEmployeeType();
            $temp['attendance_date'] = $oimsSetting->convertToDisplayDate($report->check_in, 'd/m/Y');
            $temp['check_in'] = $oimsSetting->convertToDisplayDate($report->check_in, 'd/m/Y H:i');
            $temp['check_out'] = $oimsSetting->convertToDisplayDate($report->check_out, 'd/m/Y H:i');
            $temp['wages'] = $report->daily_wages;
            $temp['total_hours'] = $report->total_working_hour;
            $temp['over_time'] = $report->overtime;
            $temp['total_wages'] = $oimsSetting->getPriceFormattedWithoutCurrency($report->total_wages);

            $excel_rows[] = $temp;
        }

        $export_data[] = ['title' => 'Attendance Report', 'header' => $header_columns, 'rows' => $excel_rows];


        //Summary

        $temp = [];
        $temp['title'] = 'Summary';
        $temp['header'] = ['DESCRIPTION', 'AMOUNT / COUNT'];
        $temp['rows'] = [
            ['TOTAL ATTENDANCE', $count],
            ["TOTAL ATTENDANCE AMOUNT", $oimsSetting->getPriceFormattedWithoutCurrency($grand_total)],
        ];

        $export_data[] = $temp;
        ////////////////////////////////////////////////////////////
        $fileName = 'attendance_report_' . time() . $file_type;

        Excel::excel()->store(new \Olabs\Oims\Exports\ReportsExport($export_data), $fileName, 'local');

        return \Redirect::to('/backend/olabs/oims/reports/download?name=' . $fileName);
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
        
        
        
        if($attendance_type == \Olabs\Oims\Models\Attendance::EMPLOYEE_TYPE_OFFROLE){
            $model = \Olabs\Oims\Models\Attendance::where($params)
                ->with('employee_offrole')
                ->whereIn('project_id', $assigned_projects);
        }else {
            $model = \Olabs\Oims\Models\Attendance::select()
                    ->where($params);
//                    ->with('employee_offrole')
//                    ->join("backend_users",'backend_users.id','employee_id');
                
//                ->whereIn('project_id', $assigned_projects);
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
        $model->orderBy('supplier_id');
        $model->orderBy('check_in');
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

    //Attendance Summary Report
    public function attendanceSummary_report() {
        BackendMenu::setContext('Olabs.Oims', 'reports', 'attendance_summary_report');
        $this->searchFormWidget = $this->createAttendanceSearchFormWidget();
        $this->pageTitle = 'Attendance Summary Report';
        $reports = array();
//        dd('hi');
        $oimsSetting = \Olabs\Oims\Models\Settings::instance();

        $searchForm = $this->searchFormWidget;

        $this->vars['search'] = false;
        $this->vars['msg'] = false;
        $this->vars['searchFormWidget'] = $searchForm;
        $this->vars['reports'] = $reports;

        $this->vars['oimsSetting'] = $oimsSetting;
    }

    public function onAttendanceSummarySearch() {
        $reports = array();

        if (post('reportSearch')) {

            $searchParams = post('reportSearch');

            // get dpr components
            $this->searchAttendanceReport($searchParams);
        }

        $oimsSetting = \Olabs\Oims\Models\Settings::instance();

        $this->vars['search'] = true;
        $this->vars['oimsSetting'] = $oimsSetting;
    }

//    public function onAttendanceSummaryReportExport_BIN() {
//
//
//        //generate PDF html
//        $report = array();
//
//        if (post('reportSearch')) {
//
//            $searchParams = post('reportSearch');
//
//            // get dpr components
//            $this->searchAttendanceReport($searchParams);
//
//            $search_from_date = isset($searchParams['from_date']) ? $searchParams['from_date'] : '';
//            $search_to_date = isset($searchParams['to_date']) ? $searchParams['to_date'] : '';
////
//            $from_date = false;
//            if ($search_from_date != '') {
//                $from_date = \Olabs\Oims\Models\Settings::convertToDBDate($search_from_date); //date('Y-m-d 00:00:00', strtotime($from_date));
//            }
//
//            $to_date = false;
//            if ($search_to_date != '') {
//                $timeFormat = '23:59:59';
//                $to_date = \Olabs\Oims\Models\Settings::convertToDBDate($search_to_date, $timeFormat);
//            }
//
//            $project = ( trim($searchParams['project']) != "" ) ? $searchParams['project'] : false;
//
//            $projectModal = \Olabs\Oims\Models\Project::find($project);
//        }
//
//        $oimsSetting = \Olabs\Oims\Models\Settings::instance();
//
//        $this->vars['search'] = true;
//        $this->vars['from_date'] = $from_date;
//        $this->vars['to_date'] = $to_date;
//
//        $reports = $this->vars['reports'];
////        $manpowers = $this->vars['manpowers'];
////        $machineries = $this->vars['machineries'];
////        $expenseOnMaterials = $this->vars['expenseOnMaterials'];
////        $expenseOnPcs = $this->vars['expenseOnPcs'];
////        $fix_expense = $this->vars['fix_expense'];
////
////        $total_days = $this->vars['total_days'];
//
//        $style = ".product-title { width: 315px; display: inline-block; }
//.product-quantity { width: 50px; display: inline-block; }
//.product-price-without-tax { width: 100px; display: inline-block; text-align: right; }
//.product-tax { width: 100px; display: inline-block; text-align: right; }
//.product-price { width: 130px; display: inline-block; text-align: right; }
//table { width: 100%; border-collapse: collapse; font-size:12px;}
//td, th { border: 1px solid #ccc; }";
//
//        $html = "<html><head><style>" . $style . "</style></head><body>";
//
//        $html .= "<h3>Attendance Report From : " . \Olabs\Oims\Models\Settings::convertToDisplayDate($from_date) . " To : " . \Olabs\Oims\Models\Settings::convertToDisplayDate($to_date) . "</h3>";
//
//        $html .= $this->makePartial('attendance_summary_report_list', [
//            'reports' => $reports,
////            'manpowers' => $manpowers,
////            'machineries' => $machineries,
////            'expenseOnPcs' => $expenseOnPcs,
////            'expenseOnMaterials' => $expenseOnMaterials,
//            'from_date' => $from_date,
//            'to_date' => $to_date,
////            'total_days' => $total_days,
////            'fix_expense' => $fix_expense,
//            'oimsSetting' => $oimsSetting]);
//
//        $html .= "</body></html>";
//
//
//        // Generate invoice
//        $fileName = 'attendance_report_' . time();
//        $invoiceTempFile = temp_path() . "/" . $fileName . ".pdf";
//        $pdf = App::make('dompdf.wrapper');
//
//
//        $pdf->loadHtml($html);
//
//        // (Optional) Setup the paper size and orientation
//        $pdf->setPaper('A4', 'landscape'); //landscape
//        // Output the generated PDF to Browser
//        $pdf->save($invoiceTempFile);
//
//        return \Redirect::to('/backend/olabs/oims/reports/downloadPdf?name=' . $fileName);
//    }

    public function onAttendanceSummaryExportExcel() {

        $file_type = '.' . post('type');

        ////////Generate Excel Data

        $report = array();

        if (post('reportSearch')) {

            $searchParams = post('reportSearch');

            // get dpr components
            $this->searchAttendanceReport($searchParams);

            $search_from_date = isset($searchParams['from_date']) ? $searchParams['from_date'] : '';
            $search_to_date = isset($searchParams['to_date']) ? $searchParams['to_date'] : '';
//
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

            $projectModal = \Olabs\Oims\Models\Project::find($project);
        }

        $oimsSetting = \Olabs\Oims\Models\Settings::instance();

        $this->vars['search'] = true;
        $this->vars['from_date'] = $from_date;
        $this->vars['to_date'] = $to_date;

        $reports = $this->vars['reports'];

        //Generating Excel
        $header_columns = ['Project', 'Attendance Date'];

        $grand_total = 0;
        $count = 0;
        $employee_types = [];
        $rows = [];
        $wages = [];
        foreach ($reports as $report) {
            if (isset($report->employee_offrole)) {
                $employee_type = $report->employee_offrole->employee_type;
                $employee_wage = $report->total_wages;
                $employee_types[$employee_type] = ucfirst($employee_type); //['count'=>0,'total'=>0];
                $attendance_date = $oimsSetting->convertToDisplayDate($report->check_in, 'd/m/Y');
                $temp = [];
                $temp['project_name'] = $report->project->name;
                $temp['attendance_date'] = $attendance_date;

                $key = $report->project_id . '_' . $attendance_date . '_' . $employee_type;
                $wages[$key]['count'] = isset($wages[$key]['count']) ? $wages[$key]['count'] + 1 : 1;
                $wages[$key]['total'] = isset($wages[$key]['total']) ? $wages[$key]['total'] + $employee_wage : $employee_wage;

                $rows[$report->project_id][$attendance_date] = $temp;
            }
        }

        foreach ($employee_types as $key => $employee_type) {
            $header_columns[] = ucfirst($key) . ' Count';
            $header_columns[] = ucfirst($key) . ' Wages';
        }

        $header_columns[] = 'Total Count';
        $header_columns[] = 'Total Wages';



        //Attendance Summary Report
        $excel_rows = [];

        $summary_count = 0;
        $summary_total = 0;
        foreach ($rows as $project_id => $project_row) {
            foreach ($project_row as $attendance_date => $attendance_row) {
                $attendance_count = 0;
                $attendance_total = 0;
                $temp = [];
                $temp[] = $attendance_row['project_name'];
                $temp[] = $attendance_row['attendance_date'];

                foreach ($employee_types as $key => $employee_type) {
                    $data_key = $project_id . '_' . $attendance_date . '_' . $key;
                    $data_count = isset($wages[$data_key]['count']) ? $wages[$data_key]['count'] : 0;
                    $data_total = isset($wages[$data_key]['total']) ? $wages[$data_key]['total'] : 0;
                    $temp[] = $data_count;
                    $temp[] = $oimsSetting->getPriceFormattedWithoutCurrency($data_total);
                    $attendance_count += $data_count; //Attendance Total
                    $attendance_total += $data_total;
                    $summary_count += $data_count; //Grand Total
                    $summary_total += $data_total;
                }
                $temp[] = $attendance_count;
                $temp[] = $oimsSetting->getPriceFormattedWithoutCurrency($attendance_total);

                $excel_rows[] = $temp;
            }
        }

        $export_data[] = ['title' => 'Attendance Summary Report', 'header' => $header_columns, 'rows' => $excel_rows];


        //Summary
        $temp = [];
        $temp['title'] = 'Summary';
        $temp['header'] = ['DESCRIPTION', 'AMOUNT / COUNT'];
        $temp['rows'] = [
            ['TOTAL ATTENDANCE', $summary_count],
            ["TOTAL ATTENDANCE AMOUNT", $oimsSetting->getPriceFormattedWithoutCurrency($summary_total)],
        ];

        $export_data[] = $temp;
        ////////////////////////////////////////////////////////////
        $fileName = 'attendance_summary_report_' . time() . $file_type;

        Excel::excel()->store(new \Olabs\Oims\Exports\ReportsExport($export_data), $fileName, 'local');

        return \Redirect::to('/backend/olabs/oims/reports/download?name=' . $fileName);
    }

    //Petty Contractor Attendance Report
    public function pcAttendance_report() {
        BackendMenu::setContext('Olabs.Oims', 'reports', 'pcattendance_report');
        $this->searchFormWidget = $this->createAttendanceSearchFormWidget();
        $this->pageTitle = 'Petty Contractor Attendance Report';
        $reports = array();

        $oimsSetting = \Olabs\Oims\Models\Settings::instance();

        $searchForm = $this->searchFormWidget;

        $this->vars['search'] = false;
        $this->vars['msg'] = false;
        $this->vars['searchFormWidget'] = $searchForm;
        $this->vars['reports'] = $reports;

        $this->vars['oimsSetting'] = $oimsSetting;
    }

    public function onPcAttendanceSearch() {
        $reports = array();

        if (post('reportSearch')) {

            $searchParams = post('reportSearch');

            // get dpr components
            $this->searchPcAttendanceReport($searchParams);
        }

        $oimsSetting = \Olabs\Oims\Models\Settings::instance();

        $this->vars['search'] = true;
        $this->vars['oimsSetting'] = $oimsSetting;
    }

    public function onPcAttendanceReportExport_BIN() {


        //generate PDF html
        $report = array();

        if (post('reportSearch')) {

            $searchParams = post('reportSearch');

            // get dpr components
            $this->searchPcAttendanceReport($searchParams);

            $search_from_date = isset($searchParams['from_date']) ? $searchParams['from_date'] : '';
            $search_to_date = isset($searchParams['to_date']) ? $searchParams['to_date'] : '';
//
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

            $projectModal = \Olabs\Oims\Models\Project::find($project);
        }

        $oimsSetting = \Olabs\Oims\Models\Settings::instance();

        $this->vars['search'] = true;
        $this->vars['from_date'] = $from_date;
        $this->vars['to_date'] = $to_date;

        $reports = $this->vars['reports'];

        $style = ".product-title { width: 315px; display: inline-block; }
.product-quantity { width: 50px; display: inline-block; }
.product-price-without-tax { width: 100px; display: inline-block; text-align: right; }
.product-tax { width: 100px; display: inline-block; text-align: right; }
.product-price { width: 130px; display: inline-block; text-align: right; }
table { width: 100%; border-collapse: collapse; font-size:12px;}
td, th { border: 1px solid #ccc; }";

        $html = "<html><head><style>" . $style . "</style></head><body>";

        $html .= "<h3>Petty Contractor Attendance Report From : " . \Olabs\Oims\Models\Settings::convertToDisplayDate($from_date) . " To : " . \Olabs\Oims\Models\Settings::convertToDisplayDate($to_date) . "</h3>";

        $html .= $this->makePartial('pc_attendance_report_list', [
            'reports' => $reports,
            'from_date' => $from_date,
            'to_date' => $to_date,
            'oimsSetting' => $oimsSetting]);

        $html .= "</body></html>";


        // Generate invoice
        $fileName = 'pc_attendance_report_' . time();
        $invoiceTempFile = temp_path() . "/" . $fileName . ".pdf";
        $pdf = App::make('dompdf.wrapper');


        $pdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation
        $pdf->setPaper('A4', 'landscape'); //landscape
        // Output the generated PDF to Browser
        $pdf->save($invoiceTempFile);

        return \Redirect::to('/backend/olabs/oims/reports/downloadPdf?name=' . $fileName);
    }

    public function onPCAttendanceExportExcel() {
        $file_type = '.' . post('type');

        ////////Generate Excel Data
        $report = array();

        if (post('reportSearch')) {

            $searchParams = post('reportSearch');

            // get dpr components
            $this->searchPcAttendanceReport($searchParams);

            $search_from_date = isset($searchParams['from_date']) ? $searchParams['from_date'] : '';
            $search_to_date = isset($searchParams['to_date']) ? $searchParams['to_date'] : '';
//
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

            $projectModal = \Olabs\Oims\Models\Project::find($project);
        }

        $oimsSetting = \Olabs\Oims\Models\Settings::instance();

        $this->vars['search'] = true;
        $this->vars['from_date'] = $from_date;
        $this->vars['to_date'] = $to_date;

        $reports = $this->vars['reports'];

        //Generating Excel
        $header_columns = ['Project', 'Petty Contractor', 'Attendance Date', 'Employee Type', 'Quantity', 'Daily Wages', 'Total Price'];

        //Attendance Summary Report
        $excel_rows = [];

        $summary_count = 0;
        $summary_total = 0;

        foreach ($reports as $report) {
            $products = $report->products ? $report->products : array();
            $productArray = array();
            foreach ($products as $product) {
                $product_title = $product->employee_type_code->name . ", QTY : " . $product->quantity . ", AMNT :" . $oimsSetting->getPriceFormattedWithoutCurrency($product->total_price);
                $productArray[] = $product_title;
                $summary_count += $product->quantity; //Grand Total
                $summary_total += $product->total_price;

                $temp = [];
                $temp[] = $report->project->name;
                $temp[] = $report->supplier->fullname;
                $temp[] = $oimsSetting->convertToDisplayDate($report->context_date, 'd/m/Y');
                $temp[] = $product->employee_type_code->name;
                $temp[] = $product->quantity;
                $temp[] = $oimsSetting->getPriceFormattedWithoutCurrency($product->daily_wages);
                $temp[] = $oimsSetting->getPriceFormattedWithoutCurrency($product->total_price);
                $excel_rows[] = $temp;
            }
        }


        $export_data[] = ['title' => 'Attendance Summary Report', 'header' => $header_columns, 'rows' => $excel_rows];


        //Summary
        $temp = [];
        $temp['title'] = 'Summary';
        $temp['header'] = ['DESCRIPTION', 'AMOUNT / COUNT'];
        $temp['rows'] = [
            ['TOTAL ATTENDANCE', $summary_count],
            ["TOTAL ATTENDANCE AMOUNT", $oimsSetting->getPriceFormattedWithoutCurrency($summary_total)],
        ];

        $export_data[] = $temp;
        ////////////////////////////////////////////////////////////
        $fileName = 'pc_attendance_report_' . time() . $file_type;

        Excel::excel()->store(new \Olabs\Oims\Exports\ReportsExport($export_data), $fileName, 'local');

        return \Redirect::to('/backend/olabs/oims/reports/download?name=' . $fileName);
    }

    protected function searchPcAttendanceReport($searchParams) {
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
        $model->orderBy('user_id');
        $model->orderBy('context_date');
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

    //Project Assets Report
    public function assets_report() {
        BackendMenu::setContext('Olabs.Oims', 'reports', 'assets_report');
        $this->searchFormWidget = $this->createAssetsSearchFormWidget();
        $this->pageTitle = 'Assets Report';
        $reports = array();

        $oimsSetting = \Olabs\Oims\Models\Settings::instance();

        $searchForm = $this->searchFormWidget;

        $this->vars['search'] = false;
        $this->vars['msg'] = false;
        $this->vars['searchFormWidget'] = $searchForm;
        $this->vars['reports'] = $reports;

        $this->vars['oimsSetting'] = $oimsSetting;
    }

    public function onAssetsSearch() {
        $reports = array();

        if (post('reportSearch')) {

            $searchParams = post('reportSearch');

            // get assets reports
            $this->searchAssetsReport($searchParams);
        }

        $oimsSetting = \Olabs\Oims\Models\Settings::instance();

        $this->vars['search'] = true;
        $this->vars['oimsSetting'] = $oimsSetting;
    }

    public function onAssetsReportExport() {


        //generate PDF html
        $report = array();

        if (post('reportSearch')) {

            $searchParams = post('reportSearch');

            // get dpr components
            $this->searchAssetsReport($searchParams);

            $search_from_date = isset($searchParams['from_date']) ? $searchParams['from_date'] : '';
            $search_to_date = isset($searchParams['to_date']) ? $searchParams['to_date'] : '';
//
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

            $projectModal = \Olabs\Oims\Models\Project::find($project);
        }

        $oimsSetting = \Olabs\Oims\Models\Settings::instance();

        $this->vars['search'] = true;
        $this->vars['from_date'] = $from_date;
        $this->vars['to_date'] = $to_date;

        $reports = $this->vars['reports'];
//        $manpowers = $this->vars['manpowers'];
//        $machineries = $this->vars['machineries'];
//        $expenseOnMaterials = $this->vars['expenseOnMaterials'];
//        $expenseOnPcs = $this->vars['expenseOnPcs'];
//        $fix_expense = $this->vars['fix_expense'];
//
//        $total_days = $this->vars['total_days'];

        $style = ".product-title { width: 315px; display: inline-block; }
.product-quantity { width: 50px; display: inline-block; }
.product-price-without-tax { width: 100px; display: inline-block; text-align: right; }
.product-tax { width: 100px; display: inline-block; text-align: right; }
.product-price { width: 130px; display: inline-block; text-align: right; }
table { width: 100%; border-collapse: collapse; font-size:12px;}
td, th { border: 1px solid #ccc; }";

        $html = "<html><head><style>" . $style . "</style></head><body>";

        $html .= "<h3>Assets Report</h3>";

        $html .= $this->makePartial('assets_report_list', [
            'reports' => $reports,
//            'manpowers' => $manpowers,
//            'machineries' => $machineries,
//            'expenseOnPcs' => $expenseOnPcs,
//            'expenseOnMaterials' => $expenseOnMaterials,
            'from_date' => $from_date,
            'to_date' => $to_date,
//            'total_days' => $total_days,
//            'fix_expense' => $fix_expense,
            'oimsSetting' => $oimsSetting]);

        $html .= "</body></html>";


        // Generate invoice
        $fileName = 'assets_report_' . time();
        $invoiceTempFile = temp_path() . "/" . $fileName . ".pdf";
        $pdf = App::make('dompdf.wrapper');


        $pdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation
        $pdf->setPaper('A4', 'portrait'); //landscape
        // Output the generated PDF to Browser
        $pdf->save($invoiceTempFile);

        return \Redirect::to('/backend/olabs/oims/reports/downloadPdf?name=' . $fileName);
    }

    public function onAssetExportExcel() {
        $file_type = '.' . post('type');

        ////////Generate Excel Data
        $report = array();

        if (post('reportSearch')) {

            $searchParams = post('reportSearch');

            // get dpr components
            $this->searchAssetsReport($searchParams);

            $search_from_date = isset($searchParams['from_date']) ? $searchParams['from_date'] : '';
            $search_to_date = isset($searchParams['to_date']) ? $searchParams['to_date'] : '';
//
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

            $projectModal = \Olabs\Oims\Models\Project::find($project);
        }

        $oimsSetting = \Olabs\Oims\Models\Settings::instance();

        $this->vars['search'] = true;
        $this->vars['from_date'] = $from_date;
        $this->vars['to_date'] = $to_date;

        $reports = $this->vars['reports'];

        //Generating Excel
        $header_columns = ['Project', 'Product', 'Category', 'Quantity', 'Unit'];

        //Attendance Summary Report
        $excel_rows = [];

        $count = 0;
        foreach ($reports as $report) {
            $count++;
            $temp = [];
            $temp[] = $report->project->name;
            $temp[] = $report->product->title;
            $temp[] = isset($report->product->default_category) ? $report->product->default_category->title : '';
            $temp[] = $report->quantity;
            $temp[] = isset($report->unit_code) ? $report->unit_code->name : $report->unit;
            $excel_rows[] = $temp;
        }



        $export_data[] = ['title' => 'Assets Report', 'header' => $header_columns, 'rows' => $excel_rows];

        ////////////////////////////////////////////////////////////
        $fileName = 'assets_report_' . time() . $file_type;

        Excel::excel()->store(new \Olabs\Oims\Exports\ReportsExport($export_data), $fileName, 'local');

        return \Redirect::to('/backend/olabs/oims/reports/download?name=' . $fileName);
    }

    public function onAssetsLabelExport() {


        //generate PDF html
        $report = array();
        $from_date = false;
        $to_date = false;
        $label_type = get('type', false);

        if (post('reportSearch')) {

            $searchParams = post('reportSearch');

            // get dpr components
            $this->vars['reports'] = $this->searchAssetsReport($searchParams);

            $search_from_date = isset($searchParams['from_date']) ? $searchParams['from_date'] : '';
            $search_to_date = isset($searchParams['to_date']) ? $searchParams['to_date'] : '';
//

            if ($search_from_date != '') {
                $from_date = \Olabs\Oims\Models\Settings::convertToDBDate($search_from_date); //date('Y-m-d 00:00:00', strtotime($from_date));
            }


            if ($search_to_date != '') {
                $timeFormat = '23:59:59';
                $to_date = \Olabs\Oims\Models\Settings::convertToDBDate($search_to_date, $timeFormat);
            }

            $project = ( trim($searchParams['project']) != "" ) ? $searchParams['project'] : false;

            $projectModal = \Olabs\Oims\Models\Project::find($project);
        }

        $oimsSetting = \Olabs\Oims\Models\Settings::instance();

//        $this->vars['print_style'] = get('style',40);
        $this->vars['search'] = true;
        $this->vars['from_date'] = $from_date;
        $this->vars['to_date'] = $to_date;
//        $this->vars['label_type'] = $label_type;

        $searchParams = ['project' => get('project', false)];
        $reports = $this->searchAssetsReport($searchParams);
//        $manpowers = $this->vars['manpowers'];
//        $machineries = $this->vars['machineries'];
//        $expenseOnMaterials = $this->vars['expenseOnMaterials'];
//        $expenseOnPcs = $this->vars['expenseOnPcs'];
//        $fix_expense = $this->vars['fix_expense'];
//
//        $total_days = $this->vars['total_days'];
//        $style = ".product-title { width: 315px; display: inline-block; }
//.product-quantity { width: 50px; display: inline-block; }
//.product-price-without-tax { width: 100px; display: inline-block; text-align: right; }
//.product-tax { width: 100px; display: inline-block; text-align: right; }
//.product-price { width: 130px; display: inline-block; text-align: right; }
//table { width: 100%; border-collapse: collapse; font-size:12px;}
//td, th { border: 1px solid #ccc; }";
        $style = '';
        $html = "<html><head><style>" . $style . "</style></head><body>";

//        $html .= "<h3>Assets Report</h3>";

        if ($label_type == 'all') {
            $html .= $this->makePartial('assets_labels_list_all', [
                'reports' => $reports,
                'print_style' => get('style', 40),
                'from_date' => $from_date,
                'to_date' => $to_date,
                'oimsSetting' => $oimsSetting]);
        } else {
            $html .= $this->makePartial('assets_labels_list', [
                'reports' => $reports,
                'print_style' => get('style', 40),
                'from_date' => $from_date,
                'to_date' => $to_date,
                'oimsSetting' => $oimsSetting]);
        }


        $html .= "</body></html>";

        echo $html;
        exit();
//        dd($html);
        // Generate invoice
        $fileName = 'assets_labels_' . time();
        $invoiceTempFile = temp_path() . "/" . $fileName . ".pdf";
        $pdf = App::make('dompdf.wrapper');


        $pdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation
        $pdf->setPaper('A4', 'portrait'); //landscape
        // Output the generated PDF to Browser
        $pdf->save($invoiceTempFile);

        return \Redirect::to('/backend/olabs/oims/reports/downloadPdf?name=' . $fileName);
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

}
