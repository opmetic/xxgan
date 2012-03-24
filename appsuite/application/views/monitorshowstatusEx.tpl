<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

 <link rel="stylesheet" type="text/css" href="{$system_config.img_url}/monitor/index_2.css">
<title>DBClient</title>
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

<div style="border:#94C4E8  solid 1px;width=1060;"> 
<table width="1060"  valign="top" border="0" cellpadding="0" cellspacing="0">
<tr>
<td bgcolor="#E0EDF6" background="{$system_config.img_url}/monitor/images/bodybg.gif"> 
	<table width="1060"  valign="top" border="0" cellpadding="0" cellspacing="1" >
	  <tr >
	  <td   height=30 width="40%" background="{$system_config.img_url}/monitor/images/title.jpg">
	   &nbsp;&nbsp;&nbsp;<img src="{$system_config.img_url}/monitor/images/select1.jpg" width="16" border=0 height="16" />&nbsp;&nbsp;<font style="font-size:16px; font-family:'宋体';color=white"><b> 系统实时监控</b></font>
	 
	  </td>	
	  <td   height=30 align="left" width="50%" background="{$system_config.img_url}/monitor/images/title.jpg">&nbsp;技能组：
					         <select  name="Skills"   ID="Skills"     style="HEIGHT: 25px;">
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
						      </select>&nbsp;&nbsp;&nbsp;&nbsp;
														      
														         
    						 <select  name="DealType"   ID="DealType" style="HEIGHT: 25px;">
					         	           <option value="Replace">替换</option> 
	               							 <option value="New">新增</option>									               							 
	               							 <option value="Close">关闭</option> 							 
						      </select>&nbsp;&nbsp;&nbsp;&nbsp;
						      
						      <select  name="WindowsNum"  ID="WindowsNum"    style="HEIGHT: 25px;">
					         	           <option value="1">窗口1</option> 
	               							 <option value="2">窗口2</option>									               							 
	               							 <option value="3">窗口3</option>
	               							 <option value="4">窗口4</option>
	 
						      </select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						      <input type="button" name="DealInfo" ID="DealInfo"  onclick="Deal()" size=6 value="操  作" style="HEIGHT: 25px;display:none;" >
		 </td>	
	   <td   height=30 align="center" width="10%" background="{$system_config.img_url}/monitor/images/title.jpg"> 
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
	 		<tr>
		  <td colspan=6  height=20 align="center" valign="bottom">
			  	<table>
				  	<tr>
				  			<td style="padding: 0px">
				  				<iframe width="860"     height="500" style="display:ok; margin: 0px;" bordercolor="#009900"  name="Frame1" id="Frame1" src="{$system_config.img_url}/monitor/showstatusexnode" frameborder=0></iframe>
				  			</td>
				  		  <td>
				  		  	<iframe width="860"    height="500"  style="display:none;" marginWidth=0 marginHeight=0   bordercolor="#009900"  name="Frame2" id="Frame2" src="{$system_config.img_url}/monitor/showstatusexnode" frameborder=0></iframe>
				  		  </td>
				  	</tr>
				  	<tr>
				  			<td>
				  				<iframe width="860"    height="500"  style="display:none;" marginWidth=0 marginHeight=0   bordercolor="#009900"  name="Frame3" id="Frame3" src="{$system_config.img_url}/monitor/showstatusexnode" frameborder=0></iframe>
				  			</td>
				  		  <td>
				  		  	<iframe width="860"    height="500"   style="display:none;" marginWidth=0 marginHeight=0   bordercolor="#009900"  name="Frame4" id="Frame4" src="{$system_config.img_url}/monitor/showstatusexnode" frameborder=0></iframe>
				  		  </td>
				  	</tr>
			  	</table>
	   	</td>
		  </tr>
	</table>
									 
</td>

</tr>
</table>
</div>
 
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
    
  var CurNum=0;var S1Name="";var S2Name="";var S3Name="";var S4Name="";
  var S1Text="";var S2Text="";var S3Text="";var S4Text="";
  var recordCount=0;var retcode=-1;var HDiv=1;var WDiv=1;
  var MaxNum,DivTotalAgentNum,DivAnswerAgentNum,DivIdleAgentNum,DivAfterWorkAgentNum,DivOtherAgentNum;
	var DivTotalSessionNum,DivReqTransAgentNum,DivQueueSuccNum,DivQueueFailNum,HeightNum;
  var PreSetWidth=860;var PreSetHeight=500;var HeightNum=360;
  var LastSetWidth=1010;var LastSetHeight=572; var DoFlag=0;
  
