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
<table width="860"  valign="top" border="0" cellpadding="0" cellspacing="1" >
  <tr >
  <td   height=30 width="560" background="{$system_config.img_url}/monitor/images/title.jpg">
   &nbsp;&nbsp;&nbsp;<img src="{$system_config.img_url}/monitor/images/select1.jpg" width="16" border=0 height="16" />&nbsp;&nbsp;<font style="font-size:16px; font-family:'宋体';color=white"><b> 系统实时监控</b></font>
 
  
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
系统实时监控
              </b></font>
      </td>
      </tr>
 <tr>
      <td colspan=6  height=20 align="center" valign="bottom">
          <font color=blue><div id="DivMonitorTime">当前时间:</div></font>
       </td>
      </tr>
 
</table>

             <table width="800" border=0 align="center" cellpadding="1" cellspacing="0">
              <tr>
                <td bgcolor="blue">
              
                    <table width="800"  border=0 align="center" cellpadding="0" cellspacing="0" >
                  <tr height=380>
                    <td width="" align="center" background="{$system_config.img_url}/monitor/images/bodybg.jpg" >
                    <table width="800"  border=0 cellpadding="0" cellspacing="0" >
                        <tr height=380 >
                         
                             <td>
                              <table border=0   cellpadding="0" cellspacing="0">
                                  <tr>
                                          <td align="center" width="50">&nbsp;</td>
                                            <td  valign="bottom"  height="360"> 
                                                <table border=0 cellpadding="0"  >
                                                    <tr>
                                                                 <td align="center" height="30">&nbsp;</td>
                                                                 <td align="center" width="36">
                                                                          <table border=0 cellpadding="0"  >    
                                                                                         <tr><td height=20 align="center" width=36 valign="bottom"><div id="DivTotalAgentNum">0</div></td></tr><td valign="bottom" id="TotalAgentNumH"  height="1" background="{$system_config.img_url}/monitor/images/BG1.gif"></td></tr>
                                                                                 </table>
                                                                  
                                                                  </td> 
                                                                  <td align="center" height="30">&nbsp;</td>
                                                    </tr>
                                              </table>
                                            </td>
                                            <td align="center" width="32">&nbsp;</td>
                                            <td  valign="bottom"  height="360"> 
                                                <table border=0 cellpadding="0"  >
                                                    <tr>
                                                                 <td align="center" height="30">&nbsp;</td>
                                                                 <td align="center" width="36">
                                                                          <table border=0 cellpadding="0"  >    
                                                                                         <tr><td height=20 align="center" width=36 valign="bottom"><div id="DivAnswerAgentNum">0</div></td></tr><td valign="bottom" id="AnswerAgentNumH"  height="1" background="{$system_config.img_url}/monitor/images/BG2.gif"></td></tr>
                                                                                 </table>
                                                                  
                                                                  </td> 
                                                                  <td align="center" height="30">&nbsp;</td>
                                                    </tr>
                                              </table>     
                                            </td>
                                            <td align="center" width="32">&nbsp;</td>
                                            <td  valign="bottom"  height="360"> 
                                                <table border=0 cellpadding="0" >
                                                    <tr> 
                                                                 <td align="center" height="30">&nbsp;</td>
                                                                 <td align="center" width="36">
                                                                          <table border=0 cellpadding="0"  >    
                                                                                         <tr><td height=20 align="center" width=36 valign="bottom"><div id="DivIdleAgentNum">0</div></td></tr><td valign="bottom" id="IdleAgentNumH"  height="1" background="{$system_config.img_url}/monitor/images/BG3.gif"></td></tr>
                                                                                 </table>
                                                                  
                                                                  </td> 
                                                                  <td align="center" height="30">&nbsp;</td>
                                                    </tr> 
                                                    </table>
                                            </td>
                                            <td align="center" width="32">&nbsp;</td>
                                            <td  valign="bottom"  height="360"> 
                                                <table border=0 cellpadding="0" >
                                                    <tr> 
                                                                 <td align="center" height="30">&nbsp;</td>
                                                                 <td align="center" width="36">
                                                                          <table border=0 cellpadding="0"  >    
                                                                                         <tr><td height=20 align="center" width=36 valign="bottom"><div id="DivOtherAgentNum">0</div></td></tr><td valign="bottom" id="OtherAgentNumH"  height="1" background="{$system_config.img_url}/monitor/images/BG4.gif"></td></tr>
                                                                                 </table>
                                                                  
                                                                  </td> 
                                                              <td align="center" height="30">&nbsp;</td>
                                                    </tr>  
                                                    </table>
                                            </td>
                                            <td align="center" width="32">&nbsp;</td>
                                            <td  valign="bottom"  height="360"> 
                                                <table border=0 cellpadding="0" >
                                                    <tr> 
                                                                 <td align="center" height="30">&nbsp;</td>
                                                                 <td align="center" width="36">
                                                                          <table border=0 cellpadding="0"  >    
                                                                                         <tr><td height=20 align="center" width=36 valign="bottom"><div id="DivAfterWorkAgentNum">0</div></td></tr><td valign="bottom" id="AfterWorkAgentNumH"  height="1" background="{$system_config.img_url}/monitor/images/BG5.gif"></td></tr>
                                                                                 </table>
                                                                  
                                                                  </td> 
                                                              <td align="center" height="30">&nbsp;</td>
                                                    </tr>  
                                                    </table>
                                            </td>
                                             
                                            <td align="center" width="32">&nbsp;</td>
                                            <td  valign="bottom"  height="360"> 
                                                <table border=0 cellpadding="0" >
                                                    <tr> 
                                                                 <td align="center" width="12">&nbsp;</td>
                                                                 <td align="center" width="36">
                                                                          <table border=0 cellpadding="0"  >    
                                                                                         <tr><td height=20 align="center" width=36 valign="bottom"><div id="DivReqTransAgentNum">0</div></td></tr><td valign="bottom" id="ReqTransAgentNumH"  height="1" background="{$system_config.img_url}/monitor/images/BG6.gif"></td></tr>
                                                                                 </table>
                                                                  
                                                                  </td> 
                                                              <td align="center" height="30">&nbsp;</td> 
                                                    </tr>
                                                    </table>
                                            </td> 
                                            <td align="center" width="32">&nbsp;</td>
                                            <td  valign="bottom"  height="360"> 
                                                <table border=0 cellpadding="0" >
                                                    <tr> 
                                                                 <td align="center" height="30">&nbsp;</td>
                                                                 <td align="center" width="36">
                                                                          <table border=0 cellpadding="0"  >    
                                                                                         <tr><td height=20 align="center" width=36 valign="bottom"><div id="DivQueueSuccNum">0</div></td></tr><td valign="bottom" id="QueueSuccNumH" height="1" background="{$system_config.img_url}/monitor/images/BG7.gif"></td></tr>
                                                                                 </table>
                                                                  
                                                                  </td> 
                                                              <td align="center" height="30">&nbsp;</td> 
                                                    </tr> 
                                                    </table>
                                            </td> 
                                            <td align="center" width="32">&nbsp;</td>
                                            <td  valign="bottom"  height="360"> 
                                                <table border=0 cellpadding="0" >
                                                    <tr> 
                                                                 <td align="center" height="30">&nbsp;</td>
                                                                 <td align="center" width="36">
                                                                          <table border=0 cellpadding="0"  >    
                                                                                         <tr><td height=20 align="center" width=36 valign="bottom"><div id="DivQueueFailNum">0</div></td></tr><td valign="bottom" id="QueueFailNumH" height="1" background="{$system_config.img_url}/monitor/images/BG8.gif"></td></tr>
                                                                                 </table>
                                                                  
                                                                  </td> 
                                                              <td align="center" height="30">&nbsp;</td> 
                                                    </tr>  
                                                    </table>
                                            </td>  
                                            <td align="center" width="10">&nbsp;</td>
                                </tr>
                                <tr>
                                        <td align="center"  >&nbsp;</td>
                                                <td align="center" valign="top" >坐席总数</td>
                                                <td align="center" width="32">&nbsp;</td>
                                                <td align="center" valign="top" >通话坐席数</td>
                                                <td align="center" width="32">&nbsp;</td>
                                                <td align="center" valign="top" >置闲坐席数</td>
                                                <td align="center" width="32">&nbsp;</td>
                                                <td align="center" valign="top" >置忙坐席数</td> 
                                                <td align="center" width="32">&nbsp;</td>
                                                <td align="center" valign="top" >事后整理数</td> 
                                                <td align="center" width="32">&nbsp;</td>
                                                <td align="center" valign="top" >请求转人工数</td>
                                                <td align="center" width="32">&nbsp;</td>
                                                <td align="center" valign="top" >排队成功数</td>
                                                <td align="center" width="32">&nbsp;</td>
                                                <td align="center" valign="top" >排队失败数</td>
                                                <td align="center" width="10">&nbsp;</td>
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
  var AddressID={$skill};
  {literal}
  var pno=0;var agentpno=1; var AgentModule=169; var ServerID=108;var Skills="%";var WhereSkill="";
  document.getElementById("DivMonitorTime").innerHTML=GetCurrtTime();
  //setTimeout("initial()",5000); 
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
          pno={/literal}{$pno2}{literal};/*parseInt(pno);*/  
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
    var recordCount=0;var retcode=-1;
  var MaxNum,DivTotalAgentNum,DivAnswerAgentNum,DivIdleAgentNum,DivAfterWorkAgentNum,DivOtherAgentNum;
    var DivTotalSessionNum,DivReqTransAgentNum,DivQueueSuccNum,DivQueueFailNum,HeightNum;
     
    document.getElementById("DivMonitorTime").innerHTML=GetCurrtTime();
    WhereSkill="(skills ='"+Skills+"' or skills like '"+Skills+",%' or skills like '%,"+Skills+",%' or skills like '%,"+Skills+"')";
    var SQLCmd="select count(*) from cc_moperstatus where vcid="+AddressID+" And "+WhereSkill;
  //alert(SQLCmd);
  //*************DivTotalAgentNum***************** 
  retcode = dbCtrlObject.Open(SQLCmd, ServerID);
 
    if(retcode != 0)
    { 
            alert("连接数据库失败1，请查询原因,然后再点击'开始'按狃");
            menu0  = document.all.Start;
          menu0.style.display = ""  ;
            return;
    }
    //获取结果数目
    recordCount = dbCtrlObject.GetRetCount();
    if (recordCount <= 0)
    {
          alert("连接数据库失败2，请查询原因,然后再点击'开始'按狃");
          menu0  = document.all.Start;
      menu0.style.display = ""  ;
          return;
    } 
    dbCtrlObject.GoToFirst(); 
    DivTotalAgentNum = dbCtrlObject.ResultToInt(0);
    
    
    
    //*************DivAnswerAgentNum*****************
 SQLCmd="select count(*) from cc_moperstatus where mainstatus=3 and vcid="+AddressID+" And "+WhereSkill;
    retcode = dbCtrlObject.Open(SQLCmd, ServerID); 
    if(retcode != 0)
    { 
            alert("连接数据库失败3，请查询原因,然后再点击'开始'按狃");
            menu0  = document.all.Start;
      menu0.style.display = ""  ;
            return;
    }      
    recordCount = dbCtrlObject.GetRetCount();
    if (recordCount <= 0)
    {
          alert("连接数据库失败4，请查询原因,然后再点击'开始'按狃");
          menu0  = document.all.Start;
      menu0.style.display = ""  ;
          return;
    } 
    dbCtrlObject.GoToFirst(); 
    DivAnswerAgentNum = dbCtrlObject.ResultToInt(0);
                        
        //*************DivIdleAgentNum*****************
  SQLCmd="select count(*) from cc_moperstatus where mainstatus=2 and vcid="+AddressID+" And "+WhereSkill;
    retcode = dbCtrlObject.Open(SQLCmd, ServerID); 
    if(retcode != 0)
    { 
            alert("连接数据库失败5，请查询原因,然后再点击'开始'按狃");
            menu0  = document.all.Start;
      menu0.style.display = ""  ;
            return;
    } 
    recordCount = dbCtrlObject.GetRetCount();
    if (recordCount <= 0)
    {
          alert("连接数据库失败6，请查询原因,然后再点击'开始'按狃");
          menu0  = document.all.Start;
      menu0.style.display = ""  ;
          return;
    } 
    dbCtrlObject.GoToFirst(); 
    DivIdleAgentNum = dbCtrlObject.ResultToInt(0);
                     

          //*************DivAfterWorkAgentNum*****************
  SQLCmd="select count(*) from cc_moperstatus where mainstatus=4 and vcid="+AddressID+" And "+WhereSkill;
    retcode = dbCtrlObject.Open(SQLCmd, ServerID); 
    if(retcode != 0)
    { 
            alert("连接数据库失败7，请查询原因,然后再点击'开始'按狃");
            menu0  = document.all.Start;
      menu0.style.display = ""  ;
            return;
    } 
    recordCount = dbCtrlObject.GetRetCount();
    if (recordCount <= 0)
    {
          alert("连接数据库失败8，请查询原因,然后再点击'开始'按狃");
          menu0  = document.all.Start;
      menu0.style.display = ""  ;
          return;
    } 
    dbCtrlObject.GoToFirst(); 
    DivAfterWorkAgentNum = dbCtrlObject.ResultToInt(0); 

    HeightNum=360;MaxNum=1;  
    DivOtherAgentNum=DivTotalAgentNum-DivAnswerAgentNum-DivIdleAgentNum-DivAfterWorkAgentNum;
    if(DivOtherAgentNum<0)
          DivOtherAgentNum=0; 
             //*************DivReqTransAgentNum*****************
    WhereSkill="skillid ="+Skills;
  SQLCmd="select sum(n_queue) from cc_mqueuestatcur where  vcid="+AddressID+" And "+WhereSkill;
  //alert(SQLCmd);
    retcode = dbCtrlObject.Open(SQLCmd, ServerID); 
    if(retcode != 0)
    { 
            alert("连接数据库失败9，请查询原因,然后再点击'开始'按狃");
            menu0  = document.all.Start;
      menu0.style.display = ""  ;
            return;
    } 
    recordCount = dbCtrlObject.GetRetCount();
    if (recordCount <= 0)
    {
          alert("连接数据库失败10，请查询原因,然后再点击'开始'按狃");
          menu0  = document.all.Start;
      menu0.style.display = ""  ;
          return;
    } 
    dbCtrlObject.GoToFirst();  
    DivReqTransAgentNum = dbCtrlObject.ResultToStr(0); 
     
    if(DivReqTransAgentNum=="")
          DivReqTransAgentNum=0;  
                 //*************DivQueueSuccNum*****************
  SQLCmd="select sum(n_queueok) from cc_mqueuestatcur where  vcid="+AddressID+" And "+WhereSkill;
    retcode = dbCtrlObject.Open(SQLCmd, ServerID); 
    if(retcode != 0)
    { 
            alert("连接数据库失败11，请查询原因,然后再点击'开始'按狃");
            menu0  = document.all.Start;
      menu0.style.display = ""  ;
            return;
    } 
    recordCount = dbCtrlObject.GetRetCount();
    if (recordCount <= 0)
    {
          alert("连接数据库失败12，请查询原因,然后再点击'开始'按狃");
          menu0  = document.all.Start;
      menu0.style.display = ""  ;
          return;
    } 
    dbCtrlObject.GoToFirst(); 
    DivQueueSuccNum = dbCtrlObject.ResultToStr(0); 
  
    if(DivQueueSuccNum=="")
          DivQueueSuccNum=0; 
              
    DivQueueFailNum=DivReqTransAgentNum-DivQueueSuccNum; 
    if(DivQueueFailNum<0)
        DivQueueFailNum=0;
        
    SQLCmd="Select count(*) from cc_mqueuedetail where  vcid = "+AddressID+" and queuestatus=1 And "+WhereSkill;   
  //alert(SQLCmd);
    retcode = dbCtrlObject.Open(SQLCmd, ServerID); 
    if(retcode != 0)
    { 
            alert("连接数据库失败15，请查询原因,然后再点击'开始'按狃");
            menu0  = document.all.Start;
      menu0.style.display = ""  ;
            return;
    } 
    recordCount = dbCtrlObject.GetRetCount();
    if (recordCount <= 0)
    {
          alert("连接数据库失败16，请查询原因,然后再点击'开始'按狃");
          menu0  = document.all.Start;
      menu0.style.display = ""  ;
          return;
    } 
    dbCtrlObject.GoToFirst();  
    DivReqTransAgentNum = dbCtrlObject.ResultToStr(0); 
     
    if(DivReqTransAgentNum=="")
          DivReqTransAgentNum=0; 
          
    if(parseInt(MaxNum)<=parseInt(DivTotalAgentNum))MaxNum=DivTotalAgentNum;
    if(parseInt(MaxNum)<=parseInt(DivAnswerAgentNum))MaxNum=DivAnswerAgentNum;    
    if(parseInt(MaxNum)<=parseInt(DivIdleAgentNum))MaxNum=DivIdleAgentNum;
    if(parseInt(MaxNum)<=parseInt(DivAfterWorkAgentNum))MaxNum=DivAfterWorkAgentNum;
    if(parseInt(MaxNum)<=parseInt(DivOtherAgentNum))MaxNum=DivOtherAgentNum;
     
    if(parseInt(MaxNum)<=parseInt(DivReqTransAgentNum))MaxNum=DivReqTransAgentNum;
    if(parseInt(MaxNum)<=parseInt(DivQueueSuccNum))MaxNum=DivQueueSuccNum;
    if(parseInt(MaxNum)<=parseInt(DivQueueFailNum))MaxNum=DivQueueFailNum; 
    
    document.getElementById("TotalAgentNumH").height=DivTotalAgentNum*HeightNum/MaxNum+1;
    document.getElementById("DivTotalAgentNum").innerHTML=DivTotalAgentNum;
    document.getElementById("AnswerAgentNumH").height=DivAnswerAgentNum*HeightNum/MaxNum+1;
    document.getElementById("DivAnswerAgentNum").innerHTML=DivAnswerAgentNum;
    document.getElementById("IdleAgentNumH").height=DivIdleAgentNum*HeightNum/MaxNum+1;
    document.getElementById("DivIdleAgentNum").innerHTML=DivIdleAgentNum;
    document.getElementById("AfterWorkAgentNumH").height=DivAfterWorkAgentNum*HeightNum/MaxNum+1;
    document.getElementById("DivAfterWorkAgentNum").innerHTML=DivAfterWorkAgentNum;
    document.getElementById("OtherAgentNumH").height=DivOtherAgentNum*HeightNum/MaxNum+1;
    document.getElementById("DivOtherAgentNum").innerHTML=DivOtherAgentNum;
     
    document.getElementById("ReqTransAgentNumH").height=DivReqTransAgentNum*HeightNum/MaxNum+1;
    document.getElementById("DivReqTransAgentNum").innerHTML=DivReqTransAgentNum;
    document.getElementById("QueueSuccNumH").height=DivQueueSuccNum*HeightNum/MaxNum+1;
    document.getElementById("DivQueueSuccNum").innerHTML=DivQueueSuccNum;
    document.getElementById("QueueFailNumH").height=DivQueueFailNum*HeightNum/MaxNum+1; 
    document.getElementById("DivQueueFailNum").innerHTML=DivQueueFailNum;
    //alert(DivReqTransAgentNum+"    "+MaxNum+"  "+HeightNum)
    
    menu0  = document.all.Start;
  menu0.style.display = "none"  ;
  setTimeout("GetInfo()",10000);
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
      // alert(Skills);
   
}
 </SCRIPT>
{/literal} 
   

