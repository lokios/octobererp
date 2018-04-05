<?php

namespace Autumn\Api\Classes;

use Validator;
use File as FileHelper;
use League\Fractal\Manager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use League\Fractal\Resource\Item;
use Illuminate\Routing\Controller;
use League\Fractal\Pagination\Cursor;
use League\Fractal\Resource\Collection;
//use Olabs\Tenant\Models\BaseModel;
use Olabs\Tenant\Models\BaseModel;
use Carbon\Carbon;
use Olabs\App\Classes\App;
use OlabsAuth;
/**

https://laravel.io/forum/07-21-2015-eloquent-between-two-dates-from-database

http://opaclabs.com/ehr/api/v1/users?tenant_id=72&created_at_from=2017-12-24



**/
abstract class ApiController extends Controller
{
    /**
     * Http status code.
     *
     * @var int
     */
    protected $statusCode = Response::HTTP_OK;

    /**
     * Fractal Manager instance.
     *
     * @var Manager
     */
    protected $fractal;

    /**
     * Model instance.
     *
     * @var \Illuminate\Database\Eloquent\Model;
     */
    protected $model;

    /**
     * Fractal Transformer instance.
     *
     * @var \League\Fractal\TransformerAbstract
     */
    protected $transformer;

    /**
     * Illuminate\Http\Request instance.
     *
     * @var Request
     */
    protected $request;

    /**
     * Do we need to unguard the model before create/update?
     *
     * @var bool
     */
    protected $unguard = true;

    /**
     * Number of items displayed at once if not specified.
     * There is no limit if it is 0 or false.
     *
     * @var int|bool
     */
    protected $defaultLimit = 5;

    /**
     * Maximum limit that can be set via $_GET['limit'].
     *
     * @var int|bool
     */
    protected $maximumLimit = 5;

    /**
     * Resource key for an item.
     *
     * @var string
     */
    protected $resourceKeySingular = 'data';

    /**
     * Resource key for a collection.
     *
     * @var string
     */
    protected $resourceKeyPlural = 'data';

    protected $fillable = false;




    public $search_boolean_based = false;
    public $search_like_based = false;
    public $search_barcode_based = false;
    public $images_field = 'featured_images';
    public $orderBy = 'id';
    public $orderByOrder = 'desc';
    public $filter_scopes =false;



    /**
     * Constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {

        $app = App::getInstance();
        $app->getAppUser();
        $this->model = $this->model();
        $this->transformer = $this->transformer();

        $this->fractal = new Manager();
        $this->fractal->setSerializer($this->serializer());

        if ($includes = $this->transformer->getAvailableIncludes()) {
            $this->fractal->parseIncludes($includes);
        }

        $this->request = $request;
    }

    /**
     * Eloquent model.
     *
     * @return \October\Rain\Database\Model
     */
    abstract protected function model();

    /**
     * Transformer for the current model.
     *
     * @return \League\Fractal\TransformerAbstract
     */
    abstract protected function transformer();

    /**
     * Serializer for the current model.
     *
     * @return \League\Fractal\Serializer\SerializerAbstract
     */
    protected function serializer()
    {
        return new ArraySerializer();
    }

public function scopeCreatedDaysAgo($query, $days = 7)
{
    return $query->where('created_at', '>=', Carbon::now()->subDays($days));
}




public function scopeEquals(&$criteria, $field){
    if($this->filter_scopes){
        if(!isset($this->filter_scopes[$field])){
            return;
        }
    }
        $q =  $this->request->input($field, false);
        if($q){

            
           $criteria->where($field, $q);
        }

  }
  public function scopeDateBetween(&$criteria, $field){
        $q =  $this->request->input($field.'_from', false);
        if($q){

            $fromDate = date('Y-m-d' . ' 00:00:00', strtotime($q)); 
            $toDate = false;
            $q2 =  $this->request->input($field.'_to', false);
            if($q2){
                 $toDate = date('Y-m-d' . ' 22:00:40', strtotime($q2)); 
             
            }else{
               $toDate = date('Y-m-d' . ' 22:00:40', time()); 
            }

           $criteria->whereBetween($field, [$fromDate, $toDate]);
        }

  }


   public function getExtraConditions($action, Request $request , &$criteria ){

    }



