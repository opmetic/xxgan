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
<body leftMargin=0 style="padding: 0px;margin:0px;" background="{$system_config.img_url}/monitor/images/bodybg.gif" >     
             <table width="860" style="margin-top:0px;" id=FTable border=0 align="center" cellpadding="1" cellspacing="0">
              <tr>
                <td bgcolor="blue">
              
                	<table width="100%"  border=0 align="center" cellpadding="0" cellspacing="0" >
                  <tr height=380 id=FTR >
                    <td width="" align="center"  valign="bottom"  background="{$system_config.img_url}/monitor/images/bodybg.jpg" >
                    <table width="100%"  border=0 cellpadding="0" cellspacing="0" >
                    	<tr  >
                    	     <td >
                    	      <table border=0  cellpadding="0" cellspacing="0">
                    	      	<tr>
                            	      	<td align="center" id=TD1 width="50">&nbsp;</td>
                            		    	<td  valign="bottom"  > 
                            		        	<table border=0 cellpadding="0"  >
                            		        		<tr>
                            		        		         	<td align="center"  height="30">&nbsp;</td>
                            		        		         	<td align="center" width="36">
		                            		        		         	 <table border=0 cellpadding="0"  >    
		                            		        		     						<tr><td height=20 align="center" width=36 valign="bottom"><div id="DivTotalAgentNum">0</div></td></tr><td valign="bottom" id="TotalAgentNumH"  height="1" background="{$system_config.img_url}/monitor/images/BG1.gif"></td></tr>
		                            		        							 </table>
                            		        		         	 
                            		        		         	 </td> 
                            		        		         	 <td align="center" height="30">&nbsp;</td>
                            		        		</tr>
                            		          </table>
                            		    	</td>
                            		    	<td align="center" id=TD2  width="32">&nbsp;</td>
                            		    	<td  valign="bottom"  > 
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
                            		    	<td align="center"  id=TD3 width="32">&nbsp;</td>
                            		    	<td  valign="bottom"  > 
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
                            		    	<td align="center" id=TD4  width="32">&nbsp;</td>
                            		    	<td  valign="bottom"  > 
                            		        	<table border=0 cellpadding="0" >
                            		        		<tr> 
                            		        		         	<td align="center" height="30">&nbsp;</td>
                            		        		         	<td align="center" width="36">
		                            		        		         	 <table border=0 cellpadding="0"  >    
		                            		        		     						<tr><td height=20 align="center" width=36 valign="bottom"><div id="DivOtherAgentNum">0</div></td></tr><td valign="bottom" id="OtherAgentNumH"  height="1" background="{$system_config.img_url}/monitor/images/BG5.gif"></td></tr>
		                            		        							 </table>
                            		        		         	 
                            		        		         	 </td> 
                            		        		          <td align="center" height="30">&nbsp;</td>
                            		        		</tr>  
                            		        		</table>
                            		    	</td>
                            		    	<td align="center"  id=TD5 width="32">&nbsp;</td>
                            		    	<td  valign="bottom"  > 
                            		        	<table border=0 cellpadding="0" >
                            		        		<tr> 
                            		        		         	<td align="center" height="30">&nbsp;</td>
                            		        		         	<td align="center" width="36">
		                            		        		         	 <table border=0 cellpadding="0"  >    
		                            		        		     						<tr><td height=20 align="center" width=36 valign="bottom"><div id="DivAfterWorkAgentNum">0</div></td></tr><td valign="bottom" id="AfterWorkAgentNumH"  height="1" background="{$system_config.img_url}/monitor/images/BG4.gif"></td></tr>
		                            		        							 </table>
                            		        		         	 
                            		        		         	 </td> 
                            		        		          <td align="center" height="30">&nbsp;</td>
                            		        		</tr>  
                            		        		</table>
                            		    	</td>
                            		    	 
                            		    	<td align="center"  id=TD6 width="32">&nbsp;</td>
                            		    	<td  valign="bottom"  > 
                            		        	<table border=0 cellpadding="0" >
                            		        		<tr> 
                            		        		         	<td align="center" width="12">&nbsp;</td>
                            		        		         	<td align="center" width="36">
		                            		        		         	 <table border=0 cellpadding="0"  >    
		                            		        		     						<tr><td height=20 align="center" width=36 valign="bottom"><div id="DivReqTransAgentNum">0</div></td></tr><td valign="bottom" id="ReqTransAgentNumH"  title=""  height="1" background="{$system_config.img_url}/monitor/images/BG6.gif"></td></tr>
		                            		        							 </table>
                            		        		         	 
                            		        		         	 </td> 
                            		        		          <td align="center" height="30">&nbsp;</td> 
                            		        		</tr>
                            		        		</table>
                            		    	</td> 
                            		    	<td align="center"  id=TD7 width="32">&nbsp;</td>
                            		    	<td  valign="bottom"  > 
                            		        	<table border=0 cellpadding="0" >
                            		        		<tr> 
                            		        		         	<td align="center" height="30">&nbsp;</td>
                            		        		         	<td align="center" width="36">
		                            		        		         	 <table border=0 cellpadding="0"  >    
		                            		        		     						<tr><td height=20 align="center" width=36 valign="bottom"><div id="DivQueueSuccNum">0</div></td></tr><td valign="bottom" id="QueueSuccNumH"  title="" height="1" background="{$system_config.img_url}/monitor/images/BG7.gif"></td></tr>
		                            		        							 </table>
                            		        		         	 
                            		        		         	 </td> 
                            		        		          <td align="center" height="30">&nbsp;</td> 
                            		        		</tr> 
                            		        		</table>
                            		    	</td> 
                            		    	<td align="center"  id=TD8 width="32">&nbsp;</td>
                            		    	<td  valign="bottom"  > 
                            		        	<table border=0 cellpadding="0" >
                            		        		<tr> 
                            		        		         	<td align="center" height="30">&nbsp;</td>
                            		        		         	<td align="center" width="36">
		                            		        		         	 <table border=0 cellpadding="0"  >    
		                            		        		     						<tr><td height=20 align="center" width=36 valign="bottom"><div id="DivQueueFailNum">0</div></td></tr><td valign="bottom" id="QueueFailNumH" title="" height="1" background="{$system_config.img_url}/monitor/images/BG8.gif"></td></tr>
		                            		        							 </table>
                            		        		         	 
                            		        		         	 </td> 
                            		        		          <td align="center" height="30">&nbsp;</td> 
                            		        		</tr>  
                            		        		</table>
                            		    	</td>  
                            		    	<td align="center"  id=TD9 width="10">&nbsp;</td>
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
                    		    			 
                    		  </tr>
                    		    <tr> 
                    		    				<td align="center" height=22 align="center" ID="SkillName" colspan=22  valign="bottom" ><font color=blue></font></td> 
                    		   </tr>
                    		</table>
