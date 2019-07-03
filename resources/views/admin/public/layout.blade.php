<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    {{--    <title>后台管理</title>--}}
    <title>@yield('title')</title>
    <link href="{{asset('easyweb/assets/images/favicon.ico')}}" rel="icon">
    <link rel="stylesheet" href="{{asset('easyweb/assets/libs/layui/css/layui.css')}}"/>
    <link rel="stylesheet" href="{{asset('easyweb/assets/module/admin.css?v=304')}}"/>
    <script type="text/javascript" src="{{asset('easyweb/assets/libs/jquery/jquery-3.2.1.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('easyweb/assets/libs/layui/layui.js')}}"></script>
    <script type="text/javascript" src="{{asset('easyweb/assets/js/common.js?v=304')}}"></script>
    <script type="text/javascript" src="{{asset('js/wangEditor.min.js')}}"></script>
    <link rel="stylesheet" href="{{asset('layout/index.css')}}"/>
    <script type="text/javascript" charset="utf-8" src="{{asset('uEditor/ueditor.config.js')}}"> </script>
    <script type="text/javascript" charset="utf-8" src="{{asset('uEditor/ueditor.all.min.js')}}"> </script>
    <!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
    <!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
    <script type="text/javascript" charset="utf-8" src="{{asset('uEditor/lang/zh-cn/zh-cn.js')}}"></script>
</head>
<style>
    .left-bar-secendlist-item{
        margin-bottom:20px;
    }
    .left-bar-secendlist-item>img{
        display:none;
    }
    .ball-loader span{
        display: inline-block;
        width:40px;
        height:40px;
        overflow: hidden;
        border-radius:25px;
    }
    .ball-loader span img{
        width:100%;
    }
    .layui-input, .layui-select, .layui-textarea{
        height:33px;!important;;
    }
