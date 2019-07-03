@extends('admin/public/layout')
@section('title')
    订单
@endsection
@section('mind')
    订单
@endsection
@section('content')
    <div class="layui-card">
        <div class="layui-card-body">
            <div class="layui-form toolbar">
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <input id="edtSearch" class="layui-input" type="text" placeholder="输入订单号"/>
                    </div>
                    <div class="layui-inline">
                        <button id="btnSearch" class="layui-btn layui-btn-normal icon-btn layui-btn-sm"><i class="layui-icon">&#xe615;</i>搜索</button>
                    </div>
                </div>
            </div>
            <table class="layui-table" id="userTable" lay-filter="userTable"></table>
        </div>
    </div>

    <script type="text/html" id="tableBar">
        <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="edit">完成</a>
        <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="del">失败</a>
        {{--        <a class="layui-btn layui-btn-xs" lay-event="reset">重置密码</a>--}}
    </script>
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
                url: "{{url('order/list')}}/1",
                page: true,
                cols: [[
                    {field: 'id',align:"center",title:"id"},
                    {field: 'openid', title: 'openid',align:"center"},
                    {field: 'notice', title: '罚单编号',align:"center"},
                    {field: 'ordernumber', title: '订单号',align:"center"},
                    {field: 'money', title: '罚金金额',align:"center"},
                    {field: 'name', title: '被罚人',align:"center"},
                    {field: 'overdue', title: '滞纳金',align:"center"},
                    {field: 'service', title: '服务费',align:"center"},
                    {field: 'urgent', title: '加急费',align:"center"},
                    {field: 'amount', title: '总金额',align:"center"},
                    {field: 'phone', title: '手机号',align:"center"},
                    {field: 'noticetime', title: '处罚时间',align:"center"},
                    {align: 'center', toolbar: '#tableBar', title: '操作', minWidth: 200}
                ]]
            });

            // 添加

            // 搜索
            $('#btnSearch').click(function () {
                var value = $('#edtSearch').val();
                insTb.reload({where: { key: value}});
            });

            //监听行工具事件
            table.on('tool(userTable)', function(obj){
                var that = this;
                var data = obj.data;
                if(obj.event === 'edit'){
                    $.post(
                        "{{url('order/edit')}}/"+data.id,
                        function(res){
                            layer.closeAll('loading');
                            if (res.code == 0) {
                                layer.closeAll();
                                layer.msg(res.msg, {icon: 1});
                                insTb.reload();
                            } else {
                                layer.msg(res.msg, {icon: 2});
                            }
                        }
                    )
                }else if(obj.event === 'del'){

                    layer.open({
                        type: 2 //此处以iframe举例
                        ,title: '失败原因'
                        ,area: ['40%', '40%']
                        ,shade: 0.2
                        ,maxmin: true
                        ,offset: [ //为了演示，随机坐标
                            ($(window).height()*0.15)
                            ,($(window).width()*0.3)
                        ]
                        ,content: "{{url('admin/reason')}}"
                        ,btn: ['保存关闭', '取消'] //只是为了演示
                        ,yes: function(){
                            var index = parent.layer.getFrameIndex()
                            var form = layer.getChildFrame('form', index);
                            var title = form.find('#select>option:selected').val();

                            if(!title){
                                alert('缺少参数!');
                                return;
                            }
                            layer.load(2);
                            $.post(
                                "{{url('order/titleedit')}}/"+data.id,
                                {title:title},
                                function(res){
                                    layer.closeAll('loading');
                                    if (res.code == 0) {
                                        layer.closeAll();
                                        layer.msg(res.msg, {icon: 1});
                                        insTb.reload();
                                    } else {
                                        layer.msg(res.msg, {icon: 2});
                                    }
                                }
                            )
                        }
                        ,btn2: function(){
                            layer.closeAll();
                        }

                        ,zIndex: layer.zIndex //重点1
                        ,success: function(layero){
                            layer.setTop(layero); //重点2
                        }
                    });
                }

            });

        });
    </script>
@endsection