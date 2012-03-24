<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Cache-Control" content="no-cache" />
<title>{$system_config.site_name}</title>
<link rel="stylesheet" href="{$system_config.site_url}/appsuite_images/install.css" type="text/css" />
<script type="text/javascript" src="{$system_config.img_url}/script/jquery-1.3.2.min.js"></script>
{literal}
<script type="text/javascript">
</script>
{/literal}
</head>

<body>
<OBJECT ID="ASInstal" CLASSID="CLSID:4E3E6827-8BDF-48C0-9DB4-EAAA90F5B2A5" height=0 width=0></OBJECT>


<h1 id="logo">APPSUITE座席端框架安装向导</h1>
	<p>正在为您安装APPSUITE座席端框架。</p>
	<table class="form-table">
		<tr>
			<td>
			正在创建工作目录...
			{literal}
			<script type="text/javascript">
				ASInstal.CreateFolders();
			</script>
			{/literal}
			</td>
			<td>完成</td>
		</tr>
		<tr>
			<td>
			正在配制工作环境...
			<script type="text/javascript">
				ASInstal.CreateConf('{$ip}', '{$model}', '{$ctiip}', '{$ctiport}', '{$proxynum}', '{$acdip}', '{$acdport}', '{$areacord}');          
			</script>
			</td>
			<td>完成</td>
		</tr>
		<tr>
			<td>
			正在安装文件...
            
			<OBJECT height=0 width=0 ID="ASInstalwavch" CLASSID="CLSID:8FF79F70-3314-4B99-A5FF-A6D2FB2D8A5B" codebase="{$system_config.site_url}/instal/cabANIFwavch.cab#version=1, 0, 0, 0"></OBJECT>
			<OBJECT height=0 width=0 ID="ASInstalwaven" CLASSID="CLSID:8FF79F70-3314-4B99-A5FF-A6D2FB2D8A5B" codebase="{$system_config.site_url}/instal/cabANIFwaven.cab#version=1, 0, 0, 0"></OBJECT>
			<OBJECT height=0 width=0 ID="ASInstalwavdownload" CLASSID="CLSID:8FF79F70-3314-4B99-A5FF-A6D2FB2D8A5B" codebase="{$system_config.site_url}/instal/cabANIFwavdownload.cab#version=1, 0, 0, 0"></OBJECT>
			<OBJECT height=0 width=0 ID="ASInstalwavtoneCantonese" CLASSID="CLSID:8FF79F70-3314-4B99-A5FF-A6D2FB2D8A5B" codebase="{$system_config.site_url}/instal/cabANIFwavtoneCantonese.cab#version=1, 0, 0, 0"></OBJECT>
			<OBJECT height=0 width=0 ID="ASInstalwavtonechinese" CLASSID="CLSID:8FF79F70-3314-4B99-A5FF-A6D2FB2D8A5B" codebase="{$system_config.site_url}/instal/cabANIFwavtonechinese.cab#version=1, 0, 0, 0"></OBJECT>
			<OBJECT height=0 width=0 ID="ASInstalwavtoneEnglish" CLASSID="CLSID:8FF79F70-3314-4B99-A5FF-A6D2FB2D8A5B" codebase="{$system_config.site_url}/instal/cabANIFwavtoneEnglish.cab#version=1, 0, 0, 0"></OBJECT>
			<OBJECT height=0 width=0 ID="ASInstalconf" CLASSID="CLSID:8FF79F70-3314-4B99-A5FF-A6D2FB2D8A5B" codebase="{$system_config.site_url}/instal/cabANIFconf.cab#version=1, 0, 0, 0"></OBJECT>
            
			</td>
			<td>完成</td>
		</tr>
		<tr>
			<td>
			正在安装注册接口...
            
			<OBJECT height=0 width=0 ID="ASInstal" CLASSID="CLSID:8FF79F70-3314-4B99-A5FF-A6D2FB2D8A5B" codebase="{$system_config.site_url}/instal/cabANIF.cab#version=4, 0, 4, 13"></OBJECT>
            
			</td>
			<td>完成</td>
		</tr>
		<tr>
			<td>
			正在安装注册框架...
            
			<OBJECT height=0 width=0 ID="ASInstal" CLASSID="CLSID:167CE366-D521-4457-9216-6AE78AB6DF1B" codebase="{$system_config.site_url}/instal/cabAppSuite.cab#version=1, 0, 0, 1"></OBJECT>
             
			</td>
			<td>完成</td>
		</tr>
	</table>
		<p class="step"><input name="submit" type="submit" value="完成" class="button" onclick="javascript:window.close();" /></p>
</body>
</html>

