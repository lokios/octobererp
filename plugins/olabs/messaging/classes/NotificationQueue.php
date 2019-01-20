<?php

namespace Olabs\Messaging\Classes;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class NotificationQueue {

    public function fire($job, $data) {
        //
        $service = new \Olabs\Oims\Models\BaseModel();
        $service->notify($data);

        $job->delete();
    }

}
