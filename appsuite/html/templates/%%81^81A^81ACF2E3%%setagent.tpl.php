<?php /* Smarty version 2.6.20, created on 2011-07-13 00:22:44
         compiled from renter/setagent.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Cache-Control" content="no-cache" />
<title><?php echo $this->_tpl_vars['system_config']['site_name']; ?>
</title>
<link rel="stylesheet" href="<?php echo $this->_tpl_vars['system_config']['site_url']; ?>
/appsuite_images/install.css" type="text/css" />
<script type="text/javascript" src="<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
/script/jquery-1.3.2.min.js"></script>
<?php echo '
<script type="text/javascript">
$(function(){
});
</script>
'; ?>

</head>

<body>
<form method="post" action="<?php echo $this->_tpl_vars['system_config']['site_url']; ?>
/qnuserrenter/setagent">
	<p style="color:#FF0000;"><?php echo $this->_tpl_vars['msg']; ?>
</p>
	<table class="form-table">
		<tr>
			<th scope="row"><label for="model">工 号</label></th>
			<td><?php echo $this->_tpl_vars['userData']['workid']; ?>
</td>
			<td>您登陆坐席的工号，不能修改。</td>
		</tr>
		<tr>
			<th scope="row"><label for="nickname">姓 名</label></th>
			<td><input name="nickname" id="nickname" type="text" size="25" value="<?php echo $this->_tpl_vars['userData']['nickname']; ?>
"/></td>
			<td>CTI服务器上IP地址。请保持默认值，除非您知道如何修改。</td>
		</tr>
		<tr>
			<th scope="row"><label for="mobilephone">联系方法</label></th>
			<td><input name="mobilephone" id="mobilephone" type="text" size="25" value="<?php echo $this->_tpl_vars['userData']['mobilephone']; ?>
"/></td>
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
