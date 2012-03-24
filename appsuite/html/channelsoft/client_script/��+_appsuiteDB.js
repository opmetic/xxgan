
//==========================================================
var GLOBALESTATUS = 0; //全局状态
var clock_start = 0; //电话接通时间
var intervalProcess; //
//==========================================================
var statusTxt = new Array(
						"服务未启动",  //0
						"其它工作", //1
						"准备接听",  //2
						"受理业务",    //3
						"事后整理",  //4
						"振铃",      //5
						"已登录",    //6
						"未登录",    //7
						"锁定状态"   //8
						); 

//==========================================================
/*
 * 初始化ocx
 * 
 */
function csAgentClientInit()
{
	var result = AppSuiteObject('local', 'getparam_hwnd');
	var resultDom = new xml(result);
	
	//获得根接点
    var nodes = resultDom.documentElement.childNodes;
    
    //得到根接点下共有子接点个数，并循环
    for(var i=0; i<nodes.length; i++)
    {
    	//如果接点名为 tree
    	if(nodes(i).nodeName == "result")
    	{
    		var resultNodes = nodes(i).childNodes;
    		for(var j=0; j<resultNodes.length; j++)
    		{
    			
    			var name = resultNodes(j).getAttribute("name");
    			var value = resultNodes(j).getAttribute("value");
    			if (name == "hwnd" && value == "0")
    			{
//    				csAgentClient.Init();
    			}
    		}
    	}
    }
    //删除对象
    delete(resultDom);
    csAgentClient.Init();
}


//==========================================================
/* 
 *appsuite object
 */
function AppSuiteObject(commandType, commandfunc, parameter, parameter2)
{
	if (commandType == "request")
	{
		if (parameter)
		{
			if (parameter2)
			{
				csAgentClient.SendCMD('<\?xml version="1.0" \?><cmdbody><cmdtype>command</cmdtype><cmdname>' + commandfunc + '</cmdname><parameter>' + parameter + '</parameter><parameter2>' + parameter2 + '</parameter2></cmdbody>');
			}
			else
			{
				csAgentClient.SendCMD('<\?xml version="1.0" \?><cmdbody><cmdtype>command</cmdtype><cmdname>' + commandfunc + '</cmdname><parameter>' + parameter + '</parameter></cmdbody>');
			}
		}
		else
		{
			csAgentClient.SendCMD('<\?xml version="1.0" \?><cmdbody><cmdtype>command</cmdtype><cmdname>' + commandfunc + '</cmdname></cmdbody>');
		}
	/*	
		if (commandfunc == 'login')　//签入
		{
			csAgentClient.SendCMD('<\?xml version="1.0" \?><cmdbody><cmdtype>command</cmdtype><cmdname>login</cmdname></cmdbody>');
		}
		else if (commandfunc == 'logout') //签出
		{
			csAgentClient.SendCMD('<\?xml version="1.0" \?><cmdbody><cmdtype>command</cmdtype><cmdname>logout</cmdname></cmdbody>');
		}
		else if (commandfunc == 'makecall') // 外呼
		{
			csAgentClient.SendCMD('<\?xml version="1.0" \?><cmdbody><cmdtype>command</cmdtype><cmdname>makecall</cmdname><parameter>' + parameter + '</parameter></cmdbody>');
		}
		else if (commandfunc == 'setbusy') // 示忙
		{
			csAgentClient.SendCMD('<\?xml version="1.0" \?><cmdbody><cmdtype>command</cmdtype><cmdname>setbusy</cmdname></cmdbody>');
		}
		else if (commandfunc == 'setidle') // 示闲
		{
			csAgentClient.SendCMD('<\?xml version="1.0" \?><cmdbody><cmdtype>command</cmdtype><cmdname>setidle</cmdname></cmdbody>');
		}*/
	}
	else if (commandType == "local")
	{
		if (commandfunc == 'getparam_hwnd')
		{
			return csAgentClient.manageData('<\?xml version=\"1.0\" \?><cmdbody><cmdtype>local</cmdtype><cmdname>getparam</cmdname><parameter><element name=\"\" type=\"\" value=\"hwnd\" /></parameter></cmdbody>');
		}
		else if (commandfunc == 'getparam')
		{
			return csAgentClient.manageData('<\?xml version=\"1.0\" \?><cmdbody><cmdtype>local</cmdtype><cmdname>getparam</cmdname></cmdbody>');
		}
		else if (commandfunc == 'setscript')
		{
			
			return csAgentClient.manageData('<\?xml version=\"1.0\" \?><cmdbody><cmdtype>local</cmdtype><cmdname>setscript</cmdname><parameter>' + parameter + '</parameter><parameter2>' + parameter2 + '</parameter2></cmdbody>');
		}
	}
}

