<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Cache-Control" content="no-cache" />
<title>{$system_config.site_name}</title>
<link rel="stylesheet" href="{$system_config.site_url}/appsuite_images/install.css" type="text/css" />
<script type="text/javascript" src="{$system_config.img_url}/script/jquery-1.3.2.min.js"></script>
{literal}
<script type="text/javascript" event="OnCompleted(hResult,pErrorObject, pAsyncContext)" for="foo"> 
</script>

<script type="text/javascript">
	$("#locator").empty();// 清空
	$("#foo").empty();// 清空
</script>

<script type="text/javascript" event=OnObjectReady(objObject,objAsyncContext) for="foo"> 
	if(objObject.IPEnabled != null && objObject.IPEnabled != "undefined" && objObject.IPEnabled == true) 
	{ 
		if(objObject.MACAddress != null && objObject.MACAddress != "undefined") 
		MACAddr = objObject.MACAddress; 
		if(objObject.IPEnabled && objObject.IPAddress(0) != null && objObject.IPAddress(0) != "undefined") 
		{
			$("#localIP").append("<option value='" + objObject.IPAddress(0) + "'>" + objObject.IPAddress(0) + "</option>"); 
		}
		if(objObject.DNSHostName != null && objObject.DNSHostName != "undefined") 
		sDNSName = objObject.DNSHostName; 
	} 
</script>


{/literal}
</head>

<body>
<OBJECT id=locator classid=CLSID:76A64158-CB41-11D1-8B02-00600806D9B6 VIEWASTEXT></OBJECT>
<OBJECT id=foo classid=CLSID:75718C9A-F029-11d1-A1AC-00C04FB6C223></OBJECT>
{literal}
<script type="text/javascript"> 
	var service = locator.ConnectServer(); 
	var MACAddr ; 
	var IPAddr ; 
	var DomainAddr; 
	var sDNSName; 
	service.Security_.ImpersonationLevel = 3; 
	service.InstancesOfAsync(foo, "Win32_NetworkAdapterConfiguration"); 
</script>
{/literal}

<h1 id="logo">APPSUITE座席端框架安装向导</h1>
<form method="post" action="{$system_config.site_url}/instal/step2">
	<p>您需要在下面输入您的环璄信息。如果您不知道，请联系管理。</p>
	<table class="form-table">
		<tr>
			<th scope="row"><label for="model">模块号</label></th>
			<td><input name="model" id="model" type="text" size="25" value="{$model}" /></td>
			<td>座席机器在CTI服务器上的唯一标识。请保持默认值，除非您知道如何修改。</td>
		</tr>
		<tr>
			<th scope="row"><label for="ctiip">CTI服务地址</label></th>
			<td><input name="ctiip" id="ctiip" type="text" size="25" value="{$system_config.cti_server}"/></td>
			<td>CTI服务器上IP地址。请保持默认值，除非您知道如何修改。</td>
		</tr>
		<tr>
			<th scope="row"><label for="ctiport">CTI服务端口</label></th>
			<td><input name="ctiport" id="ctiport" type="text" size="25" value="{$system_config.cti_server_port}"/></td>
			<td>CTI服务器端口。请保持默认值，除非您知道如何修改。</td>
		</tr>
		<tr>
			<th scope="row"><label for="proxynum">PROXY NUM</label></th>
			<td><input name="proxynum" id="proxynum" type="text" size="25" value="{$system_config.proxy_num}"/></td>
			<td>PROXY NUM。请保持默认值，除非您知道如何修改。</td>
		</tr>
		<tr>
			<th scope="row"><label for="acdip">ACD服务地址</label></th>
			<td><input name="acdip" id="acdip" type="text" size="25" value="{$system_config.acd_server}"/></td>
			<td>ACD服务器上IP地址。请保持默认值，除非您知道如何修改。</td>
		</tr>
		<tr>
			<th scope="row"><label for="acdport">ACD服务端口</label></th>
			<td><input name="acdport" id="acdport" type="text" size="25" value="{$system_config.acd_server_port}"/></td>
			<td>ACD服务器端口。请保持默认值，除非您知道如何修改。</td>
		</tr>
		<tr>
			<th scope="row"><label for="areacord">区号</label></th>
			<td><input name="areacord" id="areacord" type="text" size="25" value=""/></td>
			<td>座席所在地区区号。如杭州，填写571</td>
		</tr>
		<tr>
			<th scope="row"><label for="localIP">本机 IP 地址</label></th>
			<td>
				<select id="localIP" name="localIP">
				</select>
			</td>
			<td>请您选择可以正常访问互联网的本机 IP 地址。</td>
		</tr>
	</table>
		<p class="step"><input name="submit" type="submit" value="提交" class="button" /></p>   
</form>
</body>
</html>

