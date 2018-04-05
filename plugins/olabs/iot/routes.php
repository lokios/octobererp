<?php

/**
 * API call to save data logger messages
 */

    Route::post('/a/iot-response', function () {
        // save IN to events
        $eventLog = new \System\Models\EventLog();
        $data = array();
        $data["name"] = "IOT API RESPONSE";
        $data["post"] = post();
        $eventLog->message = json_encode($data);
        $eventLog->save();

        $awsMessage = new Olabs\Iot\Models\AwsMessage();
//        if (paypallValidateIPN()) {
            // confirm order
//            $order_id = post("custom");
//            $order = \Olabs\Oims\Models\Order::find($order_id);
//            $order->orderstatus = $order->paymentGateway->orderStatusAfter;
            
//            $awsMessage->create = \Carbon\Carbon::now();
            $awsMessage->request_type = Olabs\Iot\Models\AwsMessage::REQUEST_TYPE_GPRS;
            $awsMessage->meta = json_encode(post());
            $awsMessage->save();
//        }
    });