/**
 * status display
 */
function statusDisplay()
{
	this.start = function(status)
	{//alert("status.length" + status.length);////////////////////
		var statusStr, statusnumStr, updateFlat = 0;;
		for(var j=0; j<status.length; j++)
		{
			var name = status(j).getAttribute("name");
			var value = status(j).getAttribute("value");
			//alert(name + "  " + value);/////////////////////////////////
			if (name == "hwnd")
			{
				this.set_qn_status_txt(value);
			}
			else if (name == "status")
			{
				updateFlat = 1;
				statusStr = value;
			}
			else if (name == "statusnum")
			{
				statusnumStr = value;
			}
			else if (name == "statusdsc")
			{
				this.set_qn_do_txt(value);
			}
			else if (name =="callingno")
			{
				this.set_msg_calling(value)
			}
			else if (name == "calledno")
			{
				this.set_msg_callid(value)
			}
		}
		if (updateFlat)
		{
			var s = parseInt(statusStr);
			this.set_qn_status_txt(statusTxt[s]);
			this.setDisplay(s, statusnumStr);
		}


	}
	this.setDisplay = function(status, statusnum)
	{
		if (status > 5)
		{
			GLOBALESTATUS = 0;
		}
		else
		{
			GLOBALESTATUS = status;
		}

		switch(status)
		{
			case 0: //初始化
				this.set_busy_free(false, "置 忙");
			    this.set_answer_hangup(false, "应 答");
				this.set_status_img("qn_status_agentnull");
				break;
			case 1: //未准备好
				this.set_busy_free(true, "置 闲");
				this.set_answer_hangup(false, "应 答");
				this.set_status_img("qn_status_agentnotready");
				break;
			case 2:	//准备接听
				this.set_busy_free(true, "置 忙");
				this.set_answer_hangup(false, "应 答");
				this.set_status_img("qn_status_agentready");
				break;
			case 3: //受理业务
				if (statusnum == "312") //呼入振铃
				{
					this.set_busy_free(true, "挂 机");
					this.set_answer_hangup(true, "应 答");
					this.set_status_img("qn_status_agentbusy");
				}
				else 
				{
					 //受理业务
					this.set_busy_free(false, "置 忙");
					this.set_answer_hangup(true, "挂 机");
					this.set_status_img("qn_status_agentbusy");
				}
				
				break;
			case 4: //事后整理
				this.set_busy_free(true, "置 忙");
				this.set_answer_hangup(true, "置 闲");
				this.set_status_img("qn_status_agentworkingaftercall");
				break;

			case 5: //振铃
				this.set_busy_free(true, "置 忙");
				this.set_answer_hangup(true, "应 答");
				this.set_status_img("qn_status_agentready");
				break;

			case 6: //已登录
				this.set_busy_free(true, "置 闲");
				this.set_answer_hangup(false, "应 答");
				this.set_status_img("qn_status_agentnotready");
				
				break;

			case 7://未登录
			    this.set_busy_free(false, "置 忙");
			    this.set_answer_hangup(false, "应 答");
				this.set_status_img("qn_status_agentnull");
				messageBox("初始化已完全，请点击签入服务　开始工作。　");
				$(".stopservice_stype").hide();
				$(".startservice_stype").show(); ; //切换显示
				break;

			case 8://锁定状态
			    this.set_busy_free(false, "置 忙");
			    this.set_answer_hangup(false, "应 答");
				this.set_status_img("qn_status_agentready");
				break;

			case 9://初始化出错
			    this.set_busy_free(false, "置 忙");
			    this.set_answer_hangup(false, "应 答");
				this.set_status_img("qn_status_agentnull");

				$.messager.alert('error','初始化失败，请关闭程序尝试重新登陆，或直接与管理员联系!','error');
				/*
				//注销操作
				$.messager.alert('error','初始化失败，请重试，或直接与管理员联系!','error');
				AppSuiteObject("request", "logout");
				$("#start_startservice_id").attr("disabled", false);
*/
				break;
			default:
				this.set_status_img("qn_status_agentnull");
				break;
		}

        this.set_qn_status_txt(statusTxt[status]);
	}
	
/*	//用户小旗帜
	this.set_use_state = function(value)
	{
		$('#use_state').attr('value', value); 
		$('#use_state').msDropDown().data("dd");
	}
*/	
	//电话状态
	this.set_status_img = function(value)
	{
		$("#status_img").removeClass();
		$("#status_img").addClass(value);

	}
	
	//状态文字
	this.set_qn_status_txt = function(value)
	{            
		$("#qn_status_txt").html(value);
	}
	
	//状态文字2
	this.set_qn_do_txt = function(value)
	{
		$("#qn_do_txt").html(value);
	}
	
	//置忙 闲
	this.set_busy_free = function(value, txt)
	{
		$("#busy_free").attr("disabled", !value); 
		//$("#busy_free").attr("value", txt);
        $("#busy_free div").empty(); 
        $("#busy_free div").html(txt); 
	}

	//应答 挂断
	this.set_answer_hangup = function(value, txt)
	{
		$("#answer_hangup").attr("disabled", !value); 
		$("#answer_hangup div").empty();
        $("#answer_hangup div").html(txt);
	}
	
	//主叫
	this.set_msg_calling = function(value)
	{
		$("#msg_calling").html(value);
	}
	
	//被叫
	this.set_msg_callid= function(value)
	{
		$("#msg_callid").html(value);
	}
	//call_in_time呼入时间
	this.set_call_in_time = function(flag)
	{
		if (flag)
		{
			var intHours, intMinutes, intSeconds;

			today = new Date();
			
			intHours = today.getHours(); 
			intMinutes = today.getMinutes(); 
			intSeconds = today.getSeconds(); 
			
			str = Right('00' + intHours, 2) + " : " + Right('00' + intMinutes, 2) + " : " + Right('00' + intSeconds, 2);
			$("#call_in_time").html(str);
		}
		else
		{
			$("#call_in_time").html("00:00:00");
		}
	}
	//start_time应答时间
	this.set_start_time = function(flag)
	{
		if (flag)
		{
			var intHours, intMinutes, intSeconds;

			today = new Date(); 
			intHours = today.getHours(); 
			intMinutes = today.getMinutes(); 
			intSeconds = today.getSeconds(); 
			
			str = Right('00' + intHours, 2) + " : " + Right('00' + intMinutes, 2) + " : " + Right('00' + intSeconds, 2);
			$("#start_time").html(str);
		}
		else
		{
			$("#start_time").html("00:00:00");
		}
	}
	
	//呼叫时长
	this.set_msg_timelong = function(value)
	{
		var h, m, s, str;
		s = value % 60;
		m = Math.floor(value / 60);
		h = Math.floor(m / 60);
		m = m % 60;
		str = Right('00' + h, 2) + " : " + Right('00' + m, 2) + " : " + Right('00' + s, 2);
		$("#msg_timelong").html(str);
	}
	//tool
	this.set_tool = function(tool, value)
	{
		if (value) //生效
		{
			$("#" + tool).attr("disabled", false); //按钮
			$("#" + tool + " img").hide();
		}
		else //失效
		{
			$("#" + tool).attr("disabled", true); //按钮
			$("#" + tool + " img").show();
		}
	}
}

