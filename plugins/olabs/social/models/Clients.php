<?php namespace Olabs\Social\Models;

use Model;
use Db;

/**
 * Model
 */
class Clients extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    /*
     * Validation
     */
    public $rules = [
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_social_clients';



    public function getSampleRecords(){

     $list = Db::table($this->table)
    ->select(Db::raw('count(*) as sms_count, status'))
    ->where('status', '<>', 1)
    ->groupBy('status')
    ->get();

     return $list;


    }


    public function getMonthlyRecords(){


     $list = Db::table('olabs_social_notifications')

    ->select(Db::raw('sum(sms_count) as sms_count, MONTH(created_at) as month, YEAR(created_at) as year'))
    ->where('status', '<>', 1)
    ->where('tenant_id', $this->id)
    //->orderBy("MONTH(created_at)")
        ->groupBy(Db::raw("YEAR(created_at)"),Db::raw("MONTH(created_at)"))
    ->get();

     return $list;

     
    }


}