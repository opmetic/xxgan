<?php /* Smarty version 2.6.20, created on 2010-11-14 22:21:36
         compiled from scriptmemage.tpl */ ?>
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
	$(\'#agent\').combobox(\'setValue\','; ?>
<?php echo $this->_tpl_vars['user_name']; ?>
<?php echo ');
});
	</script>
'; ?>

</head>

<body style="background:#FFFFFF;">
<div style="border:#cccccc 1px dotted;padding:10px; margin:10px 0;background-color:#ffffcc;" >
<form id="editscript" method="post" action="/script/index">

用户：
	<select id="agent" class="easyui-combobox" name="agent" style="width:200px; " required="true">
	<option value="-1">null</option>
	<?php $_from = $this->_tpl_vars['conflist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['listloop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['listloop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['listloop']['iteration']++;
?>
		<option value="<?php echo $this->_tpl_vars['item']['user_id']; ?>
"><?php echo $this->_tpl_vars['item']['user_name']; ?>
</option>
	<?php endforeach; endif; unset($_from); ?>
	
	</select><input type="submit" name="submit" value="查看"></div>
</div>

<div>
	<textarea required="true" rows="22" cols="100" name="scriptdb_info"><?php echo $this->_tpl_vars['script']['scriptdb_info']; ?>
</textarea> <p/>
	<input type="submit" name="submit" value="提交"></div>
	<input type="hidden" name="scriptdb_key" value="<?php echo $this->_tpl_vars['scriptdb_key']; ?>
">
	<input type="hidden" name="scriptdb_id" value="<?php echo $this->_tpl_vars['script']['scriptdb_id']; ?>
">
</form>
</div>

</body>

</html>
