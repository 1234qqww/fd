<link rel="stylesheet" href="{{asset('easyweb/assets/libs/layui/css/layui.css')}}"/>
<link rel="stylesheet" href="{{asset('easyweb/assets/module/admin.css?v=304')}}"/>
<script type="text/javascript" src="{{asset('easyweb/assets/libs/jquery/jquery-3.2.1.min.js')}}"></script>
<script type="text/javascript" src="{{asset('easyweb/assets/libs/layui/layui.js')}}"></script>
<script type="text/javascript" src="{{asset('easyweb/assets/js/common.js?v=304')}}"></script>
<form id="modelUserForm" lay-filter="modelUserForm" class="layui-form model-form" action="javascript:;">
    <input name="userId" type="hidden"/>
    <div class="layui-form-item">
        <label class="layui-form-label">用户名</label>
        <div class="layui-input-block">
            <input name="username" id="username" placeholder="请输入用户名" type="text" class="layui-input" maxlength="20"
                   lay-verType="tips" lay-verify="required" required value="{{$info->username}}"/>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">密码</label>
        <div class="layui-input-block">
            <input name="password" id="password" placeholder="请输入密码" type="password" class="layui-input" maxlength="20"
                   lay-verType="tips" lay-verify="required" required value="{{$info->password}}"/>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">状态</label>
        <div class="layui-input-block">
            @if($info->status ==1)
                <input type="checkbox" checked="" id="status" name="open" lay-skin="switch" lay-filter="switchTest" lay-text="启用|禁用" value="1">
            @else
                <input type="checkbox"  id="status" name="open" lay-skin="switch" lay-filter="switchTest" lay-text="启用|禁用" value="0">
            @endif
        </div>
    </div>
</form>
<script>
    layui.use(['layer', 'form', 'table', 'util', 'admin', 'formSelects'], function () {
        var $ = layui.jquery;
        var layer = layui.layer;
        var form = layui.form;
        var table = layui.table;
        var util = layui.util;
        var admin = layui.admin;
        var formSelects = layui.formSelects;

        //监听指定开关
        form.on('switch(switchTest)', function(data){
            if(this.checked){
                $(this).val(1);
            }else{
                $(this).val(0);
            }
        });


    });
</script>
<script>
    layui.use('laydate', function(){
        var laydate = layui.laydate;

        //常规用法
        laydate.render({
            elem: '#time_out'
        });

    });
</script>


