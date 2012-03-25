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

	$('#userlisttab').datagrid({ 
		striped: true,
		singleSelect : true
	});
});
 
 function viewDle(title, id)
{
	parent.updateWindows("查看 " + title, "{/literal}{$system_config.img_url}{literal}/qnuser/show/id/" + id, true);
}

function editDle(title, id)
{
	parent.updateWindows("编辑 " + title, "{/literal}{$system_config.img_url}{literal}/qnuser/edit/id/" + id, true);
}

function confirmDle(id)
{
	var bln = window.confirm("确定删除吗?");
	if (bln)
	{
		location.href = "{/literal}{$system_config.img_url}{literal}/qnuser/del/id/" + id;
	}
}
function lock(id)
{
    var bln = window.confirm("确定冻结该坐席吗?");
    if (bln)
    {
        location.href = "{/literal}{$system_config.img_url}{literal}/qnuser/lock/id/" + id;
    }
}
function unlock(id)
{
    var bln = window.confirm("确定恢复该坐席吗?");
    if (bln)
    {
        location.href = "{/literal}{$system_config.img_url}{literal}/qnuser/unlock/id/" + id;
    }
}
</script>
{/literal}
</head>

<body style="background:#FFFFFF;">
<div style="background:#FFFFFF;padding:10px;">

<table id="userlisttab" fit="true">
	<thead>
		<tr>
			<th field="f1" width="30"> </th>
			<th field="f2" width="60">用户工号</th>
			<th field="f3" width="60">用户名</th>
			<th field="f4" width="60">用户角色</th>
			<th field="f5" width="60">用户姓名</th>
			<th field="f6" width="160">所属公司</th>
            <th field="f7" width="160">技能组</th>
			<th field="f8" width="100">平台工号</th>
			<th field="f9" width="100">默认分机号</th>
            <th field="f10" width="60">状态</th>
			<th field="f11"width="100"></th>
		</tr>
	</thead>
	<tbody>
	{foreach from=$list item=item name=listloop }
		<tr>
			<td>{$smarty.foreach.listloop.iteration}</td>
			<td><a href="javascript:viewDle('{$item.nickname}', {$item.uid});">{$item.workid}</a></td>
			<td>{$item.username}</td>
			<td>{$item.role_txt}</td>
			<td>{$item.nickname}</td>
			<td>{$item.factory_name}</td>
            <td>{$item.skills}</td>
			<td>{$item.plain}</td>
			<td>{$item.phone_num}</td>
            <td>{if $item.uflag == 0}正常{else}已冻结{/if}</td>
			<td>
				<a href="javascript:editDle('{$item.nickname}', {$item.uid})">编辑</a>
				<a href="javascript:confirmDle({$item.uid})">删除</a>
                {if $item.uflag == 0}
                    <a href="javascript:lock({$item.uid})">冻结</a>
                {else}
                    <a href="javascript:unlock({$item.uid})">恢复</a>
                {/if}
			</td>
		</tr>
	{/foreach}
	</tbody>
</table>
<div style="float: right;">{$page_str}</div> 
</div>
</body>

</html>

