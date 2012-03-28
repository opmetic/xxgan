<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Cache-Control" content="no-cache" />
<title>{$system_config.site_name}</title>
<link rel="stylesheet" href="{$system_config.site_url}/appsuite_images/install.css" type="text/css" />
<script type="text/javascript" src="{$system_config.img_url}/script/jquery-1.3.2.min.js"></script>
{literal}
<script type="text/javascript">
$(function(){
	//验证密码
	$("#setpwd").submit( function () { 
		oldpasspwrod = $("#password").val();
		newpasspwrod = $("#newpassword").val();
		newpasspwrod2 = $("#newpassword2").val();

		if (oldpasspwrod == "")
		{
			return true;
		}
		
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
{/literal}
</head>

<body>
<form id="setpwd" method="post" action="{$system_config.site_url}/qnuserrenter/setagent">
	<p style="color:#FF0000;">{$msg}</p>
	<table class="form-table">
		<tr>
			<th scope="row"><label for="model">工 号</label></th>
			<td>{$userData.workid}</td>
			<td>您登陆坐席的工号，不能修改。</td>
		</tr>
		<tr>
			<th scope="row"><label for="nickname">姓 名</label></th>
			<td><input name="nickname" id="nickname" type="text" size="25" value="{$userData.nickname}"/></td>
			<td>CTI服务器上IP地址。请保持默认值，除非您知道如何修改。</td>
		</tr>
		<tr>
			<th scope="row"><label for="mobilephone">联系方法</label></th>
			<td><input name="mobilephone" id="mobilephone" type="text" size="25" value="{$userData.mobilephone}"/></td>
			<td>你的联系方法，比如手机、固话等。</td>
		</tr>
		<tr>
			<th scope="row"><label for="password">密 码</label></th>
			<td><input name="password" id="password" type="password" size="27" value=""/></td>
			<td>您登陆坐席时使用的密码，如果不需要修改密码，则无需填写任何信息。</td>
		</tr>
		<tr>
			<th scope="row"><label for="newpassword">新密码</label></th>
			<td><input name="newpassword" id="newpassword" type="password" size="27" value=""/></td>
			<td>您需要修改成的新密码，则无需填写任何信息。</td>
		</tr>
		<tr>
			<th scope="row"><label for="newpassword2">再次输入新密码</label></th>
			<td><input name="newpassword2" id="newpassword2" type="password" size="27" value=""/></td>
			<td>您需要修改成的新密码，则无需填写任何信息。</td>
		</tr>
	</table>
		<p class="step"><input name="submit" type="submit" value="提交" class="button" /></p>   
</form>
</body>
</html>

