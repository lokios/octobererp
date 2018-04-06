<?php

namespace Olabs\Oimsapi\Http\Controllers;

use Olabs\Oims\Models\Employee;
use Olabs\Oimsapi\Http\Transformers\EmployeeTransformer;
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

class Employees extends ApiController
{


     public $search_like_based = ['first_name','last_name'];
     public $search_barcode_based = ['id'];
    /**
     * Eloquent model.
     *
     * @return \October\Rain\Database\Model
     */
    protected function model()
    {
        return new Employee;
    }

    /**
     * Transformer for the current model.
     *
     * @return \League\Fractal\TransformerAbstract
     */
    protected function transformer()
    {
        return new EmployeeTransformer;
    }


      /**
     * Display a listing of the resource.
     * GET /api/{resource}.
     *
     * @return Response
     */
    public function search(Request $request, $org=null,$project_id=false)
    {

        return $this->index($request);

    }
}
