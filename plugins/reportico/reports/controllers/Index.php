<?php namespace Reportico\Reports\Controllers;

use Backend\Classes\Controller;
use Backend\Traits\InspectableContainer;
use Reportico\Reports\Widgets\ReporticoEngine;

/**
 * Builder index controller
 *
 * @package reportico\reports
 * @author Peter Deed
 */
class Index extends Controller
{
    use InspectableContainer;

    public $requiredPermissions = ['reportico.reportico.manage_plugins'];

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();

        \BackendMenu::setContext('Reportico.Reports', 'reports', 'reports');

        $this->bodyClass = 'compact-container';
        $this->pageTitle = 'reportico.reportico::lang.plugin.name';

        new ReporticoEngine($this, 'ReporticoEngine');
    }

    public function index()
    {
        $this->addCss('/plugins/rainlab/builder/assets/css/builder.css', 'Reportico.Reports');

        // The table widget scripts should be preloaded
        //$this->addJs('/modules/backend/widgets/table/assets/js/build-min.js', 'core');
        //$this->addJs('/plugins/rainlab/builder/assets/js/build-min.js', 'Reportico.Reports');

        //$this->addJs('/plugins/reportico/reports/assets/js/bootstrap3/js/bootstrap.min.js');
        //$this->addCss('/plugins/reportico/reports/assets/js/bootstrap3/css/bootstrap.min.css');
        $this->addJs('/plugins/reportico/reports/assets/js/reportico.js');
        $this->addCss('/plugins/reportico/reports/assets/css/reportico_bootstrap.css');
        $this->addCss('/plugins/reportico/reports/assets/js/select2/css/reporticoSelect2.min.css');
        $this->addJs('/plugins/reportico/reports/assets/js/select2/js/reporticoSelect2.min.js');
        $this->addJs('/plugins/reportico/reports/assets/js/jquery.dataTables.min.js');
        $this->addJs('/plugins/reportico/reports/assets/js/jquery.jdMenu.js');
        //$this->addJs('/plugins/reportico/reports/assets/js/ui/jquery-ui.js');
        $this->addJs('/plugins/reportico/reports/assets/js/ui/jquery-ui.min.js');
        $this->addJs('/plugins/reportico/reports/assets/js/nvd3/d3.min.js');
        $this->addCss('/plugins/reportico/reports/assets/js/nvd3/nv.d3.css');
        $this->addJs('/plugins/reportico/reports/assets/js/nvd3/nv.d3.js');
        $this->addJs('/plugins/reportico/reports/assets/js/download.js');

        $this->pageTitleTemplate = '%s Builder';
    }

}
