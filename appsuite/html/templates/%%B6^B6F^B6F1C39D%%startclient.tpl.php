<?php /* Smarty version 2.6.20, created on 2011-03-17 17:38:09
         compiled from startclient.tpl */ ?>
<html>
<head>
<title>启动页面</title>
<?php echo '
<script language="javascript">
function init(){
	window.opener = null;
	var str = "top=0,left=0,status=yes,menubar=no,scrollbars=no,resizable=yes,width=" + (window.screen.availWidth - 10) + ",height=" + (window.screen.availHeight - 50) + "";//
	if (window.screen.width>800)
	{
		window.open(\''; ?>
<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
<?php echo '/AppSuite/client\', \'_blank\', str);
	}
	else
	{
		window.open(\''; ?>
<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
<?php echo '/AppSuite/client\', \'_blank\', \'top=0,left=0,status=no,menubar=no,resizable=yes,scrollbars=yes\');
	}
	window.close();
}
</script>
'; ?>

</head>
<body onload="init()">
</body>  
</html>