</style>
<body>
<div class="main">
    <!--顶部标题-->
    <div class="main-right">
        <div class="left-bar-title">
            <img style="width:50px;height:50px;position: relative;top:10px;z-index:100" src="{{asset('layout/static/logo.png')}}" />
        </div>
        <div class="top-title">
            <h4 style="	font-weight: bold;font-size:18px">违章缴费</h4>
            <div class="top-title-user">
                <ul class="layui-nav layui-layout-right" style="background: #fff;height:40px;">
                    <li class="layui-nav-item" lay-unselect style="margin-right: 10px;">
                        <a>
                            <img src="{{asset('easyweb/assets/images/head.png')}}" class="layui-nav-img">
                            <cite style="color: #000">{{session('admin_user')}}</cite>
                        </a>
                        <dl class="layui-nav-child">
                            <dd lay-unselect>
                                <a id="edit">修改密码</a>
                            </dd>
                            <dd lay-unselect>
                                <a  id="login_out" >退出登录</a>
                            </dd>
                        </dl>
                    </li>
                </ul>

            </div>
        </div>
    </div>
    <!--左侧菜单-->
    <div class="main-bot">
        <div class="left-bar">
            <div class="left-bar-list">
                <a href="{{url('admin')}}">
                    <div  class="left-bar-list-item admin"  >
                        <div class="left-bar-list-item-img"><img style="width:40%;height:40%" src="{{asset('vector/1.png')}}" />
                        </div>
                        <div class="left-bar-list-item-font"><span style="font-size: 14px;">首页</span></div>
                    </div>
                </a>
                <a href="{{url('admin/administrators')}}">
                    <div  class="left-bar-list-item administrators"  >
                        <div class="left-bar-list-item-img"><img style="width:40%;height:40%" src="{{asset('vector/1.png')}}" />
                        </div>
                        <div class="left-bar-list-item-font"><span style="font-size: 14px;">管理员</span></div>
                    </div>
                </a>
                <a href="{{url('admin/user')}}">
                    <div  class="left-bar-list-item user"  >
                        <div class="left-bar-list-item-img"><img style="width:40%;height:40%" src="{{asset('vector/1.png')}}" />
                        </div>
                        <div class="left-bar-list-item-font"><span style="font-size: 14px;">用户</span></div>
                    </div>
                </a>
                <a href="{{url('admin/template')}}">
                    <div  class="left-bar-list-item template"  >
                        <div class="left-bar-list-item-img"><img style="width:40%;height:40%" src="{{asset('vector/1.png')}}" />
                        </div>
                        <div class="left-bar-list-item-font"><span style="font-size: 14px;">原因</span></div>
                    </div>
                </a>
                <a href="{{url('admin/notice')}}">
                    <div  class="left-bar-list-item notice"  >
                        <div class="left-bar-list-item-img"><img style="width:40%;height:40%" src="{{asset('vector/1.png')}}" />
                        </div>
                        <div class="left-bar-list-item-font"><span style="font-size: 14px;">通知</span></div>
                    </div>
                </a>
                <a href="{{url('admin/banner')}}">
                    <div  class="left-bar-list-item banner"  >
                        <div class="left-bar-list-item-img"><img style="width:40%;height:40%" src="{{asset('vector/1.png')}}" />
                        </div>
                        <div class="left-bar-list-item-font"><span style="font-size: 14px;">广告</span></div>
                    </div>
                </a>
                <a href="{{url('admin/complaint')}}">
                    <div  class="left-bar-list-item complaint"  >
                        <div class="left-bar-list-item-img"><img style="width:40%;height:40%" src="{{asset('vector/1.png')}}" />
                        </div>
                        <div class="left-bar-list-item-font"><span style="font-size: 14px;">投诉</span></div>
                    </div>
                </a>
                <a href="{{url('admin/question')}}">
                    <div  class="left-bar-list-item question"  >
                        <div class="left-bar-list-item-img"><img style="width:40%;height:40%" src="{{asset('vector/1.png')}}" />
                        </div>
                        <div class="left-bar-list-item-font"><span style="font-size: 14px;">问题</span></div>
                    </div>
                </a>
                <a href="{{url('admin/headlines')}}">
                    <div  class="left-bar-list-item headlines"  >
                        <div class="left-bar-list-item-img"><img style="width:40%;height:40%" src="{{asset('vector/1.png')}}" />
                        </div>
                        <div class="left-bar-list-item-font"><span style="font-size: 14px;">头条</span></div>
                    </div>
                </a>
                <a href="{{url('admin/order')}}">
                    <div  class="left-bar-list-item order pay unpaid complete fail"  >
                        <div class="left-bar-list-item-img"><img style="width:40%;height:40%" src="{{asset('vector/1.png')}}" />
                        </div>
                        <div class="left-bar-list-item-font"><span style="font-size: 14px;">订单</span></div>
                    </div>
                </a>
                <a href="{{url('admin/census')}}">
                    <div  class="left-bar-list-item census"  >
                        <div class="left-bar-list-item-img"><img style="width:40%;height:40%" src="{{asset('vector/1.png')}}" />
                        </div>
                        <div class="left-bar-list-item-font"><span style="font-size: 14px;">统计</span></div>
                    </div>
                </a>
                <a href="{{url('admin/invest')}}">
                    <div  class="left-bar-list-item invest drawback"  >
                        <div class="left-bar-list-item-img"><img style="width:40%;height:40%" src="{{asset('vector/1.png')}}" />
                        </div>
                        <div class="left-bar-list-item-font"><span style="font-size: 14px;">记录</span></div>
                    </div>
                </a>
                <a href="{{url('admin/config')}}">
                    <div  class="left-bar-list-item config"  >
                        <div class="left-bar-list-item-img"><img style="width:40%;height:40%" src="{{asset('vector/1.png')}}" />
                        </div>
                        <div class="left-bar-list-item-font"><span style="font-size: 14px;">配置</span></div>
                    </div>
                </a>
            </div>
            <div class="left-bar-secendlist " id="1" style="display:none">
                <div   class="left-bar-secendlist-items" >
                    <a href="{{url('admin/config')}}">
                        <div  class="left-bar-secendlist-item" id="config">
                            <span>小程序配置</span>
                            <img src="{{asset('layout/static/right_lit.png')}}" />
                        </div>
                    </a>
                    <div class="line"></div>
                </div>
            </div>
            <div class="left-bar-secendlist " id="2" style="display:none">
                <div   class="left-bar-secendlist-items" >
                    <a href="{{url('admin/order')}}">
                        <div  class="left-bar-secendlist-item" id="order">
                            <span>加急订单</span>
                            <img src="{{asset('layout/static/right_lit.png')}}" />
                        </div>
                    </a>
                    <a href="{{url('admin/pay')}}">
                        <div  class="left-bar-secendlist-item" id="pay">
                            <span>已支付订单</span>
                            <img src="{{asset('layout/static/right_lit.png')}}" />
                        </div>
                    </a>
                    <a href="{{url('admin/unpaid')}}">
                        <div  class="left-bar-secendlist-item" id="unpaid">
                            <span>待支付订单</span>
                            <img src="{{asset('layout/static/right_lit.png')}}" />
                        </div>
                    </a>
                    <a href="{{url('admin/complete')}}">
                        <div  class="left-bar-secendlist-item" id="complete">
                            <span>已完成</span>
                            <img src="{{asset('layout/static/right_lit.png')}}" />
                        </div>
                    </a>
                    <a href="{{url('admin/fail')}}">
                        <div  class="left-bar-secendlist-item" id="fail">
                            <span>已失败</span>
                            <img src="{{asset('layout/static/right_lit.png')}}" />
                        </div>
                    </a>

                    <div class="line"></div>
                </div>
            </div>
            <div class="left-bar-secendlist " id="3" style="display:none">
                <div   class="left-bar-secendlist-items" >
                    <a href="{{url('admin/invest')}}">
                        <div  class="left-bar-secendlist-item" id="invest">
                            <span>充值记录</span>
                            <img src="{{asset('layout/static/right_lit.png')}}" />
                        </div>
                    </a>
                    <a href="{{url('admin/drawback')}}">
                        <div  class="left-bar-secendlist-item" id="drawback">
                            <span>退款记录</span>
                            <img src="{{asset('layout/static/right_lit.png')}}" />
                        </div>
                    </a>
                    <div class="line"></div>
                </div>
            </div>
        </div>
        <div class="left-bar-content" style="overflow: hidden;">
            @yield('content')
        </div>
    </div>
