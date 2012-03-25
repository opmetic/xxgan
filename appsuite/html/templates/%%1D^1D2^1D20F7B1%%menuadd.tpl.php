<?php /* Smarty version 2.6.20, created on 2011-04-13 01:14:47
         compiled from menuadd.tpl */ ?>
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
<?php echo '/qnmenu/jlist",
		dataType: "json",
		data: {factoryid: $("#factoryid").val()},
		success: function(msg){
			$("#menuparent").empty();// 清空下拉框
            $("#menuparent").append("<option value=\'0\'>顶级目录</option>"); 
			for(var i=0; i<msg.length; i++)
			{
				$("#menuparent").append("<option value=\'" + msg[i].menu_id + "\'>" + msg[i].menu_name + "</option>"); 
			}
		}
	}); 
}
$(function(){
	$("#factoryid").change(function(){
		updateList();
	});
	updateList();
    

    $("#editscript").submit( function () { 
        if ( !$("#menuname").val())
        {
            alert("菜单名不能为空");
            return false;
        }
        if ( !$("#menucode").val())
        {
            alert("菜单资源标识符不能为空");
            return false;
        }
        if ( !$("#menukey").val())
        {
            alert("菜单键不能为空");
            return false;
        }
    });

});
</script>
'; ?>

</head>

<body style="background:#FFFFFF;">
<div style="background:#FFFFFF;padding:10px;">
    <form id="editscript" method="post" action="<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
/qnmenu/adddo">
	<table cellpadding="10" cellspacing="10">
		<tr>
			<td align="right" width="100" >菜单名:</td>
			<td><input class="easyui-validatebox" type="text" name="menuname" id="menuname" required="true" width="200"></input></td>
			<td><span style="color:#FF0000;">*</span></td>
		</tr>
		<tr>
			<td align="right">所属公司:</td>
			<td>
				<select id="factoryid" name="factoryid">
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
			<td><span style="color:#FF0000;">*</span></td>
		
		</tr>
		<tr>
			<td align="right">菜单资源标识符:</td>
			<td><input class="easyui-validatebox" type="text" name="menucode" id="menucode"></input></td>
			<td><span style="color:#FF0000;">*</span>用于资源分配 </td>
		</tr>
		<tr>
			<td align="right">父菜单:</td>
			<td>
				<select id="menuparent" name="menuparent">
				</select>
			</td>
			<td><span style="color:#FF0000;">*</span></td>
		</tr>
		<tr>
			<td align="right">菜单键:</td>
			<td><input class="easyui-validatebox" type="text" name="menukey" id="menukey"></input></td>
			<td><span style="color:#FF0000;">*</span>菜单对应的一个脚本键 </td>
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
