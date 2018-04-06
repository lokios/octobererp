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
    {


        $val = $item->toArray();

        $val['name'] = [];
        if($item->project){
             $val['name'][] = $item->project->name;
        }
        if($item->employee_offrole){
             $val['name'][] = $item->employee_offrole->name;

             if($item->employee_offrole)
             $val['subtitle'] = $item->total_working_hour;
             $val['name']  =  implode(" - ", $val['name']);
        }else{

           if($item->employee_id){
            $emp =  \Olabs\Oims\Models\Employee::where(['id'=>$item->employee_id])->first();
            if($emp){
                $val['name'] = [$emp->first_name,$emp->last_name];//,'uid'.$app->getAppUserId(),'perm'.$app->hasPermission($org,'manage_his')];
                 $val['name']  =  implode(" ", $val['name']);
            }
        }


        }
        $val['subtitle'] = ['Hrs: '.$item->total_working_hour,''.$item->check_in.' - '.$item->check_out ,] ;

        $val['subtitle']  =  implode(" | ", $val['subtitle']);


        $val['content_type'] = 'attendance';
         $val['uiview_detail'] = 'group';


          $attributes  = [];
         $attributes[] =['name'=>'Total Working Hour','value'=>$item->total_working_hour];
          $attributes[] =['name'=>'Working Hour','value'=>$item->working_hour];
          $attributes[] =['name'=>'Overtime','value'=>$item->overtime];
          $attributes[] =['name'=>'Total Wages','value'=>$item->total_wages];
          
          $attributes[] =['name'=>'Check in','value'=>date('Y-m-d H:i', strtotime($item->check_in))];
           $attributes[] =['name'=>'Check out','value'=>date('Y-m-d H:i', strtotime($item->check_out))];
         $val['attributes'] = $attributes;
        


        return $val;
        return [
            'id'         => (int)$item->id,
            'created_at' => (string)$item->created_at,
            'updated_at' => (string)$item->updated_at,
        ];
    }
}
