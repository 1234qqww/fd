
@extends('admin/public/layout')
@section('title')
    用户
@endsection
@section('mind')
    用户
@endsection
@section('content')
    <div class="layui-card">
        <div class="layui-card-body">
            <div class="layui-form toolbar">
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <input id="edtSearch" class="layui-input" type="text" placeholder="输入openid"/>
                    </div>
                    <div class="layui-inline">
                        <button id="btnSearch" class="layui-btn layui-btn-normal icon-btn layui-btn-sm"><i class="layui-icon">&#xe615;</i>搜索</button></div>
                </div>
            </div>
            <table class="layui-table" id="userTable" lay-filter="userTable"></table>
        </div>
    </div>
    <!-- 表格操作列 -->
    <script>
        layui.use(['layer', 'form', 'table', 'util', 'admin', 'formSelects'], function () {
            var $ = layui.jquery;
            var layer = layui.layer;
            var form = layui.form;
            var table = layui.table;
            var util = layui.util;
            var admin = layui.admin;
            var formSelects = layui.formSelects;
            // 渲染表格
            var insTb = table.render({
                elem: '#userTable',
                skin:'line',
                url: "{{url('user/lists')}}",
                page: true,
                cols: [[
                    {field: 'id',align:"center",title:"id"},
                    {field: 'openid', title: 'openid',align:"center",templet:function(e){
                        return "<a href='{{url("order/userorder")}}?openid="+e.openid+"' >"+e.openid+"</a>"
                    }},
                    {field: 'payorder', title: '已支付',align:"center"},
                    {field: 'nopayorder', title: '待处理',align:"center"},
                    {field: 'updated_at', title: '最后登陆时间',align:"center"},
                ]]
            });
            // 搜索
            $('#btnSearch').click(function () {
                var value = $('#edtSearch').val();
                insTb.reload({where: { key: value}});
            });
        });
    </script>
@endsection