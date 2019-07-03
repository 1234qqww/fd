<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{asset('login/c/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('login/c/login/login.css')}}">
    <link rel="stylesheet" href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.css">
    <script src="{{asset('login/j/js/jquery.js')}}"></script>
    <script src="{{asset('login/j/js/bootstrap.js')}}"></script>
    <script type="text/javascript" src="{{asset('easyweb/assets/libs/layui/layui.js')}}"></script>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>管理员登录</title>
</head>
<body>
<div>
    <div class="be-content pren">
        <div class="ioc_text">
            <span style="font-size: 20px;">请登录</span>
        </div>
        <div>
            <form action="javascript:;" id="formid">
                <div class="br-content">
                    <div class="input-group mb-4 bootint">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                        </div>
                        <input type="text" id="name" class="form-control" placeholder="用户名">
                    </div>
                    <div class="input-group mb-4 bootint">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-unlock-alt"></i></span>
                        </div>
                        <input type="password" id="password" class="form-control" placeholder="密码">
                    </div>
                    <div style="padding-top: 10px">
                        <input type="button"  id="submit" class="btn"  value="登录">
                    </div>
                    <div class="be-con">
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
</body>
<script>
    $('#submit').click(function(){
        var name = $('#name').val();
        var password = $('#password').val();
        if(!name || !password){
            layui.use('table', function(){
                var table = layui.table;
                layer.msg('信息不完整');
            });
            return;
        }
        $.post("{{url('logincheck')}}",{name:name,password:password},function(res){
            if(res['code']  == 0){
                window.location.href="{{url('admin')}}";
            }else{
                layui.use('table', function(){
                    var table = layui.table;
                    layer.msg(res['msg']);
                });
            }
        })
    })

</script>
</html>