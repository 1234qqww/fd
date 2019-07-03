<link rel="stylesheet" href="{{asset('easyweb/assets/libs/layui/css/layui.css')}}"/>
<link rel="stylesheet" href="{{asset('easyweb/assets/module/admin.css?v=304')}}"/>
<script type="text/javascript" src="{{asset('easyweb/assets/libs/jquery/jquery-3.2.1.min.js')}}"></script>
<script type="text/javascript" src="{{asset('easyweb/assets/libs/layui/layui.js')}}"></script>
<script type="text/javascript" src="{{asset('easyweb/assets/js/common.js?v=304')}}"></script>
<script type="text/javascript" src="{{asset('js/wangEditor.min.js')}}"></script>
<script type="text/javascript" charset="utf-8" src="{{asset('uEditor/ueditor.config.js')}}"> </script>
<script type="text/javascript" charset="utf-8" src="{{asset('uEditor/ueditor.all.min.js')}}"> </script>
<!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
<!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
<script type="text/javascript" charset="utf-8" src="{{asset('uEditor/lang/zh-cn/zh-cn.js')}}"></script>
<form id="modelUserForm" lay-filter="modelUserForm" class="layui-form model-form">
    <input name="userId" type="hidden"/>
    <div class="layui-form-item">
        <label class="layui-form-label">标题</label>
        <div class="layui-input-block">
            <input name="username" id="name" placeholder="请输入标题" type="text" class="layui-input" maxlength="20"
                   lay-verType="tips" lay-verify="required" required value="{{$info['name']}}"/>
        </div>
    </div>
    <div class="layui-form-item layui-form-text">
        <label class="layui-form-label">内容</label>
        <div class="layui-input-block">
            <script id="editor" type="text/plain" style="width:100%;height:500px;margin: 0 auto"></script>
        </div>
        <script id="editor" type="text/plain" style="width:100%;height:300px;margin: 0 auto"></script>
        <input type="hidden" id="content" name="content" value="{{$info['content']}}">
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">排序</label>
        <div class="layui-input-block">
            <input name="sort" id="sort" placeholder="请输入位置" type="text" class="layui-input" maxlength="20"
                   lay-verType="tips" lay-verify="required" value="{{$info['sort']}}" required/>
        </div>
        <div id="getContent"  onclick="getContent()" hidden></div>
    </div>
</form>
<script>
    var ue = UE.getEditor('editor');
    $('#content').val()
    ue.ready(function() {//编辑器初始化完成再赋值
        ue.setContent( $('#content').val());  //赋值给UEditor
    });
    function getContent() {
        $('#content').val( UE.getEditor('editor').getContent())
    }

    layui.use(['layer', 'form', 'table', 'util', 'admin', 'formSelects'], function () {
        var $ = layui.jquery;
        var layer = layui.layer;
        var form = layui.form;
        var table = layui.table;
        var util = layui.util;
        var admin = layui.admin;
        var formSelects = layui.formSelects;

    });

    //第一步是先获取服务器传过来的图文信息值
    var info1 = document.getElementById("content").value;
    //把图文信息的值通过innerHTML赋值给编辑器
    document.getElementById("editor").innerHTML=info1;

    var E = window.wangEditor
    var editor = new E('#editor')
    // 或者 var editor = new E( document.getElementById('editor') )
    // 隐藏“网络图片”tab
    editor.customConfig.showLinkImg = false;
    editor.customConfig.uploadFileName = 'file';
    editor.customConfig.uploadImgMaxLength = 5;
    editor.customConfig.uploadImgServer = ""  // 上传图片到服务器
    editor.customConfig.uploadImgServer = "{{url('editUpload')}}"  // 上传图片到服务器

    editor.create()
    document.getElementById('btn1').addEventListener('click', function () {
        // 读取 html
        console.log(editor.txt.html());
        var html = editor.txt.html();
        $('#content').val(html);
    })
</script>
