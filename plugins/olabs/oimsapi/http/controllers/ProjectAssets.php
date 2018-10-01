<?php

namespace Olabs\Oimsapi\Http\Controllers;

use Olabs\Oims\Models\ProjectAssetPurchase  ;
use Olabs\Oims\Models\ProjectAssetMonitor  ;
use Olabs\Oimsapi\Http\Transformers\ProjectAssetTransformer;
use Autumn\Api\Classes\ApiController;
use Illuminate\Http\Request;
use Olabs\Tenant\Models\BaseModel;
use Db;
use Olabs\App\Classes\App;
class ProjectAssets extends ApiController
{


    public $fillable = ['quantity','project_id','product_id'];

     public $search_like_based = ['title'];
    /**
     * Eloquent model.
     *
     * @return \October\Rain\Database\Model
     */
    protected function model()
    {
        return new ProjectAssetPurchase;
    }

    /**
     * Transformer for the current model.
     *
     * @return \League\Fractal\TransformerAbstract
     */
    protected function transformer()
    {
        return new ProjectAssetTransformer;
    }


     public function getExtraConditions($action, Request $request , &$criteria ){
           $this->scopeEquals($criteria,'project_id');
           $this->scopeEquals($criteria,'product_id');

    }


    public function report(Request $request ){

        BaseModel::$feature_enabled = false;
        $app = App::getInstance();
        $base = $app->getBaseEndpoint();
        $with = $this->getEagerLoad();
        $skip = (int) $this->request->input('skip', 0);
        $limit = $this->calculateLimit();

        $where = [];
        $where['project'] =  $this->request->input('project_id', false);
        $q = $this->request->input('q', false);
        if($q)$where['q'] = $q;

        $items = $this->searchAssets($where);

        $project = \Olabs\Oims\Models\Project::where(['id'=>$where['project']])->first();


        $list = [];
        foreach ($items as $key => $item) {
            # code...
            $asset = $item;
            $product = \Olabs\Oims\Models\Product::find($asset->product_id);

            if($q && $q!=''){

              if(stripos($product->title, $q)=== FALSE){
                 continue;
              }

            }

            $quantity = 0;
            $quantity = $asset->purchase_quantity + $asset->tf_quantity - $asset->tt_quantity - $asset->damage_quantity ;


           $data = ['name'=>$product->title, 'content_type'=>'projectasset','uiview_detail'=>'group'];

           $subtitle = [];
           $subtitle[] =  'Quantity '.$quantity;
           
           if($project && $product){

               $pm = ProjectAssetMonitor::where(['project_id'=>$project->id,'product_id'=>$product->id])->orderBy('id', 'desc')->first();

               if($pm && $pm->context_date){
                 $subtitle[] =  'Dated '.date('Y-m-d H:i', strtotime($pm->context_date));
               }elseif ($pm && $pm->created_at){
                   $subtitle[] =  'Dated '.date('Y-m-d H:i', strtotime($pm->created_at));
               }

               if($pm->images){

                  $app = new App();
                  $app->item = $pm;
                  $app->val = $data;
                  $app->images_field = 'images';
                  $images = $app->getImagesApi();

                  $data = $app->val;
                  if($images && count($images)>0){
                    $data['images'] = $images;
                  }


               }
           }


           $data['subtitle'] = implode(" | ", $subtitle);

           $attributes  = [];
           if($project){
             $attributes[] =['name'=>'Project','value'=>$project->name];
           }
            if($product){
             $attributes[] =['name'=>'Product','value'=>$product->title];
           }
           $attributes[] =['name'=>'Current Quantity','value'=>$quantity];
           $attributes[] =['name'=>'Purchase Quantity','value'=>$item->purchase_quantity];
           $attributes[] =['name'=>'Damage Quantity','value'=>$item->damage_quantity];
           $attributes[] =['name'=>'TF Quantity','value'=>$item->tf_quantity];
           $attributes[] =['name'=>'TT Quantity','value'=>$item->tt_quantity];
           $data['attributes'] = $attributes;

           $modules = [];
           $fmodules = [];
           if($app->hasPermission($item,'manage_assets_reports')){
              $this->addAssetsModule($project->id, $item,$fmodules);

          }

          $modules = $fmodules;

          $data['modules'] = $modules;

           $list[] = $data;
        }

        $status = ['project'=>$project,'data'=>$list];
        return $this->respond($status);


    }

    protected function searchAssets($searchParams) {

        $purchases = array();
        
        $project = ( trim($searchParams['project']) != "" ) ? $searchParams['project'] : false;

        $baseModel = new \Olabs\Oims\Models\BaseModel();
        $assigned_projects = $baseModel->getProjectOptions();

        $params = array();

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

        return $assets;

    }


    public function addAssetsModule($project_id,$item,&$fmodules){

        $app = App::getInstance();
        $base = $app->getBaseEndpoint();

          $modules = [];


             

            $module =[  'name'=>'Assets Monitor Reports','list'=>$base.'/api/v1/projectassetmonitors/report?project_id='.$project_id.'&product_id='.$item->product_id,'module'=>'product','edit_url2'=>$base.'/api/v1/employees',
              'filters'=>[['name'=>'Filter by Product','type'=>'text_ac','item_id'=>'product_id','api'=>$base.'/api/v1/products'],
             ['name'=>'Select Dates','type'=>'date_range','item_id_from_date'=>'created_at_from','item_id_to_date'=>'created_at_to'],['name'=>'Till Date','id'=>'created_at_to']],

              
             ];
             $modules[] = $module;
             
             $module =[  'name'=>'Assets Transfer Reports','list'=>$base.'/api/v1/projectassettransfers/report?project_id='.$project_id.'&product_id='.$item->product_id,'module'=>'product','edit_url2'=>$base.'/api/v1/employees',
              'filters'=>[['name'=>'Filter by Product','type'=>'text_ac','item_id'=>'product_id','api'=>$base.'/api/v1/products'],
             ['name'=>'Select Dates','type'=>'date_range','item_id_from_date'=>'created_at_from','item_id_to_date'=>'created_at_to'],['name'=>'Till Date','id'=>'created_at_to']],

              
             ];$modules[] = $module;

             $module =[ 'name'=>'Assets Damages Reports','list'=>$base.'/api/v1/projectassetdamages/report?project_id='.$project_id.'&product_id='.$item->product_id,'module'=>'product','edit_url2'=>$base.'/api/v1/employees',
              'filters'=>[['name'=>'Filter by Product','type'=>'text_ac','item_id'=>'product_id','api'=>$base.'/api/v1/products'],
             ['name'=>'Select Dates','type'=>'date_range','item_id_from_date'=>'created_at_from','item_id_to_date'=>'created_at_to'],['name'=>'Till Date','id'=>'created_at_to']],

              
             ];

           $modules[] = $module;

 
           
           


           $module =[ 'item_type'=>'flat_list', 'name'=>'Assets logs','module'=>'patients',
              'items'=>$modules
            ];
           $fmodules[] = $module;
            return $module;



        }

}
