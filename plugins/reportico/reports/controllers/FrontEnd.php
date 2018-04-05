<?php namespace Reportico\Reports\Controllers;
use Illuminate\Routing\Controller;
use Reportico\Reports\Components\ReporticoEngine;

use Input;
use Backend\Classes\WidgetBase;
use Reportico\Reports\Components;
use Request;

class FrontEnd extends Controller
{
    public $config = false;
    public $engine = false;

    protected $defaultAlias = 'ReporticoEngine';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest');
    }

	private function initialiseEngine() {

		include_once __DIR__ . "/../config.php";
		include_once __DIR__ . "/../components/reportico.php";

		$this->engine = new \Reportico\Reports\Components\reportico();

		$this->engine->reportico_ajax_script_url = preg_replace("/\/index.php/", "", \URL::to("/")) . "/index.php";
		$this->engine->reportico_ajax_script_url = \URL::to("/reportico/ajax");

		$this->engine->forward_url_get_parameters = false;

		//$this->engine->forward_url_get_parameters_graph = "reportico/graph";
		//$this->engine->forward_url_get_parameters_dbimage = "reportico/dbimage";

		// Inficate 'path' mechanism for controllers in stead of 'get'
		$this->engine->reportico_ajax_mode = 2;

		$this->engine->embedded_report = true;
		$this->engine->allow_debug = true;
		$this->engine->framework_parent = $this->config["framework_type"];

		// Set reportico user based on October user
		$this->engine->external_user = false;
		if ( class_exists("Auth") && \Auth::getUser() && \Auth::getUser()->id )
		    $this->engine->external_user = \Auth::getUser()->id;
		if ( class_exists("BackendAuth") && \BackendAuth::getUser() && \BackendAuth::getUser()->id )
		    $this->engine->external_user = \BackendAuth::getUser()->login;

		$this->engine->url_path_to_assets = $this->config["path_to_assets"];

		// Where to store reportco projects
		$this->engine->projects_folder = $this->config["path_to_projects"];
		if ($this->engine->projects_folder && !is_dir($this->engine->projects_folder)) {
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
		if ($defaultconnection) {
			$useConnection = config("database.connections.$defaultconnection");
		} else {
			$useConnection = array(
				"driver" => "unknown",
				"dbname" => "unknown",
				"user" => "unknown",
				"password" => "unknown",
			);
		}

		$this->engine->available_connections = config("database.connections");
		$this->engine->external_connection = \DB::connection()->getPdo();

		// Set CSRF Token
		if (!csrf_token()) {
			$this->engine->csrfToken = "unknown_csrf";
		} else {
			$this->engine->csrfToken = csrf_token();
		}
		$this->engine->ajaxHandler = "ReporticoEngine::ajax";
		$this->engine->ajaxHandler = false;

		//return $this->engine;
		//});

		$this->engine->return_output_to_caller = true;

	}

    /**
     * Show the application welcome screen to the user.
     *
     * @return Response
     */
    public function admin()
    {

	    $this->initialiseEngine();

        $this->engine->bootstrap_styles = "3";
        $this->engine->bootstrap_preloaded = false;
        $this->engine->jquery_preloaded = false;
        $this->engine->jquery_preloaded = false;

        $this->engine->initial_execute_mode = "ADMIN";
        $this->engine->access_mode = "FULL";  // Run single report, no "return button"
        //$this->engine->access_mode = "SINGLEREPORT";  // Run single report, no access to other reports
        //$this->engine->Access_mode = "ONEPROJECT"; // Run single report, but with ability to access other reports
        $this->engine->clear_reportico_session = true;
        echo $this->engine->execute();
        \Session::save();
        die;

    }

    // Generate output for a single report
    public function execute($project=false, $report=false) {

	    $this->initialiseEngine();

        $this->engine->bootstrap_styles = "3";
        $this->engine->bootstrap_preloaded = false;
        $this->engine->jquery_preloaded = false;
        $this->engine->jquery_preloaded = false;

        $this->engine->initial_project = $project;
        $this->engine->initial_report = $report;
        $this->engine->initial_execute_mode = "EXECUTE";
        $this->engine->access_mode = "REPORTOUTPUT";  // Run single report, no "return button"
        //$this->engine->access_mode = "SINGLEREPORT";  // Run single report, no access to other reports
        //$this->engine->Access_mode = "ONEPROJECT"; // Run single report, but with ability to access other reports
        $this->engine->clear_reportico_session = true;
        echo $this->engine->execute();
        \Session::save();
        die;

    }

    // Generate crteria screen for a single report
    public function prepare($project=false, $report=false) {

	    $this->initialiseEngine();

        $this->engine->bootstrap_styles = "3";
        $this->engine->bootstrap_preloaded = false;
        $this->engine->jquery_preloaded = false;
        $this->engine->jquery_preloaded = false;

        $this->engine->initial_project = $project;
        $this->engine->initial_report = $report;
        $this->engine->initial_execute_mode = "PREPARE";
        $this->engine->access_mode = "SINGLEREPORT";  // Run single report, no access to other reports
        //$this->engine->Access_mode = "ONEPROJECT"; // Run single report, but with ability to access other reports
        $this->engine->clear_reportico_session = true;
        echo $this->engine->execute();
        \Session::save();
        die;

    }

    public function menu($project=false) {

	    $this->initialiseEngine();

        $this->engine->bootstrap_styles = "3";
        $this->engine->bootstrap_preloaded = false;
        $this->engine->jquery_preloaded = false;
        $this->engine->jquery_preloaded = false;

        //j$this->engine->access_mode = "ALLPROJECTS";  // Run single project menu, with access to other reports in other projects
        $this->engine->access_mode = "ONEPROJECT";
        $this->engine->initial_project = $project;
        $this->engine->clear_reportico_session = true;
        echo $this->engine->execute();
        \Session::save();
        die;
    }

    public function ajax($project=false) {

	    $this->initialiseEngine();

        $this->engine->bootstrap_styles = "3";
        $this->engine->bootstrap_preloaded = false;
        $this->engine->jquery_preloaded = false;
        $this->engine->jquery_preloaded = false;

        //j$this->engine->access_mode = "ALLPROJECTS";  // Run single project menu, with access to other reports in other projects
        //$this->engine->access_mode = "ONEPROJECT";
        //$this->engine->initial_project = $project;
        //$this->engine->clear_reportico_session = true;
        echo $this->engine->execute();
        \Session::save();
        die;
    }
}
