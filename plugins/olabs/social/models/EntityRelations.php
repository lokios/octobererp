<?php namespace Olabs\Social\Models;

use Model;

/**
 * Model
 */
class EntityRelations extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    /*
     * Validation
     */
    public $rules = [
    ];
protected $jsonable = ['data'];
    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_social_entity_relations';

    public function beforeSave(){

         if($this->relation == 'sync' && !$this->status){
            $this->status = 'L';

         }

    }



    public function afterSave(){

        if($this->relation == 'sync' && $this->status =='L'){
               
               if(isset($this->data['data'])){

                  foreach ($this->data['data'] as $key => $value) {
                      # code...

                    if(!isset($value['check_in']) || !isset($value['employee_id'])) continue;

                     $entry = $value;
                     $cer = new EntityRelations();
                     $cer->created_at = date('Y-m-d H:i:s', strtotime($entry['check_in']) );
                     $cer->context_type= 'employee';
                     $cer->relation = 'attendance';
                     $cer->context_id = $entry['employee_id'];
                     $cer->data = [$entry];
                     $cer->save();

                  }

               }

               $this->status = 'O';
               $this->save();
        }
    }
}