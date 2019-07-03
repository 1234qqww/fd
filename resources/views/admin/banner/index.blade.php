@extends('admin/public/layout')
@section('title')
    BANNER图
@endsection
@section('mind')
    BANNER图
@endsection
@section('content')
    <div class="layui-card">
        <div class="layui-card-body">

            <form class="layui-form" action="javascript:;" style="max-width: 700px;margin-left: 20px">
                <div class="layui-form-item">
                    <label class="layui-form-label">主页banner图</label>
                    <div class="layui-input-block">
                        <button type="button" class="layui-btn" id="test1" style="margin-bottom:20px"><i class="layui-icon"></i>banner</button>
                        <blockquote class="layui-elem-quote layui-quote-nm" style="width:700px" style="margin-top: 10px;">
                            预览图：
                            <div class="layui-upload-list" id="demo1">
                                @if($info['indexbanner'])
                                    @foreach($info['indexbanner'] as $key=>$value)
                                        <img style="width: 120px; height: 120px" data-url="{{$value}}" src="{{$value}}" alt="" class="layui-upload-img images image">
                                        <img class="del-image" style="cursor:pointer;position: relative;left: -35px;top: -40px;width: 25px; height: 25px;" src="{{asset('icon/delete.png')}}">
                                    @endforeach
                                @endif
                            </div>
                        </blockquote>
                        <div style="margin:20px;color:#c0c0c0">建议图片大小为：360*140</div>
                        <input type="hidden" id="indexbanner" name="indexbanner" lay-verify="title" autocomplete="off" class="layui-input" value="">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">车主banner图</label>
                    <div class="layui-input-block">
                        <button type="button" class="layui-btn" id="test2" style="margin-bottom:20px"><i class="layui-icon"></i>banner</button>
                        <blockquote class="layui-elem-quote layui-quote-nm" style="width:700px" style="margin-top: 10px;">
                            预览图：
                            <div class="layui-upload-list" id="demo2">
                                @if($info['ownerbanner'])
                                    @foreach($info['ownerbanner'] as $key=>$value)
                                        <img style="width: 120px; height: 120px" data-url="{{$value}}" src="{{$value}}" alt="" class="layui-upload-img images one">
                                        <img class="del-image" style="cursor:pointer;position: relative;left: -35px;top: -40px;width: 25px; height: 25px;" src="{{asset('icon/delete.png')}}">
                                    @endforeach
                                @endif
                            </div>
                        </blockquote>
                        <div style="margin:20px;color:#c0c0c0">建议图片大小为：360*140</div>
                        <input type="hidden" id="ownerbanner" name="ownerbanner" lay-verify="title" autocomplete="off" class="layui-input" value="">
                    </div>
                </div>
                <input type="text" id="info_id" hidden value="{{$info?$info['id']:''}}">
                <div class="layui-form-item" style="margin-top:50px">
                    <div class="layui-input-block">
                        <button class="layui-btn layui-btn-normal" id="submit">&emsp;提交&emsp;</button>
                        <button type="reset" id="restart" class="layui-btn layui-btn-primary">&emsp;重置&emsp;</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        var incon="{{asset('icon/delete.png')}}"
        $('body').on('click', '.del-image', function(){
            let par = $(this).prev()
            par.remove()
            $(this).remove();

        })
        //多图上传
        layui.use('upload', function(){
            var $ = layui.jquery
                ,upload = layui.upload;
            // 主页banner图
            var uploadInst = upload.render({
                elem: '#test1'
                ,url: "{{url('uploads')}}"
                , multiple: true
                ,before: function(obj){
                    //预读本地文件示例，不支持ie8
                    obj.preview(function(index, file, result){
                    });
                }
                ,done: function(res){
                    $('#demo1').append('<img style="width: 120px; height: 120px" data-url="'+res.url+'" src="' + res.url + '" alt="" class="layui-upload-img images image"><img class="del-image" style="cursor:pointer;position: relative;left: -35px;top: -40px;width: 25px; height: 25px;" src='+ incon +'>')
                    var image = [];
                    $('form').find('.image').each(function(){
                        image.push($(this).attr('data-url'))
                    });
                    $("input[name='indexbanner']").val(image);
                }
            });
            //车主banner图
            var uploadInst = upload.render({
                elem: '#test2'
                ,url: "{{url('uploads')}}"
                , multiple: true

                ,before: function(obj){
                    //预读本地文件示例，不支持ie8
                    obj.preview(function(index, file, result){
                    });
                }
                ,done: function(res){
                    $('#demo2').append('<img style="width: 120px; height: 120px" data-url="'+res.url+'" src="' + res.url + '" alt="" class="layui-upload-img images one"><img class="del-image" style="cursor:pointer;position: relative;left: -35px;top: -40px;width: 25px; height: 25px;" src='+ incon +'>')
                    var image = [];
                    $('form').find('.one').each(function(){
                        image.push($(this).attr('data-url'))
                    });
                    $("input[name='ownerbanner']").val(image);
                }
            });
        })
        $('#restart').click(function() {
            layui.use(['layer', 'form', 'table', 'util', 'admin', 'formSelects'], function () {
                var $ = layui.jquery;
                var layer = layui.layer;
                var form = layui.form;
                var table = layui.table;
                var util = layui.util;
                var admin = layui.admin;
                var upload = layui.upload;
                var formSelects = layui.formSelects;
                layer.load(2);
                layer.closeAll('loading');
                location.reload();
            })

        })
        $('#submit').click(function(){
            //主页banner图
            var image =[];
            $('form').find('.image').each(function(){
                image.push($(this).attr('data-url'))
            });
            $('#indexbanner').val(image)
            //车主banner图
            var one =[];
            $('form').find('.one').each(function(){
                one.push($(this).attr('data-url'))
            });
            $('#ownerbanner').val(one)

            var indexbanner = $('#indexbanner').val();
            var ownerbanner = $('#ownerbanner').val();
            var info_id = $('#info_id').val();
            if(!indexbanner || !ownerbanner ){
                layer.msg('缺少参数!',{icon: 2})
                return;
            }
            $.post("{{url('banner/insert')}}"
                ,{indexbanner:indexbanner,ownerbanner:ownerbanner,id:info_id}
                ,function(res){
                    console.log(res.code)
                    if(res){
                        if(res.code == 0){
                            layer.msg(res.msg,{icon: 1});
                        }else if(res.code == 2){
                            layer.msg(res.msg,{icon: 1});
                            window.location.reload();

                        }else{
                            layer.msg(res.msg,{icon: 2});
                        }
                    }
                });
        })
    </script>
@endsection