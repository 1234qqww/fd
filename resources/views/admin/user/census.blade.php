@extends('admin/public/layout')
@section('title')
    统计
@endsection
@section('mind')
    统计
@endsection
@section('content')
    <div class="layui-card">
        <div class="layui-card-body">
            <table class="layui-table" id="userTable" lay-filter="userTable"></table>
        </div>
    </div>
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
                url: "{{url('census/censuslist')}}",
                page: true,
                cols: [[
                    {field: 'id',align:"center",title:"id"},
                    {field: 'openid', title: 'openid',align:"center"},
                    {field: 'amount', title: '支付总金额',align:"center"},
                    {field: 'num', title: '订单数量',align:"center"},

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
                    ,offset: [ //为了演示，随机坐标
                        ($(window).height()*0.15)
                        ,($(window).width()*0.3)
                    ]
                    ,content: "{{url('admin/notice')}}?type=add"
                    ,btn: ['保存关闭', '取消'] //只是为了演示
                    ,yes: function(){
                        var index = parent.layer.getFrameIndex()
                        var form = layer.getChildFrame('form', index);
                        var notice = form.find('#notice').val()
                        var sort = form.find('#sort').val()
                        if(!notice || !sort){
                            alert('缺少参数!');
                            return;
                        }
                        layer.load(2);
                        $.post(
                            "{{url('notice/add')}}",
                            {notice: notice,sort:sort,type:status},
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
                        ,offset: [ //为了演示，随机坐标
                            ($(window).height()*0.15)
                            ,($(window).width()*0.3)
                        ]
                        ,content: "{{url('admin/notice')}}?type=edit&id="+id
                        ,btn: ['保存关闭', '取消'] //只是为了演示
                        ,yes: function(){
                            var index = parent.layer.getFrameIndex()
                            var form = layer.getChildFrame('form', index);
                            var notice = form.find('#notice').val()
                            var sort = form.find('#sort').val()
                            if(!notice || !sort){
                                alert('缺少参数!');
                                return;
                            }
                            layer.load(2);
                            $.post(
                                "{{url('notice/edit')}}/"+id,
                                {notice:notice,sort:sort,type:status},
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
                            url: "{{url('notice/delete')}}/"+id,
                            type: 'delete',
                            data: {id:id},
                            dataType: 'json',
                            success: function(){
                                obj.del();
                                layer.close(index);
                                layer.msg('删除成功', {icon: 1});
                            }
                        })
                    });
                }
            });

        });
    </script>
@endsection