<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<html>
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <base href="<?php  echo base_url();?>"/>
    <title>培训机构后台登录</title>
<style>
html, body, div, ol, ul, li, dl, dt, dd, h1, h2, h3, h4, h5, h6, input, button, textarea, p, span, table, th, td, from {
margin: 0;
padding: 0;
}
li{ list-style:none;}
.wrap{ background:url(res/images/login/wrap_bg.jpg) no-repeat center bottom; background-size:100%;background-attachment:fixed; padding-top:10%; padding-bottom:16.6%;}
.wrap .content{ width:310px; height:336px; background:#fff; }
.wrap .content .tltle_p{ color:#717a79; font-size:20px; padding:34px 0px 40px 15px; }
.wrap .content .txt{ width:224px; height:38px; outline:none; border:1px solid #ddd; margin-left:24px; background:url(res/images/login/yonghu.png) no-repeat; background-position: 5px 5px; padding-left:30px; margin-bottom:30px;}
.wrap .content .passw{ width:224px; height:38px; outline:none; border:1px solid #ddd; margin-left:24px; background:url(res/images/login/password.png) no-repeat; background-position: 5px 5px; padding-left:30px;}
.wrap .content .btn{ width:254px; height:36px; outline:none; border:none; margin-left:24px; background:#428fb9; color:#fff; font-size:16px; margin-top:36px; cursor:pointer;}
</style>
</head>
<script src="res/js/jquery-2.0.3.min.js"></script>
<script type="text/javascript">
	$(document).ready(
	           function(){
			 $("#username").focus();
			
			document.onkeydown = function(e){ 
    var ev = document.all ? window.event : e;
    if(ev.keyCode==13) {
          login();//处理事件
     }
}
			
			
			});

              function login(){
                var username = $("#username").val();
                var password = $("#password").val();
                if(username.length==0 || password.length==0){
                alert("用户名或密码不能为空！");
                 return;
                }
                $.ajax({
                      url :"login/doLogin.do",
                      type :"post",
                       dataType :"json",
                      data:{username:username,password:password},
                      success :function(data){
                           if(data.success==1){
                           window.location.href='index.do';
                           }else{
                            alert(data.msg);
                           }
                                }
                               });
				    }
			</script>
<body>
<div class="wrap">
    <div style="width:310px;margin:0 auto;">
        <img src="res/images/login/logo.png" width="213">
        <div class="content">
        	<p class="tltle_p">作业辅导后台管理系统</p>
            <form>
            	<input type="text" class="txt" placeholder="请输入您的用户名" id="username">
                <input type="password" class="passw" placeholder="密码" id="password">
                <input type="button" class="btn" value="登录" onclick="login();">
            </form>
        </div>
    </div>
</div>
</body>
</html>