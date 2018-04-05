<?php namespace Olabs\Tasks\Models;

use Model;
use Olabs\Tasks\Models\TaskLogs;
use Mail;

/**
 * Model
 */
class Tasks extends Model
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
    public $table = 'olabs_tasks_tasks';



    public function run(){
           $t = new TaskLogs();
           $t->name = $this->name;
           $t->log = 'type: '.$this->type.' schedule:'.$this->schedule;
           $t->save();

           switch ($this->type) {
               case 'email':
                   $this->run_email();
                   break;
               
               default:
                   # code...
                   break;
           }

    }

    public function run_email(){

$task = $this;
$param = [];
   Mail::send([
    'text' => $this->email_subject,
    'html' => $this->email_body,
    'raw' => true
], $param,function($message) use($task) {
$message->subject($task->email_subject);
            $message->from($task->email_from);

            if($task->email_to){
              $to = explode(",", $task->email_to);
              foreach ($to as $key => $to_item) {
                   $message->to($to_item);
               }
           }

           if($task->email_cc){
              $to = explode(",", $task->email_cc);
              foreach ($to as $key => $to_item) {
                   $message->cc($to_item);
               }
           }

           if($task->email_bcc){
              $to = explode(",", $task->email_bcc);
              foreach ($to as $key => $to_item) {
                   $message->bcc($to_item);
               }
           }

           if($task->attachment_input1){
              $message->attach($task->attachment_input1,  ['as' => $task->attachment_input1_name?$task->attachment_input1_name:'Attachment 1', 'mime' => 'application/pdf']);
           }


          if($task->attachment_input2){
              $message->attach($task->attachment_input2,  ['as' => $task->attachment_input2_name?$task->attachment_input2_name:'Attachment 2', 'mime' => 'application/pdf']);
           }

           if($task->attachment_input3){
              $message->attach($task->attachment_input3,  ['as' => $task->attachment_input3_name?$task->attachment_input3_name:'Attachment 3']);
           }

          if($task->attachment_input4){
              $message->attach($task->attachment_input4,  ['as' => $task->attachment_input4_name?$task->attachment_input4_name:'Attachment 4']);
           }


          // $message->attach("https://octobercms.com/themes/website/assets/images/october-color-logo.svg",  []);

});

    }
}