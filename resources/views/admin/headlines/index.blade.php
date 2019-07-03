@extends('admin/public/layout')
@section('title')
    车主头条
@endsection
@section('mind')
    车主头条
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
                        <button id="btnSearch" class="layui-btn layui-btn-normal icon-btn layui-btn-sm"><i class="layui-icon">&#xe615;</i>搜索</button>
                        <button id="btnAdd" class="layui-btn layui-btn-normal icon-btn layui-btn-sm"><i class="layui-icon">&#xe654;</i>添加</button>
                    </div>
                </div>
            </div>
            <table class="layui-table" id="userTable" lay-filter="userTable"></table>
        </div>
    </div>

    <script type="text/html" id="tableBar">
        <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="edit">修改</a>
        <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="del">删除</a>
        {{--        <a class="layui-btn layui-btn-xs" lay-event="reset">重置密码</a>--}}
    </script>
    <!-- 表格操作列 -->
    <script>
        function previewImg(obj) {
            var img = new Image();
            img.src = obj.src;
            var imgHtml = "<img src='" + obj.src + "' width='500px' height='500px'/>";
            //弹出层
            layer.open({
                type: 1,
                shade: 0.8,
                offset: 'auto',
                area: [500 + 'px',550+'px'],
                shadeClose:true,
                scrollbar: false,
                title: "图片预览", //不显示标题
                content: imgHtml, //捕获的元素，注意：最好该指定的元素要存放在body最外层，否则可能被其它的相对元素所影响
                cancel: function () {
                    //layer.msg('捕获就是从页面已经存在的元素上，包裹layer的结构', { time: 5000, icon: 6 });
                }
            });
        }
        function show(ss){
            var html = ss;
            html = html.replace(/<\/?SPANYES[^>]*>/gi, "");//  Remove  all  SPAN  tags
            html = html.replace(/<\/?font[^>]*>/gi,"");
            html = html.replace(/<\/?@font-face[^>]*>/gi,"");
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
            // 渲染表格
            var insTb = table.render({
                elem: '#userTable',
                skin:'line',
                url: "{{url('headlines/lists')}}",
                page: true,
                cols: [[
                    {field: 'id',align:"center",title:"id",width:200},
                    {field: 'title', title: '标题',align:"center",width:200},
                    {field: 'content', title: '内容',align:"center",width:390},
                    {field: 'image', title: '配图',align:"center",width:200,templet:function(e){
                            var img ='';
                            if(e.image){
                                for(i=0;i<e.image.length;i++){
                                    img +="<img onclick='previewImg(this)' style='width:50px;height:50px' src ="+e.image[i]+">";
                                }
                                return img;
                            }else{
                                return '';
                            }
                        }},
                    {field: 'reading', title:'阅读量',align:"center",width:200},
                    {field: 'sort', title:'排序',align:"center",width:200},
                    {align: 'center', toolbar: '#tableBar',width:300, title: '操作'}
                ]]
            });
            // 添加
            $('#btnAdd').click(function () {
                layer.open({
                    type: 2 //此处以iframe举例
                    ,title: '添加'
                    ,area: ['70%', '80%']
                    ,shade: 0.2
                    ,maxmin: true
                    ,content: "{{url('admin/headlines')}}?type=add"
                    ,btn: ['保存关闭', '取消'] //只是为了演示
                    ,yes: function(){
                        //主页banner图
                        var image =[];
                        $('form').find('.image').each(function(){
                            image.push($(this).attr('data-url'))
                        });
                        $('#image').val(image);
                        var index = parent.layer.getFrameIndex()
                        var form = layer.getChildFrame('form', index);
                        form.find('#btn1').click();
                        form.find('#getContent').click();
                        var index = parent.layer.getFrameIndex()
                        var form = layer.getChildFrame('form', index);
                        var title = form.find('#title').val()
                        var content = form.find('#content').val()
                        var image = form.find('#image').val()
                        var reading = form.find('#reading').val()
                        var sort = form.find('#sort').val()
                        if(!title || !content || !image || !reading){
                            alert('缺少参数!');
                            return;
                        }
                        layer.load(2);
                        $.post(
                            "{{url('headlines/add')}}",
                            {title: title,content:content,image:image,reading:reading,sort:sort,type:status},
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
                        ,area: ['70%', '80%']
                        ,shade: 0.2
                        ,maxmin: true
                        ,content: "{{url('admin/headlines')}}?type=edit&id="+id
                        ,btn: ['保存关闭', '取消'] //只是为了演示
                        ,yes: function(){
                            //主页banner图
                            var index = parent.layer.getFrameIndex()
                            var form = layer.getChildFrame('form', index);
                            form.find('#btn1').click();
                            form.find('#getContent').click();
                            var index = parent.layer.getFrameIndex()
                            var form = layer.getChildFrame('form', index);
                            var title = form.find('#title').val()
                            var content = form.find('#content').val()
                            var reading = form.find('#reading').val()
                            var sort = form.find('#sort').val()
                            var image =[];
                            form.find('.image').each(function(){
                                image.push($(this).attr('data-url'))
                            });
                            var img = image;
                            if(!title || !content || !img || !reading){
                                alert('缺少参数!');
                                return;
                            }
                            layer.load(2);
                            $.post(
                                "{{url('headlines/edit')}}/"+id,
                                {title: title,content:content,image:img,reading:reading,sort:sort,type:status},
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
                            url: "{{url('headlines/delete')}}/"+id,
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