    public function getQueryBuilder(Request $request )
    {

        BaseModel::$feature_enabled = false;

        $with = $this->getEagerLoad();
        $skip = (int) $this->request->input('skip', 0);
        $limit = $this->calculateLimit();

        $where = [];
        $criteria = get_class($this->model())::where($where);

        
        $this->scopeEquals($criteria,'tenant_id');
        $this->scopeEquals($criteria,'status');
        $this->scopeEquals($criteria,'project_id');
        $this->scopeEquals($criteria,'user_id');
        $this->scopeEquals($criteria,'services_id');
        $this->scopeEquals($criteria,'category_id');
        $this->scopeEquals($criteria,'parent_id');
        $this->scopeDateBetween($criteria,'created_at');
        $this->scopeDateBetween($criteria,'updated_at');
        $this->scopeDateBetween($criteria,'published_at');



         if($this->search_barcode_based && count($this->search_barcode_based)>0){
            $q =  $this->request->input('bcode', false);
            if($q){

                  $criteria->where($this->search_barcode_based[0],  $q);
                    

            }
         }


        


        $q =  $this->request->input('q', false);
        $qtype =  $this->request->input('qtype', false);

        if($qtype && $qtype=='barcode'){
            if($this->search_barcode_based && count($this->search_barcode_based)==1){
                 $value = $this->search_barcode_based[0];
                  $criteria->where($value,  $q);
                 
             }

        }else  if($q){
            //$criteria->where('first_name', 'like', $q.'%');

            if($this->search_boolean_based){
                /** $items->whereRaw(
             "MATCH(customer_name,customer_phone,customer_email) AGAINST(? IN BOOLEAN MODE)", 
             array($q.'*')); **/

              $criteria->whereRaw(
             "MATCH(".$this->search_boolean.") AGAINST(? IN BOOLEAN MODE)", 
             array($q.'*'));

            }

             if($this->search_like_based && count($this->search_like_based)>1){

                  $search_like_based = $this->search_like_based;

                   $criteria->where(function ($query)use ($search_like_based, $q) {

                     foreach ($this->search_like_based as $key => $value) {
                    # code...

                         if($value=='id'){
                             $query->orWhere($value,  $q);
                    

                         }else{
                              $query->orWhere($value, 'like', $q.'%');
                         }
                      }
                   });

                

             }else  if($this->search_like_based && count($this->search_like_based)==1){
                 $value = $this->search_like_based[0];
                 if($value=='id'){
                             $criteria->where($value,  $q);
                    

                         }else{
                              $criteria->where($value, 'like', $q.'%');
                         }

             }

            
        }

        return $criteria;



     }


    /**
     * Display a listing of the resource.
     * GET /api/{resource}.
     *
     * @return Response
     */
    public function index(Request $request )
    {

        BaseModel::$feature_enabled = false;

        $with = $this->getEagerLoad();
        $skip = (int) $this->request->input('skip', 0);
        $limit = $this->calculateLimit();

        $where = [];
        $criteria = $this->getQueryBuilder($request);

        
        

        $this->getExtraConditions('index',$request,$criteria);

        


        $items = $limit
            ? $criteria->with($with)->skip($skip)->limit($limit)
            : $criteria->with($with);

         if($this->orderBy){
            $items->orderBy($this->orderBy,$this->orderByOrder);
         }   

         $items = $items->get();

        $result = $this->respondWithCollection($items, $skip, $limit);
        BaseModel::$feature_enabled = true;
        return $result;
    }


    public function report(Request $request ){

        BaseModel::$feature_enabled = false;

        $with = $this->getEagerLoad();
        $skip = (int) $this->request->input('skip', 0);
        $limit = $this->calculateLimit();

        $where = [];
        $criteria = $this->getQueryBuilder($request);

        
        

        $this->getExtraConditions('index',$request,$criteria);

        


        $items = $limit
            ? $criteria->with($with)->skip($skip)->limit($limit)
            : $criteria->with($with);

         if($this->orderBy){
            $items->orderBy($this->orderBy,$this->orderByOrder);
         }   

         $items = $items->get();

        $result = $this->respondWithCollection($items, $skip, $limit);
        BaseModel::$feature_enabled = true;
        return $result;
    }


 /**
     * Display a listing of the resource.
     * GET /api/{resource}.
     *
     * @return Response
     */
    public function indexByTenan22(Request $request, $org=null)
    {

        BaseModel::$feature_enabled = false;

        

        $with = $this->getEagerLoad();
        $skip = (int) $this->request->input('skip', 0);
        $limit = $this->calculateLimit();

        $where = ['tenant_id'=>$org];//,'site_domain_code'=>'ehr'];

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
        BaseModel::$feature_enabled = true;

        return $response;

    }


/**
     * Creates a file object from raw data.
     *
     * @param $data string Raw data
     * @param $filename string Filename
     *
     * @return $this
     */
    public function fromData($data, $filename)
    {
        if ($data === null) {
            return;
        }
        $file1 =  new \System\Models\File();
        $tempPath = temp_path($filename);
        FileHelper::put($tempPath, $data);
        $file = $file1->fromFile($tempPath);
        FileHelper::delete($tempPath);
        return $file;
    }




    

