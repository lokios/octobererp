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

        if($this->relation == 'mr_entry' && !$this->status){
            $this->status = 'L';

            $entry = $this->data;
            if(!$entry)return;
            $entry = $entry[0];

             if(!isset($entry['mr_id']) ) return;

                         
                         
                         $this->created_at = date('Y-m-d H:i:s');
                         //$this->created_by = $this->created_by;
                         $this->context_type= 'mr_entry';
                         //$this->relation = $relation;
                         $this->context_id = $entry['mr_id'];
                         $this->data = [$entry];
                         $this->status = 'L';
                         

         }

    }


     public $attachMany = [
        'images' => 'System\Models\File',
        'attachments' => 'System\Models\File',
    ];
    



    public function afterSave(){

        if($this->relation == 'sync' && $this->status =='L'){
               
               if(isset($this->data)){

                  foreach ($this->data as $key => $entry) {
                      # code...
                    $relation = isset($entry['relation'])?$entry['relation']:'attendance';

                    if($relation =='attendance'){
                        if(!isset($entry['check_in']) || !isset($entry['employee_id'])) continue;

                         
                         $cer = new EntityRelations();
                         $cer->created_at = date('Y-m-d H:i:s', strtotime($entry['check_in']) );
                         $cer->actor_id = $this->actor_id;
                         $cer->context_type= 'employee';
                         $cer->relation = 'attendance';
                         $cer->context_id = $entry['employee_id'];
                         $cer->data = [$entry];
                         $cer->status = 'L';
                         $cer->save();

                    }

                    if($relation =='mr_entry'){
                        if(!isset($entry['mr_id']) ) continue;

                         
                         $cer = new EntityRelations();
                         $cer->created_at = date('Y-m-d H:i:s');
                         $cer->actor_id = $this->actor_id;
                         $cer->context_type= 'mr_entry';
                         $cer->relation = $relation;
                         $cer->context_id = $entry['mr_id'];
                         $cer->data = [$entry];
                         $cer->status = 'L';
                         $cer->save();

                    }





                  }



               }

               $this->status = 'O';
               $this->save();
        }
    }
}