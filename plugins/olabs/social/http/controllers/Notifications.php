<?php

namespace Olabs\Social\Http\Controllers;



use Olabs\Social\Models\Clients;
use Olabs\Social\Models\Notifications as NotificationsModel;
use Olabs\Social\Http\Transformers\NotificationsTransformer;
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
use Carbon\Carbon;
use Olabs\App\Classes\App;
use OlabsAuth;
class Notifications extends ApiController
{


     protected $defaultLimit = 5;

     protected $fillable  =['data','excerpt','peer_tenant_id','peer_branch_id','peer_tenant_info','peer_branch_info'];


    /**
     * Eloquent model.
     *
     * @return \October\Rain\Database\Model
     */
    public function model()
    {
        return new NotificationsModel;
    }

    /**
     * Transformer for the current model.
     *
     * @return \League\Fractal\TransformerAbstract
     */
    protected function transformer()
    {
        return new NotificationsTransformer;
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

         if(!isset($data['key']) || !isset($data['secret'])){

             return $this->errorUnauthorized('access denied ERR-CLI-403');
             return $this->respond(['s'=>'403','m'=>'acess denied']);
        }
        $key = $data['key'];
        $secret = $data['secret'];
        $peer_tenant_id = $data['peer_tenant_id'];

        /**
             1. key is unique acroos single deployment
             2. 1st lookup a client with unique key/business_id  (example: www.ezhealthrack.com / Dr. Vinay)
             3. If not above, lookup a client with unique key
             4. If no client found . throw access denied error
        **/
        $client = Clients::where(['key'=>$key,'secret'=>$secret,'business_id'=>$peer_tenant_id.'')->first();
        
        if(!$client){
           $client = Clients::where(['key'=>$key,'secret'=>$secret])->first();

        }

        if(!$client){
            return $this->errorUnauthorized('access denied ERR-CLI-404');
        }

        if($client->status!='L'){
            return $this->errorUnauthorized('access denied ERR-CLI-400');
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

        $fdata['tenant_id'] = $client->id;




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


}