function initial()
{
	  dbCtrlObject = document.getElementById("dbCtrlObject");
      if(dbCtrlObject!=null)
      {
          return;
      }                    
      var ocxStr = "<OBJECT ID='dbCtrlObject' CLASSID='clsid:2DC52736-0472-11D4-B481-0080C87A8CFB' STYLE='width:0px;height:0px'></OBJECT><br></div>";
      var oDiv=document.createElement("DIV");
      oDiv.innerHTML = ocxStr;
      document.body.appendChild(oDiv);
      dbCtrlObject = document.getElementById("dbCtrlObject");    

	  pno={/literal}{$pno2}{literal};  
		
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
        else
        {
        //    alert(" 连接CTI成功");   
        }

        document.getElementById("DivMonitorTime").innerHTML=GetCurrtTime();
		S1Name=document.getElementById("Skills").value;
		S1Text=document.getElementById("Skills").options[document.getElementById("Skills").selectedIndex].text;
		S2Name="";  S3Name="";  S4Name="";CurNum=1;
		menu0=document.all.DealInfo;	  	  	   	   
  	    menu0.style.display="";
        setTimeout("GetAllInfo()",1000);  
}
  

function GetAllInfo()
{

	  DoFlag=1;
		document.getElementById("DivMonitorTime").innerHTML=GetCurrtTime();
		CNum=GetTotalMonitorWindowNum();
 
	  if(S1Name=="")
	  {
	 		menu0=document.all.Frame1;	  	  	   	   
			menu0.style.display="none";
	  }
	  else
	  {
	  	   
	  	   GetInfo(S1Name); 
	  	   menu0=document.all.Frame1;	
	  	   if(CNum==1)
	  	   {
	  	   		menu0.width=PreSetWidth;
	  	   		menu0.height=PreSetHeight;
	  	   		HDiv=1;WDiv=1;
	  	   } 
	  	   if(CNum==2)
	  	   {
	  	   		menu0.width=LastSetWidth/2;
	  	   		menu0.height=PreSetHeight;
	  	   		HDiv=1;WDiv=2;
	  	   } 
	  	   if(CNum==3 || CNum==4)
	  	   {
	  	   		menu0.width=LastSetWidth/2;
	  	   		menu0.height=LastSetHeight/2;
	  	   		HDiv=2;WDiv=2;
	  	   }  	   
	  	   menu0.style.display="";

	  	   Frame1.UpdateInfo(DivTotalAgentNum,DivAnswerAgentNum,DivIdleAgentNum,DivAfterWorkAgentNum,DivOtherAgentNum,DivReqTransAgentNum,DivQueueSuccNum,DivQueueFailNum, S1Text,WDiv,HDiv,HeightNum);	
	  }
	  if(S2Name=="")
	  {
	 			 menu0=document.all.Frame2;	  	  	   	   
	  	   menu0.style.display="none";
	  }
	  else
	  {
	  	   
	  	   GetInfo(S2Name); 
	  	   menu0=document.all.Frame2;	  
	  	   if(CNum==1)
	  	   {
	  	   		menu0.width=PreSetWidth;
	  	   		menu0.height=PreSetHeight;
	  	   		HDiv=1;WDiv=1;
	  	   } 
	  	   if(CNum==2)
	  	   {
	  	   		menu0.width=LastSetWidth/2;
	  	   		menu0.height=PreSetHeight;
	  	   		HDiv=1;WDiv=2;
	  	   } 
	  	   if(CNum==3 || CNum==4)
	  	   {
	  	   		menu0.width=LastSetWidth/2;
	  	   		menu0.height=LastSetHeight/2;
	  	   		HDiv=2;WDiv=2;
	  	   }  	   
	  	   menu0.style.display="";
	  	   Frame2.UpdateInfo(DivTotalAgentNum,DivAnswerAgentNum,DivIdleAgentNum,DivAfterWorkAgentNum,DivOtherAgentNum,DivReqTransAgentNum,DivQueueSuccNum,DivQueueFailNum,S2Text,WDiv,HDiv,HeightNum);	
	  }
	  
	  if(S3Name=="")
	  {
	 			 menu0=document.all.Frame3;	  	  	   	   
	  	   menu0.style.display="none";
	  }
	  else
	  {
	  	  
	  	   GetInfo(S3Name); 
 
	  	   menu0=document.all.Frame3;	  
	  	   if(CNum==1)
	  	   {
	  	   		menu0.width=PreSetWidth;
	  	   		menu0.height=PreSetHeight;
	  	   		HDiv=1;WDiv=1;
	  	   } 
	  	   if(CNum==2)
	  	   {
	  	   		menu0.width=LastSetWidth/2;
	  	   		menu0.height=PreSetHeight;
	  	   		HDiv=1;WDiv=2;
	  	   } 
	  	   if(CNum==3 || CNum==4)
	  	   {
	  	   		menu0.width=LastSetWidth/2;
	  	   		menu0.height=LastSetHeight/2;
	  	   		HDiv=2;WDiv=2;
	  	   }  	   
	  	   menu0.style.display="";
	  	   Frame3.UpdateInfo(DivTotalAgentNum,DivAnswerAgentNum,DivIdleAgentNum,DivAfterWorkAgentNum,DivOtherAgentNum,DivReqTransAgentNum,DivQueueSuccNum,DivQueueFailNum,S3Text,WDiv,HDiv,HeightNum);	
	  }
	  
	  if(S4Name=="")
	  {
	 			 menu0=document.all.Frame4;	  	  	   	   
	  	   menu0.style.display="none";
	  }
	  else
	  {
	  	   
	  	   GetInfo(S4Name); 
	  	   menu0=document.all.Frame4;	  
	  	   if(CNum==1)
	  	   {
	  	   		menu0.width=PreSetWidth;
	  	   		menu0.height=PreSetHeight;
	  	   		HDiv=1;WDiv=1;
	  	   } 
	  	   if(CNum==2)
	  	   {
	  	   		menu0.width=LastSetWidth/2;
	  	   		menu0.height=PreSetHeight;
	  	   		HDiv=1;WDiv=2;
	  	   } 
	  	   if(CNum==3 || CNum==4)
	  	   {
	  	   		menu0.width=LastSetWidth/2;
	  	   		menu0.height=LastSetHeight/2;
	  	   		HDiv=2;WDiv=2;
	  	   }  	   
	  	   menu0.style.display=""; 
	  	   Frame4.UpdateInfo(DivTotalAgentNum,DivAnswerAgentNum,DivIdleAgentNum,DivAfterWorkAgentNum,DivOtherAgentNum,DivReqTransAgentNum,DivQueueSuccNum,DivQueueFailNum,S4Text,WDiv,HDiv,HeightNum);	
	  }
 
	  
 
		menu0  = document.all.Start;
    menu0.style.display = "none"  ;
    setTimeout("GetAllInfo()",10000);
 
}  
  
  
  
  

 
function GetInfo(inskill)
{     
	    document.getElementById("DivMonitorTime").innerHTML=GetCurrtTime();
	    WhereSkill="(skills ='"+inskill+"' or skills like '"+inskill+",%' or skills like '%,"+inskill+",%' or skills like '%,"+inskill+"')";
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
	    WhereSkill="skillid ="+inskill;
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
}






