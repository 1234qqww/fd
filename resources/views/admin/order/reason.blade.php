<link rel="stylesheet" href="{{asset('easyweb/assets/libs/layui/css/layui.css')}}"/>
<link rel="stylesheet" href="{{asset('easyweb/assets/module/admin.css?v=304')}}"/>
<script type="text/javascript" src="{{asset('easyweb/assets/libs/jquery/jquery-3.2.1.min.js')}}"></script>
<script type="text/javascript" src="{{asset('easyweb/assets/libs/layui/layui.js')}}"></script>
<script type="text/javascript" src="{{asset('easyweb/assets/js/common.js?v=304')}}"></script>
<script type="text/javascript" src="{{asset('js/wangEditor.min.js')}}"></script>
<form id="modelUserForm" lay-filter="modelUserForm" class="layui-form model-form">
    <div class="layui-form-item">
        <label class="layui-form-label">失败原因</label>
        <div class="layui-input-block">
            <select name="title"  lay-search=" " id="select">
                @foreach($info as $key=>$value)
                <option value="{{$value->title}}">{{$value->title}}</option>
                @endforeach
            </select>
        </div>


    </div>
</form>
<script>
    layui.use(['form', 'layedit', 'laydate'], function(){
        var form = layui.form
            ,layer = layui.layer
            ,layedit = layui.layedit
            ,laydate = layui.laydate;
    });
</script>
