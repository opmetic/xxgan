<HTML>
<HEAD>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>{$system_config.site_name}</TITLE>
</HEAD>
<BODY onload="onloadFun();">
<OBJECT height=0 width=0 ID="ASInstal" CLASSID="CLSID:4E3E6827-8BDF-48C0-9DB4-EAAA90F5B2A5"  codebase="{$system_config.site_url}/instal/AppSuiteInstal.cab#version=2, 0, 0, 2"></OBJECT>
<script type="text/javascript">   

     
</script>

下一步
</BODY>
{literal}
<script type="text/javascript">
function   onloadFun()
{
    var obj=document.getElementById("ASInstal");   
    //readyState为4时,代表完全加载了.   
    if(obj.readyState==4){   
     //alert("加载/成功!");   
     ASInstal.CreateInstal("122.225.204.237"); 
     setTimeout("onloadFun1()", 3000);  
    }else{   
     alert("加载失败!");   
    }  
   // 
}

function onloadFun1()
{    
	window.location.href = "{/literal}{$system_config.site_url}{literal}/instal/step1";
}
</script>

{/literal}
</HTML>
