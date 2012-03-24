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
		url: "{/literal}{$system_config.img_url}{literal}/qnmenu/jlist",
		dataType: "json",
		data: {factoryid: $("#factoryid").val()},
		success: function(msg){
			$("#menuparent").empty();// 清空下拉框
            $("#menuparent").append("<option value='0'>顶级目录</option>"); 
			for(var i=0; i<msg.length; i++)
			{
				$("#menuparent").append("<option value='" + msg[i].menu_id + "'>" + msg[i].menu_name + "</option>"); 
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
{/literal}
</head>

<body style="background:#FFFFFF;">
<div style="background:#FFFFFF;padding:10px;">
    <form id="editscript" method="post" action="{$system_config.img_url}/qnmenu/adddo">
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
					{foreach from=$list item=item name=listloop }
					<option value="{$item.factory_id}" {if $id == $item.factory_id}selected{/if}>{$item.factory_name}</option>
					{/foreach}
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

{literal}
{/literal}

</body>

</html>

