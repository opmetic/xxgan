<?php /* Smarty version 2.6.20, created on 2011-01-18 14:38:24
         compiled from factorledit.tpl */ ?>
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
function addPhone(id)
{
	parent.updateWindows("新增分机", "'; ?>
<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
<?php echo '/qnphone/add/id/" + id, true);
}
	</script>
'; ?>

</head>

<body style="background:#FFFFFF;">
<div style="background:#FFFFFF;padding:10px;">
    <form id="editscript" method="post" action="<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
/qnfactory/edit">
	<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['factoryData']['factory_id']; ?>
" />
	<table cellpadding="10" cellspacing="10">
		<tr>
			<td align="right" width="100" >公司名:</td>
			<td><input class="easyui-validatebox" type="text" name="name" required="true" width="200" value="<?php echo $this->_tpl_vars['factoryData']['factory_name']; ?>
"></input></td>
			<td> </td>
		</tr>
		<tr>
			<td align="right">公司代码:</td>
			<td><?php echo $this->_tpl_vars['factoryData']['factory_enterprisecode']; ?>
</td>
			<td> </td>
		
		</tr>
		<tr>
			<td align="right">VCID:</td>
			<td><input class="easyui-validatebox" type="text" name="code" value="<?php echo $this->_tpl_vars['factoryData']['factory_code']; ?>
"></input></td>
			<td> </td>
		</tr>
		<tr>
			<td align="right">是否定制:</td>
			<td>
				<select id="userdefined" name="userdefined">
					<option value="0" <?php if ($this->_tpl_vars['factoryData']['factory_userdefined'] == 0): ?>selected<?php endif; ?>>否</option>
					<option value="1" <?php if ($this->_tpl_vars['factoryData']['factory_userdefined'] == 1): ?>selected<?php endif; ?>>是</option>
				</select>
			</td>
			<td>如定项选择为 "是" ,需有开发人号配合</td>
		</tr>
		<tr>
			<td align="right"> </td>
			<td><input type="submit" name="submit" id="submit" value="提交"></td>
			<td> </td>
		</tr>
	</table>
    </form>
	分机号列表：
	［<a href="javascript:addPhone(<?php echo $this->_tpl_vars['factoryData']['factory_id']; ?>
)">增加分机</a>］
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
