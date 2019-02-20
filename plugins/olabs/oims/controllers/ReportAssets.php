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

class ReportAssets extends ReportHelper {

    public $implement = [];
    protected $searchFormWidget;
    public $requiredPermissions = ['olabs.oims.reportassets'];
    
    public function __construct() {
        parent::__construct();
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 600);
        $this->searchFormWidget = $this->createDPRSearchFormWidget();
        BackendMenu::setContext('Olabs.Oims', 'reportassets', 'assets_report');
    }
    
    //Project Assets Report
    public function assets_report() {
        BackendMenu::setContext('Olabs.Oims', 'reportassets', 'assets_report');
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
    
}