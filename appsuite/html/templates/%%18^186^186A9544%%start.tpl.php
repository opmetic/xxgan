<?php /* Smarty version 2.6.20, created on 2010-10-30 16:08:39
         compiled from start.tpl */ ?>
<html>
<head>
<title>启动页面</title>
</head>
<body onLoad="init()">
<?php echo '
<script language="javascript">
function init(){
	window.opener = null;
	var str = "top=0,left=0,status=yes,menubar=no,scrollbars=no,resizable=yes,width=" + (window.screen.availWidth - 10) + ",height=" + (window.screen.availHeight - 50) + "";//
	if (window.screen.width>800)
	{
		window.open(\'/index/index\', \'_blank\', str);
	}
	else
	{
		window.open(\'/index/index\', \'_blank\', \'top=0,left=0,status=yes,menubar=no,resizable=yes,scrollbars=yes\');
	}
	window.close();
}
</script>
'; ?>

</body>  
</html>