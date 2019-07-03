<?php
/**
 * 'middleware'=>'checkAdmin' //中间件
 */
Route::group(['namespace'=>'admin','middleware'=>'checkAdmin'],function(){
    /**
     * 首页
     */
    Route::any('admin','indexController@index');
    /**
     * 退出登录
     */
    Route::any('loginout',"loginController@loginout");
    /**
     * 管理员
     */
    Route::any('admin/administrators','adminController@index');
    Route::any('administrators/lists','adminController@lists');
    Route::any('administrators/insert','adminController@insert');
    Route::any('administrators/edit/{id}','adminController@edit');
    Route::any('administrators/delete/{id}','adminController@del');
    /**
     * 用户
     */
    Route::any('admin/user','userController@index');
    Route::any('user/lists','userController@lists');
    /**
     * 模板消息
     */
    Route::any('admin/template','templateController@index');
    Route::any('template/lists','templateController@lists');
    Route::any('template/add','templateController@add');
    Route::any('template/edit/{id}','templateController@edit');
    Route::any('template/delete/{id}','templateController@delete');
    /**
     * 通知
     */
    Route::any('admin/notice','noticeController@index');
    Route::any('notice/lists','noticeController@lists');
    Route::any('notice/add','noticeController@add');
    Route::any('notice/edit/{id}','noticeController@edit');
    Route::any('notice/delete/{id}','noticeController@delete');

    /**
     * banner图
     */
    Route::any('admin/banner','bannerController@index');
    Route::any('banner/insert','bannerController@insert');
    /**
     * 投诉
     */
    Route::any('admin/complaint','complaintController@index');
    Route::any('complaint/lists','complaintController@lists');
    /**
     * 常见问题
     */
    Route::any('admin/question','questionController@question');
    Route::any('question/lists',"questionController@questionLists");
    Route::any('question/insert',"questionController@questionInsert");
    Route::any('question/delete/{id}',"questionController@questionDel");
    Route::any('question/edit/{id}',"questionController@questionEdit");
    /**
     * 车主头条
     */
    Route::any('admin/headlines','headlinesController@index');
    Route::any('headlines/lists',"headlinesController@lists");
    Route::any('headlines/add',"headlinesController@add");
    Route::any('headlines/edit/{id}',"headlinesController@edit");
    Route::any('headlines/delete/{id}',"headlinesController@delete");
    /**
     * 订单
     */
    Route::any('admin/order','orderController@index');
    Route::any('admin/pay','orderController@pay');
    Route::any('admin/unpaid','orderController@unpaid');
    Route::any('admin/complete','orderController@complete');
    Route::any('admin/fail','orderController@fail');
    Route::any('order/lists','orderController@lists');
    Route::any('order/list/{type}','orderController@list');
    Route::any('order/edit/{id}','orderController@edit');
    Route::any('admin/reason','orderController@reason');
    Route::any('order/titleedit/{id}','orderController@titleedit');
    Route::any('order/refund/{id}','orderController@refund');

    Route::any('order/userorder','userController@userorder');
    Route::any('userorder/list/{openid}','userController@orderlist');
    Route::any('order/turnfail/{id}','orderController@turnfail');

    /**
     * 统计
     */

     Route::any('admin/census','userController@census');
     Route::any('census/censuslist','userController@censuslist');
    /**
     * 记录
     */
    Route::any('admin/invest','recordController@index');
    Route::any('record/lists','recordController@lists');
    Route::any('admin/drawback','recordController@drawback');
    Route::any('drawback/drawbacklists','recordController@list');


    /**
     * 配置
     */
    Route::any('admin/config','configController@index');
    Route::any('config/insert','configController@insert');


});
Route::any('order/notify','admin\orderController@notify');

Route::any('/','admin\loginController@login');
Route::any('logincheck',"admin\loginController@logincheck");//登陆
Route::any('uploads','admin\indexController@upload'); //上传图片
Route::any('update','admin\indexController@update'); //上传文件
Route::any('editUpload','admin\indexController@editUpload'); //文本编辑的图片上传