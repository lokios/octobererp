<?php
/**
 * Created by PhpStorm.
 * User: Lokendra
 * Date: 10/15/16
 * Time: 6:46 PM
 */



Route::any('a/push/register', function () {
    $r = Input::all();
    $o = Olabs\Pusher\Models\Platforms::register($r);

    return $o;
});




Route::any('a/push/test', function () {
    $r = Input::all();
    $o = Olabs\Pusher\Models\Platforms::test($r);

    return $o;
});