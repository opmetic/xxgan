<?php /* Smarty version 2.6.20, created on 2011-03-15 17:44:46
         compiled from renter/authedit.tpl */ ?>
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
    <form id="editscript" method="post" action="<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
/qnauthrenter/edit">
	<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['roleData']['role_id']; ?>
" />
    
    角色名: <b><?php echo $this->_tpl_vars['roleData']['role_name']; ?>
 </b>
    所属企业:<b> <?php echo $this->_tpl_vars['roleData']['factory_name']; ?>
 </b>
    描述: <b><?php echo $this->_tpl_vars['roleData']['role_dsc']; ?>
    </b>
    <br/>
    <?php $_from = $this->_tpl_vars['resource_type_array']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['listloop2'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['listloop2']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key2'] => $this->_tpl_vars['item2']):
        $this->_foreach['listloop2']['iteration']++;
?>
    <div style="margin:10px; padding:20px; background-color: #ffffff;border:#F5F5F5 1px dotted;">
        <b><?php echo $this->_tpl_vars['item2']; ?>
</b><br/>  

        <?php $_from = $this->_tpl_vars['resourceArray'][$this->_tpl_vars['key2']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['listloop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['listloop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
        $this->_foreach['listloop']['iteration']++;
?>
            <div style="width: 200px; float: left; background-color: #ffffcc; margin:3px; padding: 1px;">
            <input type="checkbox" name="resource_list[]" <?php echo $this->_tpl_vars['item']['checked']; ?>
 value="<?php echo $this->_tpl_vars['item']['resource_id']; ?>
"/><span style="margin-right:10px;" title="<?php echo $this->_tpl_vars['item']['resource_name']; ?>
"><?php echo $this->_tpl_vars['item']['resource_dsc']; ?>
</span>                                                                                 
            </div>
        <?php endforeach; endif; unset($_from); ?>
        <br/>
    </div>
    <?php endforeach; endif; unset($_from); ?>
    
    <input type="submit" name="submit" value="确定" />
    </form>
    
</div>

<?php echo '
'; ?>


</body>

</html>
