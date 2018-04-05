<?php

namespace Olabs\Oimsapi\Http\Controllers;

use Olabs\Oims\Models\Attendance  ;
use Olabs\Oimsapi\Http\Transformers\AttendanceTransformer;
use Autumn\Api\Classes\ApiController;

class Attendances extends ApiController
{
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
}
