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
		url: "{/literal}{$system_config.img_url}{literal}/qnphone/jsonlist",
		dataType: "json",
		data: {factoryid: $("#factoryid").val()},
		success: function(msg){
			$("#agentid").empty();// 清空下拉框
			for(var i=0; i<msg.length; i++)
			{
				$("#agentid").append("<option value='" + msg[i].phone_id + "'>" + msg[i].phone_plain + "</option>"); 
			}
		}
	}); 

	$.ajax({
		type: "GET",
		url: "{/literal}{$system_config.img_url}{literal}/qnskill/jsonlist",
		dataType: "json",
		data: {factoryid: $("#factoryid").val()},
		success: function(msg){
			$("#skills").empty();// 清空下拉框
			for(var i=0; i<msg.length; i++)
			{
				$("#skills").append('<input type="checkbox" name="skillarray[]" value="' +  msg[i].skill_id + '" />' + msg[i].skill_name + '<br/>'); 
			}

		}
	}); 
}
$(function(){
	$('#listtab').datagrid({ 
		striped: true,
		singleSelect : true
	});
});
	</script>
{/literal}
</head>

<body style="background:#FFFFFF;">
<div style="background:#FFFFFF;padding:10px;">
	<table cellpadding="10" cellspacing="10">
		<tr>
			<td align="right" width="100" >用户工号:</td>
			<td width="300">{$userData.workid}</td>
			<td><span style="color:#FF0000;">*</span>座席登陆时使用的工号</td>
		</tr>
		<tr>
			<td align="right" width="100" > 用户名:</td>
			<td width="300">{$userData.username}</td>
			<td> </td>
		</tr>
		<tr>
			<td align="right">用户角色:</td>
			<td>
				{if $userData.role == 1}班长座席{/if}
				{if $userData.role == 2}普通座席{/if}
			</td>
			<td> </td>
		</tr>
		<tr>
			<td align="right">用户姓名:</td>
			<td>{$userData.nickname}</td>
			<td><span style="color:#FF0000;">*</span></td>
		</tr>
		<tr>
			<td align="right">手机:</td>
			<td>{$userData.mobilephone}</td>
			<td><span style="color:#FF0000;">*</span></td>
		</tr>
		<tr>
			<td align="right">所属公司:	</td>
			<td>{$factoryData.factory_name}	</td>
			<td></td>
		</tr>
        <tr>
            <td align="right">平台工号:    </td>
            <td>{$userData.plain}    </td>
            <td></td>
        </tr>
	
	</table>
	技能组:
	<table id="listtab" fit="true">
		<thead>
			<tr>
				<th field="f1" width="60"></th>
				<th field="f2" width="100">技能名</th>
			</tr>
		</thead>
		<tbody>
		{foreach from=$skillsData item=item name=listloop }
			<tr>
				<td>{$smarty.foreach.listloop.iteration}</td>
				<td>{$item.skill_name}</td>
			</tr>
		{/foreach}
		</tbody>
	</table>
</div>

{literal}
{/literal}

</body>

</html>

