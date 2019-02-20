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

class Reports extends ReportHelper {

    public $implement = [];
    protected $searchFormWidget;

    public function __construct() {
        parent::__construct();
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 600);
        $this->searchFormWidget = $this->createDPRSearchFormWidget();
        BackendMenu::setContext('Olabs.Oims', 'reports', 'project_plan');
    }
    
    //Project Plan Report
    public function project_plan() {
        BackendMenu::setContext('Olabs.Oims', 'reports', 'project_plan');

//        $this->addCss('/plugins/rainlab/blog/assets/css/rainlab.blog-preview.css');
//        $this->addJs('/plugins/rainlab/blog/assets/js/post-form.js');
//        $this->addCss('/plugins/olabs/oims/assets/fusioncharts/js/themes/fusioncharts.theme.fusion.css');

        $this->addJs('/plugins/olabs/oims/assets/fusioncharts/js/fusioncharts.charts.js', 'core');
        $this->addJs('/plugins/olabs/oims/assets/fusioncharts/js/fusioncharts.js', 'core');
        $this->addJs('/plugins/olabs/oims/assets/fusioncharts/js/themes/fusioncharts.theme.fusion.js', 'core');

        $this->searchFormWidget = $this->createProjectPlanSearchFormWidget();
        $this->pageTitle = 'Project Planning Report';
        $reports = [];

        $oimsSetting = \Olabs\Oims\Models\Settings::instance();

        // get project progress components
//        $searchParams = [];
//        $searchParams['project'] = 2;
//        $this->searchProjectPlanReport($searchParams);

        $searchForm = $this->searchFormWidget;

        $this->vars['search'] = false;
        $this->vars['msg'] = false;
        $this->vars['searchFormWidget'] = $searchForm;
//        $this->vars['Chart'] = $Chart;
        $this->vars['reports'] = $reports;

        $this->vars['oimsSetting'] = $oimsSetting;
    }

    public function onProjectPlanSearch() {
        $reports = array();

        if (post('reportSearch')) {

            $searchParams = post('reportSearch');

            // get project progress components
            $this->searchProjectPlanReport($searchParams);
        }

        $oimsSetting = \Olabs\Oims\Models\Settings::instance();

        $this->vars['search'] = true;
        $this->vars['oimsSetting'] = $oimsSetting;
    }
    
    
    //Project Plan Report
    public function project_plan_details() {
        BackendMenu::setContext('Olabs.Oims', 'reports', 'project_plan_details');

//        $this->addCss('/plugins/rainlab/blog/assets/css/rainlab.blog-preview.css');
//        $this->addJs('/plugins/rainlab/blog/assets/js/post-form.js');
//        $this->addCss('/plugins/olabs/oims/assets/fusioncharts/js/themes/fusioncharts.theme.fusion.css');
//        $this->addCss('/plugins/olabs/oims/assets/bootstrap/css/bootstrap.min.css');

//        $this->addJs('/plugins/olabs/oims/assets/fusioncharts/js/fusioncharts.charts.js', 'core');
//        $this->addJs('/plugins/olabs/oims/assets/fusioncharts/js/fusioncharts.js', 'core');
//        $this->addJs('/plugins/olabs/oims/assets/fusioncharts/js/themes/fusioncharts.theme.fusion.js', 'core');

        $this->searchFormWidget = $this->createProjectPlanDetailsSearchFormWidget();
        $this->pageTitle = 'Project Plan Details Report';
        $reports = [];

        $oimsSetting = \Olabs\Oims\Models\Settings::instance();

        // get project progress components
//        $searchParams = [];
//        $searchParams['project'] = 2;
//        $this->searchProjectPlanDetailsReport($searchParams);

        $searchForm = $this->searchFormWidget;

        $this->vars['search'] = false;
        $this->vars['msg'] = false;
        $this->vars['searchFormWidget'] = $searchForm;
//        $this->vars['Chart'] = $Chart;
        $this->vars['reports'] = $reports;

        $this->vars['oimsSetting'] = $oimsSetting;
    }
    
    
    public function onProjectPlanDetailsSearch() {
        $reports = array();

        if (post('reportSearch')) {

            $searchParams = post('reportSearch');

            // get project progress components
            $this->searchProjectPlanDetailsReport($searchParams);
        }

        $oimsSetting = \Olabs\Oims\Models\Settings::instance();

        $this->vars['search'] = true;
        $this->vars['oimsSetting'] = $oimsSetting;
    }
    

    public function sample_chart() {
        BackendMenu::setContext('Olabs.Oims', 'reports', 'project_progress');

//        $this->addCss('/plugins/rainlab/blog/assets/css/rainlab.blog-preview.css');
//        $this->addJs('/plugins/rainlab/blog/assets/js/post-form.js');
//        $this->addCss('/plugins/olabs/oims/assets/fusioncharts/js/themes/fusioncharts.theme.fusion.css');

        $this->addJs('/plugins/olabs/oims/assets/fusioncharts/js/fusioncharts.charts.js', 'core');
        $this->addJs('/plugins/olabs/oims/assets/fusioncharts/js/fusioncharts.js', 'core');
        $this->addJs('/plugins/olabs/oims/assets/fusioncharts/js/themes/fusioncharts.theme.fusion.js', 'core');

        $this->searchFormWidget = $this->createProjectProgressSearchFormWidget();
        $this->pageTitle = 'Project Progress Report';
        $reports = array();

        $oimsSetting = \Olabs\Oims\Models\Settings::instance();


        $arrChartConfig = array(
            "chart" => array(
                "caption" => "Countries With Most Oil Reserves [2017-18]",
                "subCaption" => "In MMbbl = One Million barrels",
                "xAxisName" => "Country",
                "yAxisName" => "Reserves (MMbbl)",
                "numberSuffix" => "K",
                "theme" => "fusion"
            )
        );

        // An array of hash objects which stores data
        $arrChartData = array(
            ["Venezuela", "290"],
            ["Saudi", "260"],
            ["Canada", "180"],
            ["Iran", "140"],
            ["Russia", "115"],
            ["UAE", "100"],
            ["US", "30"],
            ["China", "30"]
        );

        $arrLabelValueData = array();

        // Pushing labels and values
        for ($i = 0; $i < count($arrChartData); $i++) {
            array_push($arrLabelValueData, array(
                "label" => $arrChartData[$i][0], "value" => $arrChartData[$i][1]
            ));
        }

        $arrChartConfig["data"] = $arrLabelValueData;

        // JSON Encode the data to retrieve the string containing the JSON representation of the data in the array.
        $jsonEncodedData = json_encode($arrChartConfig);

        // chart object
        $Chart = new FusionCharts("column2d", "MyFirstChart", "600", "350", "chart-container", "json", $jsonEncodedData);

//        $chartObject = \Olabs\Oims\Classes\FusionCharts::

        $searchForm = $this->searchFormWidget;

        $this->vars['search'] = false;
        $this->vars['msg'] = false;
        $this->vars['searchFormWidget'] = $searchForm;
        $this->vars['Chart'] = $Chart;
        $this->vars['reports'] = $reports;

        $this->vars['oimsSetting'] = $oimsSetting;

        //In view file
        //Render the chart options
        //      $Chart->renderOptions();
        // Render the chart
        //      $Chart->render();
        // <div id="chart-container">Chart will render here!</div>
    }

}
