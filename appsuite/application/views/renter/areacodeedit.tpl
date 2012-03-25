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
 /*   $("#editscript").submit( function () { 
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
    });*/
});
	</script>
{/literal}
</head>

<body style="background:#FFFFFF;">
<div style="background:#FFFFFF;padding:10px;">
    <form id="editscript" method="post" action="{$system_config.img_url}/qnareacoderenter/edit">
    <div style="color: #FF0000;">{$post.errmsg}</div>  
	<table cellpadding="10" cellspacing="10">
		<tr>
			<td align="right" width="100" >省:</td>
			<td><input class="easyui-validatebox" type="text" name="areacode_province" id="areacode_province" required="true" width="200" value="{$areacodeData.areacode_province}"></input></td>
			<td></td>
		</tr>
		<tr>
			<td align="right">市:</td>
			<td><input class="easyui-validatebox" type="text" id="areacode_city" name="areacode_city" value="{$areacodeData.areacode_city}"></input></td>
			<td></td>
		</tr>
        <tr>
            <td align="right">区号:</td>
            <td><input class="easyui-validatebox" type="text" id="areacode" name="areacode" value="{$areacodeData.areacode}"></input></td>
            <td></td>
        </tr>
        <tr>
            <td align="right">接入号:</td>
            <td><input class="easyui-validatebox" type="text" id="areacode_phonenum" name="areacode_phonenum" value="{$areacodeData.areacode_phonenum}"></input></td>
            <td></td>
        </tr>
        <tr>
            <td align="right">酒店/机票:</td>
            <td><input class="easyui-validatebox" type="text" id="areacode_group" name="areacode_group" value="{$areacodeData.areacode_group}"></input></td>
            <td></td>
        </tr>
        <tr>
            <td align="right">类:</td>
            <td><input class="easyui-validatebox" type="text" id="areacode_class" name="areacode_class" value="{$areacodeData.areacode_class}"></input></td>
            <td></td>
        </tr>
		<tr>
			<td align="right"> </td>
			<td><input type="submit" name="submit" value="提交"></td>
			<td> </td>
		</tr>
	</table>
    <input type="hidden" name="id" value="{$areacodeData.areacode_id}" />
    </form>
</div>

{literal}
{/literal}

</body>

</html>

