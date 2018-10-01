<?php

namespace Olabs\App\Http\Controllers;


use Olabs\Insurance\Http\Transformers\EventTransformer;
use Autumn\Api\Classes\ApiController;
use Illuminate\Http\Request;
//use Olabs\Tenant\Models\BaseModel;
use Db;
use Olabs\App\Classes\App;

use BackendAuth;

use League\Fractal\Manager;
class Contents extends ApiController
{


     protected $defaultLimit = 50;
     protected $maximumLimit = 50;



     public function setSettings(){

       $this->_setSettings();

       // $this->app = $app;
        $this->model = $this->model();
        $this->transformer = $this->transformer();

        $this->fractal = new Manager();
        $this->fractal->setSerializer($this->serializer());

        if($this->transformer){
          if ($includes = $this->transformer->getAvailableIncludes()) {
            $this->fractal->parseIncludes($includes);
          }
        }
     }

     public function _setSettings(){
         $this->settings = false;
         $type =  $this->content_type;//$this->request->input('content_type', false);

        switch($type){

            case 'voucher':{

               $this->settings = [
                 'model'=>new \Olabs\App\Models\Event,
                 'transformer'=>new \Olabs\App\Http\Transformers\EventTransformer,
                 

               ];
                 $this->fillable = ['name','headline','description'];

               break;
            }

             case 'events':{

               $this->settings = [
                 'model'=>new \Olabs\App\Models\Event,
                 'transformer'=>new \Olabs\App\Http\Transformers\EventTransformer,
                 

               ];
                 $this->fillable = ['name','headline','description'];

               break;
            }

            case 'profiles':{

               $this->settings = [
                 'model'=>new \Backend\Models\User,
                 'transformer'=>new \Olabs\App\Http\Transformers\BackendUserTransformer,
                // 'fillable'=> ['email','first_name','last_name','contact_phone'],

               ];

               $this->fillable = ['email','first_name','last_name','contact_phone'];


               break;
            }
        }

        return  $this->settings;
     }


    /**
     * Eloquent model.
     *
     * @return \October\Rain\Database\Model
     */
    protected function model()
    {
        //$settings = $this->getSettings();
        return $this->settings['model'];

       // return new Event;
    }

    /**
     * Transformer for the current model.
     *
     * @return \League\Fractal\TransformerAbstract
     */
    protected function transformer()
    {
        //$settings = $this->getSettings();
        return $this->settings['transformer'];
        
       // return new EventTransformer;
    }

     public $content_type;
     public $settings;

    public function indexByContentType(Request $request, $content_type ) {
        $this->content_type = $content_type;
        $this->setSettings();

        return $this->index($request);
  }

    public function storeByContentType(Request $request, $content_type ) {
        $this->content_type = $content_type;
        $this->setSettings();

        return $this->store($request);
  }
   public function updateByContentType(Request $request, $content_type ) {
        $this->content_type = $content_type;
        $this->setSettings();

        return $this->update($request);
  }

   public function uploadByContentType(Request $request, $content_type ) {
        $this->content_type = $content_type;
        $this->setSettings();

        return $this->upload($request);
  }



}