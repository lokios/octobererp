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

class ReportAccounts extends ReportHelper {

    public $implement = [];
    protected $searchFormWidget;
    public $requiredPermissions = ['olabs.oims.reportaccounts'];

    public function __construct() {
        parent::__construct();
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 600);
        $this->searchFormWidget = $this->createDPRSearchFormWidget();
        BackendMenu::setContext('Olabs.Oims', 'reportaccounts', 'transaction_report');
    }
    
    //Transaction Report
    public function transaction_report() {
        BackendMenu::setContext('Olabs.Oims', 'reportaccounts', 'transaction_report');
        $this->searchFormWidget = $this->createTransactionSearchFormWidget();
        $this->pageTitle = 'Account Statement Report';
        $reports = array();
        $balance_amount = 0;
        $from_date = '';
        $to_date = '';
        $oimsSetting = \Olabs\Oims\Models\Settings::instance();

        $searchForm = $this->searchFormWidget;

        $this->vars['search'] = false;
        $this->vars['msg'] = false;
        $this->vars['searchFormWidget'] = $searchForm;
        $this->vars['reports'] = $reports;
        $this->vars['balance_amount'] = $balance_amount;
        $this->vars['from_date'] = $from_date;
        $this->vars['to_date'] = $to_date;

        $this->vars['oimsSetting'] = $oimsSetting;
    }

    public function onTransactionSearch() {
        $reports = array();

        if (post('reportSearch')) {

            $searchParams = post('reportSearch');

            // get dpr components
            $this->searchTransactionReport($searchParams);
        }
        
        $oimsSetting = \Olabs\Oims\Models\Settings::instance();

        $this->vars['search'] = true;
        $this->vars['oimsSetting'] = $oimsSetting;
    }

    public function onTransactionExportExcel() {
        $file_type = '.' . post('type');

        ////////Generate Excel Data
        $report = array();

        if (post('reportSearch')) {

            $searchParams = post('reportSearch');

            $this->searchTransactionReport($searchParams);

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
    
    
    //Cash Flow Report
    public function cash_flow_report() {
        BackendMenu::setContext('Olabs.Oims', 'reportaccounts', 'cash_flow_report');
        $this->searchFormWidget = $this->createTransactionSearchFormWidget();
        $this->pageTitle = 'Cash FLow Report';
        $reports = array();
        $balance_amount = 0;
        $from_date = '';
        $to_date = '';
        $oimsSetting = \Olabs\Oims\Models\Settings::instance();

        $searchForm = $this->searchFormWidget;

        $this->vars['search'] = false;
        $this->vars['msg'] = false;
        $this->vars['searchFormWidget'] = $searchForm;
        $this->vars['reports'] = $reports;
        $this->vars['balance_amount'] = $balance_amount;
        $this->vars['from_date'] = $from_date;
        $this->vars['to_date'] = $to_date;

        $this->vars['oimsSetting'] = $oimsSetting;
    }

    public function onCashFlowSearch() {
        $reports = array();

        if (post('reportSearch')) {

            $searchParams = post('reportSearch');

            // get dpr components
            $this->searchTransactionReport($searchParams);
        }
        
        $oimsSetting = \Olabs\Oims\Models\Settings::instance();

        $this->vars['search'] = true;
        $this->vars['oimsSetting'] = $oimsSetting;
    }

    public function onCashFLowExportExcel() {
        $file_type = '.' . post('type');

        ////////Generate Excel Data
        $report = array();

        if (post('reportSearch')) {

            $searchParams = post('reportSearch');

            $this->searchTransactionReport($searchParams);

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
        $balance_amount = $this->vars['balance_amount'];

        //Generating Excel
        $header_columns = ['Date', 'Project', 'Reference No.', 'Description', 'Payment Received'];

        //MR Report
        $excel_rows = [];
        $status_count = [];
        $grand_total = 0;
        $count = 0;
        $grand_total = 0;
        $count = 0;

        $payment_types = ['Payment Received'=>0];

        foreach($reports as $report){ 
            if($report->payment_type != '' AND !isset($payment_types[$report->payment_type]) AND $report->debit_amount != 0 ){
                $ledger_name = isset($report->ledger_type) ? $report->ledger_type->name : $report->payment_type;
                $payment_types[$report->payment_type] = 0;
                $header_columns[] = $ledger_name;
            }
        }
        
        $header_columns[] = 'Total';
        
        
        
        
        foreach ($reports as $report) {
            $total = 0;
            $temp = [];
             
            $temp[] = date("d-m-Y", strtotime($report->context_date));
            $temp[] = $report->project->slug;
            $temp[] = $report->reference_number;
            $temp[] = $report->description;
            foreach($payment_types as $key => $value){
                $amount = '';
                if($report->payment_type == $key){
                    $amount = $report->debit_amount != 0 ? $report->debit_amount : $report->credit_amount;
                    $payment_types[$key] += is_numeric($amount) ? $amount : 0;
                    if($report->debit_amount != 0) {
                        $total +=$amount;    
                        $grand_total += $amount;
                    }
                    
                }
                $temp[] = $amount;
                
                
            }
            $temp[] = $total;
            
            $excel_rows[] = $temp;
        }
        
        //Report total
        $temp = ['Total','','',''];
        foreach($payment_types as $key => $value){
            $temp[] = $value;
        }
        $temp[] = $grand_total;
        $excel_rows[] = $temp;

        $export_data[] = ['title' => 'Cash Flow', 'header' => $header_columns, 'rows' => $excel_rows];


        //Summary
        $closing_balance_amount = $balance_amount + $payment_types['Payment Received'] - $grand_total;
        $temp = [];
        $temp['title'] = 'Summary';
        $temp['header'] = ['DESCRIPTION', 'AMOUNT / COUNT'];
        $temp['rows'] = [
            ["Opening Balance On Date " . date("d-m-Y", strtotime($from_date)) . "", $balance_amount],
            ["Total Received", $oimsSetting->getPriceFormattedWithoutCurrency($payment_types['Payment Received'])],
            ["Total Expenses", $oimsSetting->getPriceFormattedWithoutCurrency($grand_total)],
            ["Closing Balance On Date ". date("d-m-Y", strtotime($to_date)) . "", $oimsSetting->getPriceFormattedWithoutCurrency($closing_balance_amount)],
        ];
//        foreach ($status_count as $k => $v) {
//            $temp['rows'][] = [$k . ' MR Count', $v];
//        }
        $export_data[] = $temp;
        ////////////////////////////////////////////////////////////
        $fileName = 'cash_flow_report_' . time() . $file_type;

        Excel::excel()->store(new \Olabs\Oims\Exports\ReportsExport($export_data), $fileName, 'local');

        return \Redirect::to('/backend/olabs/oims/reports/download?name=' . $fileName);
    }
    
    
    //Daily Cash Flow Sheet
    public function daily_cash_flow() {
        BackendMenu::setContext('Olabs.Oims', 'reportaccounts', 'daily_cash_flow');
        $this->searchFormWidget = $this->createDailyCashFlowSearchFormWidget();
        $this->pageTitle = 'Daily Cash FLow';
        $reports = array();
        $balance_amount = 0;
        $from_date = '';
        $to_date = '';
        $oimsSetting = \Olabs\Oims\Models\Settings::instance();

        $searchForm = $this->searchFormWidget;

        $this->vars['search'] = false;
        $this->vars['msg'] = false;
        $this->vars['searchFormWidget'] = $searchForm;
        $this->vars['reports'] = $reports;
        $this->vars['balance_amount'] = $balance_amount;
        $this->vars['from_date'] = $from_date;
        $this->vars['to_date'] = $to_date;

        $this->vars['oimsSetting'] = $oimsSetting;
    }

    public function onDailyCashFlowSearch() {
        $reports = array();

        if (post('reportSearch')) {

            $searchParams = post('reportSearch');

            // get dpr components
            $this->searchTransactionReport($searchParams);
        }
        
        $oimsSetting = \Olabs\Oims\Models\Settings::instance();

        $this->vars['search'] = true;
        $this->vars['oimsSetting'] = $oimsSetting;
    }

    public function onDailyCashFLowExportExcel() {
        $file_type = '.' . post('type');

        ////////Generate Excel Data
        $report = array();

        if (post('reportSearch')) {

            $searchParams = post('reportSearch');

            $this->searchTransactionReport($searchParams);

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
        $balance_amount = $this->vars['balance_amount'];

        //Generating Excel
        $header_columns = ['Date', 'Project', 'Reference No.', 'Description', 'Payment Received'];

        //MR Report
        $excel_rows = [];
        $status_count = [];
        $grand_total = 0;
        $count = 0;
        $grand_total = 0;
        $count = 0;

        $payment_types = ['Payment Received'=>0];

        foreach($reports as $report){ 
            if($report->payment_type != '' AND !isset($payment_types[$report->payment_type]) AND $report->debit_amount != 0 ){
                $ledger_name = isset($report->ledger_type) ? $report->ledger_type->name : $report->payment_type;
                $payment_types[$report->payment_type] = 0;
                $header_columns[] = $ledger_name;
            }
        }
        
        $header_columns[] = 'Total';
        
        
        
        
        foreach ($reports as $report) {
            $total = 0;
            $temp = [];
             
            $temp[] = date("d-m-Y", strtotime($report->context_date));
            $temp[] = $report->project->slug;
            $temp[] = $report->reference_number;
            $temp[] = $report->description;
            foreach($payment_types as $key => $value){
                $amount = '';
                if($report->payment_type == $key){
                    $amount = $report->debit_amount != 0 ? $report->debit_amount : $report->credit_amount;
                    $payment_types[$key] += is_numeric($amount) ? $amount : 0;
                    if($report->debit_amount != 0) {
                        $total +=$amount;    
                        $grand_total += $amount;
                    }
                    
                }
                $temp[] = $amount;
                
                
            }
            $temp[] = $total;
            
            $excel_rows[] = $temp;
        }
        
        //Report total
        $temp = ['Total','','',''];
        foreach($payment_types as $key => $value){
            $temp[] = $value;
        }
        $temp[] = $grand_total;
        $excel_rows[] = $temp;

        $export_data[] = ['title' => 'Cash Flow', 'header' => $header_columns, 'rows' => $excel_rows];


        //Summary
        $closing_balance_amount = $balance_amount + $payment_types['Payment Received'] - $grand_total;
        $temp = [];
        $temp['title'] = 'Summary';
        $temp['header'] = ['DESCRIPTION', 'AMOUNT / COUNT'];
        $temp['rows'] = [
            ["Opening Balance On Date " . date("d-m-Y", strtotime($from_date)) . "", $balance_amount],
            ["Total Received", $oimsSetting->getPriceFormattedWithoutCurrency($payment_types['Payment Received'])],
            ["Total Expenses", $oimsSetting->getPriceFormattedWithoutCurrency($grand_total)],
            ["Closing Balance On Date ". date("d-m-Y", strtotime($to_date)) . "", $oimsSetting->getPriceFormattedWithoutCurrency($closing_balance_amount)],
        ];
//        foreach ($status_count as $k => $v) {
//            $temp['rows'][] = [$k . ' MR Count', $v];
//        }
        $export_data[] = $temp;
        ////////////////////////////////////////////////////////////
        $fileName = 'cash_flow_report_' . time() . $file_type;

        Excel::excel()->store(new \Olabs\Oims\Exports\ReportsExport($export_data), $fileName, 'local');

        return \Redirect::to('/backend/olabs/oims/reports/download?name=' . $fileName);
    }
    
    
    
    //Attendance Report
    public function attendance_report() {
        BackendMenu::setContext('Olabs.Oims', 'reportaccounts', 'attendance_report');
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
            $temp['project'] = $report->getEmployeeProjectName();
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
    
    //Attendance Summary Report
    public function attendanceSummary_report() {
        BackendMenu::setContext('Olabs.Oims', 'reportaccounts', 'attendance_summary_report');
        $this->searchFormWidget = $this->createAttendanceSummarySearchFormWidget();
        $this->pageTitle = 'Attendance Summary Report';
        $reports = array();
        $pc_reports = array();
//        dd('hi');
        $oimsSetting = \Olabs\Oims\Models\Settings::instance();

        $searchForm = $this->searchFormWidget;

        $this->vars['search'] = false;
        $this->vars['msg'] = false;
        $this->vars['searchFormWidget'] = $searchForm;
        $this->vars['reports'] = $reports;
        $this->vars['pc_reports'] = $pc_reports;

        $this->vars['oimsSetting'] = $oimsSetting;
    }

    public function onAttendanceSummarySearch() {
        $reports = array();
        $pc_reports = array();

        if (post('reportSearch')) {

            $searchParams = post('reportSearch');

            // get dpr components
            $this->searchAttendanceReport($searchParams);
            $this->vars['pc_reports'] = $this->searchPcAttendanceReport($searchParams, True);
        }

        $oimsSetting = \Olabs\Oims\Models\Settings::instance();

        $this->vars['search'] = true;
        $this->vars['oimsSetting'] = $oimsSetting;
    }

    public function onAttendanceSummaryExportExcel() {

        $file_type = '.' . post('type');

        ////////Generate Excel Data

        $report = array();
        $pc_reports = array();


        if (post('reportSearch')) {

            $searchParams = post('reportSearch');

            // get dpr components
            $this->searchAttendanceReport($searchParams);

            $pc_reports = $this->searchPcAttendanceReport($searchParams, True);

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
        $header_columns = ['Project', 'Attendance Date', 'Supplier Name'];

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
                $temp['supplier_name'] = $report->supplier->fullname;
                $temp['attendance_date'] = $attendance_date;

                $key = $report->project_id . '_' . $report->supplier_id . '_' . $attendance_date . '_' . $employee_type;
                $wages[$key]['count'] = isset($wages[$key]['count']) ? $wages[$key]['count'] + 1 : 1;
                $wages[$key]['total'] = isset($wages[$key]['total']) ? $wages[$key]['total'] + $employee_wage : $employee_wage;

                $rows[$report->project_id][$attendance_date][$report->supplier_id] = $temp;
            }
        }


        foreach ($pc_reports as $report) {
            $products = $report->products ? $report->products : array();
            foreach ($products as $product) {
                $employee_type = $product->employee_type;
                $employee_wage = $product->total_price;
                $employee_quantity = $product->quantity;
                $employee_types[$employee_type] = ucfirst($employee_type); //['count'=>0,'total'=>0];
                $attendance_date = $oimsSetting->convertToDisplayDate($report->context_date, 'd/m/Y');
                $temp = [];
                $temp['project_name'] = $report->project->name;
                $temp['supplier_name'] = $report->supplier->fullname;
                $temp['attendance_date'] = $attendance_date;

                $key = $report->project_id . '_' . $report->user_id . '_' . $attendance_date . '_' . $employee_type;
                $wages[$key]['count'] = isset($wages[$key]['count']) ? $wages[$key]['count'] + $employee_quantity : $employee_quantity;
                $wages[$key]['total'] = isset($wages[$key]['total']) ? $wages[$key]['total'] + $employee_wage : $employee_wage;

                $rows[$report->project_id][$attendance_date][$report->user_id] = $temp;
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
                foreach ($attendance_row as $supplier_id => $supplier_row) {
                    $attendance_count = 0;
                    $attendance_total = 0;
                    $temp = [];
                    $temp[] = $supplier_row['project_name'];
                    $temp[] = $supplier_row['attendance_date'];
                    $temp[] = $supplier_row['supplier_name'];

                    foreach ($employee_types as $key => $employee_type) {
                        $data_key = $project_id . '_' . $supplier_id . '_' . $attendance_date . '_' . $key;
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
        BackendMenu::setContext('Olabs.Oims', 'reportaccounts', 'pcattendance_report');
        $this->searchFormWidget = $this->createAttendanceSummarySearchFormWidget();
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
}
