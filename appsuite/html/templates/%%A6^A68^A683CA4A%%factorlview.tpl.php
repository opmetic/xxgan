<?php /* Smarty version 2.6.20, created on 2011-03-25 09:40:42
         compiled from factorlview.tpl */ ?>
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

	$(\'#listtab\').datagrid({ 
		striped: true,
		singleSelect : true
	});
});
	</script>
'; ?>

</head>

<body style="background:#FFFFFF;">
<div style="background:#FFFFFF;padding:10px;">
	<table cellpadding="10" cellspacing="10">
		<tr>
			<td align="right" width="100" >公司名:</td>
			<td><?php echo $this->_tpl_vars['factoryData']['factory_name']; ?>
</td>
			<td> </td>
		</tr>
		<tr>
			<td align="right">公司代码:</td>
			<td><?php echo $this->_tpl_vars['factoryData']['factory_enterprisecode']; ?>
</td>
			<td></td>
		
		</tr>
		<tr>
			<td align="right">接入码:</td>
			<td><?php echo $this->_tpl_vars['factoryData']['factory_code']; ?>
</td>
			<td> </td>
		</tr>
		<tr>
			<td align="right">接入密码:</td>
			<td><?php echo $this->_tpl_vars['factoryData']['factory_pwd']; ?>
</td>
			<td> </td>
		</tr>
		<tr>
			<td align="right">是否定制:
			
			</td>
			<td>
				<?php if ($this->_tpl_vars['factoryData']['factory_userdefined'] == 0): ?>否<?php else: ?>是<?php endif; ?>

			</td>
			<td</td>
		</tr>

	</table>
	
	分机号列表：
	<table id="listtab" fit="true">
		<thead>
			<tr>
				<th field="f1" width="60"></th>
				<th field="f2" width="100">分机号</th>
				<th field="f3" width="200">所属公司</th>
				<th field="f4" width="100">当前被使用</th>
			</tr>
		</thead>
		<tbody>
		<?php $_from = $this->_tpl_vars['phoneData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['listloop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['listloop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['listloop']['iteration']++;
?>
			<tr>
				<td><?php echo $this->_foreach['listloop']['iteration']; ?>
</td>
				<td><?php echo $this->_tpl_vars['item']['phone_num']; ?>
</td>
				<td><?php echo $this->_tpl_vars['factoryData']['factory_name']; ?>
</td>
				<td><?php echo $this->_tpl_vars['item']['phone_status']; ?>
</td>
			</tr>
		<?php endforeach; endif; unset($_from); ?>
		</tbody>
	</table>
</div>

<?php echo '
'; ?>


</body>

</html>
