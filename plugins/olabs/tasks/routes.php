<?php
/**
 * Created by PhpStorm.
 * User: Lokendra
 * Date: 10/24/16
 * Time: 4:23 PM
 */

//require __DIR__.'/vendor/autoload.php';
//use Mail;
use Olabs\Tasks\Models\Tasks;
Route::get('m/test', function() {
$param = [];
   Mail::send([
    'text' => 'This is plain text',
    'html' => '<strong>This is HTML</strong>',
    'raw' => true
], $param,function($message) {
$message->subject('MR report updates');
            $message->from('lokendra@lsasoftware.com', 'October');
           $message->to('adventz77@gmail.com')->cc('anutech17@gmail.com');
//           $message->to('adventz77@gmail.com');
//           $message->attach("https://octobercms.com/themes/website/assets/images/october-color-logo.svg",  []);

           //http://oims.opaclabs.com/reportico/execute/inventory/mr_register?&target_format=PDF
        $message->attach("http://oims.opaclabs.com/reportico/execute/inventory/mr_register?&target_format=PDF",  ['as' => 'MR Report', 'mime' => 'application/pdf']);



           /**

           $message->from($address, $name = null);
$message->sender($address, $name = null);
$message->to($address, $name = null);
$message->cc($address, $name = null);
$message->bcc($address, $name = null);
$message->replyTo($address, $name = null);
$message->subject($subject);
$message->priority($level);
$message->attach($pathToFile, array $options = []);

// Attach a file from a raw $data string...
$message->attachData($data, $name, array $options = []);

**/

});

   return ['s'=>'200'];
});


Route::get('m/schedule', function() {

        $tasks = Tasks::where([])->get();
        foreach ($tasks as $key => $task) {
           //$schedule->call(function ()use ($task) {
           
                $task->run();

         // })->$task->schedule();


        }

         return ['s'=>'200'];
});