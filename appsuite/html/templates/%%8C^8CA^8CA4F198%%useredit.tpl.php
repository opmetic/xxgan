<?php /* Smarty version 2.6.20, created on 2011-07-18 14:32:40
         compiled from renter/useredit.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Cache-Control" content="no-cache" />
<title><?php echo $this->_tpl_vars['system_config']['site_name']; ?>
</title>
<link type="text/css" href="<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
/appsuite_images/jquery-ui-1.8.1.custom.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
/appsuite_script/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
/appsuite_script/jquery-ui-1.8.1.custom.min.js"></script>

<!-- css -->
<link type="text/css" href="<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
/appsuite_images/admin.css" rel="stylesheet" />

<!-- easyui -->
<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
/appsuite_images/themes/default/easyui.css">
<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
/appsuite_images/themes/icon.css">
<script type="text/javascript" src="<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
/appsuite_script/jquery.easyui.min.js"></script>

<?php echo '
	<script>
$(function(){
    $("#editscript").submit( function () {
 
        if (!$("#nickname").val())
        {
            alert("用户名不能为空");
            return false;
        }     
        if (!$("#plain").val())
        {
            alert("平台工号不能为空");
            return false;
        }     
        if ( !$("#pwdplaintext").val() )
        {
            alert("用户密码不能为空");
            return false;
        }  
        return true;
    } ); 
});
	</script>
'; ?>

</head>

<body style="background:#FFFFFF;">
<div style="background:#FFFFFF;padding:10px;">
    <form id="editscript" method="post" action="<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
/qnuserrenter/edit">
	<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['userData']['uid']; ?>
" />
	<input type="hidden" name="factoryid" value="<?php echo $this->_tpl_vars['factoryData']['factory_id']; ?>
" />
	<table cellpadding="10" cellspacing="10">
		<tr>
			<td align="right" width="100" >用户工号:</td>
			<td><?php echo $this->_tpl_vars['userData']['workid']; ?>
</td>
			<td><span style="color:#FF0000;">*</span>座席登陆时使用的工号</td>
		</tr>
		<tr>
			<td align="right">用户角色:</td>
			<td>
				<select id="role" name="role">
					<option value="1" <?php if ($this->_tpl_vars['userData']['role'] == 1): ?>selected<?php endif; ?>>班长座席</option>
					<option value="2" <?php if ($this->_tpl_vars['userData']['role'] == 2): ?>selected<?php endif; ?>>普通座席</option>
				</select>
			</td>
			<td> </td>
		</tr>
		<tr>
			<td align="right">用户姓名:</td>
			<td><input class="easyui-validatebox" type="text" name="nickname" id="nickname" value="<?php echo $this->_tpl_vars['userData']['nickname']; ?>
"></input></td>
			<td><span style="color:#FF0000;">*</span></td>
		</tr>
        <tr>
            <td align="right">用户密码:</td>
            <td><input class="easyui-validatebox" type="text" name="pwdplaintext" id="pwdplaintext" value="<?php echo $this->_tpl_vars['userData']['pwdplaintext']; ?>
"></input></td>
            <td><span style="color:#FF0000;">*</span></td>
        </tr>
		<tr>
			<td align="right">所属公司:	</td>
			<td>
				<?php echo $this->_tpl_vars['factoryData']['factory_name']; ?>

			</td>
			<td></td>
		</tr>
        <tr>
            <td align="right">平台工号:</td>
            <td><input class="easyui-validatebox" type="text" id="plain" name="plain" value="<?php echo $this->_tpl_vars['userData']['plain']; ?>
"></input></td>
            <td><span style="color:#FF0000;">*</span>由平台提供</td>
        </tr>
		<tr>
            <td align="right">平台密码:</td>
            <td><input class="easyui-validatebox" type="text" id="plain_pwd" name="plain_pwd" value="<?php echo $this->_tpl_vars['userData']['plain_pwd']; ?>
"></input></td>
            <td><span style="color:#FF0000;">*</span></td>
        </tr>
		<tr>
			<td align="right" valign="top">技能组:</td>
			<td id="skills">
			<?php $_from = $this->_tpl_vars['skillsData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['listloop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['listloop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['listloop']['iteration']++;
?>
			<input type="checkbox" name="skillarray[]" value="<?php echo $this->_tpl_vars['item']['skill_id']; ?>
" <?php echo $this->_tpl_vars['item']['checked']; ?>
><?php echo $this->_tpl_vars['item']['skill_name']; ?>
<br/>
			<?php endforeach; endif; unset($_from); ?>
			</td>
			<td><span style="color:#FF0000;"> </span></td>
		</tr>
		<tr>
			<td align="right"> </td>
			<td><input type="submit" name="submit" value="提交"></td>
			<td> </td>
		</tr>
	</table>
    </form>
</div>

<?php echo '
'; ?>


</body>

</html>
