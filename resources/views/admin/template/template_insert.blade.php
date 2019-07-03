<link rel="stylesheet" href="{{asset('easyweb/assets/libs/layui/css/layui.css')}}"/>
<link rel="stylesheet" href="{{asset('easyweb/assets/module/admin.css?v=304')}}"/>
<script type="text/javascript" src="{{asset('easyweb/assets/libs/jquery/jquery-3.2.1.min.js')}}"></script>
<script type="text/javascript" src="{{asset('easyweb/assets/libs/layui/layui.js')}}"></script>
<script type="text/javascript" src="{{asset('easyweb/assets/js/common.js?v=304')}}"></script>
<script type="text/javascript" src="{{asset('js/wangEditor.min.js')}}"></script>
<form id="modelUserForm" lay-filter="modelUserForm" class="layui-form model-form">
    <input name="userId" type="hidden"/>
    <div class="layui-form-item">
        <label class="layui-form-label">失败原因</label>
        <div class="layui-input-block">
            <input name="title" id="title" placeholder="请输入失败原因" type="text" class="layui-input"
                   lay-verType="tips" lay-verify="required" required/>
        </div>
    </div>
</form>
