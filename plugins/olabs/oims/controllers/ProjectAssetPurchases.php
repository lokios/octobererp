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

class ProjectAssetPurchases extends Controller {

    public $implement = [
        'Backend\Behaviors\ListController', 
        'Backend\Behaviors\FormController', 
        'Backend\Behaviors\ReorderController'
        ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $reorderConfig = 'config_reorder.yaml';

    public $requiredPermissions = ['olabs.oims.project_assets'];
    
    protected $searchFormWidget;
    
    public function __construct() {
        parent::__construct();
        BackendMenu::setContext('Olabs.Oims', 'project_assets', 'project_asset_purchases');
        $this->searchFormWidget = $this->createAssetSearchFormWidget();
    }
    
    protected function createAssetSearchFormWidget() {
        $config = $this->makeConfig('$/olabs/oims/models/projectassetpurchase/asset_search_fields.yaml');

        $config->alias = 'assetSearch';

        $config->arrayName = 'AssetSearch';

        $config->model = new \Olabs\Oims\Models\ProjectAssetPurchase;

        $widget = $this->makeWidget('Backend\Widgets\Form', $config);

        $widget->bindToController();

        return $widget;
    }
    
    public function assetList() {
        BackendMenu::setContext('Olabs.Oims', 'project_assets', 'project_asset_list');
        $this->pageTitle = 'Asset List';
        $purchases = array();
        

//        $oimsSetting = '';
        $oimsSetting = \Olabs\Oims\Models\Settings::instance();

        $searchForm = $this->searchFormWidget;

        $this->vars['search'] = false;
        $this->vars['msg'] = false;
        $this->vars['searchFormWidget'] = $searchForm;
        $this->vars['oimsSetting'] = $oimsSetting;
//        $this->vars['purchases'] = $purchases;
        $this->vars['assets'] = [];
        
    }
    
    public function onAssetSearch() {
        
        

        if (post('AssetSearch')) {

            $searchParams = post('AssetSearch');

            // get dpr components
            $this->searchAssets($searchParams);
        }

        $oimsSetting = \Olabs\Oims\Models\Settings::instance();

        $this->vars['search'] = true;
        $this->vars['oimsSetting'] = $oimsSetting;
    }
    
    
    protected function searchAssets($searchParams) {

        $purchases = array();
        
        $project = ( trim($searchParams['project']) != "" ) ? $searchParams['project'] : false;

        $baseModel = new \Olabs\Oims\Models\BaseModel();
        $assigned_projects = $baseModel->getProjectOptions();

        $params = array();
//        if ($project) {
//            $params['project_id'] = $project;
//        }
        /*
        SELECT product_id, sum(purchase_quantity) as purchase_quantity, sum(tf_quantity) as tf_quantity, sum(tt_quantity) as tt_quantity, sum(damage_quantity) as damage_quantity
FROM (
SELECT product_id, quantity as purchase_quantity, 0 as tf_quantity,0 as  tt_quantity,0 as  damage_quantity FROM `olabs_oims_project_assets` WHERE project_id = 1 
UNION ALL
SELECT product_id, 0 as purchase_quantity, quantity as tf_quantity,0 as  tt_quantity,0 as  damage_quantity FROM `olabs_oims_project_asset_transfers` WHERE to_project_id = 1
UNION ALL
SELECT product_id, 0 as purchase_quantity, 0 as tf_quantity,quantity as  tt_quantity,0 as  damage_quantity FROM `olabs_oims_project_asset_transfers` WHERE project_id = 1
UNION ALL 
SELECT product_id,0 as purchase_quantity, 0 as tf_quantity,0 as  tt_quantity,quantity as  damage_quantity FROM `olabs_oims_project_asset_damages` where project_id = 1
)X
GROUP BY product_id
         * 
         */
        //Purchases on Project
//        $purchases = \Olabs\Oims\Models\ProjectAsset::where($params)
//                        ->select(Db::raw('sum(quantity) as purchase_quantity, product_id'))
//                        ->where('project_id',$project)
//                        ->groupBy('product_id');
//        
//        //Received by Transfer from Different Projects
//        $transfer_from = \Olabs\Oims\Models\ProjectAssetTransfer::where($params)
//                        ->select(Db::raw('sum(quantity) as quantity, product_id'))
//                        ->where('to_project_id',$project)
//                        ->groupBy('product_id');
//        
//        //Transfer to Different Projects
//        $transfer_to = \Olabs\Oims\Models\ProjectAssetTransfer::where($params)
//                        ->select(Db::raw('sum(quantity) as purchase_quantity, product_id'))
//                        ->where('project_id',$project)
//                        ->groupBy('product_id');
//        
//        //Product Damage
//        $damages = \Olabs\Oims\Models\ProjectAssetDamage::where($params)
//                        ->select(Db::raw('sum(quantity) as damage_quantity, product_id'))
//                        ->where('project_id',$project)
//                        ->groupBy('product_id');
        
        $assets = DB::select("SELECT product_id, sum(purchase_quantity) as purchase_quantity, sum(tf_quantity) as tf_quantity, sum(tt_quantity) as tt_quantity, sum(damage_quantity) as damage_quantity
FROM (
SELECT product_id, quantity as purchase_quantity, 0 as tf_quantity,0 as  tt_quantity,0 as  damage_quantity FROM `olabs_oims_project_asset_purchases` WHERE project_id = $project 
UNION ALL
SELECT product_id, 0 as purchase_quantity, quantity as tf_quantity,0 as  tt_quantity,0 as  damage_quantity FROM `olabs_oims_project_asset_transfers` WHERE to_project_id = $project
UNION ALL
SELECT product_id, 0 as purchase_quantity, 0 as tf_quantity,quantity as  tt_quantity,0 as  damage_quantity FROM `olabs_oims_project_asset_transfers` WHERE project_id = $project
UNION ALL 
SELECT product_id,0 as purchase_quantity, 0 as tf_quantity,0 as  tt_quantity,quantity as  damage_quantity FROM `olabs_oims_project_asset_damages` where project_id = $project
)X
GROUP BY product_id");
//                ->get();
        
//        $purchases->get();
        
//        dd(count($purchases));
        
        $msg = false;
        if (!$project) {
            $msg = 'Please select Project!';
        }


//        $oimsSetting = \Olabs\Oims\Models\Settings::instance();
//        $this->vars['search'] = true;
        $this->vars['msg'] = $msg;
//        $this->vars['purchases'] = $purchases->get();
        $this->vars['assets'] = $assets;
    }
    

}
