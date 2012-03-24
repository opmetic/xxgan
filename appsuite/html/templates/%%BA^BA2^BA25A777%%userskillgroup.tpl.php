<?php /* Smarty version 2.6.20, created on 2010-11-29 16:24:19
         compiled from userskillgroup.tpl */ ?>
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
function updateList()
{
	$.ajax({
		type: "GET",
		url: "'; ?>
<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
<?php echo '/qnuserskillgroup/jsonlist",
		dataType: "json",
		data: {factoryid: $("#factoryid").val()},
		success: function(msg){

			$("#userid").empty();// 清空下拉框
			for(var i=0; i<msg.length; i++)
			{
			
				$("#userid").append("<option value=\'" + msg[i].uid + "\'>" + msg[i].username + "[" + msg[i].nickname + "]</option>"); 
			}
		}
	}); 
}
$(function(){
	$("#factoryid").change(function(){
		updateList();
	});
	updateList();
});
	</script>
'; ?>

</head>

<body style="background:#FFFFFF;">
<div style="background:#FFFFFF;padding:10px;">
    <form id="editscript" method="post" action="<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
/qnuserskillgroup/list">
	<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['phoneData']['phone_id']; ?>
"/>
	<table cellpadding="10" cellspacing="10" style="border:#ffff99 1px dotted;" width="100%">
		<tr>
			<td align="right" width="50" >公司:</td>
			<td width="250">
				<select id="factoryid" name="factoryid" style="width:230px;">
					<?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['listloop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['listloop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['listloop']['iteration']++;
?>
					<option value="<?php echo $this->_tpl_vars['item']['factory_id']; ?>
" <?php if ($this->_tpl_vars['id'] == $this->_tpl_vars['item']['factory_id']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['item']['factory_name']; ?>
</option>
					<?php endforeach; endif; unset($_from); ?>
				</select>
			</td>
			<td width="50" align="right"> 用户: </td>
			<td width="150">
				<select id="userid" name="userid" style="width:200px;">
				</select>
			</td>
			<td><input type="submit" name="submit" value="确定"/></td>
		</tr>
	</table>
    </form>
</div>

<?php echo '
'; ?>


</body>

</html>
