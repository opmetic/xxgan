<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Cache-Control" content="no-cache" />

 <link rel="stylesheet" type="text/css" href="{$system_config.img_url}/monitor/index.css">
<title>DBClient Demo</title>
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="expires" content="0">

{literal} 
<style type="text/css">
<!--
.style3 {
    color: #005BB8;
    font-weight: bold;
}
.style6 {color: #005BB8}
a:hover { text-decoration:none; color:#990033} 
-->
</style>
{/literal} 

</head>
 <body leftMargin=0  topMargin=0 background="./images/bodybg.gif" >      
 <form name="theForm" method="POST">  
 
 
  <div style="border:#94C4E8  solid 1px;width=840;"> 
 <table width="840"  valign="top" border="0" cellpadding="0" cellspacing="0">
<tr>
<td bgcolor="#E0EDF6">
<table width="840" border="0" cellpadding="" cellspacing="1" >
{foreach name=name item=item from=$count}
    {if $smarty.foreach.name.iteration % 2 == 0}
    <tr onMouseOver="this.bgColor='#20c0ff';" bgcolor="#9CBEE4" onMouseOut="this.bgColor='#9CBEE4';" ID="TRID_{$item}" style="display:{if $item > 0}none{/if};" >
        <td align="center" valign="center" width="80"  height="28"  >{$item}</td>    
        <td align="center" valign="center" width="100" height="28"   style="word-break:break-all" ID="TRID_{$item}_AgentID">a</td>  
        <td align="center" valign="center" height="28" width="140"   style="word-break:break-all" ID="TRID_{$item}_name">f</td>  
        <td align="center" valign="center" height="28" width="120"   style="word-break:break-all" ID="TRID_{$item}_DN">b</td>
        <td align="center" valign="center" height="28" width="140"   style="word-break:break-all" ID="TRID_{$item}_Stat"><font color=green>空闲</font></td> 
        <td align="center" valign="center" height="28" width="140"   style="word-break:break-all" ID="TRID_{$item}_Time">d</td>
        <td align="center" valign="center" height="28" width="120"   style="word-break:break-all" ID="TRID_{$item}_SAgentID">c</td> 
    </tr>
    {else}
    <tr onMouseOver="this.bgColor='#20c0ff';" bgcolor="#A9C7EF" onMouseOut="this.bgColor='#A9C7EF';" ID="TRID_{$item}" style="display:{if $item > 0}none{/if};" >
        <td align="center" valign="center" width="80"  height="28"  >{$item}</td>    
        <td align="center" valign="center" width="100" height="28"   style="word-break:break-all" ID="TRID_{$item}_AgentID">a</td>  
        <td align="center" valign="center" height="28" width="140"   style="word-break:break-all" ID="TRID_{$item}_name">f</td>   
        <td align="center" valign="center" height="28" width="120"   style="word-break:break-all" ID="TRID_{$item}_DN">b</td>
        <td align="center" valign="center" height="28" width="140"   style="word-break:break-all" ID="TRID_{$item}_Stat"><font color=green>空闲</font></td> 
        <td align="center" valign="center" height="28" width="140"   style="word-break:break-all" ID="TRID_{$item}_Time">d</td>
        <td align="center" valign="center" height="28" width="120"   style="word-break:break-all" ID="TRID_{$item}_SAgentID">c</td> 
    </tr>
    {/if}      
{/foreach}
          
 
 </Table>          
  </td>
  </tr>
  </table>
  </div> 
   <input type="Hidden" NAME="DelStr" VALUE="dd">
  </form>
 </body>
 {literal}
 <SCRIPT LANGUAGE=javascript>
     
     
    function SelectAll()
{
   alert(document.all.DelStr.value);
}
 function Force(num)
{
  
   agentid=document.getElementById("TRID_"+num+"_AgentID").innerHTML;
   var bln = window.confirm("确定强制签出吗?");
    if (bln)
    {
        alert(agentid);
    }
   
}  
 
 
</SCRIPT>
{/literal}
   

