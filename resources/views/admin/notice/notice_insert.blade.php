<link rel="stylesheet" href="{{asset('easyweb/assets/libs/layui/css/layui.css')}}"/>
<link rel="stylesheet" href="{{asset('easyweb/assets/module/admin.css?v=304')}}"/>
<script type="text/javascript" src="{{asset('easyweb/assets/libs/jquery/jquery-3.2.1.min.js')}}"></script>
<script type="text/javascript" src="{{asset('easyweb/assets/libs/layui/layui.js')}}"></script>
<script type="text/javascript" src="{{asset('easyweb/assets/js/common.js?v=304')}}"></script>
<form id="modelUserForm" lay-filter="modelUserForm" class="layui-form model-form" action="javascript:;">
    <div class="layui-form-item">
        <label class="layui-form-label">通知</label>
        <div class="layui-input-block">
            <input name="notice" id="notice" placeholder="请输入通知内容" type="text" class="layui-input"
                   lay-verType="tips" lay-verify="required" required/>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">排序</label>
        <div class="layui-input-block">
            <input name="sort" id="sort" placeholder="请输入排序" type="text" class="layui-input"
                   lay-verType="tips" lay-verify="required" required/>
        </div>
    </div>
</form>
