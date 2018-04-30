<?php namespace Olabs\Social\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Db;
use  Olabs\Social\Models\Clients;
use  Olabs\Social\Models\ClientsBilling as ClientsBillingModel;

class ClientsBilling extends Controller
{
    public $implement = ['Backend\Behaviors\ListController','Backend\Behaviors\FormController'];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Olabs.Social', 'messaging', 'clientsbilling');
    }



    public function invoice($id,  $year=null, $month = null){

          BackendMenu::setContext('Olabs.Social', 'main-menu-item');
          $this->pageTitle =  'Client Reports';

          $client = Clients::where(['id'=>$id])->first();

          if(!$year){
            //means last billable month. i.e. previous month
            $year = date('Y', strtotime('first day of last month'));
            $month = date('m', strtotime('first day of last month'));

          }

          if($year == 'current'){
            //means last billable month. i.e. previous month
            $year = date('Y');
            $month = date('m');

          }



          $list = Db::table('olabs_social_notifications')

    ->select(Db::raw('sum(sms_count) as sms_count '))
    ->where('status', '<>', 1)
    ->where('tenant_id', $client->id)
    ->whereRaw('MONTH(created_at) = ?', [$month])
    ->whereRaw('YEAR(created_at) = ?', [$year])
    
    //->orderBy("MONTH(created_at)")
       // ->groupBy(Db::raw("YEAR(created_at)"),Db::raw("MONTH(created_at)"))
    ->get();


         $monthyear = $year."-".$month."-01";
         $model = ClientsBillingModel::where(['clients_id'=>$client->id , 'month'=>$monthyear])->first();
         if(!$model){

         $model = new ClientsBillingModel();
          }
         $model->client = $client;
         $model->month = $monthyear;
         $model->sms_count = 0;
         $model->sms_total = 0;
         foreach ($list as $key => $value) {
         	# code...
         	$model->sms_count += $value->sms_count;
         }

         $model->sms_total =  $model->sms_count * $client->sms_rate;
         $model->total_amout = $model->sms_total;
         $model->net_amount = $model->total_amout;

         $model->save();

          if ($redirect = $this->makeRedirect('update-close', $model)) {
            return $redirect;
        }


          $this->vars['client'] = $client;

    }

}