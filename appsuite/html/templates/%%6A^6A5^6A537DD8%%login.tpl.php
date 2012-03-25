<?php /* Smarty version 2.6.20, created on 2012-03-26 00:49:40
         compiled from login.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Cache-Control" content="no-cache" />
<title><?php echo $this->_tpl_vars['system_config']['site_name']; ?>
</title>
<link type="text/css" href="<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
/images/jquery-ui-1.7.2.custom.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
/script/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
/script/jquery-ui-1.7.2.custom.min.js"></script>

<!-- easyui -->
<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
/client_images/themes/default/easyui.css">
<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
/client_images/themes/icon.css">
<script type="text/javascript" src="<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
/client_script/jquery.easyui.min.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
/client_script/easyloader.js"></script>

<?php echo '
<style type="text/css">
body { margin : 0px; background: #ffffff; font-size:12px; text-align:center;}/*4499ee*/
a {color:#097bf0; text-decoration:none;}
a:hover { color:#f98821; text-decoration:underline;}
div {margin: 0px; padding: 0px;}

.qn_all { margin : 0px; padding: 0px; border:#000000 0px solid;}
.qn_head { height: 33px; background: #0078ae url('; ?>
<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
<?php echo '/images/ui-bg_glass_45_0078ae_1x400.png) 50% 50% repeat-x; font-weight: normal; color: #b1c0c2; outline: none; padding:0px}
.qn_head .logo_div {padding: 0px; margin: 0px; height: 33px; width:142px; float:left;}
.qn_head .content_div{float: right; padding:0px; margin: 0 5px 0 0; width:auto; height:33px; text-align: right;}

.login {background:#4499ee url('; ?>
<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
<?php echo '/images/loginback.gif) 50% 50% repeat-x; padding:120px 0 0 0; color: #ffffff;}
.loginboard {border:#FFFFFF 0px solid;background: url('; ?>
<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
<?php echo '/images/loginboard.gif); text-align: left; height: 258px; width:560px; margin: 0 auto; }
.loginboard input{ border:0px;}
.username {margin: 94px auto 0 138px ; width:174px;}
.userpwd {margin: 18px auto 0 138px !important ; margin: 14px auto 0 138px; width:174px;}
.submit {color:#ffffff; margin: 21px auto 0 80px !important ; margin: 20px auto 0 80px;height: 26px; width:88px; 
background-image: url('; ?>
<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
<?php echo '/images/loginboard.gif); background-position: -80px -170px;
}
.reset {margin: 21px auto 0 30px !important ; margin: 20px auto 0 33px;height: 26px; width: 88px; 
background-image: url('; ?>
<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
<?php echo '/images/loginboard.gif); background-position: -205px -170px;
}
.alert {margin: 0 0 0 130px; color: #ff3300;}

.form-table {
	margin-left: 20px;
	margin-top: 20px;
}

.form-table th {
font-size:15px;
text-align: left;
padding: 16px 10px 10px;
/*border-bottom:8px solid #ffffff;*/
width:100px;
color: #0099CC;
}

.form-table td {
font-size:12px;
text-align: left;
padding: 10px;
/*border-bottom:8px solid #ffffff;*/
margin-bottom: 9px;
color: #808080;
}

.form-table input {
line-height: 20px;
font-size: 15px;
padding: 2px;
}

</style>

<script type="text/javascript">
$(function() {
    $("#username").focus();
	clientHeight = $(window).height();
	$(".login").height(clientHeight - 33 - 120);

	$("#loginform").submit(function(){
		if ($(".username").val() == "" ||$(".userpwd").val() == "")
		{
			alert("用户名 或 密码 不能为空！");
			return false;
		} 
		return true;
	});
	
	$(\'#lockscreem_window\').window({
		collapsible: false,
		minimizable: false,
		maximizable: false,
		closable: true,
		modal: true,
		shadow: false,
		closed: true
		});

	'; ?>
<?php if ($this->_tpl_vars['setpwd']): ?>
	alert("<?php echo $this->_tpl_vars['setpwd']; ?>
");
	<?php echo '
	$(\'#lockscreem_window\').window({
		collapsible: false,
		minimizable: false,
		maximizable: false,
		closable: true,
		modal: true,
		shadow: false,
		closed: false
	});
	'; ?>
<?php endif; ?><?php echo '
	

	$(".form-table tr").mouseover(function(){
        $(this).css("background-color" , "#e0e0e0");    
    });
	$(".form-table tr").mouseout(function(){
		$(this).css("background-color" , "#ffffff");    
    });	

	//验证密码
	$("#setpwd").submit( function () { 
		oldpasspwrod = $("#oldpasspwrod").val();
		newpasspwrod = $("#newpasspwrod").val();
		newpasspwrod2 = $("#newpasspwrod2").val();

		if (newpasspwrod != newpasspwrod2)
		{
			alert("错误:两次输入密码不一致!");
			return false;
		}

		if (newpasspwrod == oldpasspwrod)
		{
			alert("错误:输入的新密码和原密码一致!");
			return false;
		}

		if (newpasspwrod.length < 6 || newpasspwrod.length > 8)
		{
			alert("错误:新密码长度不符合要求! 要求长度6位-8位");
			return false;
		}

		var jgpattern =/^[A-Za-z0-9]+$/; //只能是字母和数字
		if (!jgpattern.test(newpasspwrod))
		{
			alert("错误:新密码格式不符合要求! 要求由 字母 和 数字 组成");
			return false;
		}
		var jgpattern2 = /^.*[A-Za-z]+.*$/; //必须有一个字母
		if (!jgpattern2.test(newpasspwrod))
		{
			alert("错误:新密码格式不符合要求! 要求至少含有一个字母");
			return false;
		}

		var jgpattern3 = /^.*[0-9]+.*$/; //必须有一个数字
		if (!jgpattern3.test(newpasspwrod))
		{
			alert("错误:新密码格式不符合要求! 要求至少含有一个数字");
			return false;
		}
		
        return true;
    });
});
</script>
'; ?>


<?php echo '
<script type="text/javascript" event="OnCompleted(hResult,pErrorObject, pAsyncContext)" for="foo"> 
</script>

<script type="text/javascript">
    $("#locator").empty();// 清空
    $("#foo").empty();// 清空
</script>

<script type="text/javascript" event=OnObjectReady(objObject,objAsyncContext) for="foo"> 
    if(objObject.IPEnabled != null && objObject.IPEnabled != "undefined" && objObject.IPEnabled == true) 
    { 
        if(objObject.MACAddress != null && objObject.MACAddress != "undefined") 
        MACAddr = objObject.MACAddress; 
        if(objObject.IPEnabled && objObject.IPAddress(0) != null && objObject.IPAddress(0) != "undefined") 
        {
            $("#ip").val(objObject.IPAddress(0));
        }
        if(objObject.DNSHostName != null && objObject.DNSHostName != "undefined") 
        sDNSName = objObject.DNSHostName; 
    } 
</script>


'; ?>

</head>

<body>
<OBJECT id=locator classid=CLSID:76A64158-CB41-11D1-8B02-00600806D9B6 VIEWASTEXT  height=0 width=0></OBJECT>
<OBJECT id=foo classid=CLSID:75718C9A-F029-11d1-A1AC-00C04FB6C223  height=0 width=0></OBJECT>
<?php echo '
<script type="text/javascript"> 
    var service = locator.ConnectServer(); 
    var MACAddr ; 
    var IPAddr ; 
    var DomainAddr; 
    var sDNSName; 
    service.Security_.ImpersonationLevel = 3; 
    service.InstancesOfAsync(foo, "Win32_NetworkAdapterConfiguration"); 
</script>
'; ?>



</head>

<body>
<div id="qn_all" class="qn_all">
  <!-- head -->
  <div id="qn_head" class="qn_head">
    <div class="logo_div"><img src="<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
/images/logo.gif"/></div>
    <div class="content_div"><span>IP:<?php echo $this->_tpl_vars['ip']; ?>
</span></div>
  </div>
  <div class="login">
	  <div class="loginboard">
	  <form id="loginform" action="<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
/access/login" method="POST">
	        <input class="username" name="username" type="text" /><br/>
	  	    <input class="userpwd" name="userpwd" type="password" /><br/>
	  	    <input class="submit" type="submit" name="submit" value=" " />
	  	    <input class="reset" type="reset" name="submit" value=" "/>
            <input type="hidden" name="ip" id="ip" value=""/>
	  	    <input type="hidden" name="act" value="submit" />
	  </form>
	  <?php if ($this->_tpl_vars['alert']): ?><span class="alert"><?php echo $this->_tpl_vars['alert']; ?>
</span><?php endif; ?>
	  </div>
      <!--
	  <span> 
            <select id="localIP" name="localIP">
            </select>
      </span>
      -->
      <br/><br/><br/><br/><span>@2011 www.ChannelSoft.com</span>
  </div>
</div>

<!-- 修改密码 -->
<div id="lockscreem_window" closed="true" modal="true" title="修改密码" style="width:550px;height:300px;text-align :left;">
	<form id="setpwd" action="<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
/access/resetpassword" method="POST">
		<table class="form-table">
			<tr >
				<th>原密码：</th>
				<td><input type="password" name="oldpasspwrod" id="oldpasspwrod"></input></td>
				<td style="width: 150px">原密码</td>
			</tr>
			<tr>
				<th>新密码：</th>
				<td><input type="password" name="newpasspwrod" id="newpasspwrod"></input></td>
				<td id="newpasspwroddsc">密码要求由字母和数字组成，长度6位至8位</td>
			</tr>
			<tr>
				<th>再次新密码：</th>
				<td><input type="password" name="newpasspwrod2" id="newpasspwrod2"></input></td>
				<td id="newpasspwroddsc2">请再输入一次新密码</td>
			</tr>
		</table>
		<input type="hidden" id="userid" name="userid" value="<?php echo $this->_tpl_vars['user']['uid']; ?>
"/>
		<input type="hidden" id="userid" name="workid" value="<?php echo $this->_tpl_vars['user']['workid']; ?>
"/>
		<input style="margin-left:100px; margin-top:10px;" type="submit" name="submit" value="提交" />
		<input style="margin-left:50px; margin-top:10px;" type="reset" name="reset" value="重填" />
	</form>

</div>
<!-- 锁屏 end -->
		

</div><!--qn_all -->
<div id="databuf"></div>
</body>
</html>