<?php

namespace Olabs\Social\Models;

use Model;
use Olabs\App\Classes\App;
use Olabs\Oims\Models\Attendance;
/**
 * Model
 */
class EntityRelations extends Model {

    use \October\Rain\Database\Traits\Validation;

    /*
     * Validation
     */

    const TARGET_TYPE_MR_ENTRY = 'mr_entry';
    const TARGET_TYPE_ATTENDANCE = 'attendance';
    const STATUS_LIVE = 'L';
    const STATUS_DONE = 'O';

    public $rules = [
    ];
    protected $jsonable = ['data'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_social_entity_relations';

    public function beforeSave() {

        $app = App::getInstance();
        $this->actor_id = $app->getAppUserId();
        if ($this->target_type == 'sync' && !$this->status) {
            $this->status = 'L';
        }

        if ($this->target_type == 'mr_entry' && !$this->status) {
            $this->status = 'L';

            $entry = $this->data;
            if (!$entry)
                return;
            $entry = $entry[0];

            if (!isset($entry['mr_id']))
                return;



            $this->created_at = date('Y-m-d H:i:s');
            //$this->created_by = $this->created_by;
            $this->target_type = 'mr_entry';
            $this->relation = 'created';
            $this->target_id = $entry['mr_id'];
            if (isset($entry['data'])) {
                unset($entry['data']);
            }

            $this->data = [$entry];
            $this->status = 'L';
        }

        if ($this->target_type == 'attendance' && !$this->status) {
            $this->status = 'L';

            $entry = $this->data;
            if (!$entry)
                return;
            $entry = $entry[0];

            if (!isset($entry['employee_id']))
                return;



            //$this->created_at = date('Y-m-d H:i:s');
            $this->created_at = date('Y-m-d H:i:s', strtotime($entry['check_in']));
            //$this->created_by = $this->created_by;
            $this->target_type = 'attendance';
            $this->relation = 'created';
            $this->target_id = $entry['employee_id'];
            if (isset($entry['data'])) {
                unset($entry['data']);
            }

            $this->data = [$entry];
            $this->status = 'L';
        }
    }

    public $attachMany = [
        'images' => 'System\Models\File',
        'attachments' => 'System\Models\File',
    ];

    public function afterSave() {

        if ($this->target_type == 'sync' && $this->status == 'L') {

            if (isset($this->data)) {

                foreach ($this->data as $key => $entry) {
                    # code...
                    $target_type = isset($entry['target_type']) ? $entry['target_type'] : 'attendance';

                    if ($target_type == 'attendance') {
                        if (!isset($entry['check_in']) || !isset($entry['employee_id']))
                            continue;


                        $cer = new EntityRelations();
                        $cer->created_at = date('Y-m-d H:i:s', strtotime($entry['check_in']));
                        $cer->actor_id = $this->actor_id;

                        $cer->target_type = 'attendance';

                        $cer->target_id = $entry['employee_id'];
                        $cer->relation = 'created';
                        if (isset($entry['request_id']))
                            $cer->request_id = $entry['request_id'];


                        if (isset($entry['data'])) {
                            unset($entry['data']);
                        }


                        $cer->data = [$entry];
                        $cer->status = 'L';
                        $cer->save();
                    }

                    if ($target_type == 'mr_entry') {
                        if (!isset($entry['mr_id']))
                            continue;


                        $cer = new EntityRelations();
                        $cer->created_at = date('Y-m-d H:i:s');
                        $cer->actor_id = $this->actor_id;
                        $cer->target_type = 'mr_entry';
                        $cer->relation = 'created';
                        $cer->target_id = $entry['mr_id'];

                        if (isset($entry['request_id']))
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
        //Sync all data :
       // $this->SyncData();
    }

    //Sync all entity relation data with respective models : attendance, mr_entry
    public function SyncData() {

        $records = EntityRelations::whereIn('target_type', array(self::TARGET_TYPE_ATTENDANCE, self::TARGET_TYPE_MR_ENTRY))
                        ->where('status', self::STATUS_LIVE)->get();

        foreach ($records as $record) {
            if ($record->target_type == self::TARGET_TYPE_ATTENDANCE) {

                if (isset($record->data)) {

                    foreach ($record->data as $key => $entry) {
//                        var_dump($entry);
                        //Create attendace entry
                        $employee_id = $entry['employee_id'];
                        $employee_id = (int)substr($employee_id, 1); //First character is O or E
                        $employee_type = $entry['employee_type'];
                        $check_in = date('Y-m-d H:i:s', strtotime($entry['check_in']));
                        $from_date = date('Y-m-d',strtotime($check_in)) . " 00:00:00";
                        $to_date = date('Y-m-d',strtotime($check_in)) . " 23:59:59";
                        $attendace = \Olabs\Oims\Models\Attendance::where('employee_id', $employee_id)
                                ->where('employee_type', $employee_type)
                                ->whereBetween('check_in', [$from_date, $to_date])
                                ->first();
                        
                        if (!$attendace) {
                            $attendace = new \Olabs\Oims\Models\Attendance();
                            if($employee_type == Attendance::EMPLOYEE_TYPE_OFFROLE){
                                $attendace->employee_offrole = \Olabs\Oims\Models\OffroleEmployee::find($employee_id);
//                                $attendace->employee_id = $employee_id;
                            }
                            if($employee_type == Attendance::EMPLOYEE_TYPE_ONROLE){
                                $attendace->employee_onrole = $employee_id;//\Olabs\Oims\Models\Employee::find($employee_id);
                                $attendace->employee_id = $employee_id;
                                $attendace->employee_offrole = FALSE;
                            }
                            $attendace->employee_type = $employee_type;
                            $attendace->check_in = $check_in;
                            $attendace->created_by = $entry['created_by'];
                            $attendace->created_at = date('Y-m-d H:i:s');
                        }
                        
//                        dd($attendace->employee_onrole);

                        $attendace->check_out = $check_in;
                        $attendace->updated_by = $entry['created_by'];
                        $attendace->updated_at = date('Y-m-d H:i:s');
                        
                        $attendace->execute_validation = false;
                        
                        $attendace->calculateWages();
                        $attendace->save();
                    }
                }
            }
            if ($record->target_type == self::TARGET_TYPE_MR_ENTRY) {
                //Create mr entry
            }

            $record->status = self::STATUS_DONE;
            $record->save();
        }
    }

}
