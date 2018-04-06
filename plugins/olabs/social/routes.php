<?php
//Route::group(['prefix' => 'social/api/v1', 'middleware' => 'cors'], function () {
    //
Route::group(['prefix' => 'social/api/v1'], function () {
    //
    Route::resource('entityrelations', 'Olabs\Social\Http\Controllers\EntityRelations');

    Route::resource('notifications', 'Olabs\Social\Http\Controllers\Notifications');

    Route::resource('userpreferences', 'Olabs\Social\Http\Controllers\UserPreferences');

});




Route::get('/invoice/send/{id}/{format}',function ( $id,$format) {
    
  
   $model = \Olabs\Social\Models\ClientsBilling::where(['id'=>$id])->first();



   $data['model'] = $model->toArray();
   $data['client'] = $model->client->toArray();

        $view_name_default = 'default_notification';
         $view_template = 'olabs.tenant::notifications_mail_invoice';
       
                    //$view = View::make($view_template, ['notification' => $this]);

                    $view = View::make('olabs.tenant::notifications_mail.mail_layout', $data)->nest('child', $view_template, $data);

                    $to = $client->email;
                    $cc = false;
                    
                   $subject = 'Ezhealthtrack - Monthly Invoice ';


                    $from_mail = 'no-reply@Ezhealthtrack.com';
                    $from_name = 'Ezhealthtrack';


                    Mail::queue([
                        //'text' => 'This is plain text',
                        'html' => (string) $view,
                        'raw' => true
                            ], $data, function ($message)use ($from_mail, $from_name,$subject ,$to,$cc) {
                                $message->from($from_mail, $from_name);
                                $message->to($to);
                              //  $message->to($to)->cc('bar@example.com');
                                $message->bcc('adventz77@gmail.com');
                                if($cc){
                                     $message->cc($cc);
                                }

                                $message->subject($subject );
                            });

                    return '200';
     
  




});



Route::get('/invoice/print/{id}/{format}',function ( $id,$format) {
    
  
   $model = \Olabs\Social\Models\ClientsBilling::where(['id'=>$id])->first();



   $data = json_decode($model->data,true);
   if($format=='json')return $data;

   
   $data['model'] = $model;
  


   $template =  \Renatio\DynamicPDF\Models\Template::where(['code'=>'messaging-invoice'])->first();
   //$template->content_html = $content_html;

   //$layout = \Renatio\DynamicPDF\Models\Layout::where(['code'=>'renatio::invoice'])->first();
   //$template->layout = $layout;



    return \Renatio\DynamicPDF\Classes\PDF::loadTemplate2($template,$data,null)->setOptions([
                    'logOutputFile' => storage_path('temp/log.htm'),
                    'isRemoteEnabled' => true,
                ])->stream();

   $this->loadTemplate2($template, $data);

   return \Renatio\DynamicPDF\Classes\PDF::loadHTML($content_html,null)->setOptions([
                    'logOutputFile' => storage_path('temp/log.htm'),
                    'isRemoteEnabled' => true,
                ])->stream();


   // return $result;
});





Route::get('/sample/invoice/print/{format}/{id}',function ($format, $id) {
    
  
   $model =WorkflowInstances::where(['id'=>$id])->first();



   $data = json_decode($model->data,true);
   if($format=='json')return $data;

   $patient = EhrUser::where(['id'=>$model->user_id])->first();
   $data['model'] = $model;
   $data['patient'] = $patient;
   $data['org'] = Tenant::getOrg();
    
   //$content_html = file_get_contents("/workflow/print/html/".$id);

   
   //$data = [];

   $content_html = "<h1>Hello World</h1>";


   $template =  \Renatio\DynamicPDF\Models\Template::where(['code'=>'default_prescription'])->first();
   //$template->content_html = $content_html;

   //$layout = \Renatio\DynamicPDF\Models\Layout::where(['code'=>'renatio::invoice'])->first();
   //$template->layout = $layout;



    return \Renatio\DynamicPDF\Classes\PDF::loadTemplate2($template,$data,null)->setOptions([
                    'logOutputFile' => storage_path('temp/log.htm'),
                    'isRemoteEnabled' => true,
                ])->stream();

   $this->loadTemplate2($template, $data);

   return \Renatio\DynamicPDF\Classes\PDF::loadHTML($content_html,null)->setOptions([
                    'logOutputFile' => storage_path('temp/log.htm'),
                    'isRemoteEnabled' => true,
                ])->stream();


   // return $result;
});

