<?php namespace Olabs\Social\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use  Olabs\Social\Models\Clients;
class ClientsReport extends Controller
{
    public $implement = ['Backend\Behaviors\ListController','Backend\Behaviors\FormController','Backend\Behaviors\ReorderController'];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $reorderConfig = 'config_reorder.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Olabs.Social', 'main-menu-item', 'side-menu-item');
    }


    public function report22(){
    	 $this->bodyClass = 'slim-container';
        $this->makeLists();
    }


      public function report33(){
        $this->addCss('/plugins/rainlab/builder/assets/css/builder.css', 'RainLab.Builder');

        // The table widget scripts should be preloaded
        $this->addJs('/modules/backend/widgets/table/assets/js/build-min.js', 'core');
        $this->addJs('/plugins/rainlab/builder/assets/js/build-min.js', 'RainLab.Builder');

        $this->pageTitleTemplate = '%s Builder';
        $this->pageTitle =  'Reports';
    }


    public function clientreport($id,  $month = null){

          BackendMenu::setContext('Olabs.Social', 'main-menu-item');
          $this->pageTitle =  'Client Reports';

          $client = Clients::where(['id'=>$id])->first();

          $this->vars['client'] = $client;

    }

     public function invoice($id,  $month = null){

          BackendMenu::setContext('Olabs.Social', 'main-menu-item');
          $this->pageTitle =  'Client Reports';

          $client = Clients::where(['id'=>$id])->first();

          $this->vars['client'] = $client;

    }

}
