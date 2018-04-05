<?php

namespace Olabs\Oimsapi\Http\Transformers;

use Olabs\Oims\Models\Attendance;
use League\Fractal\TransformerAbstract;

class AttendanceTransformer extends TransformerAbstract
{
    /**
     * Turn this item object into a generic array.
     *
     * @param $item
     * @return array
     */
    public function transform(Attendance $item)
    {$val = $item->toArray();

        $val['content_type'] = 'attendance';


        return $val;
        return [
            'id'         => (int)$item->id,
            'created_at' => (string)$item->created_at,
            'updated_at' => (string)$item->updated_at,
        ];
    }
}
