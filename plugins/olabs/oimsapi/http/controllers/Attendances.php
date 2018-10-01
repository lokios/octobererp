<?php

namespace Olabs\Oimsapi\Http\Controllers;

use Olabs\Oims\Models\Attendance  ;
use Olabs\Oimsapi\Http\Transformers\AttendanceTransformer;
use Autumn\Api\Classes\ApiController;
use Illuminate\Http\Request;
class Attendances extends ApiController
{

     public $fillable = ['employee_id','project_id','total_working_hour','employee_type','check_out','check_in'];

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
        return new Attendance;
    }

    /**
     * Transformer for the current model.
     *
     * @return \League\Fractal\TransformerAbstract
     */
    protected function transformer()
    {
        return new AttendanceTransformer;
    }

    public function getExtraConditions($action, Request $request , &$criteria ){
           $this->scopeEquals($criteria,'employee_type');
           $this->scopeEquals($criteria,'employee_id');

    }
}
