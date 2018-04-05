<?php

namespace Olabs\Oimsapi\Http\Transformers;

use Olabs\Oims\Models\Supplier;
use League\Fractal\TransformerAbstract;
use Olabs\App\Classes\App;
class SupplierTransformer extends TransformerAbstract
{

    public  function getProps(){

        return ['content_type'=>'supplier','uiview_detail'=>'group'];

    } 
    /**
     * Turn this item object into a generic array.
     *
     * @param $item
     * @return array
     */
    public function transform(Supplier $item)
    {
        $app = App::getInstance();
        $base = $app->getBaseEndpoint();
        $val = $item->toArray();
        $val['content_type'] = 'user';
         // $val['uiview_detail'] = 'group';


        $val['name'] = [$val['first_name'],$val['last_name']];//,'uid'.$app->getAppUserId(),'perm'.$app->hasPermission($org,'manage_his')];
        $val['name']  =  implode(" ", $val['name']);
        $addr = [];
        if(isset($val['contact_email'])){
            $val['email'] = $val['contact_email'];
        } 

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
         foreach ($val as $key => $value) {
          # code...
          if(!$value ||  $value==''){
              unset($val[$key]);
          }
        }


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