</body>
</html>
{literal} 
<SCRIPT LANGUAGE=javascript>
  var MaxNum=1;
 
  function UpdateInfo(DivTotalAgentNum,DivAnswerAgentNum,DivIdleAgentNum,DivAfterWorkAgentNum,DivOtherAgentNum,DivReqTransAgentNum,DivQueueSuccNum,DivQueueFailNum,SkillName,WDiv,HDiv,HeightNum)
		{ 
			  MaxNum=1;
			  if(parseInt(MaxNum)<=parseInt(DivTotalAgentNum))MaxNum=parseInt(DivTotalAgentNum);
				if(parseInt(MaxNum)<=parseInt(DivAnswerAgentNum))MaxNum=parseInt(DivAnswerAgentNum);	
				if(parseInt(MaxNum)<=parseInt(DivIdleAgentNum))MaxNum=parseInt(DivIdleAgentNum);
				if(parseInt(MaxNum)<=parseInt(DivAfterWorkAgentNum))MaxNum=parseInt(DivAfterWorkAgentNum);
				if(parseInt(MaxNum)<=parseInt(DivOtherAgentNum))MaxNum=parseInt(DivOtherAgentNum);
				
				if(parseInt(MaxNum)<=parseInt(DivReqTransAgentNum))MaxNum=parseInt(DivReqTransAgentNum);
				if(parseInt(MaxNum)<=parseInt(DivQueueSuccNum))MaxNum=parseInt(DivQueueSuccNum);
				if(parseInt(MaxNum)<=parseInt(DivQueueFailNum))MaxNum=parseInt(DivQueueFailNum); 
//alert(DivTotalAgentNum + " " + HeightNum + " " + MaxNum + " " + HDiv);
				if(parseInt(DivTotalAgentNum*HeightNum/MaxNum/HDiv)>0)
					document.getElementById("TotalAgentNumH").height=parseInt(DivTotalAgentNum*HeightNum/MaxNum/HDiv);
				else
					document.getElementById("TotalAgentNumH").height=parseInt(DivTotalAgentNum*HeightNum/MaxNum/HDiv)+1;
	
				document.getElementById("DivTotalAgentNum").innerHTML=DivTotalAgentNum;
			
				if(parseInt(DivAnswerAgentNum*HeightNum/MaxNum/HDiv)>0)
					document.getElementById("AnswerAgentNumH").height=parseInt(DivAnswerAgentNum*HeightNum/MaxNum/HDiv);
				else
					document.getElementById("AnswerAgentNumH").height=parseInt(DivAnswerAgentNum*HeightNum/MaxNum/HDiv)+1;
				document.getElementById("DivAnswerAgentNum").innerHTML=DivAnswerAgentNum;

				if(parseInt(DivIdleAgentNum*HeightNum/MaxNum/HDiv)>0)
					document.getElementById("IdleAgentNumH").height=parseInt(DivIdleAgentNum*HeightNum/MaxNum/HDiv);
				else
					document.getElementById("IdleAgentNumH").height=parseInt(DivIdleAgentNum*HeightNum/MaxNum/HDiv)+1;
				document.getElementById("DivIdleAgentNum").innerHTML=DivIdleAgentNum;

				if(parseInt(DivAfterWorkAgentNum*HeightNum/MaxNum/HDiv)>0)
					document.getElementById("AfterWorkAgentNumH").height=parseInt(DivAfterWorkAgentNum*HeightNum/MaxNum/HDiv);
				else
					document.getElementById("AfterWorkAgentNumH").height=parseInt(DivAfterWorkAgentNum*HeightNum/MaxNum/HDiv)+1;
				document.getElementById("DivAfterWorkAgentNum").innerHTML=DivAfterWorkAgentNum;

				if(parseInt(DivOtherAgentNum*HeightNum/MaxNum/HDiv)>0)
					document.getElementById("OtherAgentNumH").height=parseInt(DivOtherAgentNum*HeightNum/MaxNum/HDiv);
				else
					document.getElementById("OtherAgentNumH").height=parseInt(DivOtherAgentNum*HeightNum/MaxNum/HDiv)+1;
				document.getElementById("DivOtherAgentNum").innerHTML=DivOtherAgentNum;

				if(parseInt(DivReqTransAgentNum*HeightNum/MaxNum/HDiv)>0) 
					document.getElementById("ReqTransAgentNumH").height=parseInt(DivReqTransAgentNum*HeightNum/MaxNum/HDiv);
				else
					document.getElementById("ReqTransAgentNumH").height=parseInt(DivReqTransAgentNum*HeightNum/MaxNum/HDiv)+1;
				document.getElementById("DivReqTransAgentNum").innerHTML=DivReqTransAgentNum;

				if(parseInt(DivQueueSuccNum*HeightNum/MaxNum/HDiv)>0) 
					document.getElementById("QueueSuccNumH").height=parseInt(DivQueueSuccNum*HeightNum/MaxNum/HDiv);
				else
					document.getElementById("QueueSuccNumH").height=parseInt(DivQueueSuccNum*HeightNum/MaxNum/HDiv)+1;				
				document.getElementById("DivQueueSuccNum").innerHTML=DivQueueSuccNum;

				if(parseInt(DivQueueFailNum*HeightNum/MaxNum/HDiv)>0)
					document.getElementById("QueueFailNumH").height=parseInt(DivQueueFailNum*HeightNum/MaxNum/HDiv); 
				else
					document.getElementById("QueueFailNumH").height=parseInt(DivQueueFailNum*HeightNum/MaxNum/HDiv)+1; 
				document.getElementById("DivQueueFailNum").innerHTML=DivQueueFailNum;

				document.getElementById("SkillName").innerHTML="<font color=blue>"+SkillName+"<font>";

				UpdateDiv(WDiv);

	}
	function UpdateDiv(WDiv)
	{
		if(WDiv==2)
		{
			 document.getElementById("FTable").width="450";
			 document.getElementById("TD1").innerHTML="";
			 document.getElementById("TD1").width="1";
			 document.getElementById("TD2").innerHTML="";
			 document.getElementById("TD2").width="1";
			 document.getElementById("TD3").innerHTML="";
			 document.getElementById("TD3").width="1";
			 document.getElementById("TD4").innerHTML="";
			 document.getElementById("TD4").width="1";
			 document.getElementById("TD5").innerHTML="";
			 document.getElementById("TD5").width="1";
			 document.getElementById("TD6").innerHTML="";
			 document.getElementById("TD6").width="1";
			 document.getElementById("TD7").innerHTML="";
			 document.getElementById("TD7").width="1";
			 document.getElementById("TD8").innerHTML="";
			 document.getElementById("TD8").width="1";
			 document.getElementById("TD9").innerHTML="";
			 document.getElementById("TD9").width="1";
			 document.getElementById("FTR").height="200";
		}
		else
		{
			 document.getElementById("FTable").width="860";
			 document.getElementById("TD1").innerHTML="&nbsp;";
			 document.getElementById("TD1").width="32";
			 document.getElementById("TD2").innerHTML="&nbsp;";
			 document.getElementById("TD2").width="32";
			 document.getElementById("TD3").innerHTML="&nbsp;";
			 document.getElementById("TD3").width="32";
			 document.getElementById("TD4").innerHTML="&nbsp;";
			 document.getElementById("TD4").width="32";
			 document.getElementById("TD5").innerHTML="&nbsp;";
			 document.getElementById("TD5").width="32";
			 document.getElementById("TD6").innerHTML="&nbsp;";
			 document.getElementById("TD6").width="32";
			 document.getElementById("TD7").innerHTML="&nbsp;";
			 document.getElementById("TD7").width="32";
			 document.getElementById("TD8").innerHTML="&nbsp;";
			 document.getElementById("TD8").width="32";
			 document.getElementById("TD9").innerHTML="&nbsp;";
			 document.getElementById("TD9").width="32";
			 document.getElementById("FTR").height="380";
		}
		 
	}
  </SCRIPT> 
{/literal} 

