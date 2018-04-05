<?php

namespace Olabs\Oimsapi\Http\Controllers;

use Olabs\Oims\Models\Supplier;
use Olabs\Oimsapi\Http\Transformers\SupplierTransformer;
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
class Suppliers extends ApiController
{
    /**
     * Eloquent model.
     *
     * @return \October\Rain\Database\Model
     */
    protected function model()
    {
        return new Supplier;
    }

    /**
     * Transformer for the current model.
     *
     * @return \League\Fractal\TransformerAbstract
     */
    protected function transformer()
    {
        return new SupplierTransformer;
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

        

        $with = $this->getEagerLoad();
        $skip = (int) $this->request->input('skip', 0);
        $limit = $this->calculateLimit();

        $where = [];//'tenant_id'=>$org];//,'site_domain_code'=>'ehr'];

        if($project_id){
           // $where['project_id'] = $project_id;
        }

        $criteria = get_class($this->model())::where($where);

        $q =  $this->request->input('q', false);
        if($q){
            //$criteria->where('first_name', 'like', $q.'%');

             $items->whereRaw(
             "MATCH(customer_name,customer_phone,customer_email) AGAINST(? IN BOOLEAN MODE)", 
             array($q.'*'));
        }

        //$criteria->whereIn('profile_type',['his_clinic','his_lab']);

        $items = $limit
            ? $criteria->with($with)->skip($skip)->limit($limit)->get()
            : $criteria->with($with)->get();
        $response = $this->respondWithCollection($items, $skip, $limit);
        //BaseModel::$feature_enabled = true;

        return $response;

    }
}
