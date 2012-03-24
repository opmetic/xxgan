//==========================================================
var statusTxt = new Array(
						"未初始化",
						"准备接听",
						"工作中",
						"其它工作",
						"事后整理",
						"振铃",
						"已登录",
						"未登录",
						"锁定状态"
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
function AppSuiteObject(commandType, commandfunc, parameter)
{
	if (commandType == "request")
	{
		if (commandfunc == 'login')
		{
			csAgentClient.SendCMD('<\?xml version="1.0" \?><cmdbody><cmdtype>command</cmdtype><cmdname>login</cmdname></cmdbody>');
		}
		else if (commandfunc == 'logout')
		{
			csAgentClient.SendCMD('<\?xml version="1.0" \?><cmdbody><cmdtype>command</cmdtype><cmdname>logout</cmdname></cmdbody>');
		}
		else if (commandfunc == 'makecall')
		{
			csAgentClient.SendCMD('<\?xml version="1.0" \?><cmdbody><cmdtype>command</cmdtype><cmdname>makecall</cmdname><parameter>' + parameter + '</parameter></cmdbody>');
		}
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
	}
}

/**
 * status display
 */
function statusDisplay()
{
	this.start = function(status)
	{
		for(var j=0; j<status.length; j++)
		{
			var name = status(j).getAttribute("name");
			var value = status(j).getAttribute("value");
			if (name == "hwnd")
			{
				this.set_qn_status_txt(value);
			}
			else if (name == "status")
			{
				var s = parseInt(value);
				this.set_qn_status_txt(statusTxt[s]);
				this.setDisplay(s);
			}
		}
	}
	this.setDisplay = function(status)
	{
		switch(status)
		{
			case 1:	//准备接听
				this.set_busy_free(true, "置  忙");
				this.set_answer_hangup(false, "应  答");
				this.set_status_img("qn_status_agentready");
				break;
			case 2: //工作中
				this.set_busy_free(false, "置  忙");
				this.set_answer_hangup(true, "挂  机");
				this.set_status_img("qn_status_agentbusy");
				break;
			case 3: //其它工作
				this.set_busy_free(true, "置  闲");
				this.set_answer_hangup(false, "应  答");
				this.set_status_img("qn_status_agentworkingaftercall");
				break;
			case 4: //事后整理
				this.set_busy_free(true, "置  忙");
				this.set_answer_hangup(false, "应  答");
				this.set_status_img("qn_status_agentnotready");
				break;
			case 5: //振铃
				this.set_busy_free(true, "置  忙");
				this.set_answer_hangup(true, "应  答");
				this.set_status_img("qn_status_agentready");
				break;
			case 6: //已登录
				this.set_status_img("qn_status_agentnotready");
				break;
			case 7://未登录
			    this.set_busy_free(false, "置  忙");
			    this.set_answer_hangup(false, "应  答");
				this.set_status_img("qn_status_agentnull");
				break;
			case 8://锁定状态
			    this.set_busy_free(false, "置  忙");
			    this.set_answer_hangup(false, "应  答");
				this.set_status_img("qn_status_agentready");
				break;
			default:
				this.set_status_img("qn_status_agentnull");
				break;
		}
	}
	
	//用户小旗帜
	this.set_use_state = function(value)
	{
		$('#use_state').attr('value', value); 
		$('#use_state').msDropDown().data("dd");
	}
	
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
		$("#busy_free").attr("value", txt); 
	}

	//应答 挂断
	this.set_answer_hangup = function(value, txt)
	{
		$("#answer_hangup").attr("disabled", !value); 
		$("#answer_hangup").attr("value", txt); 
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
	
	//时长
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
	var resultDom = new xml(xmlStr);
	
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
    			if (name == "href")
    			{
    				openNowWindows("new", value, true);
    			}
    		}
    	}
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
    		/*
    		for(var j=0; j<resultNodes.length; j++)
    		{
    			
    			var name = resultNodes(j).getAttribute("name");
    			var value = resultNodes(j).getAttribute("value");
    		}*/
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