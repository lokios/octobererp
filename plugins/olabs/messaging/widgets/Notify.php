<?php

//namespace Backend\Widgets;

namespace Olabs\Messaging\Widgets;

use Backend\Classes\WidgetBase;
use BackendAuth;
use System\Helpers\DateTime;

class Notify extends WidgetBase {

    /**
     * @var string A unique alias to identify this widget.
     */
    protected $defaultAlias = 'notify';

    // ...

    public function onPoll() {
        $data = [];
        $user = BackendAuth::getUser();

        $params = [
//            'web_push_status' => 'read',
        ];
        
        $data['count_unread'] = \Olabs\Social\Models\Notifications::getNotificationCount($params);
        
        $model_notifications = \Olabs\Social\Models\Notifications::getNotifications($params);
        
        $notifications = [];
        
        foreach($model_notifications as $model){
            $json_data = $model->data;
            $title = '';
            $message = '';
            foreach($json_data as $v){
                if($v['type'] == 'web_push'){
                    $title = $v['title'];
                    $message = $v['message'];
                }
            }
            $temp['id'] = $model->id;
            $temp['s'] = $model->web_push_status;
            $temp['t'] = $title;
            $temp['m'] = $message;
            $temp['at'] = DateTime::timeTense($model->created_at);
            
            $notifications[] = $temp;
        }
        
        $data['data'] = $notifications;
        

        return $data;
    }
    
    
    public function onNotificationRead(){
        $id = request('id');
        
        if(!$id){
            $id = request('all');
        }
        
        if($id == ''){
            return false;
        }
        
        $params = [
            'id' => $id,
        ];
        
        $status = \Olabs\Social\Models\Notifications::setNotificationStatus($params);
        
        return $status;
//        if($all == 'all'){
//            //Mark read all message
//        }
//        
//        if($id){
//            //Mark notification read
//            $model = \Olabs\Social\Models\Notifications::where('id', $id);
//            $model->web_push_status = 'read';
//            $model->save();
//        }
        
    }

}
