<html>
<head>
<title>启动页面</title>
{literal}
<script language="javascript">
function init(){
	window.opener = null;
	var str = "top=0,left=0,status=yes,menubar=no,scrollbars=no,resizable=yes,width=" + (window.screen.availWidth - 10) + ",height=" + (window.screen.availHeight - 50) + "";//
	if (window.screen.width>800)
	{
		window.open('{/literal}{$system_config.img_url}{literal}/AppSuite/client', '_blank', str);
	}
	else
	{
		window.open('{/literal}{$system_config.img_url}{literal}/AppSuite/client', '_blank', 'top=0,left=0,status=no,menubar=no,resizable=yes,scrollbars=yes');
	}
	window.close();
}
</script>
{/literal}
</head>
<body onload="init()">
</body>  
</html>