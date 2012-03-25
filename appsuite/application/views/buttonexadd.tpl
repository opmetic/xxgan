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
    $("#editscript").submit( function () { 
        if ( !$("#button_name").val())
        {
            alert("按键名不能为空");
            return false;
        }
        if ( !$("#button_info").val())
        {
            alert("按键值不能为空");
            return false;
        }
    });
});
	</script>
{/literal}
</head>

<body style="background:#FFFFFF;">
<div style="background:#FFFFFF;padding:10px;">
    <form id="editscript" method="post" action="{$system_config.img_url}/qnbuttonexrenter/adddo">
    <div style="color: #FF0000;">{$post.errmsg}</div>  
	<table cellpadding="10" cellspacing="10">
		<tr>
			<td align="right" width="100" >按键名:</td>
			<td><input class="easyui-validatebox" type="text" name="button_name" id="button_name" required="true" width="200"></input></td>
			<td><span style="color:#FF0000;">*</span></td>
		</tr>
		<tr>
			<td align="right">按键值:</td>
			<td><input class="easyui-validatebox" type="text" id="button_info" name="button_info" value="userdef_button_"></input></td>
			<td><span style="color:#FF0000;">*</span>以userdef_button_开头为挂机转,以userdef_buttonex_开头为单步转</td>
		</tr>
        <tr>
            <td align="right">所属技能组:</td>
            <td>
                <select name="button_group" id="button_group">
                    {foreach from=$list item=item name=listloop }
                    	<option value="{$item.skill_code}">{$item.skill_name}</option>
                    {/foreach}
                </select>
            <td><span style="color:#FF0000;">*</span></td>
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

