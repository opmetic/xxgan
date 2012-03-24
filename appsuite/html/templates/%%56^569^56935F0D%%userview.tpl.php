<?php /* Smarty version 2.6.20, created on 2011-04-14 11:53:00
         compiled from userview.tpl */ ?>
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
<?php echo '/qnphone/jsonlist",
		dataType: "json",
		data: {factoryid: $("#factoryid").val()},
		success: function(msg){
			$("#agentid").empty();// 清空下拉框
			for(var i=0; i<msg.length; i++)
			{
				$("#agentid").append("<option value=\'" + msg[i].phone_id + "\'>" + msg[i].phone_plain + "</option>"); 
			}
		}
	}); 

	$.ajax({
		type: "GET",
		url: "'; ?>
<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
<?php echo '/qnskill/jsonlist",
		dataType: "json",
		data: {factoryid: $("#factoryid").val()},
		success: function(msg){
			$("#skills").empty();// 清空下拉框
			for(var i=0; i<msg.length; i++)
			{
				$("#skills").append(\'<input type="checkbox" name="skillarray[]" value="\' +  msg[i].skill_id + \'" />\' + msg[i].skill_name + \'<br/>\'); 
			}

		}
	}); 
}
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
			<td align="right" width="100" >用户工号:</td>
			<td width="300"><?php echo $this->_tpl_vars['userData']['workid']; ?>
</td>
			<td><span style="color:#FF0000;">*</span>座席登陆时使用的工号</td>
		</tr>
		<tr>
			<td align="right" width="100" > 用户名:</td>
			<td width="300"><?php echo $this->_tpl_vars['userData']['username']; ?>
</td>
			<td> </td>
		</tr>
		<tr>
			<td align="right">用户角色:</td>
			<td>
				<?php if ($this->_tpl_vars['userData']['role'] == 0): ?>班长座席<?php endif; ?>
				<?php if ($this->_tpl_vars['userData']['role'] == 1): ?>普通座席<?php endif; ?>
			</td>
			<td> </td>
		</tr>
		<tr>
			<td align="right">用户姓名:</td>
			<td><?php echo $this->_tpl_vars['userData']['nickname']; ?>
</td>
			<td><span style="color:#FF0000;">*</span></td>
		</tr>
		<tr>
			<td align="right">所属公司:	</td>
			<td><?php echo $this->_tpl_vars['factoryData']['factory_name']; ?>
	</td>
			<td></td>
		</tr>
        <tr>
            <td align="right">平台工号:    </td>
            <td><?php echo $this->_tpl_vars['userData']['plain']; ?>
    </td>
            <td></td>
        </tr>
		<tr>
			<td align="right">初始平台分机号:	</td>
			<td>
				分机:<?php echo $this->_tpl_vars['phoneData']['phone_num']; ?>

			</td>
			<td>默认情况下的分机号</td>
		</tr>
	
	</table>
	技能组:
	<table id="listtab" fit="true">
		<thead>
			<tr>
				<th field="f1" width="60"></th>
				<th field="f2" width="100">技能名</th>
			</tr>
		</thead>
		<tbody>
		<?php $_from = $this->_tpl_vars['skillsData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['listloop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['listloop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['listloop']['iteration']++;
?>
			<tr>
				<td><?php echo $this->_foreach['listloop']['iteration']; ?>
</td>
				<td><?php echo $this->_tpl_vars['item']['skill_name']; ?>
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
