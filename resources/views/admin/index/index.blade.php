@extends('admin/public/layout')
@section('title')
    ��ҳ
@endsection
@section('mind')
    ��ҳ
@endsection
@section('content')
    <div class="layui-card">
        <div class="layui-card-body">
            <div class="layui-form toolbar">
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <input id="edtSearch" class="layui-input" type="text" placeholder="����ؼ���"/>
                    </div>
                    <div class="layui-inline">
                        <button id="btnSearch" class="layui-btn layui-btn-normal icon-btn layui-btn-sm"><i class="layui-icon">&#xe615;</i>����</button>
                        <button id="btnAdd" class="layui-btn layui-btn-normal icon-btn layui-btn-sm"><i class="layui-icon">&#xe654;</i>���</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/html" id="tableBar">
        <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="edit">�޸�</a>
        <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="del">ɾ��</a>
        {{--        <a class="layui-btn layui-btn-xs" lay-event="reset">��������</a>--}}
    </script>
    <!-- �������� -->
@endsection