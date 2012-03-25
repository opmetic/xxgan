<?php /* Smarty version 2.6.20, created on 2011-08-02 22:05:54
         compiled from monitoragentstatushead.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Cache-Control" content="no-cache" />

 <link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
/monitor/index.css">
<title>DBClient Demo</title>
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="expires" content="0">

<?php echo ' 
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
'; ?>
 
    </head>
 <body leftMargin=0  topMargin=0 background="<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
/monitor/images/bodybg.gif" >      
 <form name="theForm" method="POST">  
 
 
  <div style="border:#94C4E8  solid 1px;width=840;"> 
 <table width="840"  valign="top" border="0" cellpadding="0" cellspacing="0">
<tr>
<td bgcolor="#E0EDF6">
<table width="840" border="0" cellpadding="" cellspacing="1" >
   
  <tr bgcolor="#20c0ff"> 
    <td width="80" align="center" valign="center" height="36"  ><span class="style3">序号</span></td>
    <td width="100" align="center" valign="center" height="36" ><span class="style3"><a href="javascript:OrderBy(1)" >员工号码<img name="AgentID" src=<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
/monitor/images/asc.gif style="display:'';" width=11 border=0 height=9></a> </span></td>
    <td width="140" align="center" valign="center" height="36" ><span class="style3">员工姓名</span></td>
	<td width="120" align="center" valign="center" height="36" ><span class="style3"><a href="javascript:OrderBy(2)" >分机号码<img name="AgentDN" src=<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
/monitor/images/asc.gif  style="display:none;" width=11 border=0 height=9></a></span></td>
	<td width="140" align="center" valign="center" height="36" ><span class="style3"><a href="javascript:OrderBy(3)" >员工状态<img name="NowStatus" src=<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
/monitor/images/asc.gif  style="display:none;"  width=11 border=0 height=9></a></span></td>
	<td width="140" align="center" valign="center" height="36" ><span class="style3"><a href="javascript:OrderBy(4)" >状态开始时间<img name="StartTime" src=<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
/monitor/images/asc.gif  style="display:none;"  width=11 border=0 height=9></a></span></td>
	<td width="120" align="center" valign="center" height="36" ><span class="style3"><a href="javascript:OrderBy(5)" >触发状态源员工<img name="SAgentID" src=<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
/monitor/images/asc.gif  style="display:none;"  width=11 border=0 height=9></a></span></td>
	  
  </tr>             
 
 </Table>          
  </td>
  </tr>
  </table>
  </div> 
   <input type="Hidden" NAME="LAgentID" VALUE="1">
   <input type="Hidden" NAME="LAgentDN" VALUE="1">
   <input type="Hidden" NAME="LNowStatus" VALUE="1">
   <input type="Hidden" NAME="LStartTime" VALUE="1">
   <input type="Hidden" NAME="LSAgentID" VALUE="1"> 
  </form>
 </body>
 <?php echo ' 
 <SCRIPT LANGUAGE=javascript>
     
     
    function OrderBy(choice)
{
   if(choice==1)
   {
          document.getElementById("AgentID").style.display = "";
          document.getElementById("AgentDN").style.display = "none";
          document.getElementById("NowStatus").style.display = "none";
          document.getElementById("StartTime").style.display = "none";
          document.getElementById("SAgentID").style.display = "none"; 
          if(document.getElementById("LAgentID").value=="1")
          {
                document.getElementById("LAgentID").value="11";
                document.getElementById("AgentID").src="'; ?>
<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
<?php echo '/monitor/images/desc.gif";
                window.parent.SetOrderBy(\' AgentID \',\' desc \');
          }
          else
          {
                   document.getElementById("LAgentID").value="1";
                   document.getElementById("AgentID").src="'; ?>
<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
<?php echo '/monitor/images/asc.gif";
                   window.parent.SetOrderBy(\' AgentID \',\' asc \');
          }
   }
   if(choice==2)
   {
          document.getElementById("AgentDN").style.display = ""; 
          document.getElementById("AgentID").style.display = "none";
          document.getElementById("NowStatus").style.display = "none";
          document.getElementById("StartTime").style.display = "none";
          document.getElementById("SAgentID").style.display = "none"; 
          if(document.getElementById("LAgentDN").value=="1")
          {
                document.getElementById("LAgentDN").value="11";
                document.getElementById("AgentDN").src="'; ?>
<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
<?php echo '/monitor/images/desc.gif";
                window.parent.SetOrderBy(\' agentphone \',\' desc \');
          }
          else
          {
                   document.getElementById("LAgentDN").value="1";
                   document.getElementById("AgentDN").src="'; ?>
<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
<?php echo '/monitor/images/asc.gif";
                   window.parent.SetOrderBy(\' agentphone \',\' asc \');
          }
   }
   if(choice==3)
   {
          document.getElementById("NowStatus").style.display = ""; 
          document.getElementById("AgentID").style.display = "none";
          document.getElementById("AgentDN").style.display = "none";
          document.getElementById("StartTime").style.display = "none";
          document.getElementById("SAgentID").style.display = "none"; 
          if(document.getElementById("LNowStatus").value=="1")
          {
                document.getElementById("LNowStatus").value="11";
                document.getElementById("NowStatus").src="'; ?>
<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
<?php echo '/monitor/images/desc.gif";
                window.parent.SetOrderBy(\' mainstatus \',\' desc \');
          }
          else
          {
                   document.getElementById("LNowStatus").value="1";
                   document.getElementById("NowStatus").src="'; ?>
<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
<?php echo '/monitor/images/asc.gif";
                   window.parent.SetOrderBy(\' mainstatus \',\' asc \');
          }
   }
   if(choice==4)
   {
          document.getElementById("StartTime").style.display = ""; 
          document.getElementById("AgentID").style.display = "none";
          document.getElementById("AgentDN").style.display = "none";
          document.getElementById("NowStatus").style.display = "none";
          document.getElementById("SAgentID").style.display = "none"; 
          if(document.getElementById("LStartTime").value=="1")
          {
                document.getElementById("LStartTime").value="11";
                document.getElementById("StartTime").src="'; ?>
<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
<?php echo '/monitor/images/desc.gif";
                window.parent.SetOrderBy(\' StartTime \',\' desc \');
          }
          else
          {
                   document.getElementById("LStartTime").value="1";
                   document.getElementById("StartTime").src="'; ?>
<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
<?php echo '/monitor/images/asc.gif";
                   window.parent.SetOrderBy(\' StartTime \',\' asc \');
          }
   }
   if(choice==5)
   {
          document.getElementById("SAgentID").style.display = ""; 
          document.getElementById("AgentID").style.display = "none";
          document.getElementById("AgentDN").style.display = "none";
          document.getElementById("NowStatus").style.display = "none";
          document.getElementById("StartTime").style.display = "none"; 
          if(document.getElementById("LSAgentID").value=="1")
          {
                document.getElementById("LSAgentID").value="11";
                document.getElementById("SAgentID").src="'; ?>
<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
<?php echo '/monitor/images/desc.gif";
                window.parent.SetOrderBy(\' srcagentid \',\' desc \');
          }
          else
          {
                   document.getElementById("LSAgentID").value="1";
                   document.getElementById("SAgentID").src="'; ?>
<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
<?php echo '/monitor/images/asc.gif";
                   window.parent.SetOrderBy(\' srcagentid \',\' asc \');
          }
   }
  
}
         
  
 
</SCRIPT>
'; ?>
 
 
 

   
