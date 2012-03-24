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
function updateList()
{
	$.ajax({
		type: "GET",
		url: "{/literal}{$system_config.img_url}{literal}/qnuserskillgroup/jsonlist",
		dataType: "json",
		data: {factoryid: $("#factoryid").val()},
		success: function(msg){

			$("#userid").empty();// 清空下拉框
			for(var i=0; i<msg.length; i++)
			{
			
				$("#userid").append("<option value='" + msg[i].uid + "'>" + msg[i].username + "[" + msg[i].nickname + "]</option>"); 
			}
		}
	}); 
}
$(function(){
	$("#factoryid").change(function(){
		updateList();
	});
	updateList();
});
	</script>
{/literal}
</head>

<body style="background:#FFFFFF;">
<div style="background:#FFFFFF;padding:10px;">
    <form id="editscript" method="post" action="{$system_config.img_url}/qnuserskillgroup/list">
	<input type="hidden" name="id" value="{$phoneData.phone_id}"/>
	<table cellpadding="10" cellspacing="10" style="border:#ffff99 1px dotted;" width="100%">
		<tr>
			<td align="right" width="50" >公司:</td>
			<td width="250">
				<select id="factoryid" name="factoryid" style="width:230px;">
					{foreach from=$list item=item name=listloop }
					<option value="{$item.factory_id}" {if $id == $item.factory_id}selected{/if}>{$item.factory_name}</option>
					{/foreach}
				</select>
			</td>
			<td width="50" align="right"> 用户: </td>
			<td width="150">
				<select id="userid" name="userid" style="width:200px;">
				</select>
			</td>
			<td><input type="submit" name="submit" value="确定"/></td>
		</tr>
	</table>
    </form>
</div>

{literal}
{/literal}

</body>

</html>

