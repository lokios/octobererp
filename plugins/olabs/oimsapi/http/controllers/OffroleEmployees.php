<?php

namespace Olabs\Oimsapi\Http\Controllers;

use Olabs\Oims\Models\OffroleEmployee;
use Olabs\Oimsapi\Http\Transformers\OffroleEmployeeTransformer;
use Autumn\Api\Classes\ApiController;
use Validator;
use File as FileHelper;
use League\Fractal\Manager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use League\Fractal\Resource\Item;
use Illuminate\Routing\Controller;
use League\Fractal\Pagination\Cursor;
use League\Fractal\Resource\Collection;
use Olabs\Tenant\Models\BaseModel;
class OffroleEmployees extends ApiController
{


    public $search_like_based = ['name'];
    public $search_barcode_based = ['id'];
    /**
     * Eloquent model.
     *
     * @return \October\Rain\Database\Model
     */
    protected function model()
    {
        return new OffroleEmployee;
    }

    /**
     * Transformer for the current model.
     *
     * @return \League\Fractal\TransformerAbstract
     */
    protected function transformer()
    {
        return new OffroleEmployeeTransformer;
    }


     /**
     * Display a listing of the resource.
     * GET /api/{resource}.
     *
     * @return Response
     */
    public function search(Request $request, $org=null,$project_id=false)
    {

        //BaseModel::$feature_enabled = false;

        

       return $this->index($request);

    } 

    public function getExtraConditions($action, Request $request , &$criteria ){
           //$this->scopeEquals($criteria,'project_id');
           //$this->scopeEquals($criteria,'product_id');

           $projects = [];

           $project_id =  $this->request->input('project_id', false);
           if($project_id){
            $projects[] = $project_id;

           }else{
                      
                       $user1 = $this->app->getAppUser();
                       
                      if (!$user1->isAdmin()) {
                    //            foreach ($user->projects as $project) {
                   //                $list[$project->id] = $project->name;
                   //            }
                        $list = $user1->projects;
                    } else {
                        return;
                    }
                     foreach ($list as $key => $value) {
                    # code...
                    $projects[] = $value->id;
                  }
         }

           $criteria->whereIn('project_id', $projects);

    }

}
