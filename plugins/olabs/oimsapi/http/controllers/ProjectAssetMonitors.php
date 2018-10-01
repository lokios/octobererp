<?php

namespace Olabs\Oimsapi\Http\Controllers;

use Olabs\Oims\Models\ProjectAssetMonitor  ;
use Olabs\Oimsapi\Http\Transformers\ProjectAssetMonitorTransformer;
use Autumn\Api\Classes\ApiController;
use Illuminate\Http\Request;
class ProjectAssetMonitors extends ApiController
{

    public $fillable = ['quantity','project_id','product_id','context_date'];

     public $search_like_based = ['title'];
     public $images_field = 'images';
     public $orderBy = 'created_at';
     public $orderByOrder = 'desc';


    /**
     * Eloquent model.
     *
     * @return \October\Rain\Database\Model
     */
    protected function model()
    {
        return new ProjectAssetMonitor;
    }

    /**
     * Transformer for the current model.
     *
     * @return \League\Fractal\TransformerAbstract
     */
    protected function transformer()
    {
        return new ProjectAssetMonitorTransformer;
    }


      public function getExtraConditions($action, Request $request , &$criteria ){
           $q2 =  $this->request->input('scope', false);
           if($q2 =='all_recent_entries'){
             $this->scopeEquals($criteria,'project_id');

           }else{
               $this->scopeEquals($criteria,'project_id');
               $this->scopeEquals($criteria,'product_id');
           }
    }

     /**
     * Display a listing of the resource.
     * GET /api/{resource}.
     *
     * @return Response
     */
    public function report(Request $request, $org=null,$project_id=false)
    {

        //BaseModel::$feature_enabled = false;

        

       return $this->index($request);

    }
}