    /**
     * Store a newly created resource in storage.
     * POST /api/{resource}.
     *
     * @return Response
     */
    public function store()
    {

         BaseModel::$feature_enabled = false;
        $data = $this->request->json()->get($this->resourceKeySingular);

        if (! $data) {
            return $this->errorWrongArgs('Empty data');
        }

        $validator = Validator::make($data, $this->rulesForCreate());
        if ($validator->fails()) {
            return $this->errorWrongArgs($validator->messages());
        }

        $this->unguardIfNeeded();

        $fdata = $data;
        if($this->fillable){
            $fdata = [];
            foreach ($this->fillable as $key => $value) {
               if(isset($data[$value])){
                  $fdata[$value] =  $data[$value];
               }
            }
        }

        if(isset($fdata['context_date'])){
            $fdata['context_date'] = date("Y-m-d H:i:s", strtotime($fdata['context_date']));

            
        }else{
            //$fdata['context_date'] = date("Y-m-d H:i:s");
        }


        if(isset($fdata['images'])){
            unset($fdata['images']);
        }

        $item = $this->model->create($fdata);

        if(isset($data['images'])){
            foreach ($data['images'] as $key => $value) {

               $idata = base64_decode($value['data']);
               
               $file = $this->fromData($idata, 'photo_'.$key);
               $file->is_public = true;
               $file->save();

               $item->{$this->images_field}()->add($file);
            }
        }

         BaseModel::$feature_enabled = true;

        return $this->respondWithItem($item);
    }



   public function storeByUser(Request $request,$tenant_id=null, $user_id=null)
    {

         BaseModel::$feature_enabled = false;
        $data = $this->request->json()->get($this->resourceKeySingular);

        if (! $data) {
            return $this->errorWrongArgs('Empty data');
        }

        $validator = Validator::make($data, $this->rulesForCreate());
        if ($validator->fails()) {
            return $this->errorWrongArgs($validator->messages());
        }

        $this->unguardIfNeeded();

        $fdata = $data;
        if($this->fillable){
            $fdata = [];
            foreach ($this->fillable as $key => $value) {
               if(isset($data[$value])){
                  $fdata[$value] =  $data[$value];
               }
            }
        }

        $fdata['user_id'] = $user_id;
        $fdata['tenant_id'] = $tenant_id;
        if(isset($fdata['images'])){
            unset($fdata['images']);
        }
        $item = $this->model->create($fdata);

        if(isset($data['images'])){
            foreach ($data['images'] as $key => $value) {

               $idata = base64_decode($value['data']);
               
               $file = $this->fromData($idata, 'photo_'.$key);
               $file->is_public = true;
               $file->save();

               $item->{$this->images_field}()->add($file);
            }
        }

         BaseModel::$feature_enabled = true;

        return $this->respondWithItem($item);
    }




    public function storeByService(Request $request,$tenant_id=null,$services_id=null)
    {

         BaseModel::$feature_enabled = false;
        $data = $this->request->json()->get($this->resourceKeySingular);

        if (! $data) {
            return $this->errorWrongArgs('Empty data');
        }

        $validator = Validator::make($data, $this->rulesForCreate());
        if ($validator->fails()) {
            return $this->errorWrongArgs($validator->messages());
        }

        $this->unguardIfNeeded();

        $fdata = $data;
        if($this->fillable){
            $fdata = [];
            foreach ($this->fillable as $key => $value) {
               if(isset($data[$value])){
                  $fdata[$value] =  $data[$value];
               }
            }
        }
        

        $fdata['services_id'] = $services_id;
        
        $fdata['tenant_id'] = $tenant_id;
        if(isset($fdata['images'])){
            unset($fdata['images']);
        }
        $item = $this->model->create($fdata);

        if(isset($data['images'])){
            foreach ($data['images'] as $key => $value) {

               $idata = base64_decode($value['data']);
               
               $file = $this->fromData($idata, 'photo_'.$key);
               $file->is_public = true;
               $file->save();

               $item->{$this->images_field}()->add($file);
            }
        }

         BaseModel::$feature_enabled = true;

        return $this->respondWithItem($item);
    }

