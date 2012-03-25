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
		url: "{/literal}{$system_config.site_url}{literal}/qnuser/jsonlist",
		dataType: "json",
		data: {factoryid: $("#factoryid").val()},
		success: function(msg){
			$("#userid").empty();// 清空下拉框
			for(var i=0; i<msg.length; i++)
			{
				$("#userid").append("<option value='" + msg[i].uid + "'>" + msg[i].nickname + "[工号:" + msg[i].workid + "]</option>"); 
			}
		}
	}); 
}

$(function(){

	$('#listtab').datagrid({ 
		striped: true,
		singleSelect : true
	});

	$("#factoryid").change(function(){
		updateList();
	});
	updateList();

});

function addDle(id)
{
	parent.updateWindows("新增脚本", "{/literal}{$system_config.site_url}{literal}/script/add/id/" + id, true);
}

function editDle(title, id)
{
	parent.updateWindows("编辑 " + title, "{/literal}{$system_config.site_url}{literal}/script/edit/id/" + id, true);
}

function confirmDle(id)
{
	var bln = window.confirm("确定删除吗?");
	if (bln)
	{
		location.href = "{/literal}{$system_config.site_url}{literal}/script/del/id/" + id;
	}
}
</script>
{/literal}
</head>

<body style="background:#FFFFFF;">

<div style="background:#FFFFFF;padding:10px;">
	<div style="border:#cccccc 1px dotted;padding:10px; margin:10px 0;background-color:#ffffff;" >
	<form id="editscript" method="post" action="{$system_config.site_url}/script/list">
	<table>
		<tr>
		<td width="60">
		公司：
		</td>
		<td width="200">
			<select id="factoryid" name="factoryid">
			{foreach from=$list item=item name=listloop }
			<option value="{$item.factory_id}" {if $id == $item.factory_id}selected{/if}>{$item.factory_name}</option>
			{/foreach}
		</select>
		</td>
		<td width="60">
		用户：
		</td>
		<td width="200">
			<select id="userid" name="userid">
			</select>
		</td>
		<td width="60">
		<input type="submit" name="submit" value="查看"></div>
		</td>
	</table>
	<form>
	</div>
{if $userData}用户 {$userData.username} 的{/if}脚本列表：{if $userData}［<a href="javascript:addDle({$userData.uid})">新增</a>］{/if}
<table id="listtab" fit="true">
	<thead>
		<tr>
			<th field="f1" width="60"> </th>
			<th field="f2" width="100">脚本名</th>
			<th field="f3" width="50">所属用户</th>
			<th field="f4" width="160">脚本键</th>
			<th field="f5" width="300">脚本描述</th>
			<th field="f6" width="80">脚本类型</th>
			<th field="f7" width="160"></th>
		</tr>
	</thead>
	<tbody>
	{foreach from=$scriptlist item=item name=listloop }
		<tr>
			<td>{$smarty.foreach.listloop.iteration}</td>
			<td>{$item.scriptdb_name}</td>
			<td>{$item.nickname}</td>
			<td>{$item.scriptdb_key}</td>
			<td>{$item.scriptdb_dsc}</td>
			<td>{if $item.flag == 1}自定义脚本{/if}</td>
			<td>
				<a href="javascript:editDle('{$item.scriptdb_name}-{$item.nickname}', {$item.scriptdb_id})">编辑</a>
				<a href="javascript:confirmDle({$item.scriptdb_id})">删除</a>
			</td>
		</tr>
	{/foreach}
	</tbody>
</table>
</div>
</body>

</html>

