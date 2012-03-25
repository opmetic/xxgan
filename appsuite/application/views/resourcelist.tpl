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
<script type="text/javascript">
$(function(){
	$('#listtab').datagrid({ 
		striped: true,
		singleSelect : true    
	});
    
    $("#resource_type").val({/literal}'{$sourcetype}'{literal});
});

function updateList()
{
     location.href = "{/literal}{$system_config.img_url}{literal}/qnresource/list/sourcetype/" + $("#resource_type").val();
}
 
function viewDle(title, id)
{
	parent.updateWindows("查看 " + title, "{/literal}{$system_config.img_url}{literal}/qnresource/show/id/" + id, true);
}

function editDle(title, id)
{
	parent.updateWindows("编辑 " + title, "{/literal}{$system_config.img_url}{literal}/qnresource/edit/id/" + id, true);
}

function confirmDle(id)
{
	var bln = window.confirm("确定删除吗?");
	if (bln)
	{
		location.href = "{/literal}{$system_config.img_url}{literal}/qnresource/del/id/" + id;
	}
}
</script>
{/literal}
</head>

<body style="background:#FFFFFF;">
<div style="background:#FFFFFF;padding:10px;">

<table id="listtab" fit="true">
	<thead>
		<tr>
			<th field="f1" width="60"></th>
			<th field="f2" width="160">资源名</th>
			<th field="f3" width="160">
                 <select id="resource_type" name="resource_type" onchange="javascript:updateList();">
                    <option value="all" >所有资源</option>
                    {foreach from=$resource_type_array key=key2 item=item2 name=listloop2}
                    <option value="{$key2}">{$item2}</option>
                    {/foreach}
                </select>
            </th>
            <th field="f4" width="160">所属厂商</th>   
            <th field="f5" width="160">资源描述</th> 
			<th field="f6" width="160"></th>
		</tr>
	</thead>
	<tbody>
	{foreach from=$list item=item name=listloop }
		<tr>
			<td>{$smarty.foreach.listloop.iteration}</td>
			<td>{$item.resource_name}</td>
			<td>{$item.type_txt}</td>
            <td>{$item.factory_name}</td> 
            <td>{$item.resource_dsc}</td> 
			<td>
				<a href="javascript:editDle('{$item.resource_name}', {$item.resource_id})">编辑</a>
				<a href="javascript:confirmDle({$item.resource_id})">删除</a>
			</td>
		</tr>
	{/foreach}
	</tbody>
</table>
<div style="float: right;">{$page_str}</div>

<br/>
</div>
{literal}
{/literal}

</body>

</html>