    /**
     * Display the specified resource.
     * GET /api/{resource}/{id}.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $with = $this->getEagerLoad();

        $item = $this->findItem($id, $with);
        if (! $item) {
            return $this->errorNotFound();
        }

        return $this->respondWithItem($item);
    }





   public function echo(Request $request){
        

return $this->respond(['s'=>'echo']);
        return ['s'=>'echo'];

        return \Response::json(array('success' => true));
    }


   public function upload2(Request $request){
        $id = $request->input('id', false);
        $files = $request->file('images');


        $item = $this->findItem($id);
        if (! $item) {
            return $this->errorNotFound();
        }



        if(!empty($files)):

            foreach($files as $file):
                Storage::put($file->getClientOriginalName(), file_get_contents($file));
            endforeach;

        endif;

        return \Response::json(array('success' => true));
    }

    public function upload(Request $request){

         BaseModel::$feature_enabled = false;
        $id = $request->input('id', false);
        $files = $request->file('images');


        $item = $this->findItem($id);
        if (! $item) {
            return $this->errorNotFound();
        }

       $count = 0;

        if(!empty($files)){

            //return $this->respond(['s'=>'echo', 'files'=>count($files)]);

             foreach($files as $file1) {

                $file = new \System\Models\File();
$file->data = $file1;
$file->is_public = true;
$file->save();

               $item->{$this->images_field}()->add($file);
               $count++;
            }
        }

       // $item->save();

       //    return $this->respond(['s'=>'echo', 'files'=>$count]);

       BaseModel::$feature_enabled = true;

        return $this->respondWithItem($item);
    }



    /**
     * Update the specified resource in storage.
     * PUT /api/{resource}/{id}.
     *
     * @param int $id
     *
     * @return Response
     */
    public function update($id)
    {
         BaseModel::$feature_enabled = false;
        $data = $this->request->json()->get($this->resourceKeySingular);


        $data1 = $this->request->json();

        if (! $data) {
            return $this->errorWrongArgs('Empty data');
        }

        $item = $this->findItem($id);
        if (! $item) {
            return $this->errorNotFound();
        }

        $validator = Validator::make($data, $this->rulesForUpdate($item->id));
        if ($validator->fails()) {
            return $this->errorWrongArgs($validator->messages());
        }

        $this->unguardIfNeeded();


        $fdata = $data;
        if($this->fillable){
            $fdata = [];
            foreach ($this->fillable as $key => $value) {
               if(isset($data[$value])){
                  $fdata[$value] =  $data[$value];
               }
            }
        }
        if(isset($fdata['images'])){
            unset($fdata['images']);
        }
        $item->fill($fdata);
        $item->save();

         if(isset($data['images'])){
            foreach ($data['images'] as $key => $value) {

               $idata = base64_decode($value['data']);
               
               $file = $this->fromData($idata, 'photo_'.$key);
               $file->is_public = true;
               $file->save();

               $item->{$this->images_field}()->add($file);
            }
        }

        if(isset($data['deleted_images'])){
            foreach ($data['deleted_images'] as $key => $value) {

                foreach ($item->{$this->images_field} as $key2 => $value2) {
                    # code...
                    if($value2->id == $value['id']){
                        $item->{$this->images_field}()->remove($value2);
                    }
                }

              

               
            }
        }

        $item->save();


         BaseModel::$feature_enabled = true;

        return $this->respondWithItem($item);
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /api/{resource}/{id}.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {

        BaseModel::$feature_enabled = false;
        $item = $this->findItem($id);

        if (! $item) {
            return $this->errorNotFound();
        }


        $item->status = 'O';
        $item->save();

        //$item->delete();


        BaseModel::$feature_enabled = true;

        return $this->respond(['message' => 'Deleted']);
    }

    /**
     * Show the form for creating the specified resource.
     *
     * @return Response
     */
    public function create()
    {
        return $this->errorNotImplemented();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        return $this->errorNotImplemented();
    }

    /**
     * Respond with a given item.
     *
     * @param $item
     *
     * @return mixed
     */
    protected function respondWithItem($item)
    {
        $resource = new Item($item, $this->transformer, $this->resourceKeySingular);

        $rootScope = $this->prepareRootScope($resource);

        return $this->respond($rootScope->toArray());
    }

    /**
     * Respond with a given collection.
     *
     * @param $collection
     * @param int $skip
     * @param int $limit
     *
     * @return mixed
     */
    protected function respondWithCollection($collection, $skip = 0, $limit = 0)
    {
        $resource = new Collection($collection, $this->transformer, $this->resourceKeyPlural);

        if ($limit) {
            $cursor = new Cursor($skip, $skip + $limit, $collection->count());
            $resource->setCursor($cursor);
        }

        $rootScope = $this->prepareRootScope($resource);

        $listData = $rootScope->toArray();
        $meta =$listData['meta'];
        unset($listData['meta']);

        $status = ['data'=>$listData,'meta'=>$meta];
        return $this->respond($status);

        //return $this->respond($rootScope->toArray());
    }

    /**
     * Get the http status code.
     *
     * @return int
     */
    protected function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Set the http status code.
     *
     * @param int $statusCode
     *
     * @return $this
     */
    protected function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Send the response as json.
     *
     * @param array $data
     * @param array $headers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respond($data = [], array $headers = [])
    {
        return response()->json($data, $this->statusCode, $headers);
    }

    /**
     * Send the error response as json.
     *
     * @param string $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithError($message)
    {
        return $this->respond([
            'error' => [
                'message' => $message,
                'status_code' => $this->statusCode,
            ],
        ]);
    }

    /**
     * Prepare root scope and set some meta information.
     *
     * @param Item|Collection $resource
     *
     * @return \League\Fractal\Scope
     */
    protected function prepareRootScope($resource)
    {
        return $this->fractal->createData($resource);
    }

    /**
     * Get the validation rules for create.
     *
     * @return array
     */
    protected function rulesForCreate()
    {
        return [];
    }

    /**
     * Get the validation rules for update.
     *
     * @param int $id
     *
     * @return array
     */
    protected function rulesForUpdate($id)
    {
        return [];
    }

    /**
     * Generate a Response with a 400 HTTP header and a given message.
     *
     * @param string $message
     *
     * @return Response
     */
    protected function errorWrongArgs($message = 'Wrong Arguments')
    {
        return $this->setStatusCode(Response::HTTP_BAD_REQUEST)->respondWithError($message);
    }

    /**
     * Generate a Response with a 401 HTTP header and a given message.
     *
     * @param string $message
     *
     * @return Response
     */
    protected function errorUnauthorized($message = 'Unauthorized')
    {
        return $this->setStatusCode(Response::HTTP_UNAUTHORIZED)->respondWithError($message);
    }

    /**
     * Generate a Response with a 403 HTTP header and a given message.
     *
     * @param string $message
     *
     * @return Response
     */
    protected function errorForbidden($message = 'Forbidden')
    {
        return $this->setStatusCode(Response::HTTP_FORBIDDEN)->respondWithError($message);
    }

    /**
     * Generate a Response with a 404 HTTP header and a given message.
     *
     * @param string $message
     *
     * @return Response
     */
    protected function errorNotFound($message = 'Resource Not Found')
    {
        return $this->setStatusCode(Response::HTTP_NOT_FOUND)->respondWithError($message);
    }

    /**
     * Generate a Response with a 405 HTTP header and a given message.
     *
     * @param string $message
     *
     * @return Response
     */
    protected function errorNotAllowed($message = 'Method Not Allowed')
    {
        return $this->setStatusCode(Response::HTTP_METHOD_NOT_ALLOWED)->respondWithError($message);
    }

    /**
     * Generate a Response with a 500 HTTP header and a given message.
     *
     * @param string $message
     *
     * @return Response
     */
    protected function errorInternalError($message = 'Internal Error')
    {
        return $this->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR)->respondWithError($message);
    }

