<?php /* Smarty version 2.6.20, created on 2010-12-13 04:57:49
         compiled from scriptedit.tpl */ ?>
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
	
});
	</script>
'; ?>

</head>

<body style="background:#FFFFFF;">
<div style="background:#FFFFFF;padding:10px;">
    <form id="editscript" method="post" action="<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
/script/edit">
	<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['scriptData']['scriptdb_id']; ?>
" />
	<table cellpadding="10" cellspacing="10">
		<tr>
			<td align="right">所属用户:</td>
			<td><?php echo $this->_tpl_vars['scriptData']['nickname']; ?>
</td>
			<td> </td>
		
		</tr>
		<tr>
			<td align="right">脚本名:</td>
			<td><input class="easyui-validatebox" type="text" name="script_name" value="<?php echo $this->_tpl_vars['scriptData']['scriptdb_name']; ?>
"></input></td>
			<td> </td>
		</tr>
		
		<tr >
			<td align="right">脚本键:</td>
			<td><?php echo $this->_tpl_vars['scriptData']['scriptdb_key']; ?>
</td>
			<td> </td>
		</tr>
		<tr>
			<td align="right">脚本描述:</td>
			<td><textarea required="true" rows="3" cols="100" name="script_dsc"><?php echo $this->_tpl_vars['scriptData']['scriptdb_dsc']; ?>
</textarea></td>
			<td> </td>
		</tr>
		<tr>
			<td align="right">脚本内容:</td>
			<td><textarea required="true" rows="22" cols="100" name="script_info" style="word-wrap:normal;overflow :auto;"><?php echo $this->_tpl_vars['scriptData']['scriptdb_info']; ?>
</textarea></td>
			<td> </td>
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
