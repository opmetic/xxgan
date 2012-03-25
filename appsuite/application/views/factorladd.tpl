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
    
         if ( !$("#name").val())
        {
            alert("公司名不能为空");
            return false;
        }
            
        var str = $("#enterprisecode").val();
        var patrn = /^[a-z]+$/;
        if (patrn.exec(str))
        {
            return true;
        }  
        else
        {
            alert("公司代码输入格式不正确，请重新输入");
            return false;
        }
   
    });
});
	</script>
{/literal}
</head>

<body style="background:#FFFFFF;">
<div style="background:#FFFFFF;padding:10px;">
    <form id="editscript" method="post" action="{$system_config.img_url}/qnfactory/adddo">
    <div style="color: #FF0000;">{$post.errmsg}</div>
	<table cellpadding="10" cellspacing="10">
		<tr>
			<td align="right" width="100" >公司名:</td>
			<td><input class="easyui-validatebox" type="text" name="name" id="name" required="true" width="200" value="{$post.name}"></input></td>
			<td> <span style="color:#FF0000;">*</span></td>
		</tr>
		<tr>
			<td align="right">公司代码:</td>
			<td><input class="easyui-validatebox" type="text" id="enterprisecode" name="enterprisecode"></input></td>
			<td><span style="color:#FF0000;">*</span>小写字母，一般使用公司拼音简称，用于公司的唯一标识</td>
		
		</tr>
		<tr>
			<td align="right">VCID:</td>
			<td><input class="easyui-validatebox" type="text" name="code"  value="{$post.code}"></input></td>
			<td> 平台提供 </td>
		</tr>
        <!--
		<tr>
			<td align="right">接入密码:</td>
			<td><input class="easyui-validatebox" type="text" name="pwd"  value="{$post.pwd}"></input></td>
			<td> </td>
		</tr>
        -->
		<tr>
			<td align="right">是否定制:
			
			</td>
			<td>
				<select id="userdefined" name="userdefined">
					<option value="0">否</option>
					<option value="1">是</option>
				</select>
			</td>
			<td>如定项选择为 "是" ,需有开发人号配合</td>
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

