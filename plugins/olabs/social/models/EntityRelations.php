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

         if($this->target_type == 'sync' && !$this->status){
            $this->status = 'L';

         }

        if($this->target_type == 'mr_entry' && !$this->status){
            $this->status = 'L';

            $entry = $this->data;
            if(!$entry)return;
            $entry = $entry[0];

             if(!isset($entry['mr_id']) ) return;

                         
                         
                         $this->created_at = date('Y-m-d H:i:s');
                         //$this->created_by = $this->created_by;
                         $this->target_type= 'mr_entry';
                         $this->relation = 'created';
                         $this->target_id = $entry['mr_id'];
                         $this->data = [$entry];
                         $this->status = 'L';
                         

         }

    }


     public $attachMany = [
        'images' => 'System\Models\File',
        'attachments' => 'System\Models\File',
    ];
    



    public function afterSave(){

        if($this->target_type == 'sync' && $this->status =='L'){
               
               if(isset($this->data)){

                  foreach ($this->data as $key => $entry) {
                      # code...
                    $target_type = isset($entry['target_type'])?$entry['target_type']:'attendance';

                    if($target_type =='attendance'){
                        if(!isset($entry['check_in']) || !isset($entry['employee_id'])) continue;

                         
                         $cer = new EntityRelations();
                         $cer->created_at = date('Y-m-d H:i:s', strtotime($entry['check_in']) );
                         $cer->actor_id = $this->actor_id;
                         
                         $cer->target_type = 'attendance';

                         $cer->target_id = $entry['employee_id'];
                         $cer->relation = 'created';
                         isset($entry['request_id'])
                         $cer->request_id = $entry['request_id'];

                         
                         $cer->data = [$entry];
                         $cer->status = 'L';
                         $cer->save();

                    }

                    if($target_type =='mr_entry'){
                        if(!isset($entry['mr_id']) ) continue;

                         
                         $cer = new EntityRelations();
                         $cer->created_at = date('Y-m-d H:i:s');
                         $cer->actor_id = $this->actor_id;
                         $cer->target_type= 'mr_entry';
                         $cer->relation = 'created';
                         $cer->target_id = $entry['mr_id'];

                         isset($entry['request_id'])
                         $cer->request_id = $entry['request_id'];
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