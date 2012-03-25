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
 <br>
  <body leftMargin=20  topMargin=0 background="{$system_config.img_url}/monitor/images/bodybg.gif" >      
 
 

<form name="theForm" method="POST" action=""> 
 
<div style="border:#94C4E8  solid 1px;width=860;"> 
<table width="860"  valign="top" border="0" cellpadding="0" cellspacing="0">
<tr>
<td bgcolor="#E0EDF6" background="{$system_config.img_url}/monitor/images/bodybg.gif"> 
<table width="870"  valign="top" border="0" cellpadding="0" cellspacing="1" >
  <tr >
  <td   height=30 width="690" background="{$system_config.img_url}/monitor/images/title.jpg">
   &nbsp;&nbsp;&nbsp;<img src="{$system_config.img_url}/monitor/images/select1.jpg" width="16" border=0 height="16" />&nbsp;&nbsp;<font style="font-size:16px; font-family:'宋体';color=white"><b> 坐席状态监控</b></font>
 
  
  </td>    
  <td   height=30 align="left" width="300" background="{$system_config.img_url}/monitor/images/title.jpg">&nbsp;技能组：
                         <select  name="Skills"  onChange="groupChange(this.value)" style="HEIGHT: 25px;">
                                    {if $flag == "gz"}
                                        <option value="4">广州公众机票前台</option> 
                                        <option value="5">广州公众机票中台</option>                                            
                                        <option value="6">广州酒店前台</option>
                                        <option value="7">广州酒店中台</option>
                                         <option value="14">广州国际机票前台</option>
                                        <option value="15">广州国际机票中台</option>
                                    {else}
                                    
                                        <option value="9">成都公众机票前台</option> 
                                            <option value="10">成都公众机票中台</option>                                            
                                            <option value="11">成都酒店前台</option>
                                            <option value="12">成都酒店中台</option>
                                    {/if}
 
                           </select>
     </td>    
   <td   height=30 align="center" width="100" background="{$system_config.img_url}/monitor/images/title.jpg"> 
                            <img name="Start" onclick="initial()" src="{$system_config.img_url}/monitor/images/Start.png" width="73" height="19" border="0" alt="" />
     </td>    
</tr>
      <tr>
      <td colspan=6 height=16></td>
      </tr>
      <tr>
      <td colspan=6 align="center">
          <font style="font-size:26px; font-family:'宋体';color=green"><b>
坐席状态监控
              </b></font>
      </td>
      </tr>
 <tr>
      <td colspan=6  height=20 align="center" valign="bottom">
          <div id="DivMonitorTime">当前时间:</div>
       </td>
      </tr>
 
</table>

             <table width="860" border=0 align="left" cellpadding="1" cellspacing="0">
              <tr>
                <td bgcolor="blue">
              
                    <table  width="860"  border=0 align="left" cellpadding="0" cellspacing="0" >
                  <tr  >
                    <td width="" align="left" background="{$system_config.img_url}/monitor/images/bodybg.jpg" >
                    <table    border=0 cellpadding="0" cellspacing="0" >
                        <tr  >
                         
                                             <td>
                                                      <table border=1   cellpadding="0" cellspacing="0">
                                                              <tr>
                                                                   
                                                                    <td  valign="bottom" align="left" > 
                                                                        
                                                                        <table border=0 cellpadding="0" >
                                                                                <tr> 
                                                                                             <td  valign="bottom" align="left" > 
                                                                                              <iframe width="860"    height="42"  style="display:'';" marginWidth=0 marginHeight=0   bordercolor="#009900"  name="HeadAgentStatus" id="HeadAgentStatus" src="{$system_config.img_url}/monitor/agentstatushead" frameborder=0></iframe>
                                                                    
                                                                                              </td>  
                                                                                </tr>
                                                                                <tr> 
                                                                                             <td  valign="bottom" align="left" > 
                                                                                              <iframe width="860"    height="496"  style="display:'';" marginWidth=0 marginHeight=0   bordercolor="#009900"  name="AgentStatus" id="AgentStatus" src="{$system_config.img_url}/monitor/agentstatustable" frameborder=0></iframe>
                                                                    
                                                                                              </td>  
                                                                                </tr>
                              
                                                                    </td> 
                                                            </tr>                               
                                                            </table>
                                        </td> 
                     </tr>
                     
                    </table>
                    </td> 
                        
                  </tr>
                  
                </table></td>
                    
              </tr>
            
            </table>
            