    /**
     * Generate a Response with a 501 HTTP header and a given message.
     *
     * @param string $message
     *
     * @return Response
     */
    protected function errorNotImplemented($message = 'Not implemented')
    {
        return $this->setStatusCode(Response::HTTP_NOT_IMPLEMENTED)->respondWithError($message);
    }

    /**
     * Specify relations for eager loading.
     *
     * @return array
     */
    protected function getEagerLoad()
    {
        $includes = $this->transformer->getAvailableIncludes();

        return $includes ?: [];
    }

    /**
     * Get item according to mode.
     *
     * @param int   $id
     * @param array $with
     *
     * @return mixed
     */
    protected function findItem($id, array $with = [])
    {
        if ($this->request->has('use_as_id')) {
            return $this->model->with($with)->where($this->request->input('use_as_id'), '=', $id)->first();
        }

        return $this->model->with($with)->find($id);
    }

    /**
     * Unguard eloquent model if needed.
     */
    protected function unguardIfNeeded()
    {
        if ($this->unguard) {
            $this->model->unguard();
        }
    }

    /**
     * Calculates limit for a number of items displayed in list.
     *
     * @return int
     */
    protected function calculateLimit()
    {
        $limit = (int) $this->request->input('limit', $this->defaultLimit);

        return ($this->maximumLimit && $this->maximumLimit < $limit) ? $this->maximumLimit : $limit;
    }
}