function handleErr(msg,url,l)
{
    alert("查询出问题，请点击 '开始' 按钮！");
    menu0  = document.all.Start;
    menu0.style.display = ""  ;
      
}
   	function GetCurrtTime()
{
	var 	m_today=new Date();
	var		strTime="";
	strTime += m_today.getYear() + "-" ;

	if( m_today.getMonth()+1 < 10 )
		strTime +=	"0";
	strTime +=	 (m_today.getMonth()+1) + "-";

	if( m_today.getDate() < 10 )
		strTime +=	"0";
	strTime += m_today.getDate() + " ";

	if( m_today.getHours() < 10 )
		strTime +=	"0";
	strTime += m_today.getHours() + ":";

	if( m_today.getMinutes() < 10 )
		strTime +=	"0";
	strTime += m_today.getMinutes() + ":";

	if( m_today.getSeconds() < 10 )
		strTime +=	"0";
	strTime += m_today.getSeconds() ;

	return strTime;
}
 function Deal() 
{ 
	   var dotype="";var replacenum=1;var cnum=0;
	   var SName="";var SText="";var skill="";var txt="";
     
 
	   if(GetTotalMonitorWindowNum()<=0)return;
 
	   if(DoFlag==0) 
     	   return;
 
   skill=document.getElementById("Skills").value;
   txt=document.getElementById("Skills").options[document.getElementById("Skills").selectedIndex].text;    
   dotype=document.getElementById("DealType").value; 
   if(dotype=="Replace")
   {
        replacenum= document.getElementById("WindowsNum").value;
        for(var i=0;i<1;i++)
   	    {
          	if(replacenum==1)
	   	    	{
	   	    			S1Name=skill;S1Text=txt;break;
	   	    	}
	   	    	if(replacenum==2)
	   	    	{
	   	    			S2Name=skill;S2Text=txt;break;
	   	    	}
	   	    	if(replacenum==3)
	   	    	{
	   	    			S3Name=skill;S3Text=txt;break;
	   	    	}
	   	    	if(replacenum==4)
	   	    	{
	   	    			S4Name=skill;S4Text=txt;break;
	   	    	}	 
	   	   }
	   	 //alert(replacenum+"   s1:    "+S1Name+"   s2:    "+S2Name+"   s3:    "+S3Name+"   s4:    "+S4Name);
   }
   if(dotype=="New")
   {
   	    if(skill==S1Name || skill==S2Name || skill==S3Name || skill==S4Name )
   	    {
   	    	  // alert("重复监控!");
   	    	  return;
   	    }
   	    for(var i=0;i<1;i++)
   	    {   	    
	   	    	if(S1Name=="")
	   	    	{
	   	    			S1Name=skill;S1Text=txt;break;
	   	    	}
	   	    	if(S2Name=="")
	   	    	{
	   	    			S2Name=skill;S2Text=txt;break;
	   	    	}
	   	    	if(S3Name=="")
	   	    	{
	   	    			S3Name=skill;S3Text=txt;break;
	   	    	}
	   	    	if(S4Name=="")
	   	    	{
	   	    			S4Name=skill;S4Text=txt;break;
	   	    	}
	   	    	replacenum= document.getElementById("WindowsNum").value;
	   	    	
 
	   	    	if(replacenum==1)
	   	    	{
	   	    			S1Name=skill;S1Text=txt;break;
	   	    	}
	   	    	if(replacenum==2)
	   	    	{
	   	    			S2Name=skill;S2Text=txt;break;
	   	    	}
	   	    	if(replacenum==3)
	   	    	{
	   	    			S3Name=skill;S3Text=txt;break;
	   	    	}
	   	    	if(replacenum==4)
	   	    	{
	   	    			S4Name=skill;S4Text=txt;break;
	   	    	}	   	    		
   	    }
   		//  alert(S1Name+"   b  "+S2Name+"  c   "+S3Name+"  d   "+S4Name);
   		  
   }
    
  
  if(dotype=="Close")
   {
   	  if(GetTotalMonitorWindowNum()<=1)return;
   	   
	    for(var i=0;i<1;i++)
   	    {   	 
   	    	  var winnum= document.getElementById("WindowsNum").value;   
	   	    	if(winnum==1)
	   	    	{
	   	    			S1Name="";S1Text="";menu0=document.all.Frame1;menu0.style.display="none";break;
	   	    	}
	   	    	if(winnum==2)
	   	    	{
	   	    			S2Name="";S2Text="";menu0=document.all.Frame2;menu0.style.display="none";break;
	   	    	}
	   	    	if(winnum==3)
	   	    	{
	   	    			S3Name="";S3Text="";menu0=document.all.Frame3;menu0.style.display="none";break;
	   	    	}
	   	    	if(winnum==4)
	   	    	{
	   	    			S4Name="";S4Text="";menu0=document.all.Frame4;menu0.style.display="none";break;
	   	    	}
	   	  }
	     		 
	 }   
	 
	if(GetTotalMonitorWindowNum()==2)
	 {
		   	  	for(var i=0;i<1;i++)
		 				{
				   	  	  if(S1Name=="")
				   	  	  {
					   	  	  	if(S2Name!="")
					   	  	  	{
					   	  	  		S1Name=S2Name;S1Text=S2Text;S2Text="";S2Name="";break;
					   	  	  	}
					   	  	  	if(S3Name!="")
					   	  	  	{
					   	  	  		S1Name=S3Name;S1Text=S3Text;S3Text="";S3Name="";break;
					   	  	  	}
					   	  	  	if(S4Name!="")
					   	  	  	{
					   	  	  		S1Name=S4Name;S1Text=S4Text;S4Text="";S4Name="";break;
					   	  	  	}
				   	  	  	
				   	  	  }	
		   	  	}	
		   	  	for(var i=0;i<1;i++)
		 				{
				   	  	  if(S2Name=="")
				   	  	  {
					   	  	   
					   	  	  	if(S3Name!="")
					   	  	  	{
					   	  	  		S2Name=S3Name;S2Text=S3Text;S3Text="";S3Name="";break;
					   	  	  	}
					   	  	  	if(S4Name!="")
					   	  	  	{
					   	  	  		S2Name=S4Name;S2Text=S4Text;S4Text="";S4Name="";break;
					   	  	  	}
				   	  	  	
				   	  	  }	
		   	  	}	
	  }
	  
	  DoFlag=0;
}
function GetTotalMonitorWindowNum()
{
	var wNum=0;
	if(S1Name!="")
			wNum++;
	if(S2Name!="")
			wNum++;
  if(S3Name!="")
			wNum++;
  if(S4Name!="")
			wNum++;
  return wNum;		
	
}
 </SCRIPT> 
{/literal}


   

