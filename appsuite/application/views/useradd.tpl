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
		url: "{/literal}{$system_config.img_url}{literal}/qnphone/jsonlist",
		dataType: "json",
		data: {factoryid: $("#factoryid").val()},
		success: function(msg){
			$("#agentid").empty();// 清空下拉框
			for(var i=0; i<msg.length; i++)
			{
				$("#agentid").append("<option value='" + msg[i].phone_id + "'>" + msg[i].phone_num + "</option>"); 
			}
		}
	}); 

	$.ajax({
		type: "GET",
		url: "{/literal}{$system_config.img_url}{literal}/qnskill/jsonlist",
		dataType: "json",
		data: {factoryid: $("#factoryid").val()},
		success: function(msg){
			$("#skills").empty();// 清空下拉框
			for(var i=0; i<msg.length; i++)
			{
				$("#skills").append('<input type="checkbox" name="skillarray[]" value="' +  msg[i].skill_id + '" />' + msg[i].skill_name + '<br/>'); 
			}

		}
	}); 
}
$(function(){
	$("#factoryid").change(function(){
		updateList();
	});
	updateList();
    
    $("#editscript").submit( function () {

        if ( !$("#username").val())
        {
            alert("用户工号不能为空");
            return false;
        }
 
        if (!$("#nickname").val())
        {
            alert("用户名不能为空");
            return false;
        }
        if (!$("#plain").val())
        {
            alert("平台工号不能为空");
            return false;
        }     
        if ( !$("#pwdplaintext").val() )
        {
            alert("用户密码不能为空");
            return false;
        }  
        return true;
    } ); 

});
	</script>
{/literal}
</head>

<body style="background:#FFFFFF;">
<div style="background:#FFFFFF;padding:10px;">
    <form id="editscript" method="post" action="{$system_config.img_url}/qnuser/adddo">
    <div style="color: #FF0000;">{$post.errmsg}</div>  
	<table cellpadding="10" cellspacing="10">
		<tr>
			<td align="right" width="100" >用户工号:</td>
			<td width="300"><input class="easyui-validatebox" type="text" id="username" name="username" required="true" width="200"></input></td>
			<td><span style="color:#FF0000;">*</span>座席登陆时使用的工号</td>
		</tr>
		<tr>
			<td align="right">用户角色:</td>
			<td>
				<select id="role" name="role">
					<option value="1" {if $factoryData.factory_userdefined == 0}selected{/if}>班长座席</option>
					<option value="2" {if $factoryData.factory_userdefined == 1}selected{/if}>普通座席</option>
				</select>
			</td>
			<td> </td>
		</tr>
		<tr>
			<td align="right">用户姓名:</td>
			<td><input class="easyui-validatebox" type="text" id="nickname" name="nickname"></input></td>
			<td><span style="color:#FF0000;">*</span></td>
		</tr>
		<tr>
			<td align="right">所属公司:	</td>
			<td>
				<select id="factoryid" name="factoryid">
					{foreach from=$list item=item name=listloop }
					<option value="{$item.factory_id}" {if $id == $item.factory_id}selected{/if}>{$item.factory_name}</option>
					{/foreach}
				</select>
			</td>
			<td></td>
		</tr>
		<tr>
			<td align="right">初始分机号:	</td>
			<td>
				<select id="agentid" name="agentid">
				</select>
			</td>
			<td>默认情况下的分机号</td>
		</tr>
        <tr>
            <td align="right">平台工号:</td>
            <td><input class="easyui-validatebox" type="text" id="plain" name="plain" value=""></input></td>
            <td><span style="color:#FF0000;">*</span>由平台提供</td>
        </tr>
		<tr>
			<td align="right">密码:</td>
			<td><input class="easyui-validatebox" type="text" id="pwdplaintext" name="pwdplaintext" value="Abc123"></input></td>
			<td><span style="color:#FF0000;">*</span></td>
		</tr>
		<tr>
			<td align="right" valign="top">技能组:</td>
			<td id="skills"></td>
			<td></td>
		</tr>
		<tr>
			<td align="right"> </td>
			<td><input type="submit" name="submit" id="submit" value="提交"></td>
			<td> </td>
		</tr>
	</table>
    </form>
</div>

{literal}
{/literal}

</body>

</html>