</div>
<!-- 加载动画，移除位置在common.js中 -->
<div class="page-loading">
    <div class="ball-loader">
        <span>
            <img src="{{asset('layout/static/logo.png')}}" alt="">
        </span>
        <span>
            <img src="{{asset('layout/static/logo.png')}}" alt="">
        </span>
        <span>
            <img src="{{asset('layout/static/logo.png')}}" alt="">
        </span>
        <span>
            <img src="{{asset('layout/static/logo.png')}}" alt="">
        </span>
    </div>
</div>
</body>
<script>
    var domain = document.location.href;
    var i = domain.lastIndexOf('/');
    var href = domain.substr(i+1);
    if(href == 'config'){
        $('#1').show();
    }
    if(href == 'order' || href == 'pay' || href == 'unpaid' || href == 'complete' || href == 'fail'){
        $('#2').show();
    }
    if(href == 'invest' || href == 'drawback'){
        $('#3').show();
    }
    $('.'+href).css({'background':'#24303C','border-radius':'3px'});
    $('#'+href).find('img').show();
    $('#'+href).css({'background':'#e9eaf0'});
</script>
<script>
    $('#login_out').click(function(){
        layer.confirm('确认退出吗？', {
            btn: ['确认','取消'] //按钮
        }, function(){
            $.post("{{url('loginout')}}",function(res){
                if(res.code == 1){
                    window.location.href = "{{url('/')}}";
                }
            })
        }, function(){
            layer.closeAll();
        });

    })
</script>
<script>
    $('#edit').click(function(){
        layer.open({
            type: 2 //此处以iframe举例
            ,title: '编辑'
            ,area: ['50%', '50%']
            ,shade: 0.2
            ,maxmin: true
            ,offset: [ //为了演示，随机坐标
                ($(window).height()*0.15)
                ,($(window).width()*0.25)
            ]
            ,content:"{{url('admin/administrators')}}?type=token"
            ,btn: ['保存关闭', '取消'] //只是为了演示
            ,yes: function(){
                var index = parent.layer.getFrameIndex()
                var form = layer.getChildFrame('form', index);
                form.find('#btn1').click();
                var password = form.find('#password').val()
                var username = form.find('#username').val()
                if(!password || !username){
                    layer.closeAll();
                    layer.msg('缺少参数!',{icon: 2})
                    return;
                }
                layer.load(2);
                $.post(
                    "{{url('administrators/edit')}}/"+"{{session('admin_id')}}",
                    {username: username,password:password},
                    function(res){
                        layer.closeAll('loading');
                        if (res.code == 0) {
                            layer.closeAll();
                            layer.msg(res.msg+'请重新登录', {icon: 1});
                            $.post("{{url('loginout')}}",function(res){
                                setTimeout(function(){
                                    window.location.href="{{url('/')}}";
                                },1000);
                            })

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
    })
</script>
</html>