//============================================================
/*
 * 消息响应
 */
function manageEvent(xmlStr)
{                 
	//alert("xmlStr=" + xmlStr);
	var resultDom = new xml(xmlStr);

	if (!resultDom)
    {
       // alert("xmlStr error");
        return;
    }
	var cmdtype = resultDom.documentElement.selectSingleNode("cmdtype");
	var cmdname = resultDom.documentElement.selectSingleNode("cmdname");
	var cmdresult = resultDom.documentElement.selectSingleNode("result");
//alert(cmdtype.text + "   " + cmdname.text);
	if (cmdtype)
	{
		//alert("why:" + cmdtype.text);
		if (cmdtype.text == "common")
		{
			if (cmdname.text == "initial")
			{
				var name, value, title, url;
				var resultNodes = cmdresult.childNodes;
				for(var j=0; j<resultNodes.length; j++)
    			{
					name = resultNodes(j).getAttribute("name");
					//alert(name);
					if (name == "status")
					{
						value = resultNodes(j).getAttribute("value");
						//alert(value);
						if (value == "0")
						{
							//初始化正功
							var mStatusDisplay = new statusDisplay();
							mStatusDisplay.setDisplay(7);
						}
						else
						{
							//初始化失败
							var mStatusDisplay = new statusDisplay();
							mStatusDisplay.setDisplay(9);
						}
					}
					else if (name == "url")
					{
						url = resultNodes(j).getAttribute("value");
					}
				}
			} // initial end
			else if (cmdname.text == "signin")
			{
				if (checkStatus(cmdresult) == "0") //成功
				{
					$(".stopservice_stype").show();
					$(".startservice_stype").hide(); ; //切换显示
					messageBox("您已经成功签入服务器,　系统进入正常作业中。");
				}
				else
				{
					$(".stopservice_stype").hide();
					$(".startservice_stype").show(); ; //切换显示
				}
			} // signin end
			else if (cmdname.text == "signout")
			{
				if (checkStatus(cmdresult) == "0") //成功
				{
					$(".stopservice_stype").hide();
					$(".startservice_stype").show(); ; //切换显示
					messageBox("您已经成功签出服务器。");
				}
				else
				{
					$(".stopservice_stype").show();
					$(".startservice_stype").hide(); ; //切换显示
				}
			} // singout end
			else if (cmdname.text == "msg")
			{
				var name, value, title, url;
				var resultNodes = cmdresult.childNodes;
				for(var j=0; j<resultNodes.length; j++)
    			{
					name = resultNodes(j).getAttribute("name");
					//alert(name);
					if (name == "info")
					{
						value = resultNodes(j).getAttribute("value");
					}
				}
				
				messageBox(value, "提示");
			}//alert end
			else if (cmdname.text == "alert")
			{
				var name, value, title, url;
				var resultNodes = cmdresult.childNodes;
				for(var j=0; j<resultNodes.length; j++)
    			{
					name = resultNodes(j).getAttribute("name");
					//alert(name);
					if (name == "info")
					{
						value = resultNodes(j).getAttribute("value");
					}
				}
				
				$.messager.alert('AppSuite', value, 'info');
			}//alert end
			else if (cmdname.text == "answerrequest")
			{
				if (checkStatus(cmdresult) == "1") //有呼叫
				{
					var mStatusDisplay = new statusDisplay();
					mStatusDisplay.set_call_in_time(1); //设置呼入时间显示
					delete(mStatusDisplay);
				}
				else if (checkStatus(cmdresult) == "2") //呼叫成功
				{
					var mStatusDisplay = new statusDisplay();
					mStatusDisplay.set_start_time(1); //设置接通时间显示
					delete(mStatusDisplay);


					var time_start = new Date(); 
					clock_start = time_start.getTime(); 
					intervalProcess = setInterval("get_time_spent()", 1000);



				}
			}// answerrequest end
			else if (cmdname.text == "onrelease")
			{
				$(".msg_calling").html($("#msg_calling").html());
				$(".msg_called").html($("#msg_callid").html());
				$(".call_in_time").html($("#call_in_time").html());
				$(".start_time").html($("#start_time").html());
				$(".msg_timelong").html($("#msg_timelong").html());

				var mStatusDisplay = new statusDisplay();
				mStatusDisplay.set_msg_calling("");
				mStatusDisplay.set_msg_callid("")
				mStatusDisplay.set_call_in_time(0); //设置呼入时间显示
				mStatusDisplay.set_start_time(0); //设置接通时间显示
				delete(mStatusDisplay);
				clearInterval(intervalProcess);
			} // onrelease end
		} // common end
		else if (cmdtype.text == "action")
		{
			
			if (cmdname.text == "href")
			{
				var name, value, title, url;
				var resultNodes = cmdresult.childNodes;
				for(var j=0; j<resultNodes.length; j++)
    			{
					name = resultNodes(j).getAttribute("name");
					if (name == "title")
					{
						title = resultNodes(j).getAttribute("value");
					}
					else if (name == "url")
					{
						url = resultNodes(j).getAttribute("value");
					}
				}

				openNowWindows(title, url, true);
			}
			else if (cmdname.text == "hreflocal")
			{
				var name, value, title, url;
				var resultNodes = cmdresult.childNodes;
				for(var j=0; j<resultNodes.length; j++)
    			{
					name = resultNodes(j).getAttribute("name");
					if (name == "title")
					{
						title = resultNodes(j).getAttribute("value");
					}
					else if (name == "url")
					{
						url = resultNodes(j).getAttribute("value");
					}
				}

				openNowWindowsLocal(title, url, true);
			}
			else if (cmdname.text == "setstatus")
			{
				var mStatusDisplay = new statusDisplay();
				mStatusDisplay.start(cmdresult.childNodes);
				delete(mStatusDisplay);
			}
			
		}//action end
		else if (cmdtype.text == "")
		{
		}

	}

	/*
	//获得根接点
    var nodes = resultDom.documentElement.childNodes;
    //alert(resultDom.documentElement.nodeName);
    //得到根接点下共有子接点个数，并循环
    for(var i=0; i<nodes.length; i++)
    {
		alert(nodes(i).nodeName);
		alert(nodes(i).text);
    	//如果接点名为 tree
    	if(nodes(i).nodeName == "result")
    	{
    		var resultNodes = nodes(i).childNodes;
    		for(var j=0; j<resultNodes.length; j++)
    		{
    			var name = resultNodes(j).getAttribute("name");
    			var value = resultNodes(j).getAttribute("value");
    			if (name == "href")
    			{
    				openNowWindows("new", value, true);
    			}
				else if (name == "hreflocal")
				{
				//	openNowWindowsLocal("
				}
    		}
    	}
		else if (nodes(i).nodeName == "result")
		{
		}
    }
	*/


	//删除对象
	if (!resultDom)
	{
		delete(resultDom);
	}   
}
//===========================================================
/*
 * 刷新状态
 */
