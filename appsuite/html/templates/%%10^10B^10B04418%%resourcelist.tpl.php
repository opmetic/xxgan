<?php /* Smarty version 2.6.20, created on 2011-03-15 17:29:25
         compiled from renter/resourcelist.tpl */ ?>
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
<script type="text/javascript">
$(function(){
	$(\'#listtab\').datagrid({ 
		striped: true,
		singleSelect : true    
	});
    
    $("#resource_type").val('; ?>
'<?php echo $this->_tpl_vars['sourcetype']; ?>
'<?php echo ');
});

function updateList()
{
     location.href = "'; ?>
<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
<?php echo '/qnresourcerenter/list/sourcetype/" + $("#resource_type").val();
}
 
function viewDle(title, id)
{
	parent.updateWindows("查看 " + title, "'; ?>
<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
<?php echo '/qnresourcerenter/show/id/" + id, true);
}

function editDle(title, id)
{
	parent.updateWindows("编辑 " + title, "'; ?>
<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
<?php echo '/qnresourcerenter/edit/id/" + id, true);
}

function confirmDle(id)
{
	var bln = window.confirm("确定删除吗?");
	if (bln)
	{
		location.href = "'; ?>
<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
<?php echo '/qnresourcerenter/del/id/" + id;
	}
}
</script>
'; ?>

</head>

<body style="background:#FFFFFF;">
<div style="background:#FFFFFF;padding:10px;">

<table id="listtab" fit="true">
	<thead>
		<tr>
			<th field="f1" width="60"></th>
			<th field="f2" width="160">资源名</th>
			<th field="f3" width="160">
                 <select id="resource_type" name="resource_type" onchange="javascript:updateList();">
                    <option value="all" >所有资源</option>
                    <?php $_from = $this->_tpl_vars['resource_type_array']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['listloop2'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['listloop2']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key2'] => $this->_tpl_vars['item2']):
        $this->_foreach['listloop2']['iteration']++;
?>
                    <option value="<?php echo $this->_tpl_vars['key2']; ?>
"><?php echo $this->_tpl_vars['item2']; ?>
</option>
                    <?php endforeach; endif; unset($_from); ?>
                </select>
            </th>
            <th field="f4" width="160">所属厂商</th>   
            <th field="f5" width="160">资源描述</th> 
			<th field="f6" width="160"></th>
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
			<td><?php echo $this->_tpl_vars['item']['resource_name']; ?>
</td>
			<td><?php echo $this->_tpl_vars['item']['type_txt']; ?>
</td>
            <td><?php echo $this->_tpl_vars['item']['factory_name']; ?>
</td> 
            <td><?php echo $this->_tpl_vars['item']['resource_dsc']; ?>
</td> 
			<td>
				<a href="javascript:editDle('<?php echo $this->_tpl_vars['item']['resource_name']; ?>
', <?php echo $this->_tpl_vars['item']['resource_id']; ?>
)">编辑</a>
				<a href="javascript:confirmDle(<?php echo $this->_tpl_vars['item']['resource_id']; ?>
)">删除</a>
			</td>
		</tr>
	<?php endforeach; endif; unset($_from); ?>
	</tbody>
</table>
<div style="float: right;"><?php echo $this->_tpl_vars['page_str']; ?>
</div>

<br/>
</div>
<?php echo '
'; ?>


</body>

</html>
