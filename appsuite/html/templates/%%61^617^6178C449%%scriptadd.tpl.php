<?php /* Smarty version 2.6.20, created on 2011-07-04 11:27:12
         compiled from renter/scriptadd.tpl */ ?>
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
	$("#flag").change(function(){
		if ($("#flag").val() == 0)
		{
			$("#script_key_1").show();
			$("#script_key_2").hide();
		}
		else
		{	$("#script_key_2").show();
			$("#script_key_1").hide();
		}
	});
});
	</script>
'; ?>

</head>

<body style="background:#FFFFFF;">
<div style="background:#FFFFFF;padding:10px;">
    <form id="editscript" method="post" action="<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
/scriptrenter/adddo">
	<input type="hidden" name="uid" value="<?php echo $this->_tpl_vars['userData']['uid']; ?>
" />
	<table cellpadding="10" cellspacing="10">
		<tr>
			<td align="right" width="100" >所属公司:</td>
			<td><?php echo $this->_tpl_vars['userData']['factory_name']; ?>
</td>
			<td> </td>
		</tr>
		<tr>
			<td align="right">所属用户:</td>
			<td><?php echo $this->_tpl_vars['userData']['nickname']; ?>
</td>
			<td> </td>
		
		</tr>
		<tr>
			<td align="right">脚本名:</td>
			<td><input class="easyui-validatebox" type="text" name="script_name"></input></td>
			<td> </td>
		</tr>
		<tr>
			<td align="right">脚本键:</td>
			<td>
				<select name="flag" id="flag">
					<option value="0">常规脚本</option>
					<option value="1">自定义脚本</option>
				</select>
			</td>
			<td> </td>
		</tr>
		<tr id="script_key_1">
			<td align="right">常规脚本键:</td>
			<td>
				<select name="script_key_com" id="script_key_com">
					<?php $_from = $this->_tpl_vars['qnsoft_script_type']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['listloop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['listloop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['listloop']['iteration']++;
?>
					<option value="<?php echo $this->_tpl_vars['item']['type']; ?>
"><?php echo $this->_tpl_vars['item']['dsc']; ?>
</option>
					<?php endforeach; endif; unset($_from); ?>
				</select>
			</td>
			<td> </td>
		</tr>
		<tr id="script_key_2" style="display:none;">
			<td align="right">自定义脚本键:</td>
			<td><input class="easyui-validatebox" type="text" name="script_key"></input></td>
			<td> </td>
		</tr>
		<tr>
			<td align="right">脚本描述:</td>
			<td><textarea required="true" rows="3" cols="100" name="script_dsc"></textarea></td>
			<td> </td>
		</tr>
		<tr>
			<td align="right">脚本内容:</td>
			<td><textarea required="true" rows="22" cols="100" name="script_info" style="word-wrap:normal;overflow :auto;"></textarea></td>
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
