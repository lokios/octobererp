<?php


namespace Olabs\App\Http\Controllers;


use Olabs\App\Http\Transformers\BackendUserTransformer;
use Autumn\Api\Classes\ApiController;
use Illuminate\Http\Request;
//use Olabs\Tenant\Models\BaseModel;
use Db;
use Olabs\App\Classes\App;

use BackendAuth;
use Backend\Models\User as BackendUser;

class Profiles extends ApiController
{
     public $fillable = ['email','first_name','last_name','contact_phone'];

     public $search_like_based = ['first_name','last_name'];
     public $images_field = 'images';
     public $orderBy = 'created_at';
     public $orderByOrder = 'desc';

     protected $defaultLimit = 50;
     protected $maximumLimit = 50;
    /**
     * Eloquent model.
     *
     * @return \October\Rain\Database\Model
     */
    protected function model()
    {
        return new BackendUser;
    }

    /**
     * Transformer for the current model.
     *
     * @return \League\Fractal\TransformerAbstract
     */
    protected function transformer()
    {
        return new BackendUserTransformer;
    }


     public function upload(Request $request) {

        //BaseModel::$feature_enabled = false;
        $id = $request->input('id', false);
        $files = $request->file('images');


        $item = $this->findItem($id);
        if (!$item) {
            return $this->errorNotFound();
        }

        $count = 0;

        if (!empty($files)) {

            //return $this->respond(['s'=>'echo', 'files'=>count($files)]);

            foreach ($files as $file1) {

                $file = new \System\Models\File();
                $file->data = $file1;
                $file->is_public = true;
                $file->save();

                $item->avatar = $file;
                $count++;
            }
        }
        
        //Amit : 30/04/2018 => to resync uploaded image with actual models
        //$item->status = 'L';
        $item->save();
        //    return $this->respond(['s'=>'echo', 'files'=>$count]);

        //BaseModel::$feature_enabled = true;

        return $this->respondWithItem($item);
    }




}