
@extends('admin.public.layout')
@section('title')
    管理员
@endsection
@section('mind')
    管理员
@endsection
@section('content')
    <div class="layui-card">
        <div class="layui-card-body">
            <div class="layui-form toolbar">
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <input id="edtSearch" class="layui-input" type="text" placeholder="输入管理员名称"/>
                    </div>
                    <div class="layui-inline">
                        <button id="btnSearch" class="layui-btn layui-btn-normal icon-btn layui-btn-sm"><i class="layui-icon">&#xe615;</i>搜索</button>
                        <button id="btnAdd" class="layui-btn layui-btn-normal icon-btn layui-btn-sm"><i class="layui-icon">&#xe654;</i>添加</button>
                    </div>
                </div>
            </div>
            <table class="layui-table" id="userTable" lay-filter="userTable"></table>
        </div>
    </div>
    <!-- 表格操作列 -->
    <script type="text/html" id="tableBar">
        <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="edit">修改</a>
        <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="del">删除</a>
        {{--        <a class="layui-btn layui-btn-xs" lay-event="reset">重置密码</a>--}}
    </script>
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
                url: "{{url('administrators/lists')}}",
                page: true,
                cols: [[
                    {field: 'id',align:"center",title:"id"},
                    {field: 'username', title: '管理员名称',align:"center"},
                    {field: 'status', title: '状态',align:"center",templet:function(e){
                        if(e.status==1){
                            return '正常';
                        }else{
                            return '禁止登陆'
                        }
                    }},
                    {field: 'updated_at', title: '最后一次登陆时间',align:"center"},
                    {align: 'center', toolbar: '#tableBar', title: '操作', minWidth: 200}
                ]]
            });
            // 添加
            $('#btnAdd').click(function () {
                layer.open({
                    type: 2 //此处以iframe举例
                    ,title: '添加'
                    ,area: ['40%', '40%']
                    ,shade: 0.2
                    ,maxmin: true
                    ,content: "{{url('admin/administrators')}}?type=add"
                    ,btn: ['保存关闭', '取消'] //只是为了演示
                    ,yes: function(){
                        var index = parent.layer.getFrameIndex()
                        var form = layer.getChildFrame('form', index);
                        var username = form.find('#username').val()
                        var password = form.find('#password').val()
                        var res_password = form.find('#res_password').val()
                        var status = form.find('#status').val()
                        if(password != res_password){
                            alert('两次密码不一致');
                            return;
                        }

                        if(!username || !password){
                            alert('缺少参数!');
                            return;
                        }
                        layer.load(2);
                        $.post(
                            "{{url('administrators/insert')}}",
                            {username: username,password:password,status:status},
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
            });

            // 搜索
            $('#btnSearch').click(function () {
                var value = $('#edtSearch').val();
                insTb.reload({where: { key: value}});
            });

            //监听行工具事件
            table.on('tool(userTable)', function(obj){
                var that = this;
                var data = obj.data;
                //console.log(obj)
                if(obj.event === 'edit'){
                    var id = data.id;
                    //多窗口模式，层叠置顶
                    layer.open({
                        type: 2 //此处以iframe举例
                        ,title: '修改'
                        ,area: ['40%', '40%']
                        ,shade: 0.2
                        ,maxmin: true
                        ,content: "{{url('admin/administrators')}}?type=edit&id="+id
                        ,btn: ['保存关闭', '取消'] //只是为了演示
                        ,yes: function(){
                            var index = parent.layer.getFrameIndex()
                            var form = layer.getChildFrame('form', index);
                            var username = form.find('#username').val()
                            var password = form.find('#password').val()
                            var status = form.find('#status').val()
                            if(!username || !password){
                                alert('缺少参数!');
                                return;
                            }
                            layer.load(2);
                            $.post(
                                "{{url('administrators/edit')}}/"+id,
                                {username: username,password:password,status:status},
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


                }else if(obj.event === 'del') {
                    layer.confirm('真的删除吗?', function(index){
                        var id = data.id;
                        //console.log(id)
                        $.ajax({
                            url: "{{url('administrators/delete')}}/"+id,
                            type: 'delete',
                            data: {id:id},
                            dataType: 'json',
                            success: function(){
                                obj.del();
                                layer.msg('删除成功', {icon: 1});
                                window.location.reload();
                            }
                        })
                    });
                }
            });
        });
    </script>
@endsection