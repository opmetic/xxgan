<?php /* Smarty version 2.6.20, created on 2011-05-26 22:28:48
         compiled from renter/buttonlista.tpl */ ?>
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

function addDle()
{
	parent.updateWindows("新增按键", "'; ?>
<?php echo $this->_tpl_vars['system_config']['site_url']; ?>
<?php echo '/qnbuttonrenter/add/", true);
}

function editDle(title, id)
{
	parent.updateWindows("编辑 " + title, "'; ?>
<?php echo $this->_tpl_vars['system_config']['site_url']; ?>
<?php echo '/qnbuttonrenter/edit/id/" + id, true);
}

function confirmDle(id)
{
	var bln = window.confirm("确定删除吗?");
	if (bln)
	{
		location.href = "'; ?>
<?php echo $this->_tpl_vars['system_config']['site_url']; ?>
<?php echo '/qnbuttonrenter/del/id/" + id;
	}
}
</script>
'; ?>

</head>

<body style="background:#FFFFFF;">

<div style="background:#FFFFFF;padding:10px;">
	<div style="border:#cccccc 1px dotted;padding:10px; margin:10px 0;background-color:#ffffff;" >
	    <a href="javascript:addDle()">新增</a>
	</div>

<table id="listtab" fit="true">
	<thead>
		<tr>
			<th field="f1" width="60"> </th>
			<th field="f2" width="200">按键名</th>
			<th field="f3" width="300">内容</th>
			<th field="f4" width="150">类别</th>
			<th field="f5" width="160"></th>
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
			<td><?php echo $this->_tpl_vars['item']['button_name']; ?>
</td>
			<td><?php echo $this->_tpl_vars['item']['button_info']; ?>
</td>
			<td>
                <?php if ($this->_tpl_vars['item']['button_group'] == 100): ?>常用<?php endif; ?>
                <?php if ($this->_tpl_vars['item']['button_group'] == 101): ?>非常用<?php endif; ?>
            </td>
			<td>
				<a href="javascript:editDle('<?php echo $this->_tpl_vars['item']['button_name']; ?>
', <?php echo $this->_tpl_vars['item']['button_id']; ?>
)">编辑</a>
				<a href="javascript:confirmDle(<?php echo $this->_tpl_vars['item']['button_id']; ?>
)">删除</a>
			</td>
		</tr>
	<?php endforeach; endif; unset($_from); ?>
	</tbody>
</table>
</div>
</body>

</html>
