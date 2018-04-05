<?php namespace Reportico\Reports\Components;

use ApplicationException;
use Cms\Classes\ComponentBase;
use Cache;
use Request;

class ReporticoAjax extends ComponentBase
{
    public $config = false;
    public $engine = false;
    public function componentDetails()
    {
        return [
            'name'        => 'Reportico Ajax',
            'description' => 'Embeds a Reportico Ajax page'
        ];
    }

    public function defineProperties()
    {
        return [
            'project' => [
                'title'             => 'Project',
                'type'              => 'dropdown',
                'default'           => 'us'
            ],
            'country' => [
                'title'             => 'Country',
                'type'              => 'dropdown',
                'default'           => 'us'
            ],
            'state' => [
                'title'             => 'State',
                'type'              => 'dropdown',
                'default'           => 'dc',
                'depends'           => ['country'],
                'placeholder'       => 'Select a state'
            ],
            'city' => [
                'title'             => 'City',
                'type'              => 'string',
                'default'           => 'Washington',
                'placeholder'       => 'Enter the city name',
                'validationPattern' => '^[0-9a-zA-Z\s]+$',
                'validationMessage' => 'The City field is required.'
            ],
            'units' => [
                'title'             => 'Units',
                'description'       => 'Units for the temperature and wind speed',
                'type'              => 'dropdown',
                'default'           => 'imperial',
                'placeholder'       => 'Select units',
                'options'           => ['metric'=>'Metric', 'imperial'=>'Imperial']
            ]
        ];
    }

    public function getProjectOptions()
    {
        $result = [];
        $result ["project1"] = "project1name";
        $result ["project2"] = "project2name";

        return $result;
    }

    public function getCountryOptions()
    {
        $countries = $this->loadCountryData();
        $result = [];

        foreach ($countries as $code=>$data)
            $result[$code] = $data['n'];

        return $result;
    }

    public function getStateOptions()
    {
        $countries = $this->loadCountryData();
        $countryCode = Request::input('country');
        return isset($countries[$countryCode]) ? $countries[$countryCode]['s'] : [];
    }

