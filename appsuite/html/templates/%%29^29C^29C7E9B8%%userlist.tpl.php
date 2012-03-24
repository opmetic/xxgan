<?php /* Smarty version 2.6.20, created on 2011-03-18 07:57:34
         compiled from userlist.tpl */ ?>
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

	$(\'#userlisttab\').datagrid({ 
		striped: true,
		singleSelect : true
	});
});
 
 function viewDle(title, id)
{
	parent.updateWindows("查看 " + title, "'; ?>
<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
<?php echo '/qnuser/show/id/" + id, true);
}

function editDle(title, id)
{
	parent.updateWindows("编辑 " + title, "'; ?>
<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
<?php echo '/qnuser/edit/id/" + id, true);
}

function confirmDle(id)
{
	var bln = window.confirm("确定删除吗?");
	if (bln)
	{
		location.href = "'; ?>
<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
<?php echo '/qnuser/del/id/" + id;
	}
}
function lock(id)
{
    var bln = window.confirm("确定冻结该坐席吗?");
    if (bln)
    {
        location.href = "'; ?>
<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
<?php echo '/qnuser/lock/id/" + id;
    }
}
function unlock(id)
{
    var bln = window.confirm("确定恢复该坐席吗?");
    if (bln)
    {
        location.href = "'; ?>
<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
<?php echo '/qnuser/unlock/id/" + id;
    }
}
</script>
'; ?>

</head>

<body style="background:#FFFFFF;">
<div style="background:#FFFFFF;padding:10px;">

<table id="userlisttab" fit="true">
	<thead>
		<tr>
			<th field="f1" width="30"> </th>
			<th field="f2" width="60">用户工号</th>
			<th field="f3" width="60">用户名</th>
			<th field="f4" width="60">用户角色</th>
			<th field="f5" width="60">用户姓名</th>
			<th field="f6" width="160">所属公司</th>
            <th field="f7" width="160">技能组</th>
			<th field="f8" width="100">平台工号</th>
			<th field="f9" width="100">默认分机号</th>
            <th field="f10" width="60">状态</th>
			<th field="f11"width="100"></th>
		</tr>
	</thead>
	<tbody>
	<?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['listloop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['listloop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['listloop']['iteration']++;
?>
		<tr>
			<td><?php echo $this->_foreach['listloop']['iteration']; ?>
</td>
			<td><a href="javascript:viewDle('<?php echo $this->_tpl_vars['item']['nickname']; ?>
', <?php echo $this->_tpl_vars['item']['uid']; ?>
);"><?php echo $this->_tpl_vars['item']['workid']; ?>
</a></td>
			<td><?php echo $this->_tpl_vars['item']['username']; ?>
</td>
			<td><?php echo $this->_tpl_vars['item']['role_txt']; ?>
</td>
			<td><?php echo $this->_tpl_vars['item']['nickname']; ?>
</td>
			<td><?php echo $this->_tpl_vars['item']['factory_name']; ?>
</td>
            <td><?php echo $this->_tpl_vars['item']['skills']; ?>
</td>
			<td><?php echo $this->_tpl_vars['item']['plain']; ?>
</td>
			<td><?php echo $this->_tpl_vars['item']['phone_num']; ?>
</td>
            <td><?php if ($this->_tpl_vars['item']['uflag'] == 0): ?>正常<?php else: ?>已冻结<?php endif; ?></td>
			<td>
				<a href="javascript:editDle('<?php echo $this->_tpl_vars['item']['nickname']; ?>
', <?php echo $this->_tpl_vars['item']['uid']; ?>
)">编辑</a>
				<a href="javascript:confirmDle(<?php echo $this->_tpl_vars['item']['uid']; ?>
)">删除</a>
                <?php if ($this->_tpl_vars['item']['uflag'] == 0): ?>
                    <a href="javascript:lock(<?php echo $this->_tpl_vars['item']['uid']; ?>
)">冻结</a>
                <?php else: ?>
                    <a href="javascript:unlock(<?php echo $this->_tpl_vars['item']['uid']; ?>
)">恢复</a>
                <?php endif; ?>
			</td>
		</tr>
	<?php endforeach; endif; unset($_from); ?>
	</tbody>
</table>
<div style="float: right;"><?php echo $this->_tpl_vars['page_str']; ?>
</div> 
</div>
</body>

</html>
