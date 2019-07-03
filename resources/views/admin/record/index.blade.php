
@extends('admin/public/layout')
@section('title')
    充值记录
@endsection
@section('mind')
    充值记录
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
                url: "{{url('record/lists')}}",
                page: true,
                cols: [[
                    {field: 'id',align:"center",title:"id"},
                    {field: 'openid', title: 'openid',align:"center"},
                    {field: 'ordernumber', title: '订单号',align:"center"},
                    {field: 'status', title: '类型',align:"center",templet:function(e){
                        if(e.status==0){
                            return '充值';
                        }else{
                            return '退款';
                        }
                    }},
                    {field: 'created_at', title: '支付时间',align:"center"},
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