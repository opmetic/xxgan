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
    
  //  $("#fid").change(function(){
   //     location.href = "{/literal}{$system_config.img_url}{literal}/qnphone/list/fid/" + $("#fid").val();
  //  });
});
 
 function viewDle(title, id)
{
	parent.updateWindows("查看 " + title, "{/literal}{$system_config.img_url}{literal}/qnphone/show/id/" + id, true);
}

function editDle(title, id)
{
	parent.updateWindows("编辑 " + title, "{/literal}{$system_config.img_url}{literal}/qnphone/edit/id/" + id, true);
}

function confirmDle(id)
{
	var bln = window.confirm("确定删除吗?");
	if (bln)
	{
		location.href = "{/literal}{$system_config.img_url}{literal}/qnphone/del/id/" + id;
	}
}
</script>
{/literal}
</head>

<body style="background:#FFFFFF;">
<div style="background:#FFFFFF;padding:10px;">

	<div style="border:#cccccc 1px dotted;padding:10px; margin:10px 0;background-color:#ffffff;" >
	<form id="editscript" method="post" action="{$system_config.site_url}/qnphone/list">
	<table>
		<tr>
		<td width="60">分机号：</td>
		<td width="180"><input name="phone_num" id="phone_num" type="text" size="15" value="{$workid}"/></td>
		<td width="60">IP地址：</td>
		<td width="180"><input name="machineip" id="machineip" type="text" size="15" value="{$username}"/></td>
		<td width="60">所属公司：</td>
		<td width="180">
			<select name="fid" id="fid">
                <option value="0">所属公司</option>
           		{foreach from=$factoryList item=item name=listloop}
            		<option value="{$item.factory_id}" {if $factory_id == $item.factory_id}selected{/if}>{$item.factory_name}</option>
        		{/foreach}
            </select>
		</td>
		<td width="60"><input type="submit" name="submit" value="查看"></div></td>
		</tr>
	</table>
	<form>
	</div>
	
	
<table id="listtab"  fit="true">
	<thead>
		<tr>
			<th field="f1" width="60"> </th>
			<th field="f2" width="160">分机号</th>
			<th field="f3" width="160">所属公司</th>
            <th field="f4" width="160">对应IP地址</th>
            <th field="f5" width="160">模块号</th>
			<th field="f6" width="160"></th>
		</tr>
	</thead>
	<tbody>
	{foreach from=$list item=item name=listloop }
		<tr>
			<td>{$smarty.foreach.listloop.iteration}</td>
			<td>{$item.phone_num}</td>
			<td>{$item.factory_name}</td>
            <td>{$item.machineip}</td> 
            <td>{$item.basemodel}</td>
			<td>
				<a href="javascript:editDle('{$item.phone_num}', {$item.phone_id})">编辑</a>
				<a href="javascript:confirmDle({$item.phone_id})">删除</a>
			</td>
		</tr>
	{/foreach}
	</tbody>
</table>
<div style="float: right;">{$page_str}</div>
</div>

</body>

</html>

