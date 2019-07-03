<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$api = app('Dingo\Api\Routing\Router');
$api->version('v1', function ($api) {
    $api->group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\admin'], function ($api) {
    $api->any('login','indexController@login');
    $api->any('complaintapi','complaintController@complaintapi');//提交投诉
    $api->any('questionAllData','questionController@questionAllData');//问题详情
    $api->any('idgetquestion','questionController@idgetquestion');//常见问题
    $api->any('configapi','configController@configapi');//配置
    $api->any('headlines','headlinesController@headlines');//全部头条
    $api->any('idheadlines','headlinesController@idheadlines');//全部头条
    $api->any('notice','noticeController@notice');//全部通知
    $api->any('banner','bannerController@banner');//banner图
    $api->any('orderadd','orderController@orderadd');//添加订单
    $api->any('payorder','orderController@payorder');//支付订单
    $api->any('paytemplate','orderController@paytemplate');//模板消息
    $api->any('payorderapi','orderController@payorderapi');//全部订单
    $api->any('paymentorder','orderController@paymentorder');//支付订单
    });
});

