
//==========================================================
var GLOBALESTATUS = 0; //全局状态
var SUBSTATUS = 0; //详细状态
var clock_start = 0; //电话接通时间
var intervalProcess; //
var location = new Object();
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
function AppSuiteObject(commandType, commandfunc, parameter, parameter2, parameter3)
{
	if (commandType == "request")
	{
		if (parameter)
		{
			if (parameter2)
			{
			}
			else
			{
			}
		}
		else
		{
			csAgentClient.manageData('<\?xml version="1.0" \?><cmdbody><cmdtype>request</cmdtype><cmdname>' + commandfunc + '</cmdname></cmdbody>');
		}
	}
	else if(commandType == "command")
	{
		if (parameter)
		{
			if (parameter2)
			{
                if (parameter3)
                {
                    csAgentClient.SendCMD('<\?xml version="1.0" \?><cmdbody><cmdtype>command</cmdtype><cmdname>' + commandfunc + '</cmdname><parameter>' + parameter + '</parameter><parameter2>' + parameter2 + '</parameter2><parameter3>' + parameter3 + '</parameter3></cmdbody>');    
                }
				else
                {   
                    csAgentClient.SendCMD('<\?xml version="1.0" \?><cmdbody><cmdtype>command</cmdtype><cmdname>' + commandfunc + '</cmdname><parameter>' + parameter + '</parameter><parameter2>' + parameter2 + '</parameter2></cmdbody>');
                }
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
	}
	else if (commandType == "local")
	{
		if (commandfunc == 'getparam_hwnd')
		{
			return csAgentClient.manageData('<\?xml version=\"1.0\" \?><cmdbody><cmdtype>local</cmdtype><cmdname>getparam</cmdname><parameter><element name=\"\" type=\"\" value=\"hwnd\" /></parameter></cmdbody>');
		}
		else if (commandfunc == 'getparam')
		{
			if (parameter)
			{
				return csAgentClient.manageData('<\?xml version=\"1.0\" \?><cmdbody><cmdtype>local</cmdtype><cmdname>getparam</cmdname><parameter>' + parameter + '</parameter></cmdbody>');
			}
			else
			{
				return csAgentClient.manageData('<\?xml version=\"1.0\" \?><cmdbody><cmdtype>local</cmdtype><cmdname>getparam</cmdname></cmdbody>');
			}
			
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
		var statusStr, statusnumStr, updateFlat = 0;
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
			//else if (name == "calledno")
            else if (name == "orgcallno")
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
	{//alert(status + "  " + statusnum);/////////////////////////////////////
		if (status > 5)
		{
			GLOBALESTATUS = 0;
		}
		else
		{
			GLOBALESTATUS = status;
            SUBSTATUS = statusnum;
		}

		switch(status)
		{
			case 0: //初始化
				set_status(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
				break;

			case 1: //未准备好
				set_status(1, 1, 0, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0);

				break;
			case 2:	//准备接听
			
				set_status(0, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1);

				break;
			case 3: //受理业务
				if (statusnum == "312") //呼入振铃
				{
					setAgentAutoEnterIdle(); //自动置闲
					set_status(1, 0, 1, 0, 1, 1, 1, 1, 1, 0, 1, 1, 1);
				}
				else if (statusnum == "304") //保持
				{
					set_status(1, 1, 1, 1, 1, 1, 1, 0, 1, 0, 1, 1, 1);
				}
				else if (statusnum == "306" /*外部咨询*/ || statusnum == "307" /*内部咨询*/ )
				{
					set_status(1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 1, 1, 1);
				}
				else 
				{
					 //受理业务
					setAgentAutoEnterIdle(); //自动置闲
					set_status(1, 1, 1, 0, 0, 0, 1, 1, 1, 0, 1, 1, 1);
				}
				
				break;
			case 4: //事后整理
				set_status(0, 1, 0, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0);

				break;

			case 5: //振铃
				break;

			case 6: //已登录
			
				break;

			case 7://未登录

				break;

			case 8://锁定状态

				break;

			case 9://初始化出错

				$.messager.alert('error','初始化失败，请关闭程序尝试重新登陆，或直接与管理员联系!','error');
				/*
				//注销操作
				$.messager.alert('error','初始化失败，请重试，或直接与管理员联系!','error');
				AppSuiteObject("request", "logout");
				$("#start_startservice_id").attr("disabled", false);
*/
				break;
			default:

				break;
		}

        this.set_qn_status_txt(statusTxt[status]);
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
	
	
	//主叫
	this.set_msg_calling = function(value)
	{
		$("#msg_calling").html(value);
	}
	
	//被叫
	this.set_msg_callid= function(value)
	{
        if (value == "057483858681" || value == "057483858823")
        {
            $("#msg_callid").html("四川");
        }
        else if (value == "057483858910" || value == "057483858924")
        {
            $("#msg_callid").html("四川 118114接入"); 
        }
        else if (value == "057483858707" || value == "057483858849")
        {
            $("#msg_callid").html("四川 OTA接入"); 
        }
        else if (value == "057483858674" || value == "057483858816")
        {
            $("#msg_callid").html("青海"); 
        }
        else if (value == "057483858909" || value == "057483858923")
        {
            $("#msg_callid").html("青海 118114接入"); 
        }
        else if (value == "057483858678" || value == "057483858820")
        {
            $("#msg_callid").html("青海 OTA接入"); 
        }
        else if (value == "057483858700" || value == "057483858842")
        {
            $("#msg_callid").html("贵州"); 
        }
        else if (value == "057483858700" || value == "057483858842")
        {
            $("#msg_callid").html("贵州 118114接入"); 
        }
        
        else if (value == "057483858708" || value == "057483858850")
        {
            $("#msg_callid").html("贵州 OTA接入"); 
        }
        else if (value == "057483858632" || value == "057483858774")
        {
            $("#msg_callid").html("西藏 拉萨 0891"); 
        }
        else if (value == "057483858633" || value == "057483858775")
        {
            $("#msg_callid").html("西藏 日喀则 0892"); 
        }
        else if (value == "057483858634" || value == "057483858776")
        {
            $("#msg_callid").html("西藏 山南 0893"); 
        }
        else if (value == "057483858635" || value == "057483858777")
        {
            $("#msg_callid").html("西藏 林芝 0894"); 
        }
        else if (value == "057483858636" || value == "057483858778")
        {
            $("#msg_callid").html("西藏 昌都 0895"); 
        }
        else if (value == "057483858637" || value == "057483858779")
        {
            $("#msg_callid").html("西藏 那曲 0896"); 
        }
        else if (value == "057483858638" || value == "057483858780")
        {
            $("#msg_callid").html("西藏 阿里 0897"); 
        }
        else if (value == "057483858905" || value == "057483858919")
        {
            $("#msg_callid").html("西藏 118114接入"); 
        }
        else if (value == "057483858908" || value == "057483858922")
        {
            $("#msg_callid").html("云南 118114接入"); 
        }
        else if (value == "057483858701" || value == "057483858843")
        {
            $("#msg_callid").html("云南 OTA接入"); 
        }
        else if (value == "057483858654" || value == "057483858796")
        {
            $("#msg_callid").html("云南 昭通 0870"); 
        }
        else if (value == "057483858655" || value == "057483858797")
        {
            $("#msg_callid").html("云南 昆明 0871"); 
        }
        else if (value == "057483858656" || value == "057483858798")
        {
            $("#msg_callid").html("云南 曲靖 0874"); 
        }
        else if (value == "057483858657" || value == "057483858799")
        {
            $("#msg_callid").html("云南 保山 0875"); 
        }
        else if (value == "057483858658" || value == "057483858800")
        {
            $("#msg_callid").html("云南 玉溪 0877"); 
        }
        else if (value == "057483858659" || value == "057483858801")
        {
            $("#msg_callid").html("云南 普洱 0879"); 
        }
        else if (value == "057483858660" || value == "057483858802")
        {
            $("#msg_callid").html("云南 临沧 0883"); 
        }
        else if (value == "057483858661" || value == "057483858803")
        {
            $("#msg_callid").html("云南 丽江 0888"); 
        }
        else if (value == "057483858662" || value == "057483858804")
        {
            $("#msg_callid").html("云南 大理 0872"); 
        }
        else if (value == "057483858663" || value == "057483858805")
        {
            $("#msg_callid").html("云南 红河 0873"); 
        }
        else if (value == "057483858664" || value == "057483858806")
        {
            $("#msg_callid").html("云南 文山 0876"); 
        }
        else if (value == "057483858665" || value == "057483858807")
        {
            $("#msg_callid").html("云南 楚雄 0878"); 
        }
        else if (value == "057483858666" || value == "057483858808")
        {
            $("#msg_callid").html("云南 怒江 0886"); 
        }
        else if (value == "057483858667" || value == "057483858809")
        {
            $("#msg_callid").html("云南 迪庆 0887"); 
        }
        else if (value == "057483858668" || value == "057483858810")
        {
            $("#msg_callid").html("云南 西双版纳 0691"); 
        }
        else if (value == "057483858669" || value == "057483858811")
        {
            $("#msg_callid").html("云南 德宏 0892"); 
        }
        else if (value == "057483858914" || value == "057483858928")
        {
            $("#msg_callid").html("湖北 118114接入 "); 
        }
        else if (value == "057483858702" || value == "057483858844")
        {
            $("#msg_callid").html("湖北 OTA接入 "); 
        }
        else if (value == "057483858711" || value == "057483858853")
        {
            $("#msg_callid").html("湖北 武汉 027"); 
        }
        else if (value == "057483858712" || value == "057483858854")
        {
            $("#msg_callid").html("湖北 襄樊 0710"); 
        }
        else if (value == "057483858713" || value == "057483858855")
        {
            $("#msg_callid").html("湖北 鄂州 0711"); 
        }
        else if (value == "057483858714" || value == "057483858856")
        {
            $("#msg_callid").html("湖北 孝感 0712"); 
        }
        else if (value == "057483858715" || value == "057483858857")
        {
            $("#msg_callid").html("湖北 黄冈 0713"); 
        }
        else if (value == "057483858716" || value == "057483858858")
        {
            $("#msg_callid").html("湖北 黄石 0714"); 
        }
        else if (value == "057483858717" || value == "057483858859")
        {
            $("#msg_callid").html("湖北 咸宁 0715"); 
        }
        else if (value == "057483858718" || value == "057483858860")
        {
            $("#msg_callid").html("湖北 荆州 0716"); 
        }
        else if (value == "057483858719" || value == "057483858861")
        {
            $("#msg_callid").html("湖北 宜昌 0717"); 
        }
        else if (value == "057483858720" || value == "057483858862")
        {
            $("#msg_callid").html("湖北 十堰 0719"); 
        }
        else if (value == "057483858721" || value == "057483858863")
        {
            $("#msg_callid").html("湖北 随州 0722"); 
        }
        else if (value == "057483858722" || value == "057483858864")
        {
            $("#msg_callid").html("湖北 荆门 0724"); 
        }
        else if (value == "057483858723" || value == "057483858865")
        {
            $("#msg_callid").html("湖北 神农架区 0719"); 
        }
        else if (value == "057483858724" || value == "057483858866")
        {
            $("#msg_callid").html("湖北 恩施 0718"); 
        }
        else if (value == "057483858725" || value == "057483858867")
        {
            $("#msg_callid").html("湖北 仙桃 0728"); 
        }
        else if (value == "057483858726" || value == "057483858868")
        {
            $("#msg_callid").html("湖北 天门 0728"); 
        }
        else if (value == "057483858727" || value == "057483858869")
        {
            $("#msg_callid").html("湖北 潜江 027"); 
        }
        else if (value == "057483858915" || value == "057483858929")
        {
            $("#msg_callid").html("广西 118114接入"); 
        }
        else if (value == "057483858741" || value == "057483858883")
        {
            $("#msg_callid").html("广西 OTA接入"); 
        }
        else if (value == "057483858729" || value == "057483858871")
        {
            $("#msg_callid").html("广西"); 
        }
        else if (value == "057483858639" || value == "057483858781")
        {
            $("#msg_callid").html("重庆"); 
        }
        else if (value == "057483858906" || value == "057483858920")
        {
            $("#msg_callid").html("重庆 118114接入"); 
        }
        else if (value == "057483858704" || value == "057483858846")
        {
            $("#msg_callid").html("重庆 OTA接入"); 
        }
        else if (value == "057483858640" || value == "057483858782")
        {
            $("#msg_callid").html("湖南 岳阳 0730"); 
        }
        else if (value == "057483858641" || value == "057483858783")
        {
            $("#msg_callid").html("湖南 长沙 0731"); 
        }
        else if (value == "057483858642" || value == "057483858784")
        {
            $("#msg_callid").html("湖南 湘潭 0731"); 
        }
        else if (value == "057483858643" || value == "057483858785")
        {
            $("#msg_callid").html("湖南 株洲 0731"); 
        }
        else if (value == "057483858644" || value == "057483858786")
        {
            $("#msg_callid").html("湖南 衡阳 0734"); 
        }
        else if (value == "057483858645" || value == "057483858787")
        {
            $("#msg_callid").html("湖南 郴州 0735"); 
        }
        else if (value == "057483858646" || value == "057483858788")
        {
            $("#msg_callid").html("湖南 常德 0736"); 
        }
        else if (value == "057483858647" || value == "057483858789")
        {
            $("#msg_callid").html("湖南 益阳 0737"); 
        }
        else if (value == "057483858648" || value == "057483858790")
        {
            $("#msg_callid").html("湖南 娄底 0738"); 
        }
        else if (value == "057483858649" || value == "057483858791")
        {
            $("#msg_callid").html("湖南 邵阳 0739"); 
        }
        else if (value == "057483858650" || value == "057483858792")
        {
            $("#msg_callid").html("湖南 张家界 0744"); 
        }
        else if (value == "057483858651" || value == "057483858793")
        {
            $("#msg_callid").html("湖南 怀化 0745"); 
        }
        else if (value == "057483858652" || value == "057483858794")
        {
            $("#msg_callid").html("湖南 永州 0746"); 
        }
        else if (value == "057483858653" || value == "057483858795")
        {
            $("#msg_callid").html("湖南 湘西 0743"); 
        }
        else if (value == "057483858907" || value == "057483858921")
        {
            $("#msg_callid").html("湖南 118114接入"); 
        }
        else if (value == "057483858705" || value == "057483858847")
        {
            $("#msg_callid").html("湖南 OTA接入"); 
        }
        else
        {
            $("#msg_callid").html(value);   
        }	
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
		/*var h, m, s, str;
		s = value % 60;
		m = Math.floor(value / 60);
		h = Math.floor(m / 60);
		m = m % 60;
		str = Right('00' + h, 2) + " : " + Right('00' + m, 2) + " : " + Right('00' + s, 2);
		$("#msg_timelong").html(str); */ 
        $("#msg_timelong").html(value);
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
							//初始化成功
                            if (c_autosignin)
                            {
                                messageBox("初始化已完全,自动正在签入服务, 请稍等... ...　");
                                AppSuiteObject("command", "login");
                            }
                            else
                            {
							    messageBox("初始化已完全，请点击签入服务　开始工作。　");
							    $("#startService_id").attr("disabled", false);//签入
                            }
                            AppSuiteObject("command", "agentautoenteridle", "yes"); //自动示闲
                            AppSuiteObject("command", "autoanswer", "yes"); //自动应答 
						}
						else
						{
							//初始化失败
							$.messager.alert('error','初始化失败，请关闭程序尝试重新登陆，或直接与管理员联系!','error');
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
					messageBox("您已经成功签入服务器,　系统进入正常作业中。");
                    $("#startService_id").html("签出");  
				}
				else
				{
				}
			} // signin end
			else if (cmdname.text == "signout")
			{
				if (checkStatus(cmdresult) == "0") //成功
				{
					messageBox("您已经成功签出服务器。");
                    $("#startService_id").html("签入");  
				}
				else
				{
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
                    if (intervalProcess)
                    {
                        clearInterval(intervalProcess);
                    }
					intervalProcess = setInterval("get_time_spent()", 1000);
				}
			}// answerrequest end
			else if (cmdname.text == "onrelease")
			{
				/*
                $(".msg_calling").html($("#msg_calling").html());
                $(".msg_called").html($("#msg_callid").html());
				$(".call_in_time").html($("#call_in_time").html());
				$(".start_time").html($("#start_time").html());
				$(".msg_timelong").html($("#msg_timelong").html());
                */ 

                addOld();    

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


/**
 *
 */
function get_time_spent () 
{ 
	var time_now = new Date(); 
	var times = ((time_now.getTime() - clock_start)/1000); 

	var mStatusDisplay = new statusDisplay();
	mStatusDisplay.set_msg_timelong(times);
	delete(mStatusDisplay);
} 

function set_status(cti_tool_setbusy,//示忙
					cti_tool_answer,//接听
					cti_tool_setidle,//示闲
					cti_tool_over,//挂断
					cti_tool_hold,//保持
					cti_tool_consult,//咨询
					cti_tool_conference,//会议
					cti_tool_back,//接回
					cti_tool_transfer,//转移
					com_tool_phone,//外呼
					cti_tool_monitor,//监听
					cti_tool_inset,//强插
					cti_tool_take_apart//强拆
					)
{

	if (cti_tool_setbusy < 2)
	{
		$("#cti_tool_setbusy").attr("disabled", cti_tool_setbusy);//示忙
	}
	if (cti_tool_answer < 2)
	{
		$("#cti_tool_answer").attr("disabled", cti_tool_answer);//接听
	}
	if (cti_tool_setidle < 2)
	{
		$("#cti_tool_setidle").attr("disabled", cti_tool_setidle);//示闲
	}
	
	if (cti_tool_over < 2)
	{
		$("#cti_tool_over").attr("disabled", cti_tool_over);//挂断
	}
	
	if (cti_tool_hold < 2)
	{
		$("#cti_tool_hold").attr("disabled", cti_tool_hold);//保持
	}
	
	if (cti_tool_consult < 2)
	{
		$("#cti_tool_consult").attr("disabled", cti_tool_consult);//咨询
	}
	
	if (cti_tool_conference < 2)
	{
		$("#cti_tool_conference").attr("disabled", cti_tool_conference);//会议
	}
	
	if (cti_tool_back < 2)
	{
		$("#cti_tool_back").attr("disabled", cti_tool_back);//接回
	}
	
	if (cti_tool_transfer < 2)
	{
		$("#cti_tool_transfer").attr("disabled", cti_tool_transfer);//转移
	}
	
	if (com_tool_phone < 2)
	{
		$("#com_tool_phone").attr("disabled", com_tool_phone);//外呼
	}
	

	if (cti_tool_monitor < 2)
	{
        if (c_role == 2)
        {
             cti_tool_monitor = 1;
        }
		$("#cti_tool_monitor").attr("disabled", cti_tool_monitor);//监听
	}
	
	if (cti_tool_inset < 2)
	{
        if (c_role == 2)
        {
             cti_tool_inset = 1;
        }
		$("#cti_tool_insert").attr("disabled", cti_tool_inset);//强插
	}
	
	if (cti_tool_take_apart < 2)
	{
        if (c_role == 2)
        {
             cti_tool_take_apart = 1;
        }
		$("#cti_tool_take_apart").attr("disabled", cti_tool_take_apart);//拦截
	}
	
}
