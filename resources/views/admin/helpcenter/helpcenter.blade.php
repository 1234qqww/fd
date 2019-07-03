@extends('admin.public.layout')
@section('title')
    常见问题
@endsection
@section('mind')
    常见问题
@endsection
@section('content')
    <div class="layui-card">
        <div class="layui-card-body">
            <div class="layui-form toolbar">
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <input id="edtSearch" class="layui-input" type="text" placeholder="输入关键字"/>
                    </div>
                    <div class="layui-inline">
                        <button id="btnSearch" class="layui-btn icon-btn layui-btn-normal layui-btn-sm"><i class="layui-icon">&#xe615;</i>搜索</button>
                        <button id="btnAdd" class="layui-btn icon-btn layui-btn-normal layui-btn-sm"><i class="layui-icon">&#xe654;</i>添加</button>
                    </div>
                </div>
            </div>

            <table class="layui-table" id="userTable" lay-filter="userTable"></table>
        </div>
    </div>
    <!-- 表格操作列 -->
    <script type="text/html" id="tableBar">
        <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="edit">修改</a>
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
        {{--        <a class="layui-btn layui-btn-xs" lay-event="reset">重置密码</a>--}}
    </script>
    <script>
        function show(ss){
            var html = ss;
            html = html.replace(/<\/?SPANYES[^>]*>/gi, "");//  Remove  all  SPAN  tags
            html = html.replace(/<\/?font[^>]*>/gi,"");
            html = html.replace(/<\/?span[^>]*>/gi,"");
            html = html.replace(/<(\w[^>]*)  lang=([^|>]*)([^>]*)/gi, "<$1$3");//  Remove  Lang  attributes
            html = html.replace(/<\\?\?xml[^>]*>/gi, "");//  Remove  XML  elements  and  declarations
            html = html.replace(/<\/?\w+:[^>]*>/gi, "");//  Remove  Tags  with  XML  namespace  declarations:  <o:p></o:p>
            html = html.replace(/&nbsp;/, "");//  Replace  the  &nbsp;
            html = html.replace(/\n(\n)*( )*(\n)*\n/gi, '\n');
            return html;
        }
        layui.use(['layer', 'form', 'table', 'util', 'admin', 'formSelects'], function () {
            var $ = layui.jquery;
            var layer = layui.layer;
            var form = layui.form;
            var table = layui.table;
            var util = layui.util;
            var admin = layui.admin;
            var formSelects = layui.formSelects;
            var tableWidth = layui.$('.layui-table-header').width();
            // 渲染表格
            var insTb = table.render({
                elem: '#userTable',
                skin:'line',
                url: '{{url('question/lists')}}',
                page: true,
                cols: [[
                    {field: 'id',align:"center",title:"id",width:200},
                    {field: 'name', title: '标题',align:"center",width:300},
                    {field: 'content', title: "内容",align:"center",width:390},
                    {field: 'sort', title: "排序",align:"center",width:200},
                    {field: 'created_at', title: '添加时间',align:"center",width:300},
                    {align: 'center', toolbar: '#tableBar', title: '操作', width: 300}
                ]]
            });

            // 添加
            $('#btnAdd').click(function () {
                layer.open({
                    type: 2 //此处以iframe举例
                    ,title: '添加'
                    ,area: ['60%', '60%']
                    ,shade: 0.2
                    ,maxmin: true
                    ,offset: [ //为了演示，随机坐标
                        ($(window).height()*0.15)
                        ,($(window).width()*0.25)
                    ]
                    ,content: "{{url('admin/question')}}?type=add"
                    ,btn: ['保存关闭', '取消'] //只是为了演示
                    ,yes: function(){
                        var index = parent.layer.getFrameIndex()
                        var form = layer.getChildFrame('form', index);
                        form.find('#btn1').click();
                        form.find('#getContent').click();
                        var name = form.find('#name').val()
                        var sort = form.find('#sort').val()
                        var content = form.find('#content').val()
                        if(!name || !content ||!sort){
                            layer.closeAll();
                            layer.msg('缺少参数!',{icon: 2})
                            return;
                        }
                        layer.load(2);
                        $.post(
                            "{{url('question/insert')}}",
                            {name: name,content:content,sort:sort},
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
                if(obj.event === 'del'){
                    layer.confirm('真的删除吗?', function(index){
                        var id = data.id;
                        //console.log(id)
                        $.ajax({
                            url: "{{url('question/delete')}}/"+id,
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
                } else if(obj.event === 'edit'){
                    var id = data.id;
                    //多窗口模式，层叠置顶
                    layer.open({
                        type: 2 //此处以iframe举例
                        ,title: '编辑'
                        ,area: ['50%', '55%']
                        ,shade: 0.2
                        ,maxmin: true
                        ,offset: [ //为了演示，随机坐标
                            ($(window).height()*0.15)
                            ,($(window).width()*0.25)
                        ]
                        ,content:"{{url('admin/question')}}?type=edit&id="+id
                        ,btn: ['保存关闭', '取消'] //只是为了演示
                        ,yes: function(){
                            var index = parent.layer.getFrameIndex()
                            var form = layer.getChildFrame('form', index);
                            form.find('#btn1').click();
                            form.find('#getContent').click();
                            var name = form.find('#name').val()
                            var sort = form.find('#sort').val()
                            var content = form.find('#content').val();
                            if(!name || !content || !sort){
                                layer.closeAll();
                                layer.msg('缺少参数!',{icon: 2})
                                return;
                            }
                            layer.load(2);
                            $.post(
                                "{{url('question/edit')}}/"+id,
                                {name: name,content:content,sort:sort},
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
