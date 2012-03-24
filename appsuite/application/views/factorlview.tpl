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
			<td align="right" width="100" >公司名:</td>
			<td>{$factoryData.factory_name}</td>
			<td> </td>
		</tr>
		<tr>
			<td align="right">公司代码:</td>
			<td>{$factoryData.factory_enterprisecode}</td>
			<td></td>
		
		</tr>
		<tr>
			<td align="right">接入码:</td>
			<td>{$factoryData.factory_code}</td>
			<td> </td>
		</tr>
		<tr>
			<td align="right">接入密码:</td>
			<td>{$factoryData.factory_pwd}</td>
			<td> </td>
		</tr>
		<tr>
			<td align="right">是否定制:
			
			</td>
			<td>
				{if $factoryData.factory_userdefined == 0}否{else}是{/if}

			</td>
			<td</td>
		</tr>

	</table>
	
	分机号列表：
	<table id="listtab" fit="true">
		<thead>
			<tr>
				<th field="f1" width="60"></th>
				<th field="f2" width="100">分机号</th>
				<th field="f3" width="200">所属公司</th>
				<th field="f4" width="100">当前被使用</th>
			</tr>
		</thead>
		<tbody>
		{foreach from=$phoneData item=item name=listloop }
			<tr>
				<td>{$smarty.foreach.listloop.iteration}</td>
				<td>{$item.phone_num}</td>
				<td>{$factoryData.factory_name}</td>
				<td>{$item.phone_status}</td>
			</tr>
		{/foreach}
		</tbody>
	</table>
</div>

{literal}
{/literal}

</body>

</html>

