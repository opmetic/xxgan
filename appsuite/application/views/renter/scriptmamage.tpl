<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Cache-Control" content="no-cache" />
<title>{$system_config.site_name}</title>
<link type="text/css" href="{$system_config.img_url}/appsuite_images/jquery-ui-1.8.1.custom.css" rel="stylesheet" />
<script type="text/javascript" src="{$system_config.img_url}/appsuite_script/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="{$system_config.img_url}/appsuite_script/jquery-ui-1.8.1.custom.min.js"></script>

<!-- css -->
<link type="text/css" href="{$system_config.img_url}/appsuite_images/admin.css" rel="stylesheet" />

<!-- easyui -->
<link rel="stylesheet" type="text/css" href="{$system_config.img_url}/appsuite_images/themes/default/easyui.css">
<link rel="stylesheet" type="text/css" href="{$system_config.img_url}/appsuite_images/themes/icon.css">
<script type="text/javascript" src="{$system_config.img_url}/appsuite_script/jquery.easyui.min.js"></script>

{literal}
	<script>
$(function(){
	$('#agent').combobox('setValue', {/literal}{$user_name}{literal});
});
	</script>
{/literal}
</head>

<body style="background:#FFFFFF;">
<div style="border:#cccccc 1px dotted;padding:10px; margin:10px 0;background-color:#ffffcc;" >
<form id="editscript" method="post" action="/script/index">

用户：
	<select id="agent" class="easyui-combobox" name="agent" style="width:200px; " required="true">
	<option value="-1">null</option>
	{foreach from=$conflist item=item name=listloop }
		<option value="{$item.user_id}">{$item.user_name}</option>
	{/foreach}
	
	</select><input type="submit" name="submit" value="查看"></div>
</div>

<div>
	<textarea required="true" rows="22" cols="100" name="scriptdb_info" style="word-wrap:normal;overflow :auto;">{$script.scriptdb_info}</textarea> <p/>
	<input type="submit" name="submit" value="提交"></div>
	<input type="hidden" name="scriptdb_key" value="{$scriptdb_key}">
	<input type="hidden" name="scriptdb_id" value="{$script.scriptdb_id}">
</form>
</div>

</body>

</html>

