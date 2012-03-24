
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
        if (value == "057483858915" || value == "057483858929")
        {
            $("#msg_callid").html("广西 118114接入"); 
        }
        else if (value == "057483858741" || value == "057483858883")
        {
            $("#msg_callid").html("广西 OTA接入"); 
        }
        else if (value == "057483858728" || value == "057483858870")
        {
            $("#msg_callid").html("广西 防城港 "); 
        }
        else if (value == "057483858729" || value == "057483858871")
        {
            $("#msg_callid").html("广西 南宁 0771"); 
        }
        else if (value == "057483858730" || value == "057483858872")
        {
            $("#msg_callid").html("广西 柳州 0772"); 
        }
        else if (value == "057483858731" || value == "057483858873")
        {
            $("#msg_callid").html("广西 桂林 0773"); 
        }
        else if (value == "057483858732" || value == "057483858874")
        {
            $("#msg_callid").html("广西 梧州 0774"); 
        }
        else if (value == "057483858733" || value == "057483858875")
        {
            $("#msg_callid").html("广西 玉林 0775"); 
        }
        else if (value == "057483858734" || value == "057483858876")
        {
            $("#msg_callid").html("广西 百色 0776"); 
        }
        else if (value == "057483858735" || value == "057483858877")
        {
            $("#msg_callid").html("广西 钦州 0777"); 
        }
        else if (value == "057483858736" || value == "057483858878")
        {
            $("#msg_callid").html("广西 河池 0778"); 
        }
        else if (value == "057483858737" || value == "057483858879")
        {
            $("#msg_callid").html("广西 北海 0779"); 
        }
        else if (value == "057483858738" || value == "057483858880")
        {
            $("#msg_callid").html("广西 崇左 0771"); 
        }  
        else if (value == "057483858739" || value == "057483858881")
        {
            $("#msg_callid").html("广西 来宾 0772"); 
        }
        else if (value == "057483858740" || value == "057483858882")
        {
            $("#msg_callid").html("广西 贺州 0774"); 
        }
        else if (value == "057483858703" || value == "057483858845")
        {
            $("#msg_callid").html("广西 贵港 0775"); 
        }
        else if (value == "057483858903" || value == "057483858917")
        {
            $("#msg_callid").html("海南 118114接入"); 
        }
        else if (value == "057483858622" || value == "057483858764")
        {
            $("#msg_callid").html("海南 OTA接入"); 
        }
        else if (value == "057483858621" || value == "057483858763")
        {
            $("#msg_callid").html("海南"); 
        }
        else if (value == "057483858904" || value == "057483858918")
        {
            $("#msg_callid").html("福建 118114接入"); 
        } 
        else if (value == "057483858706" || value == "057483858848")
        {
            $("#msg_callid").html("福建 OTA接入"); 
        }
        else if (value == "057483858623" || value == "057483858765")
        { 
            $("#msg_callid").html("福建 福州 0591"); 
        }
        else if (value == "057483858624" || value == "057483858766")
        { 
            $("#msg_callid").html("福建 厦门 0592"); 
        }
        else if (value == "057483858625" || value == "057483858767")
        {
            $("#msg_callid").html("福建 宁德 0593"); 
        }
        else if (value == "057483858626" || value == "057483858768")
        { 
            $("#msg_callid").html("福建 莆田 0594"); 
        }
        else if (value == "057483858627" || value == "057483858769")
        { 
            $("#msg_callid").html("福建 泉州 0595"); 
        }
        else if (value == "057483858628" || value == "057483858770")
        {  
            $("#msg_callid").html("福建 漳州 0596"); 
        }
        else if (value == "057483858629" || value == "057483858771")
        {    
            $("#msg_callid").html("福建 龙岩 0597"); 
        }
        else if (value == "057483858630" || value == "057483858772")
        {
            $("#msg_callid").html("福建 三明 0598"); 
        }
        else if (value == "057483858631" || value == "057483858773")
        { 
            $("#msg_callid").html("福建 南平 0599"); 
        } 
        else if (value == "057483858600" || value == "057483858742")
        { 
            $("#msg_callid").html("广东 深圳  0755"); 
        } 
        else if (value == "057483858601" || value == "057483858743")
        { 
            $("#msg_callid").html("广东 广州  020"); 
        } 		
        else if (value == "057483858602" || value == "057483858744")
        { 
            $("#msg_callid").html("广东 东莞  0769"); 
        }
        else if (value == "057483858603" || value == "057483858745")
        { 
            $("#msg_callid").html("广东 佛山  0757"); 
        }
        else if (value == "057483858604" || value == "057483858746")
        { 
            $("#msg_callid").html("广东 汕头  0754"); 
        }
        else if (value == "057483858605" || value == "057483858747")
        { 
            $("#msg_callid").html("广东 中山  0760"); 
        }
        else if (value == "057483858606" || value == "057483858748")
        { 
            $("#msg_callid").html("广东 惠州  0752"); 
        }
        else if (value == "057483858607" || value == "057483858749")
        { 
            $("#msg_callid").html("广东 江门  0750"); 
        }
        else if (value == "057483858608" || value == "057483858750")
        { 
            $("#msg_callid").html("广东 揭阳  0663"); 
        }
        else if (value == "057483858609" || value == "057483858751")
        { 
            $("#msg_callid").html("广东 湛江  0759"); 
        }
        else if (value == "057483858610" || value == "057483858752")
        { 
            $("#msg_callid").html("广东 珠海  0756"); 
        }
        else if (value == "057483858611" || value == "057483858753")
        { 
            $("#msg_callid").html("广东 茂名  0668"); 
        }
        else if (value == "057483858612" || value == "057483858754")
        { 
            $("#msg_callid").html("广东 肇庆  0758"); 
        }
        else if (value == "057483858613" || value == "057483858755")
        { 
            $("#msg_callid").html("广东 梅州  0753"); 
        }
        else if (value == "057483858614" || value == "057483858756")
        { 
            $("#msg_callid").html("广东 潮州  0768"); 
        }
        else if (value == "057483858615" || value == "057483858757")
        { 
            $("#msg_callid").html("广东 韶关  0751"); 
        }
        else if (value == "057483858616" || value == "057483858758")
        { 
            $("#msg_callid").html("广东 清远  0763"); 
        }
        else if (value == "057483858617" || value == "057483858759")
        { 
            $("#msg_callid").html("广东 汕尾  0660"); 
        }
        else if (value == "057483858618" || value == "057483858760")
        { 
            $("#msg_callid").html("广东 阳江  0662"); 
        }
        else if (value == "057483858619" || value == "057483858761")
        { 
            $("#msg_callid").html("广东 河源  0762"); 
        }
        else if (value == "057483858620" || value == "057483858762")
        { 
            $("#msg_callid").html("广东 云浮  0766"); 
        }
        else if (value == "057483858684" || value == "057483858709")
        {
            $("#msg_callid").html("广东 118114接入"); 
        }
        else if (value == "057483858675" || value == "057483858710")
        {
            $("#msg_callid").html("广东 OTA接入"); 
        }
        else if (value == "057483858975")
        { 
            $("#msg_callid").html("4008国际机票"); 
        } 
        else if (value == "057483858944")
        { 
            $("#msg_callid").html("广东 国际机票"); 
        } 
        else if (value == "057483858945")
        { 
            $("#msg_callid").html("海南 国际机票"); 
        } 
        else if (value == "057483858946")
        { 
            $("#msg_callid").html("福建 国际机票"); 
        }
        else if (value == "057483858947")
        { 
            $("#msg_callid").html("广西 国际机票"); 
        }
        else if (value == "057483858948")
        { 
            $("#msg_callid").html("江苏 国际机票"); 
        }
        else if (value == "057483858949")
        { 
            $("#msg_callid").html("安徽 国际机票"); 
        }
        else if (value == "057483858950")
        { 
            $("#msg_callid").html("上海 国际机票"); 
        }
        else if (value == "057483858951")
        { 
            $("#msg_callid").html("浙江 国际机票"); 
        }
        else if (value == "057483858951")
        { 
            $("#msg_callid").html("浙江 国际机票"); 
        }
        else if (value == "057483858952")
        { 
            $("#msg_callid").html("江西 国际机票"); 
        }
        else if (value == "057483858953")
        { 
            $("#msg_callid").html("四川 国际机票"); 
        }
        else if (value == "057483858954")
        { 
            $("#msg_callid").html("湖南 国际机票"); 
        }
        else if (value == "057483858955")
        { 
            $("#msg_callid").html("青海 国际机票"); 
        }
        else if (value == "057483858956")
        { 
            $("#msg_callid").html("贵州 国际机票"); 
        }
        else if (value == "057483858957")
        { 
            $("#msg_callid").html("重庆 国际机票"); 
        }
        else if (value == "057483858958")
        { 
            $("#msg_callid").html("云南 国际机票"); 
        }
        else if (value == "057483858959")
        { 
            $("#msg_callid").html("西藏 国际机票"); 
        }
        else if (value == "057483858960")
        { 
            $("#msg_callid").html("湖北 国际机票"); 
        }
        else if (value == "057483858961")
        { 
            $("#msg_callid").html("陕西 国际机票"); 
        }
        else if (value == "057483858962")
        { 
            $("#msg_callid").html("宁夏 国际机票"); 
        }
        else if (value == "057483858963")
        { 
            $("#msg_callid").html("新疆 国际机票"); 
        }
        else if (value == "057483858964")
        { 
            $("#msg_callid").html("甘肃 国际机票"); 
        }
        else if (value == "057483858965")
        { 
            $("#msg_callid").html("吉林 国际机票"); 
        }
        else if (value == "057483858966")
        { 
            $("#msg_callid").html("黑龙江 国际机票"); 
        }
        else if (value == "057483858967")
        { 
            $("#msg_callid").html("河北 国际机票"); 
        }
        else if (value == "057483858968")
        { 
            $("#msg_callid").html("山西 国际机票"); 
        }
        else if (value == "057483858969")
        { 
            $("#msg_callid").html("辽宁 国际机票"); 
        }
        else if (value == "057483858970")
        { 
            $("#msg_callid").html("河南 国际机票"); 
        }
        else if (value == "057483858971")
        { 
            $("#msg_callid").html("天津 国际机票"); 
        }
        else if (value == "057483858972")
        { 
            $("#msg_callid").html("北京 国际机票"); 
        }
        else if (value == "057483858973")
        { 
            $("#msg_callid").html("山东 国际机票"); 
        }
        else if (value == "057483858974")
        { 
            $("#msg_callid").html("内蒙 国际机票"); 
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
