<?php


namespace Olabs\App\Http\Controllers;

use Olabs\App\Models\Event;
use Olabs\App\Http\Transformers\EventTransformer;
use Autumn\Api\Classes\ApiController;
use Illuminate\Http\Request;
//use Olabs\Tenant\Models\BaseModel;
use Db;
use Olabs\App\Classes\App;

use BackendAuth;
class Events extends ApiController
{


     protected $defaultLimit = 50;
     protected $maximumLimit = 50;
    /**
     * Eloquent model.
     *
     * @return \October\Rain\Database\Model
     */
    protected function model()
    {
        return new Event;
    }

    /**
     * Transformer for the current model.
     *
     * @return \League\Fractal\TransformerAbstract
     */
    protected function transformer()
    {
        return new EventTransformer;
    }



}