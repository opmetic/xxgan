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
var falg = true;
$(function(){
    $("#resource_name").blur(function(){
    });

    $("#editscript").submit( function () {            
        var str = $("#resource_name").val();
        var patrn = /^[A-Z]+$/;
        if (patrn.exec(str) && true)
        {
            return true;
        }  
        else
        {
            alert("资源名输入格式不正确，请重新输入");
            return false;
        }
   
    });
});
</script>
{/literal}
</head>

<body style="background:#FFFFFF;">
<div style="background:#FFFFFF;padding:10px;">
    <form id="editscript" method="post" action="{$system_config.img_url}/qnresourcerenter/adddo">
    <div style="color: #FF0000;">{$post.errmsg}</div>
	<table cellpadding="10" cellspacing="10">
		<tr>
			<td align="right" width="100" >资源名:</td>
			<td><input class="easyui-validatebox" type="text" name="resource_name" id="resource_name" required="true" width="200" value="{$post.name}"></input></td>
			<td> <span style="color:#FF0000;">*</span>大写字母</td>
		</tr>
        <tr>
            <td align="right">资源类型:
            </td>
            <td>
                <select id="resource_type" name="resource_type">
                    {foreach from=$resource_type_array key=key2 item=item2 name=listloop2}
                    <option value="{$key2}">{$item2}</option>
                    {/foreach}
                </select>
            </td>
            <td></td>
        </tr>
        <tr>
            <td align="right" width="100" >资源描述:</td>
            <td><input type="text" name="resource_dsc" id="resource_dsc" required="true" width="500" value="{$post.name}"></input></td>
            <td></td>
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

