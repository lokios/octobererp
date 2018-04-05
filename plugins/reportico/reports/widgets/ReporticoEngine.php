<?php namespace Reportico\Reports\Widgets;

use Str;
use Input;
use Backend\Classes\WidgetBase;
use Reportico\Reports\Components;
use Request;

/**
 * Plugin controller list widget.
 *
 * @package reportico\reports
 * @author Peter Deed
 */
class ReporticoEngine extends WidgetBase
{
	public $config = false;
	public $engine = false;

    protected $defaultAlias = 'ReporticoEngine';
    public function __construct($controller, $alias)
    {
        $this->alias = $alias;

        parent::__construct($controller, []);
        $this->bindToController();
    }

    /**
     * Renders the widget.
     * @return string
     */
    public function render()
    {

		$this->initialiseEngine();
		$this->engine->clear_reportico_session = 1;
        $this->engine->bootstrap_styles = "3";
        $this->engine->bootstrap_preloaded = true;
        $this->engine->jquery_preloaded = true;
        $this->engine->reportico_ajax_preloaded = true;

        return $this->makePartial('body', [ 'content' => $this->engine->execute()]);

    }

	public function getProjectOptions() {
		$lookin = storage_path() . "/reportico/projects";

		$result = [];
		$result["none"] = "";
		if (is_dir($lookin)) {
			if ($dh = opendir($lookin)) {

				$ct = 0;
				while (($file = readdir($dh)) !== false) {
					if ($file == "." || $file == "..") {
						continue;
					}

					if (is_dir($lookin . "/" . $file)) {
						$ct++;
						$result["$file"] = "$file";
					}
				}
				closedir($dh);
			}
		}
		return ($result);

	}

	public function getReportOptions() {
		$result = [];
		$project = Request::input('project');

		if (!$project) {
			return ($result);
		}

		$lookin = storage_path() . "/reportico/projects/$project";

		//$result ["none"] = "";
		if (is_dir($lookin)) {
			if ($dh = opendir($lookin)) {
				$ct = 0;
				while (($file = readdir($dh)) !== false) {
					if ($file == "." || $file == "..") {
						continue;
					}

					if (preg_match("/.xml$/", $file)) {
						$ct++;
						$result[preg_replace("/.xml$/", "", $file)] = preg_replace("/.xml$/", "", $file);
					}
				}
				closedir($dh);
			}
		}
		return ($result);
	}

	private function initialiseEngine() {
		include_once __DIR__ . "/../config.php";
		include_once __DIR__ . "/../components/reportico.php";
//echo "<PRE>111"; var_dump(\URL::to('/')); echo "</PRE>";
		//$data = \Session::all();
		//set_up_reportico_session();

		//var_dump($this->config);

		$app = $this->app;
//\Route::get('reportico/go', array('as' => 'webform.api.get', 'uses' => 'Reportico\Reports\Classes\Ocaforms@store'));
/*
foreach ( $this->getRouter() as $k => $v )
    echo "$k<BR>";
die;
$this->app["router"]->get("reportico/go", function() use ($app)
{
die;
//return View::make('reportico.reportico');
return $this->app["view"]->make('reportico::reportico');
});

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
		$this->engine = new \Reportico\Reports\Components\reportico();

		$this->engine->reportico_ajax_script_url = preg_replace("/\/index.php/", "", \URL::to("/")) . "/index.php";
		$this->engine->reportico_ajax_script_url = \URL::to("/reportico/ajax");
		//echo $this->engine->reportico_ajax_script_url; die;
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
		$this->engine->ajaxHandler = "ReporticoEngine::onAjax";

		//return $this->engine;
		//});

		$this->engine->return_output_to_caller = true;

	}

/*
	public function onRun() {
		$this->initialiseEngine();
		$this->engine->clear_reportico_session = 1;

		// Apply properties
		if ($this->property('startMode')) {
			$this->engine->initial_execute_mode = strtoupper($this->property('startMode'));
		}

		if ($this->property('project')) {
			$this->engine->initial_project = $this->property('project');
		}

		if ($this->property('report')) {
			$this->engine->initial_report = $this->property('report');
		}

		if ($this->property('accessMode')) {
			$this->engine->access_mode = strtoupper($this->property('accessMode'));
		}

		if ($this->property('accessMode')) {
			$this->engine->access_mode = strtoupper($this->property('accessMode'));
		}

		if ($this->engine->initial_execute_mode == "ADMIN") {
			$this->engine->initial_project = "admin";
		}

		if ($this->property('jquery_status')) {
			if ($this->property('jquery_status') == "ihavejquery") {
				$this->engine->jquery_preloaded = true;
			} else {
				$this->engine->jquery_preloaded = false;
			}

		}
				$this->engine->jquery_preloaded = true;

		if ($this->property('bootstrap_status')) {
			if ($this->property('bootstrap_status') == "ihavebootstrap3") {
				$this->engine->bootstrap_preloaded = true;
			} else {
				$this->engine->bootstrap_preloaded = false;
			}

		}
	    $this->engine->bootstrap_preloaded = true;
	    $this->engine->jquery_preloaded = true;
        $this->engine->reportico_ajax_preloaded = true;


		//if ( !$this->engine->jquery_preloaded )
		//$this->addJs('/plugins/reportico/reports/assets/js/jquery.js');
		$this->addJs('/plugins/reportico/reports/assets/js/reportico.js');
		$this->addCss('/plugins/reportico/reports/assets/css/reportico_bootstrap.css');
		$this->addCss('/plugins/reportico/reports/assets/js/select2/css/reporticoSelect2.min.css');
		$this->addJs('/plugins/reportico/reports/assets/js/select2/js/select2.min.js');
		$this->addJs('/plugins/reportico/reports/assets/js/jquery.dataTables.min.js');
		$this->addJs('/plugins/reportico/reports/assets/js/jquery.jdMenu.js');
		//$this->addJs('/plugins/reportico/reports/assets/js/ui/jquery-ui.js');
		$this->addJs('/plugins/reportico/reports/assets/js/ui/jquery-ui.min.js');
		$this->addJs('/plugins/reportico/reports/assets/js/nvd3/d3.min.js');
		$this->addJs('/plugins/reportico/reports/assets/js/nvd3/nv.d3.js');
        $this->addCss('/plugins/reportico/reports/assets/js/nvd3/nv.d3.css');
		$this->addJs('/plugins/reportico/reports/assets/js/download.js');

		$this->page['content'] = $this->engine->execute();
		return;
	}
*/

	public function info() {
		$this->initialiseEngine();
		$this->page['content'] = $this->engine->execute();

		$json = file_get_contents(sprintf(
			"http://api.openweathermap.org/data/2.5/weather?q=%s,%s,%s&units=%s&APPId=43cc6737f814ea2f5f004a9fbed81ecb",
			$this->property('city'),
			$this->property('state'),
			$this->property('country'),
			$this->property('units')
		));

		return json_decode($json);
	}

	public function onAjax() {

		$this->initialiseEngine();
		echo $this->engine->execute();
        \Session::save();
        die;

	}

	public function onGo() {

		$this->initialiseEngine();
		echo $this->engine->execute();
        \Session::save();
        die;

	}
}
