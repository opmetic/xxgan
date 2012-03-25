<?php /* Smarty version 2.6.20, created on 2011-07-19 15:28:59
         compiled from phoneedit.tpl */ ?>
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
    $("#editscript").submit( function () { 
        var str = $("#num").val();
        var patrn = /^[0-9]+$/;
        if (!patrn.exec(str))
        {
            alert("分机号格式不正确");
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
/qnphone/edit">
	<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['phoneData']['phone_id']; ?>
"/>
	<table cellpadding="10" cellspacing="10">
		<tr>
			<td align="right">分机号:</td>
			<td><input class="easyui-validatebox" type="text" name="num" id="num" value="<?php echo $this->_tpl_vars['phoneData']['phone_num']; ?>
"></input></td>
			<td><span style="color:#FF0000;">*</span></td>
		
		</tr>
		<tr>
			<td align="right">所属公司:
			
			</td>
			<td>
				<select id="factoryid" name="factoryid">
					<?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['listloop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['listloop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['listloop']['iteration']++;
?>
					<option value="<?php echo $this->_tpl_vars['item']['factory_id']; ?>
" <?php if ($this->_tpl_vars['phoneData']['factory_id'] == $this->_tpl_vars['item']['factory_id']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['item']['factory_name']; ?>
</option>
					<?php endforeach; endif; unset($_from); ?>
				</select>
			</td>
			<td></td>
		</tr>
        <tr>
            <td align="right">对应IP地址:</td>
            <td><input class="easyui-validatebox" type="text" name="ip" id="ip" value="<?php echo $this->_tpl_vars['phoneData']['machineip']; ?>
"></input></td>
            <td><span style="color:#FF0000;">*</span></td>
        
        </tr>
        <tr>
            <td align="right">模块号:</td>
            <td><input class="easyui-validatebox" type="text" name="basemodel" id="basemodel" value="<?php echo $this->_tpl_vars['phoneData']['basemodel']; ?>
"></input></td>
            <td><span style="color:#FF0000;">*</span></td>
        
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
