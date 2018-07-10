<?php

namespace Olabs\Social\Http\Controllers;

use Olabs\Social\Models\EntityRelations as EntityRelationsModel;
use Olabs\Social\Http\Transformers\EntityRelationsTransformer;
use Autumn\Api\Classes\ApiController;
use Olabs\Tenant\Models\BaseModel;


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
use Carbon\Carbon;
use Olabs\App\Classes\App;
use OlabsAuth;


class EntityRelations extends ApiController {

    protected $defaultLimit = 10;
    protected $fillable = ['data', 'actor_id', "data", "target_type", "target_id", "relation", "request_id"];
    protected $fillable2 = ['actor_id'];
    public $images_field = 'images';

    public $after_create_event = true;
    public $after_upload_event = true;

    /**
     * Eloquent model.
     *
     * @return \October\Rain\Database\Model
     */
    protected function model() {
        return new EntityRelationsModel;
    }

    /**
     * Transformer for the current model.
     *
     * @return \League\Fractal\TransformerAbstract
     */
    protected function transformer() {
        return new EntityRelationsTransformer;
    }

    public function getExtraConditions($action, Request $request, &$criteria) {
        $this->scopeEquals($criteria, 'target_type');
        $this->scopeEquals($criteria, 'actor_id');
        $this->scopeEquals($criteria, 'status');
    }

    public function createAction($fdata) {
        $item = false;
        if (isset($fdata['request_id'])) {

            $item = $this->model->where(['request_id' => $fdata['request_id']])->first();

            if ($item) {
                //duplicate request -- so simply update this item object
                //return $item;
            }
        }


        if (!$item) {

            $item = $this->model->create($fdata);
           $item->SyncDataRecord($item);
        }

        if ($item) {

           // $m = new EntityRelationsModel();
           // $m->id = $item->id;
           // return $m;
        }

        return $item;
    }


    public function upload(Request $request) {

        BaseModel::$feature_enabled = false;
        $id = $request->input('id', false);
        $files = $request->file('images');


        $item = $this->findItem($id);
        if (!$item) {
            return $this->errorNotFound();
        }

        $count = 0;

        $existing_files =  $item->{$this->images_field};

        if (!empty($files)) {

            //return $this->respond(['s'=>'echo', 'files'=>count($files)]);

            foreach ($files as $file1) {

                $file = new \System\Models\File();
                $file->data = $file1;
                $file->is_public = true;
                $alreadyExists = false;

                $name = $file->getFilename();

                if( $name && $existing_files ){
                    foreach ($existing_files as $ekey => $efile) {
                        # code...
                        if($efile->name ==  $file->getFilename()){
                            $alreadyExists = true;

                        }
                    }
                }

                if(!$alreadyExists){
                    $file->save();

                    $item->{$this->images_field}()->add($file);
                    $count++;
                }
            }
        }
        
        //Amit : 30/04/2018 => to resync uploaded image with actual models
        //$item->status = 'L';
        //$item->save();

        $item->SyncDataRecord($item);
        //    return $this->respond(['s'=>'echo', 'files'=>$count]);

        BaseModel::$feature_enabled = true;

        return $this->respondWithItem($item);
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

        if(isset($fdata['relation'])){
            $relation = $fdata['relation'];
            if($relation == 'like'||$relation='follow'){
                $er = EntityRelationsModel::where(['actor_id'=>$fdata['actor_id']
                       ,'target_type'=>$fdata['target_type']
                       ,'target_id'=>$fdata['target_id']
                        ,'relation'=>$fdata['relation']
                    ])->first();

                if($er){
                    if($er->status =='L'){
                        $er->status = 'O';
                    }else{
                         $er->status = 'L';
                    }

                    $er->save();

                   return $this->respondWithItem($er);
                }
            }
        }

        $fdata['status'] = 'L';

        $item = $this->createAction($fdata);

      /*  if(isset($data['images'])){
            foreach ($data['images'] as $key => $value) {

               $idata = base64_decode($value['data']);
               
               $file = $this->fromData($idata, 'photo_'.$key);
               $file->is_public = true;
               $file->save();

               $item->{$this->images_field}()->add($file);
            }
        }*/

         BaseModel::$feature_enabled = true;

        return $this->respondWithItem($item);
    }

    
//    public function upload(Request $request) {
//        
//        $id = $request->input('id', false);
//        $item = $this->findItem($id);
//        if (!$item) {
//            return $this->errorNotFound();
//        }
//        $item->status = 'L1';
//        $item->save();
//        
//        parent::upload($request);
//        
//        
//        
//    }

}