function updateStatus()
{
	var result = AppSuiteObject('local', 'getparam');
	var resultDom = new xml(result);
	
	//获得根接点
    var nodes = resultDom.documentElement.childNodes;
    
    //得到根接点下共有子接点个数，并循环
    for(var i=0; i<nodes.length; i++)
    {
    	//如果接点名为 tree
    	if(nodes(i).nodeName == "result")
    	{
    		var resultNodes = nodes(i).childNodes;
    		var mStatusDisplay = new statusDisplay();
    		mStatusDisplay.start(resultNodes);
    		delete(mStatusDisplay);
    	}
    }
    //删除对象
    delete(resultDom);
}
//============================================================
/*
 * 工具 在字符前补 0
 */
function Right(string, length)
{
    return string.substring(string.length - length);
}

/*
 * 创建一个dom对象
 */
function xml(str){
	if(window.DOMParser)//firefox内核的浏览器
	{
		var p = new DOMParser();
		return p.parseFromString( str, "text/xml" );
	}
	else if( window.ActiveXObject )//ie内核的浏览器
	{
		var doc = new ActiveXObject( "Msxml2.DOMDocument" );
		doc.loadXML(str);
		return doc;
	}
	else
	{
		return false;
	}
}


/* 
用途：检查输入手机号码是否正确 
输入： 
s：字符串 
返回： 
如果通过验证返回true,否则返回false 
*/ 

function checkMobile(s)
{  
	var regu =/^[0-9#*]{1,30}$/; 
	var re = new RegExp(regu); 
	if (re.test(s)) { 
		return true; 
	}
	else{ 
		return false; 
	} 

} 



/*
判断返回的结果

*/
function checkStatus(cmdresult)
{
	var name, value, title, url;
	var resultNodes = cmdresult.childNodes;
	for(var j=0; j<resultNodes.length; j++)
	{
		name = resultNodes(j).getAttribute("name");
		//alert(name);
		if (name == "status")
		{
			value = resultNodes(j).getAttribute("value");
			//alert(value);
			return value;
		}
	}
}


/*

*/
function get_time_spent () 
{ 
	var time_now = new Date(); 
	var times = ((time_now.getTime() - clock_start)/1000); 

	var mStatusDisplay = new statusDisplay();
	mStatusDisplay.set_msg_timelong(times);
	delete(mStatusDisplay);
} 