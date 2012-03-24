<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Cache-Control" content="no-cache" />
<title>{$system_config.site_name}</title>
<link type="text/css" href="{$system_config.img_url}/images/jquery-ui-1.7.2.custom.css" rel="stylesheet" />
<script type="text/javascript" src="{$system_config.img_url}/script/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="{$system_config.img_url}/script/jquery-ui-1.7.2.custom.min.js"></script>

{literal}
<style type="text/css">
body { margin : 0px; background: #ffffff; font-size:12px; text-align:center;}/*4499ee*/
a {color:#097bf0; text-decoration:none;}
a:hover { color:#f98821; text-decoration:underline;}
div {margin: 0px; padding: 0px;}

.qn_all { margin : 0px; padding: 0px; border:#000000 0px solid;}
.qn_head { height: 33px; background: #0078ae url({/literal}{$system_config.img_url}{literal}/images/ui-bg_glass_45_0078ae_1x400.png) 50% 50% repeat-x; font-weight: normal; color: #b1c0c2; outline: none; padding:0px}
.qn_head .logo_div {padding: 0px; margin: 0px; height: 33px; width:142px; float:left;}
.qn_head .content_div{float: right; padding:0px; margin: 0 5px 0 0; width:auto; height:33px; text-align: right;}

.login {background:#4499ee url({/literal}{$system_config.img_url}{literal}/images/loginback.gif) 50% 50% repeat-x; padding:120px 0 0 0; color: #ffffff;}
.loginboard {border:#FFFFFF 0px solid;background: url({/literal}{$system_config.img_url}{literal}/images/loginboard.gif); text-align: left; height: 258px; width:560px; margin: 0 auto; }
.loginboard input{ border:0px;}
.username {margin: 94px auto 0 138px ; width:174px;}
.userpwd {margin: 18px auto 0 138px !important ; margin: 14px auto 0 138px; width:174px;}
.submit {color:#ffffff; margin: 21px auto 0 80px !important ; margin: 20px auto 0 80px;height: 26px; width:88px; 
background-image: url({/literal}{$system_config.img_url}{literal}/images/loginboard.gif); background-position: -80px -170px;
}
.reset {margin: 21px auto 0 30px !important ; margin: 20px auto 0 33px;height: 26px; width: 88px; 
background-image: url({/literal}{$system_config.img_url}{literal}/images/loginboard.gif); background-position: -205px -170px;
}
.alert {margin: 0 0 0 130px; color: #ff3300;}
</style>

<script type="text/javascript">
$(function() {
    $("#username").focus();
	clientHeight = $(window).height();
	$(".login").height(clientHeight - 33 - 120);
});
</script>
{/literal}
</head>

<body>
<div id="qn_all" class="qn_all">
  <!-- head -->
  <div id="qn_head" class="qn_head">
    <div class="logo_div"><img src="{$system_config.img_url}/images/logo.gif"/></div>
    <div class="content_div"><span>IP:{$ip}</span></div>
  </div>
  <div class="login">
	  <div class="loginboard">
	  <form action="{$system_config.img_url}/access/login" method="POST">
	        <input class="username" name="username" type="text" /><br/>
	  	    <input class="userpwd" name="userpwd" type="password" /><br/>
	  	    <input class="submit" type="submit" name="submit" value=" " />
	  	    <input class="reset" type="reset" name="submit" value=" "/>
	  	    <input type="hidden" name="act" value="submit" />
	  </form>
	  {if $alert}<span class="alert">{$alert}</span>{/if}
	  </div>
	  <span>@2010 www.ChannelSoft.com </span>
  </div>
</div>

</div><!--qn_all -->
<div id="databuf"></div>
</body>
</html>
