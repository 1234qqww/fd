@extends('admin/public/layout')
@section('title')
    配置
@endsection
@section('mind')
    配置
@endsection
@section('content')
    <div class="layui-card">
        <div class="layui-card-body">

            <form class="layui-form" action="javascript:;" style="max-width: 700px;margin-left: 20px">
                <div class="layui-form-item">
                    <label class="layui-form-label">小程序appid</label>
                    <div class="layui-input-block">
                        <input type="text" id="appid" name="appid" lay-verify="title" autocomplete="off" placeholder="请输入小程序appid" class="layui-input" value="{{$info?$info->appid:''}}">
                        <span style="font-size: 12px;color: #999;">*添加小程序appid和秘钥用于用户登录获取用户信息</span>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">小程序秘钥</label>
                    <div class="layui-input-block">
                        <input type="text" id="secret" name="secret" lay-verify="title" autocomplete="off" placeholder="请输入小程序秘钥" class="layui-input" value="{{$info?$info->secret:''}}">
                    </div>
                </div>
                <div class="layui-form-item" style="margin-top:40px;">

                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">商户号</label>
                    <div class="layui-input-block">
                        <input type="text" id="mer_id" name="mer_id" lay-verify="title" autocomplete="off" placeholder="请输入商户号" class="layui-input" value="{{$info?$info->mer_id:''}}">
                        <span style="font-size: 12px;color: #999;">*添加商户号和秘钥用于用户支付</span>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">商户秘钥</label>
                    <div class="layui-input-block">
                        <input type="text" id="msecret" name="msecret" lay-verify="title" autocomplete="off" placeholder="请输入商户秘钥" class="layui-input" value="{{$info?$info->msecret:''}}">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">加急金额</label>
                    <div class="layui-input-block">
                        <input type="text" id="urgent" name="urgent" lay-verify="title" autocomplete="off" placeholder="请输入加急金额" class="layui-input" value="{{$info?$info->urgent:''}}">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">服务费</label>
                    <div class="layui-input-block">
                        <input type="text" id="service" name="service" lay-verify="title" autocomplete="off" placeholder="请输入服务费" class="layui-input" value="{{$info?$info->service:''}}">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">滞纳金周期</label>
                    <div class="layui-input-block">
                        <input type="text" id="latefee" name="latefee" lay-verify="title" autocomplete="off" placeholder="请输入滞纳金周期" class="layui-input" value="{{$info?$info->latefee:''}}">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">待支付模板id</label>
                    <div class="layui-input-block">
                        <input type="text" id="template_id" name="template_id" lay-verify="title" autocomplete="off" placeholder="请输入待支付模板id" class="layui-input" value="{{$info?$info->template_id:''}}">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">完成模板id</label>
                    <div class="layui-input-block">
                        <input type="text" id="complete_id" name="complete_id" lay-verify="title" autocomplete="off" placeholder="请输入完成模板id" class="layui-input" value="{{$info?$info->complete_id:''}}">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">失败模板id</label>
                    <div class="layui-input-block">
                        <input type="text" id="fail_id" name="fail_id" lay-verify="title" autocomplete="off" placeholder="请输入失败模板id" class="layui-input" value="{{$info?$info->fail_id:''}}">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">双向证书</label>
                    <button type="button" class="layui-btn" id="test3"><i class="layui-icon"></i>上传文件</button>
                    <input type="text" hidden id="autograph" name="autograph" value="{{$info?$info->autograph:''}}">
                    <div style="display:inline;margin-left:10px">apiclient_key.pem</div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">双向证书</label>
                    <button type="button" class="layui-btn" id="test4"><i class="layui-icon"></i>上传文件</button>
                    <input type="text" hidden id="templatecode" name="templatecode" value="{{$info?$info->templatecode:''}}">
                    <div style="display:inline;margin-left:10px">apiclient_cert.pem</div>
                </div>
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">内容</label>
                    <div class="layui-input-block">
                        <script id="editor" type="text/plain" style="width:130%;height:300px;margin: 0 auto"></script>
                    </div>
                    <script id="editor" type="text/plain" style="width:100%;height:300px;margin: 0 auto"></script>
                    <input type="hidden" id="content" name="content" value="{{$info['content']}}">
                    <div id="getContent"  onclick="getContent()" hidden></div>
                </div>
                <input type="text" id="info_id" hidden value="{{$info?$info->id:''}}">
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
        var ue = UE.getEditor('editor');
        ue.ready(function() {//编辑器初始化完成再赋值
            ue.setContent( $('#content').val());  //赋值给UEditor
        });
        function getContent() {
            $('#content').val( UE.getEditor('editor').getContent())
        }
        var incon="{{asset('icon/delete.png')}}"

        //多图上传
        layui.use('upload', function(){
            var $ = layui.jquery
                ,upload = layui.upload;
            //上传双向证书
            upload.render({
                elem: '#test3'
                ,url: '{{url('update')}}'
                ,accept: 'file' //普通文件
                ,exts: 'pem' //文件后缀
                ,done: function(res){
                    $('#autograph').val(res.url)
                    layer.msg('上传成功')
                }
            });
            upload.render({
                elem: '#test4'
                ,url:  '{{url('update')}}'
                ,accept: 'file' //普通文件
                ,exts: 'pem' //文件后缀
                ,done: function(res){
                    $('#templatecode').val(res.url)
                    layer.msg('上传成功')
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
            $('form').find('#btn1').click()
            $('form').find('#getContent').click()
            var appid = $('#appid').val();
            var secret = $('#secret').val();
            var mer_id = $('#mer_id').val();
            var msecret = $('#msecret').val();
            var autograph = $('#autograph').val();
            var service = $('#service').val();
            var templatecode = $('#templatecode').val();
            var template_id = $('#template_id').val();
            var complete_id = $('#complete_id').val();
            var fail_id = $('#fail_id').val();
            var urgent = $('#urgent').val();
            var content =$('#content').val();
            var latefee =$('#latefee').val();
            var info_id = $('#info_id').val();
            if(!appid || !secret || !complete_id || !fail_id || !template_id ||!latefee || !mer_id || !msecret || !autograph || !templatecode || !content || !urgent || !service){
                layer.msg('缺少参数!',{icon: 2})
                return;
            }
            $.post("{{url('config/insert')}}"
                ,{appid:appid,secret:secret,complete_id:complete_id,fail_id:fail_id,template_id:template_id,latefee:latefee,service:service,urgent:urgent,content:content,mer_id:mer_id,msecret:msecret,autograph:autograph,templatecode:templatecode,id:info_id}
                ,function(res){
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