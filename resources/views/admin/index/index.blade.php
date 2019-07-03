@extends('admin/public/layout')
@section('title')
    首页
@endsection
@section('mind')
    首页
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
        </div>
    </div>

    <script type="text/html" id="tableBar">
        <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="edit">修改</a>
        <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="del">删除</a>
        {{--        <a class="layui-btn layui-btn-xs" lay-event="reset">重置密码</a>--}}
    </script>
    <!-- 表格操作列 -->
@endsection