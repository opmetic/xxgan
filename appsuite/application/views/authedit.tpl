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
function addPhone(id)
{
	parent.updateWindows("新增分机", "{/literal}{$system_config.img_url}{literal}/qnphone/add/id/" + id, true);
}
	</script>
{/literal}
</head>

<body style="background:#FFFFFF;">
<div style="background:#FFFFFF;padding:10px;">
    <form id="editscript" method="post" action="{$system_config.img_url}/qnauth/edit">
	<input type="hidden" name="id" value="{$roleData.role_id}" />
    
    角色名: <b>{$roleData.role_name} </b>
    所属企业:<b> {$roleData.factory_name} </b>
    描述: <b>{$roleData.role_dsc}    </b>
    <br/>
    {foreach from=$resource_type_array key=key2 item=item2 name=listloop2}
    <div style="margin:10px; padding:20px; background-color: #ffffff;border:#F5F5F5 1px dotted;">
        <b>{$item2}</b><br/>  

        {foreach from=$resourceArray.$key2 key=key item=item name=listloop}
            <div style="width: 200px; float: left; background-color: #ffffcc; margin:3px; padding: 1px;">
            <input type="checkbox" name="resource_list[]" {$item.checked} value="{$item.resource_id}"/><span style="margin-right:10px;" title="{$item.resource_name}">{$item.resource_dsc}</span>                                                                                 
            </div>
        {/foreach}
        <br/>
    </div>
    {/foreach}
    
    <input type="submit" name="submit" value="确定" />
    </form>
    
</div>

{literal}
{/literal}

</body>

</html>

