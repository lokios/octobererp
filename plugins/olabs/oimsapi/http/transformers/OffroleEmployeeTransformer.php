<?php

namespace Olabs\Oimsapi\Http\Transformers;

use Olabs\Oims\Models\OffroleEmployee;
use League\Fractal\TransformerAbstract;
use Olabs\App\Classes\App;
class OffroleEmployeeTransformer extends TransformerAbstract
{
    /**
     * Turn this item object into a generic array.
     *
     * @param $item
     * @return array
     */
    public function transform(OffroleEmployee $item)
    {$app = App::getInstance();
        $base = $app->getBaseEndpoint();
        $val = $item->toArray();
$val['content_type'] = 'user';


        //$val['name'] = [$val['first_name'],$val['last_name']];//,'uid'.$app->getAppUserId(),'perm'.$app->hasPermission($org,'manage_his')];
       // $val['name']  =  implode(" ", $val['name']);
         $addr = [];
          if(isset($val['contact_email']) && $val['contact_email']){
            $val['email'] = $val['contact_email'];
        }

         if(isset($val['contact_phone']) && $val['contact_phone']){
            $val['phone_1'] = $val['contact_phone'];
        }

         if(isset($val['address'])){
            $addr[] = $val['address'];
         }
         if(isset($val['address_2'])){
            $addr[] = $val['address_2'];
         }
         if(isset($val['city'])){
            $addr[] = $val['city'];
         }
         if(isset($val['state'])){
            $addr[] = $val['state'];
         }
         if(isset($val['country'])){
            $addr[] = $val['country'];
         }

         $val['address_fmt'] = implode(", ", $addr); 
        if(!$val['address_fmt'] )unset($val['address_fmt'] );
         $overview = [];
         $attributes  = [];

          if($item->employee_type){
            $overview[] =  'Employee type - '.$item->employee_type;
            $attributes[] =['name'=>'Employee type','value'=>$item->employee_type];

         }
         if($item->project){
            $overview[] =  'Project - '.$item->project->name;
            $attributes[] =['name'=>'Project','value'=>$item->project->name];

         }

         if($item->project){
            //$overview[] =  'Project - '.$item->project->name;
            $attributes[] =['name'=>'Project','value'=>$item->project->name];

         }

         if($item->supplier){
           // $overview[] =  'Supplier - '.$item->supplier->first_name.' '.$item->supplier->last_name;
            $attributes[] =['name'=>'Supplier','value'=>$item->supplier->name];

         }
         if($item->daily_wages){
            //$overview[] =  'Daily Wages - '.$item->daily_wages;
            $attributes[] =['name'=>'Daily Wages','value'=>$item->daily_wages];

         }

          if($item->pan){
            //$overview[] =  'PAN - '.$item->pan;
            $attributes[] =['name'=>'PAN','value'=>$item->pan];

         }

         if($item->aadhaar_number){
           // $overview[] =  'Aadhaar Number - '.$item->aadhaar_number;
            $attributes[] =['name'=>'Aadhaar Number','value'=>$item->aadhaar_number];

         }
         

         $val['attributes'] = $attributes;
         $val['overview'] = implode(", ", $overview);




        
        $img = false;
        $val['bg_image'] = $img?$img:$app->getBaseEndpointImages().'/themes/octobererp_theme1/assets/images/construction/default_bg_image.jpg';
        $val['main_image'] = $img?$img:$app->getBaseEndpointImages().'/themes/octobererp_theme1/assets/images/construction/default_about.jpg';



        return $val;
        return [
            'id'         => (int)$item->id,
            'created_at' => (string)$item->created_at,
            'updated_at' => (string)$item->updated_at,
        ];
    }
}
