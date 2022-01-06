<?php

use App\Http\Controllers\TestController;

$api = app('Dingo\Api\Routing\Router');
//api.throttle 訪問節流
$api->version('v1',['middleware' => 'api.throttle', 'limit' => 60, 'expires' => 1],function($api){
   $api->get('test',[TestController::class,'index']);
$api->post('store',[TestController::class,'store']);
//執行登錄
$api->post('login',[TestController::class,'login']);
//需要登陸的路由
$api->group(['middleware'=>'api.auth'],function($api){
    $api->get('users',[TestController::class,'users']);

});
});