</td>

</tr>
</table>

</tr>
</table>
 
</form>
</body>
</html>

{literal}   
 <SCRIPT LANGUAGE=javascript>
    //onerror=handleErr;
  var txt="";var dbCtrlObject =null;
  {/literal}
	var namesjson = {$namesjson};
  var AddressID={$skill};
  {literal}
  var pno=0;var agentpno=1; var AgentModule=169; var ServerID=108;var Skills="%";var WhereSkill="";
  var Col=" AgentID ";var OrderBy=" asc ";
  document.getElementById("DivMonitorTime").innerHTML="<font color=blue>当前时间:"+GetCurrtTime()+"</font>";
  //setTimeout("initial()",5000); 
  
  function getNameCode(workid)
{
    var str = workid;
    for(var i=0; i<namesjson.length; i++)
    {
        if (namesjson[i].workid == workid)
        {
            var str = namesjson[i].nickname;  
             
            break;
        }  
    }   
    return str;
}
  
  function initial()
{
 
            dbCtrlObject = document.getElementById("dbCtrlObject");
                    if(dbCtrlObject!=null)
                    {
                          GetInfo();
                        return;
                    }                    
                    var ocxStr = "<OBJECT ID='dbCtrlObject' CLASSID='clsid:2DC52736-0472-11D4-B481-0080C87A8CFB' STYLE='width:0px;height:0px'></OBJECT><br></div>";
                    var oDiv=document.createElement("DIV");
                    oDiv.innerHTML = ocxStr;
                    document.body.appendChild(oDiv);
                    dbCtrlObject = document.getElementById("dbCtrlObject");    
          
          pno=9+Math.random()*100;
          pno={/literal}{$pno1}{literal};/*parseInt(pno);*/ 
                    dbCtrlObject.pno = pno;     
                    dbCtrlObject.agentpno =agentpno ;
                    dbCtrlObject.AgentModule = AgentModule;
                    dbCtrlObject.DbaCheckEnable = 0;
                    
                    var retcode = dbCtrlObject.Initial();
                     
                    dbCtrlObject.TimeOut = 10000;
                      
                      if(retcode!=0)
                      {
                             alert("Initial retcode:"+retcode+" pno："+ pno);
                             alert("连接CTI失败，请刷新页面!");return;
                       }
                    document.getElementById("DivMonitorTime").innerHTML=GetCurrtTime();
                    Skills=document.getElementById("Skills").value;
            setTimeout("GetInfo()",1000);  
            
           
            
  
}
  
 
function GetInfo()
{       
    var i=1; var recordCount=0;var retcode=-1; var mstatus=0;var totalnum=0;var busynum=0;var idlenum=0;var afternum=0;var othernum=0; 
    
    WhereSkill="(skills ='"+Skills+"' or skills like '"+Skills+",%' or skills like '%,"+Skills+",%' or skills like '%,"+Skills+"')";
    var SQLCmd="select agentid,agentphone,mainstatus,starttime,srcagentid,groupid,siteid from cc_moperstatus where vcid="+AddressID+" And "+WhereSkill+" order by "+Col+OrderBy;
    //SQLCmd="select agentid,agentphone,mainstatus,to_char(starttime,'yyyy-mm-dd hh24:mi:ss'),srcagentid,presubstatus from cc_moperstatus where vcid="+AddressID+" And "+WhereSkill;
  // alert(SQLCmd);
  
  retcode = dbCtrlObject.Open(SQLCmd, ServerID);
 
    if(retcode != 0)
    { 
            alert("连接数据库失败1，请查询原因,然后再点击'开始'按狃."+retcode);
            menu0  = document.all.Start;
      menu0.style.display = ""  ;
      return;
    }
    //获取结果数目
    recordCount = dbCtrlObject.GetRetCount();
    if (recordCount < 0)
    {
          alert("连接数据库失败2，请查询原因,然后再点击'开始'按狃.");
          menu0  = document.all.Start;
      menu0.style.display = ""  ;
      return;
    } 
    dbCtrlObject.GoToFirst(); 
    idlenum=0;busynum=0;afternum=0;othernum=0;
    for(i=1;i<=recordCount;i++)
    {
           cf=document.frames['AgentStatus'].document.getElementById("TRID_"+i);
       cf.style.display="";
       document.frames['AgentStatus'].document.getElementById("TRID_"+i+"_AgentID").innerHTML=dbCtrlObject.ResultToStr(0);
       document.frames['AgentStatus'].document.getElementById("TRID_"+i+"_name").innerHTML=getNameCode(dbCtrlObject.ResultToStr(0));
       document.frames['AgentStatus'].document.getElementById("TRID_"+i+"_DN").innerHTML=dbCtrlObject.ResultToStr(1);
       mstatus=dbCtrlObject.ResultToInt(2);
       
       if(mstatus==2)
       {
               document.frames['AgentStatus'].document.getElementById("TRID_"+i+"_Stat").innerHTML="<font color=black>置闲</font>";
               idlenum=idlenum+1;
           }
           else 
                   if(mstatus==3)
                   {
                document.frames['AgentStatus'].document.getElementById("TRID_"+i+"_Stat").innerHTML="<font color=blue>正在通话</font>";
                busynum=busynum+1;
              }
              else
                       if(mstatus==4)
                       {
                           document.frames['AgentStatus'].document.getElementById("TRID_"+i+"_Stat").innerHTML="<font color=yellow>事后整理</font>"; 
                           afternum=afternum+1;
                   }   
                   else
                       {
                          document.frames['AgentStatus'].document.getElementById("TRID_"+i+"_Stat").innerHTML="<font color=red>置忙</font>";
                          othernum=othernum+1;
                       }
               
           t=new Date(Date.parse(dbCtrlObject.ResultToStr(3)));//+"       "+dbCtrlObject.ResultToStr(3).toLocaleTimeString();
           document.frames['AgentStatus'].document.getElementById("TRID_"+i+"_Time").innerHTML=t.getFullYear()+"-"+parseInt(t.getMonth())+1+"-"+t.getDate()+" "+t.toLocaleTimeString();
       document.frames['AgentStatus'].document.getElementById("TRID_"+i+"_SAgentID").innerHTML=dbCtrlObject.ResultToStr(4);
       //document.frames['AgentStatus'].document.getElementById("TRID_"+i+"_PreStat").innerHTML=dbCtrlObject.ResultToStr(5);
       dbCtrlObject.MoveNext();
    }
    document.getElementById("DivMonitorTime").innerHTML="<font color=black>"+GetCurrtTime()+"</font><font color=blue>&nbsp;&nbsp;&nbsp;总的坐席数:"+recordCount+"&nbsp;   通话坐席数:"+busynum+"&nbsp;   空闲坐席数:"+idlenum+"&nbsp;   置忙坐席数:"+othernum+"&nbsp;   事后整理坐席数:"+afternum+"</font>";
    for(i=recordCount;i++;i<500)
  {
                    cf=document.frames['AgentStatus'].document.getElementById("TRID_"+i);                   
                    if(cf.style.display=="none")
                    {  
                           menu0  = document.all.Start;
                                       menu0.style.display = "none"  ;
                        setTimeout("GetInfo()",5000); 
                        return;
                    }
                    else
                           cf.style.display="none";
  }
  menu0  = document.all.Start;
  menu0.style.display = "none"  ;
  setTimeout("initial()",5000);
    /*
    DivTotalAgentNum = dbCtrlObject.ResultToInt(0);
           pno=1+Math.random()*400;
           pno=parseInt(pno); 
            document.getElementById("DivMonitorTime").innerHTML=GetCurrtTime();
               var cf=document.getElementById("AgentStatus");
             // cf.style.display="none";
             
            //document.getElementById("AgentStatus").contentWindow.SelectAll();
            //alert(document.frames['AgentStatus'].document.forms[0].DelStr.value);
            //alert(document.frames['AgentStatus'].document.all.DelStr.value);
           // alert(document.frames['AgentStatus'].document.getElementById("DelStr").value);
          // alert(pno);
          /*
           for(i;i<=pno;i++)
           {
                    
                    document.frames['AgentStatus'].document.getElementById("TRID_"+i+"_AgentID").innerHTML="1000"+i;
                    document.frames['AgentStatus'].document.getElementById("TRID_"+i+"_DN").innerHTML="1000DN"+i;
                    if(pno<40)
                        document.frames['AgentStatus'].document.getElementById("TRID_"+i+"_Stat").innerHTML="<font color=blue>正在通话</font>";
                    else
                           if(pno<160)
                               document.frames['AgentStatus'].document.getElementById("TRID_"+i+"_Stat").innerHTML="<font color=grey>其他工作</font>";
                           else
                                  if(pno<240)
                                       document.frames['AgentStatus'].document.getElementById("TRID_"+i+"_Stat").innerHTML="<font color=white>事后整理</font>";
                                  else
                                          if(pno<320)
                                               document.frames['AgentStatus'].document.getElementById("TRID_"+i+"_Stat").innerHTML="<font color=black>空闲</font>"; 
                                       else
                                             if(pno<400)
                                              document.frames['AgentStatus'].document.getElementById("TRID_"+i+"_Stat").src="<font color=green>正在响铃...</font>";
                   document.frames['AgentStatus'].document.getElementById("TRID_"+i+"_Time").innerHTML=GetCurrtTime();
                   document.frames['AgentStatus'].document.getElementById("TRID_"+i+"_SAgentID").innerHTML="S1000"+i;
                   if(pno<40)
                        document.frames['AgentStatus'].document.getElementById("TRID_"+i+"_PreStat").innerHTML="<font color=blue>正在通话</font>";
                    else
                           if(pno<160)
                               document.frames['AgentStatus'].document.getElementById("TRID_"+i+"_PreStat").innerHTML="<font color=grey>其他工作</font>";
                           else
                                  if(pno<2400)
                                       document.frames['AgentStatus'].document.getElementById("TRID_"+i+"_PreStat").innerHTML="<font color=white>事后整理</font>";
                                  else
                                          if(pno<320)
                                               document.frames['AgentStatus'].document.getElementById("TRID_"+i+"_PreStat").innerHTML="<font color=black>空闲</font>"; 
                                       else
                                             if(pno<400)
                                              document.frames['AgentStatus'].document.getElementById("TRID_"+i+"_PreStat").innerHTML="<font color=green>正在响铃...</font>";
                    
           }
           */
           
           
}
function SetOrderBy(inCol,inOrderBy) 
{
    //alert(Col + "  "+ OrderBy);
    Col=inCol;
    OrderBy=inOrderBy;
    //alert(Col + "  "+ OrderBy);
    
    
}

function handleErr(msg,url,l)
{
    alert("查询出问题，请点击 '开始' 按钮！");
    menu0  = document.all.Start;
    menu0.style.display = ""  ;
     
    
}
       function GetCurrtTime()
{
    var     m_today=new Date();
    var        strTime="";
    strTime += m_today.getYear() + "-" ;

    if( m_today.getMonth()+1 < 10 )
        strTime +=    "0";
    strTime +=     (m_today.getMonth()+1) + "-";

    if( m_today.getDate() < 10 )
        strTime +=    "0";
    strTime += m_today.getDate() + " ";

    if( m_today.getHours() < 10 )
        strTime +=    "0";
    strTime += m_today.getHours() + ":";

    if( m_today.getMinutes() < 10 )
        strTime +=    "0";
    strTime += m_today.getMinutes() + ":";

    if( m_today.getSeconds() < 10 )
        strTime +=    "0";
    strTime += m_today.getSeconds() ;

    return strTime;
}
 function groupChange(skill) 
{ 
 
       Skills=skill;
       //alert(Skills);
   
}
 </SCRIPT>
 {/literal} 

