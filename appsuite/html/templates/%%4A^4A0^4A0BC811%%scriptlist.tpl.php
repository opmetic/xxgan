<?php /* Smarty version 2.6.20, created on 2011-07-04 11:27:08
         compiled from renter/scriptlist.tpl */ ?>
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
<?php echo $this->_tpl_vars['system_config']['site_url']; ?>
<?php echo '/qnuser/jsonlist",
		dataType: "json",
		data: {factoryid: $("#factoryid").val()},
		success: function(msg){
			$("#userid").empty();// 清空下拉框
			for(var i=0; i<msg.length; i++)
			{
				$("#userid").append("<option value=\'" + msg[i].uid + "\'>" + msg[i].nickname + "[工号:" + msg[i].workid + "]</option>"); 
			}
		}
	}); 
}

$(function(){

	$(\'#listtab\').datagrid({ 
		striped: true,
		singleSelect : true
	});

//	$("#factoryid").change(function(){
//		updateList();
//	});

});

function addDle(id)
{
	parent.updateWindows("新增脚本", "'; ?>
<?php echo $this->_tpl_vars['system_config']['site_url']; ?>
<?php echo '/scriptrenter/add/id/" + id, true);
}

function editDle(title, id)
{
	parent.updateWindows("编辑 " + title, "'; ?>
<?php echo $this->_tpl_vars['system_config']['site_url']; ?>
<?php echo '/scriptrenter/edit/id/" + id, true);
}

function confirmDle(id)
{
	var bln = window.confirm("确定删除吗?");
	if (bln)
	{
		location.href = "'; ?>
<?php echo $this->_tpl_vars['system_config']['site_url']; ?>
<?php echo '/scriptrenter/del/id/" + id;
	}
}
</script>
'; ?>

</head>

<body style="background:#FFFFFF;">

<div style="background:#FFFFFF;padding:10px;">
	<div style="border:#cccccc 1px dotted;padding:10px; margin:10px 0;background-color:#ffffff;" >
	<form id="editscript" method="post" action="<?php echo $this->_tpl_vars['system_config']['site_url']; ?>
/scriptrenter/list">
	<table>
		<tr>
		<td width="60">
		用户：
		</td>
		<td width="200">
			<select id="userid" name="userid">
            <?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['listloop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['listloop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['listloop']['iteration']++;
?>
            <option value="<?php echo $this->_tpl_vars['item']['uid']; ?>
" <?php if ($this->_tpl_vars['id'] == $this->_tpl_vars['item']['uid']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['item']['nickname']; ?>
[工号:<?php echo $this->_tpl_vars['item']['workid']; ?>
] </option>
            <?php endforeach; endif; unset($_from); ?>
			</select>
		</td>
		<td width="60">
		<input type="submit" name="submit" value="查看"></div>
		</td>
		</tr>
	</table>
	<form>
	</div>
<?php if ($this->_tpl_vars['userData']): ?>用户 <?php echo $this->_tpl_vars['userData']['username']; ?>
 的<?php endif; ?>脚本列表：<?php if ($this->_tpl_vars['userData']): ?>［<a href="javascript:addDle(<?php echo $this->_tpl_vars['userData']['uid']; ?>
)">新增</a>］<?php endif; ?>
<table id="listtab" fit="true">
	<thead>
		<tr>
			<th field="f1" width="60"> </th>
			<th field="f2" width="100">脚本名</th>
			<th field="f3" width="50">所属用户</th>
			<th field="f4" width="160">脚本键</th>
			<th field="f5" width="300">脚本描述</th>
			<th field="f6" width="80">脚本类型</th>
			<th field="f7" width="160"></th>
		</tr>
	</thead>
	<tbody>
	<?php $_from = $this->_tpl_vars['scriptlist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['listloop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['listloop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['listloop']['iteration']++;
?>
		<tr>
			<td><?php echo $this->_foreach['listloop']['iteration']; ?>
</td>
			<td><?php echo $this->_tpl_vars['item']['scriptdb_name']; ?>
</td>
			<td><?php echo $this->_tpl_vars['item']['nickname']; ?>
</td>
			<td><?php echo $this->_tpl_vars['item']['scriptdb_key']; ?>
</td>
			<td><?php echo $this->_tpl_vars['item']['scriptdb_dsc']; ?>
</td>
			<td><?php if ($this->_tpl_vars['item']['flag'] == 1): ?>自定义脚本<?php endif; ?></td>
			<td>
				<a href="javascript:editDle('<?php echo $this->_tpl_vars['item']['scriptdb_name']; ?>
-<?php echo $this->_tpl_vars['item']['nickname']; ?>
', <?php echo $this->_tpl_vars['item']['scriptdb_id']; ?>
)">编辑</a>
				<a href="javascript:confirmDle(<?php echo $this->_tpl_vars['item']['scriptdb_id']; ?>
)">删除</a>
			</td>
		</tr>
	<?php endforeach; endif; unset($_from); ?>
	</tbody>
</table>
</div>
</body>

</html>