    public function onRun()
    {
        include (__DIR__."/../config.php" );
        include (__DIR__."/reportico.php" );

        //var_dump($this->config);

        $app = $this->app;
/*
        $this->app["router"]->get("reportico", function() use ($app)
        {
            //return View::make('reportico.reportico');
            return $this->app["view"]->make('reportico::reportico');
        });

        $this->app["router"]->get("reportico/ajax", function() use ($app)
        {
            //return View::make('reportico::reportico');
            //$engine= App::make("getReporticoEngine");
            $engine = $app["app"]->make('getReporticoEngine');
            $engine->execute();
        });

        $this->app["router"]->post("reportico/ajax", function() use ($app)
        {
            //return View::make('reportico::reportico');
            //$engine= App::make("getReporticoEngine");
            $engine = $app["app"]->make('getReporticoEngine');
            $engine->execute();
        });

        $this->app["router"]->get("reportico/dbimage", function() use ($app)
        {
            //return View::make('reportico::reportico');
            //$engine= App::make("getReporticoEngine");
            // Set Joomla Database Access Config from configuration
            if ( !defined("SW_FRAMEWORK_DB_DRIVER") )
            {
                    define('SW_FRAMEWORK_DB_DRIVER','pdo_mysql');
                    define('SW_FRAMEWORK_DB_USER',"root");
                    define('SW_FRAMEWORK_DB_PASSWORD',"root");
                    define('SW_FRAMEWORK_DB_HOST',"127.0.0.1");
                    define('SW_FRAMEWORK_DB_DATABASE',"iconnex.php");
            }
            include("imageget.php");

        });
*/
        //$this->app['getReporticoEngine'] = $this->app->share(function($app)
        //{
            $this->engine = new reportico();

            $this->engine->reportico_ajax_script_url = $_SERVER["SCRIPT_NAME"]."/reportico/ajax";
            $this->engine->forward_url_get_parameters = false;
            //$this->engine->forward_url_get_parameters_graph = "reportico/graph";
            //$this->engine->forward_url_get_parameters_dbimage = "reportico/dbimage";

            // Inficate 'path' mechanism for controllers in stead of 'get'
            $this->engine->reportico_ajax_mode = 2;

            $this->engine->embedded_report = true;
            $this->engine->allow_debug = true;
            $this->engine->framework_parent = $this->config["framework_type"];

            // PPP
            $this->engine->external_user = false;
            //if ( \Auth::user() )
                //$this->engine->external_user = \Auth::user()->id;
            //else
                //$this->engine->external_user = false;
            //$this->engine->url_path_to_assets = $this->app["url"]->asset($this->config["path_to_assets")];
            
            // Where to store reportco projects
            $this->engine->projects_folder = $this->config["path_to_projects"];
            if ( $this->engine->projects_folder && !is_dir($this->engine->projects_folder) )
            {
                \File::makeDirectory($this->engine->projects_folder, 0777, true);
            }
            $this->engine->admin_projects_folder = $this->config["path_to_admin"];

            // Indicates whether report output should include a refresh button
            $this->engine->show_refresh_button = $this->config["show_refresh_button"];

            // Jquery already included?
            $this->engine->jquery_preloaded = $this->config["jquery_preloaded"];

            // Bootstrap Features
            // Set bootstrap_styles to false for reportico classic styles, or "3" for bootstrap 3 look and feel and 2 for bootstrap 2
            // If you are embedding reportico and you have already loaded bootstrap then set bootstrap_preloaded equals true so reportico
            // doestnt load it again.
            $this->engine->bootstrap_styles = $this->config["bootstrap_styles"];
            $this->engine->bootstrap_preloaded = $this->config["bootstrap_preloaded"];

            // In bootstrap enable pages, the bootstrap modal is by default used for the quick edit buttons
            // but they can be ignored and reportico's own modal invoked by setting this to true
            $this->engine->force_reportico_mini_maintains = $this->config["force_reportico_maintain_modals"];

            // Engine to use for charts .. 
            // HTML reports can use javascript charting, PDF reports must use PCHART
            $this->engine->charting_engine = $this->config["charting_engine"];
            $this->engine->charting_engine_html = $this->config["charting_engine_html"];

            // Engine to use for PDF reports .. 
            $this->engine->pdf_engine = $this->config["pdf_engine"];

            // Whether to turn on dynamic grids to provide searchable/sortable reports
            $this->engine->dynamic_grids = $this->config["dynamic_grids"];
            $this->engine->dynamic_grids_sortable = $this->config["dynamic_grids_sortable"];
            $this->engine->dynamic_grids_searchable = $this->config["dynamic_grids_searchable"];
            $this->engine->dynamic_grids_paging = $this->config["dynamic_grids_paging"];
            $this->engine->dynamic_grids_page_size = $this->config["dynamic_grids_page_size"];

            // Show or hide various report elements
            $this->engine->output_template_parameters["show_hide_navigation_menu"] = $this->config["show_hide_navigation_menu"];
            $this->engine->output_template_parameters["show_hide_dropdown_menu"] = $this->config["show_hide_dropdown_menu"];
            $this->engine->output_template_parameters["show_hide_report_output_title"] = $this->config["show_hide_report_output_title"];
            $this->engine->output_template_parameters["show_hide_prepare_section_boxes"] = $this->config["show_hide_prepare_section_boxes"];
            $this->engine->output_template_parameters["show_hide_prepare_pdf_button"] = $this->config["show_hide_prepare_pdf_button"];
            $this->engine->output_template_parameters["show_hide_prepare_html_button"] = $this->config["show_hide_prepare_html_button"];
            $this->engine->output_template_parameters["show_hide_prepare_print_html_button"] = $this->config["show_hide_prepare_print_html_button"];
            $this->engine->output_template_parameters["show_hide_prepare_csv_button"] = $this->config["show_hide_prepare_csv_button"];
            $this->engine->output_template_parameters["show_hide_prepare_page_style"] = $this->config["show_hide_prepare_page_style"];

            // Static Menu definition
            // ======================
            $this->engine->static_menu = $this->config["static_menu"];

            // Dropdown Menu definition
            // ========================
            $this->engine->dropdown_menu = $this->config["dropdown_menu"];

            $defaultconnection = config("database.default");
            $useConnection = false;
            if ( $defaultconnection )
                $useConnection = config("database.connections.$defaultconnection");
            else
                $useConnection = array(
                        "driver" => "unknown",
                        "dbname" => "unknown",
                        "user" => "unknown",
                        "password" => "unknown",
                        );

            $this->engine->available_connections = config("database.connections");
            $this->engine->external_connection = \DB::connection()->getPdo();

            // Set CSRF Token
            if ( !csrf_token() )
                $this->engine->csrfToken = "unknown_csrf";
            else
                $this->engine->csrfToken = csrf_token() ;

            //return $this->engine;
        //});


        $this->engine->return_output_to_caller = true;

        $this->addCss('/plugins/reportico/reports/assets/css/weather.css');
        $this->page['weatherInfo'] = $this->engine->execute();
return;

        //$engine= App::make("getReporticoEngine");
        $this->engine->clear_reportico_session=1;
        return $this->engine->execute();
    }

    public function info()
    {
        $json = file_get_contents(sprintf(
            "http://api.openweathermap.org/data/2.5/weather?q=%s,%s,%s&units=%s&APPId=43cc6737f814ea2f5f004a9fbed81ecb", 
            $this->property('city'),
            $this->property('state'),
            $this->property('country'),
            $this->property('units')
        ));

        return json_decode($json);
    }

    protected function loadCountryData()
    {
        return json_decode(file_get_contents(__DIR__.'/../data/countries-and-states.json'), true);
    }
}
