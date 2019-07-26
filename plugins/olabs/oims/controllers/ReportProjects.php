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
use Olabs\Oims\Classes\FusionCharts;
use Olabs\Oims\Classes\ReportHelper;

class ReportProjects extends ReportHelper {

    public $implement = [];
    protected $searchFormWidget;
    public $requiredPermissions = ['olabs.oims.reportprojects'];
    
    public function __construct() {
        parent::__construct();
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 600);
        $this->searchFormWidget = $this->createDPRSearchFormWidget();
        BackendMenu::setContext('Olabs.Oims', 'reportprojects', 'drp_report');
    }
    
    public function dpr() {
        BackendMenu::setContext('Olabs.Oims', 'reportprojects', 'drp_report');
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
                $temp['unit'] = $product->unit;
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
                $temp['unit'] = $product->unit;
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
                $temp['unit'] = $product->unit;
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
                $temp['unit'] = $product->unit;
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
                $temp['unit'] = $product->unit;
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
    
    //Project Progress Report
    public function progress_report() {
        BackendMenu::setContext('Olabs.Oims', 'reportprojects', 'progress_report');
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
        BackendMenu::setContext('Olabs.Oims', 'reportprojects', 'mr_report');
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
//            $project = ( trim($searchParams['project']) != "" ) ? $searchParams['project'] : false;
//            $project = ( isset($searchParams['project']) ) ? $searchParams['project'] : false;

//            $projectModal = \Olabs\Oims\Models\Project::find($project);
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

        //MR Revisions
        $header_columns = ['MR No.', 'Status', 'Comment', 'Created By', 'Created On'];
        $excel_rows = [];
        foreach ($reports as $report) {
            $revisions = $report->getStatusHistory();

            foreach($revisions as $revision){
                $temp = [];
                $temp['mr_no'] = $report->reference_number;
                $temp['status'] = isset($revision->objectstatus) ? $revision->objectstatus->name : $revision->status;
                $temp['comment'] = $revision->comment;
                $temp['created_by'] = $revision->createdBy->getFullNameAttribute();
                $temp['created_on'] = date("d-m-Y", strtotime($revision->created_at));
                $excel_rows[] = $temp;
            }
        }
        
        $export_data[] = ['title' => 'MR Revisions', 'header' => $header_columns, 'rows' => $excel_rows];
        
        
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
    
    //MR Report
    public function material_report() {
        BackendMenu::setContext('Olabs.Oims', 'reportprojects', 'material_report');
        $this->searchFormWidget = $this->createMaterialSearchFormWidget();
        $this->pageTitle = 'Material Consumption Report';
        $reports = array();

        $oimsSetting = \Olabs\Oims\Models\Settings::instance();

        $searchForm = $this->searchFormWidget;

        $this->vars['search'] = false;
        $this->vars['msg'] = false;
        $this->vars['searchFormWidget'] = $searchForm;
        $this->vars['reports'] = $reports;

        $this->vars['oimsSetting'] = $oimsSetting;
    }

    public function onMaterialSearch() {
        $reports = array();

        if (post('reportSearch')) {

            $searchParams = post('reportSearch');

            // get dpr components
            $this->searchMaterialReport($searchParams);
        }

        $oimsSetting = \Olabs\Oims\Models\Settings::instance();

        $this->vars['search'] = true;
        $this->vars['oimsSetting'] = $oimsSetting;
    }

    public function onMaterialExportExcel() {
        $file_type = '.' . post('type');

        ////////Generate Excel Data
        $report = array();

        if (post('reportSearch')) {

            $searchParams = post('reportSearch');

            $this->searchMaterialReport($searchParams);

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
    
}