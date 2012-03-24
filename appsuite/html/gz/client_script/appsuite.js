//==========================================================
var WINDOWSINDEX = 1; //全局状态
//==========================================================

/**
 * 关闭窗口事件， 如果还有未完成的任务，停止关闭动作

function window.onbeforeunload(event) 
{
	//AppSuiteObject("command", "logout");
	//return "确定要退出？";
	
} 
 */
window.onbeforeunload = function(){       
	var n = window.event.screenX - window.screenLeft;       
	var b = n > document.documentElement.scrollWidth - 20;       
	if(b && window.event.clientY < 0 || window.event.altKey)       
	{           
		if (GLOBALESTATUS > 0)
		{
			if(window.confirm("我们判断你当前的状态还没有签出，不能关闭坐席窗口！您确定要现在关闭窗口吗?"))
			{
				if (GLOBALESTATUS == 3)
				{
					AppSuiteObject("command", "releasecall"); 
				}
				AppSuiteObject("command", "logout");
				window.event.returnValue = '因为您已确认现在关闭窗口，我们已将坐席签出，这里请继续点击"确定"离开坐席'; 
			}
			else
			{
				window.event.returnValue = '您已确认现在不关闭窗口，这里请继续点击"取消"，否则会带也很严重的后果'; 
			}
		}     
	}
	else{    
	//              alert("是刷新而非关闭");       
	}       
}  
 

/**
 * 屏蔽 按键和右键
 */
document.onkeydown=function() 
{ 
	if (//(window.event.keyCode == 116) || //屏蔽 F5 
		(window.event.keyCode == 122) || //屏蔽 F11 
		(window.event.shiftKey && window.event.keyCode == 121) //shift+F10 
        ) 
	{ 
		window.event.keyCode = 0; 
		window.event.returnValue = false; 
	} 
	if ((window.event.altKey) && (window.event.keyCode==115)) //屏蔽Alt+F4 
	{
		window.event.keyCode = 0; 
		window.event.returnValue = false; 
		//window.showModelessDialog("about:blank","","dialogWidth:1px;dialogheight:1px"); 
		return false; 
	} 
}

/**
 * 鼠标
 
if (window.Event)
{
	document.captureEvents(Event.MOUSEUP);
}
*/

function nocontextmenu()
{ 
	event.cancelBubble = true 
	event.returnValue = false; 
	return false; 
} 
function norightclick(e)
{ 
	if (window.Event){ 
	  if (e.which == 2 || e.which == 3) 
	  return false; 
	} 
	else 
	  if (event.button == 2 || event.button == 3){ 
	   event.cancelBubble = true 
	   event.returnValue = false; 
	   return false; 
	  } 
} 
//document.oncontextmenu = nocontextmenu; // for IE5+ 
//document.onmousedown = norightclick; // for all others 


//以iframe 的方式弹出一个新窗口，不受域名限制
function openNowWindows(title, url, closable)
{
	var strContent;
    var strFlag = url.substr(0, 1);
    if (strFlag == '?')
    {
        return;
    }
    
	if (!title || title == "")
	{
		title = "new window-" + (WINDOWSINDEX++);
	}
    try
    {
	    var pp = $('#maintab').tabs('getTab', title);
	    if (!pp)
	    {
		    strContent = "<iframe scrolling=\"yes\" frameborder=\"0\" src=\"" + url + "\" style=\"width:100%;height:100%;\"></iframe>";
		    $('#maintab').tabs('add', {
			    title: title,
			    content:strContent,
			    closable:true
		    });
	    }
	    else
	    {
		    var pp = $('#maintab').tabs('select', title);

		    strContent = "<iframe scrolling=\"yes\" frameborder=\"0\" src=\"" + url + "\" style=\"width:100%;height:100%;\"></iframe>";
		    var tab = $('#maintab').tabs('getSelected');
			    $('#maintab').tabs('update', {
				    tab: tab,
				    options:{
					    content:strContent
		    //			title:'new title'
				    }
		    });
	    }
    }
    catch(err)
    {
        alert(err.description);
    }
}

//通过ajax 的方式弹出一个本地新窗口，受域名限制,会干扰原界面的JS 和 css
function openNowWindowsLocal(title, url, closable)
{
	if (!title || title == "")
	{
		title = "new window";
	}
    try
    {
	    var pp = $('#maintab').tabs('getTab', title);
	    if (!pp)
	    {
		    $('#maintab').tabs('add', {
					    title:title,
					    href:url,
					    closable:closable
				    });
	    }
    }
    catch(err)
    {
        alert(err.description);
    }
}

function messageBox(info, title)
{
    if (!title || title == "")
    {
        title = "消息";
    }
    try
    {
        $.messager.show({
                title:title,
                msg:info,
                timeout:5000,
                height:150,
			    showSpeed:100,
                showType:'slide'
            });
    }
    catch(err)
    {
        alert(err.description);
    }
}

/**
 * 
 */
function refresh_queue_size_enable() 
{ 
	$("#refresh_queue_size").attr("disabled", false);
}

/**
 * 外呼 
 */
function makeOutCall(tel)
{
  //  AppSuiteObject("command", "makecall", tel, "out"); 
	messageBox("正在回拨用户：" + tel + ",请稍候...");
	AppSuiteObject("command", "makecall", tel, "out", $("#fakecalling").val());
}

/**
 * 去除首尾空格
 */
function trim(inputString) 
{
    
    if (typeof inputString != "string") 
    { 
        return inputString; 
    }
    
    var retValue = inputString;
    var ch = retValue.substring(0, 1);
    
    while (ch == " ") 
    { 
        //检查字符串开始部分的空格
        retValue = retValue.substring(1, retValue.length);
        ch = retValue.substring(0, 1);
    }
    ch = retValue.substring(retValue.length-1, retValue.length);
    
    while (ch == " ") 
    {
        //检查字符串结束部分的空格
        retValue = retValue.substring(0, retValue.length-1);
        ch = retValue.substring(retValue.length-1, retValue.length);
    }
    while (retValue.indexOf("  ") != -1) 
    { 
        //将文字中间多个相连的空格变为一个空格
        retValue = retValue.substring(0, retValue.indexOf("  ")) + retValue.substring(retValue.indexOf("  ")+1, retValue.length); 
    }
    return retValue;
}

/**
 * 挂机  
 */
function releasecall()
{
    AppSuiteObject("command", "releasecall");   
}

////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////
$().ready(function() {
	/********************************************************************************************/
	// 自动右键菜单
    var option = { width: 150, items: [
                    { text: "第一项", icon: "/client_images/contextmenu/ico1.gif", alias: "1-1", action: menuAction },
                    { text: "第二项", icon: "/client_images/contextmenu/ico2.gif", alias: "1-2", action: menuAction },
                    { text: "第三项", icon: "/client_images/contextmenu/ico3.gif", alias: "1-3", action: menuAction },
                    { type: "splitLine" },
                    { text: "组一集合", icon: "/client_images/contextmenu/ico4.gif", alias: "1-4", type: "group", width: 170, items: [
                        { text: "组三集合", icon: "/client_images/contextmenu/ico4-1.gif", alias: "2-2", type: "group", width: 190, items: [
                            { text: "组3一项", icon: "/client_images/contextmenu/ico4-1-1.gif", alias: "3-1", action: menuAction },
                            { text: "组3二项", icon: "/client_images/contextmenu/ico4-1-1.gif", alias: "3-2", action: menuAction }
                        ]
                        },
                        { text: "组1一项", icon: "/client_images/contextmenu/ico4-2.gif", alias: "2-1", action: menuAction },
                        { text: "组1二项", icon: "/client_images/contextmenu/ico4-3.gif", alias: "2-3", action: menuAction },
                        { text: "组1三项", icon: "/client_images/contextmenu/ico4-4.gif", alias: "2-4", action: menuAction }
                    ]
                    },
                    { type: "splitLine" },
                    { text: "第四项", icon: "/client_images/contextmenu/ico5.gif", alias: "1-5", action: menuAction },
                    { text: "组二集合", icon: "/client_images/contextmenu/ico6.gif", alias: "1-6", type: "group", width: 180, items: [
                        { text: "组2一项", icon: "/client_images/contextmenu/ico6-1.gif", alias: "4-1", action: menuAction },
                        { text: "组2二项", icon: "/client_images/contextmenu/ico6-2.gif", alias: "4-2", action: menuAction }
                    ]
                    }
                    ], onShow: applyrule,
        onContextMenu: BeforeContextMenu
    };
    function menuAction() {
        alert(this.data.alias);
        if (this.data.alias == "1-2")
        {
        	openNowWindows("新窗口", "http://localhost:8089/admin/iplist", "true");
        }
        else if (this.data.alias == "1-3")
        {
        	openNowWindowsLocal("新窗口", "http://localhost:8089/admin/iplist", true);
        }
        else if (this.data.alias == "1-5")
        {
 //           window.status = "why";
            alert(window.status);
        }
    }
    function applyrule(menu) {               
        if (this.id == "target2") {
            menu.applyrule({ name: "target2",
                disable: true,
                items: ["1-2", "2-3", "2-4", "1-6"]
            });
        }
        else {
            menu.applyrule({ name: "all",
                disable: true,
                items: []
            });
        }
    }
    function BeforeContextMenu() {
        return this.id != "target3";
    }
    
//    $("*").contextmenu(option);
    /********************************************************************************************/
    
    /********************************************************************************************/
    // 总布局
	
	/********************************************************************************************/


	/********************************************************************************************/
    // 
	/********************************************************************************************/
    

	/********************************************************************************************/
    // 表单提交
	/*
    $('#editscript').form({
        url: '/admin/script',
        onSubmit: function(){
                // do some check
                // return false to prevent submit;
        },
        success:function(data){
                alert(data)
        }
	});
	*/
    /********************************************************************************************/
	
    /********************************************************************************************/
    // CTI工具栏
	$("#cti_tool_hold").click(function(){ //保持
		AppSuiteObject("command", "hold");
	});

	$("#cti_tool_conference").click(function(){//三方通话
		AppSuiteObject("command", "conference");
	});

	$("#cti_tool_back").click(function(){ //接回
		AppSuiteObject("command", "back");
	});

	$("#cti_tool_transfer").click(function(){ //转接
		AppSuiteObject("command", "transfer");
	});

	$("#cti_tool_consult").click(function(){ //咨询
        try
        {
            $('#consultdialog').dialog("open");
        }
        catch(err)
        {
            alert(err.description);
        }
	});
	$("#cti_tool_monitor").click(function(){ //监听
        try
        {
             $('#monitor_window').dialog("open");
        }
        catch(err)
        {
            alert(err.description);
        }
	});

	$("#cti_tool_insert").click(function(){ //强插
        try
        {
            $('#insert_window').dialog("open");
        }
        catch(err)
        {
            alert(err.description);
        }
	});

	$("#cti_tool_take_apart").click(function(){ //拦截
        try
        {
            $('#intercept_window').dialog("open");
        }
        catch(err)
        {
            alert(err.description);
        }
	});     
    $("#cti_tool_pay").click(function(){ //转IVR支付
        try
        {
            AppSuiteObject("command", "singlesteptransfer", "02155304952");
        }
        catch(err)
        {
            alert(err.description);
        }
    });
    $("#cti_tool_pay_manual").click(function(){ //转人工支付
        try
        {
            AppSuiteObject("command", "singlesteptransfer", "02155718687");
        }
        catch(err)
        {
            alert(err.description);
        }
    });
    $("#cti_tool_pay_hotel").click(function(){ //酒店支付
        try
        {
            AppSuiteObject("command", "singlesteptransfer", "02155718686");
            
        }
        catch(err)
        {
            alert(err.description);
        }
    });  
    
    $("#cti_tool_internation_xz").click(function(){ //转国际机票 西藏 02155304929
        try
        {
            AppSuiteObject("command", "singlesteptransfer", "02155304929");
        }
        catch(err)
        {
            alert(err.description);
        }
    });  
    
    $("#cti_tool_internation_qh").click(function(){ //转国际机票 青海 02155304928
        try
        {
            AppSuiteObject("command", "singlesteptransfer", "02155304928");
        }
        catch(err)
        {
            alert(err.description);
        }
    });
    
    $("#cti_tool_internation_gz").click(function(){ //转国际机票 贵州 02155304961
        try
        {
            AppSuiteObject("command", "singlesteptransfer", "02155304961");
        }
        catch(err)
        {
            alert(err.description);
        }
    });
    
    $("#cti_tool_internation_hb").click(function(){ //转国际机票 湖北 02155304903
        try
        {
            AppSuiteObject("command", "singlesteptransfer", "02155304903");
        }
        catch(err)
        {
            alert(err.description);
        }
    });
    $("#cti_tool_internation_yn").click(function(){ //转国际机票 云南 02155304969
        try
        {
            AppSuiteObject("command", "singlesteptransfer", "02155304969");
        }
        catch(err)
        {
            alert(err.description);
        }
    });
    $("#cti_tool_internation_hlj").click(function(){ //转国际机票 黑龙江 02155304992
        try
        {
            AppSuiteObject("command", "singlesteptransfer", "02155304992");
        }
        catch(err)
        {
            alert(err.description);
        }
    });
    
    $("#cti_tool_internation_gx").click(function(){ //转国际机票 广西 02155304962
        try
        {
            AppSuiteObject("command", "singlesteptransfer", "02155304962");
        }
        catch(err)
        {
            alert(err.description);
        }
    });
    $("#cti_tool_internation_hn").click(function(){ //转国际机票 海南 02155304960
        try
        {
            AppSuiteObject("command", "singlesteptransfer", "02155304960");
        }
        catch(err)
        {
            alert(err.description);
        }
    });
    $("#cti_tool_internation_fj").click(function(){ //转国际机票 福建 02155304901
        try
        {
            AppSuiteObject("command", "singlesteptransfer", "02155304901");
        }
        catch(err)
        {
            alert(err.description);
        }
    });
    $("div[id^='userdef_button_']").click(function(){
        try
        {
            var paramCalling = $("#msg_calling").html();
            var paramCalled = $(this).attr('id').substring(15);
            paramCalling = trim(paramCalling);
            paramCalled = trim(paramCalled); 
            if (!paramCalling)
            {
                paramCalling = "118114";
            }
            paramCalling += '^';
            paramCalling += paramCalled;
              
            if (paramCalled.length > 5)
            {  
                if (paramCalled.substr(0, 5) == "44460")
                {       
                    AppSuiteObject("command", "setcalldata", paramCalling);   
                    // 2秒后自动挂机
                    setTimeout("releasecall()", 2000);  
                }
                else
                {
                    AppSuiteObject("command", "singlesteptransfer", paramCalled);    
                }
                
            }        
        }
        catch(err)
        {
            alert(err.description);
        }
    });
    
    $("div[id^='userdef_buttonex_']").click(function(){
        try
        {
            var paramCalled = $(this).attr('id').substring(17);
            AppSuiteObject("command", "singlesteptransfer", paramCalled);    
        }
        catch(err)
        {
            alert(err.description);
        }
    });
	/********************************************************************************************/

	
	
	
	/********************************************************************************************/
	//共公工具栏
	$("#com_tool_phone").click(function(){ //打开软电话
        $("#softphone").dialog('open');
	});

	/********************************************************************************************/
    //toolbar
    $("#toolbar li").mouseover(function(){
        $(this).css("background-positionX", "-58px");
    });
    $("#toolbar li").mouseout(function(){
        $(this).css("background-positionX", "0");
    });
    

	/********************************************************************************************/
	//软电话
	//$("#softphonekey").sortable();
	$("#softphonekey").disableSelection();
	/*软电话键盘*/
	$("#softphonekey li").mouseover(function(){
		$(this).css("background-positionX", "-64px");
	});
	$("#softphonekey li").mouseout(function(){
		$(this).css("background-positionX", "0");
	});
	$("#softphonekey li").mousedown(function(){
		$(this).css("background-positionX", "-128px");
	});
	$("#softphonekey li").mouseup(function(){
		$(this).css("background-positionX", "0");
	});
	$("#softphonekey li").click(function(){
		var keyVal = $(this).attr("value");

		if (keyVal < 200)
		{
			if (keyVal  == 101)
			{
				keyVal = "*";
			}
			else if (keyVal == 102)
			{
				keyVal = "#";
			}
			var value = $(".softphonevalue").val();
			value = value + keyVal;
			$(".softphonevalue").val(value);
            
            //当在通话中，拨号盘为二次拨号状态
            if (SUBSTATUS == "300" || //接入用户通话中
                SUBSTATUS == "301" || //内部呼入通话
                SUBSTATUS == "302" || //外部呼出通话
                SUBSTATUS == "303"  //内部呼出通话
                )
            {
                AppSuiteObject("command", "senddtmf", String(keyVal));        
            }
		}
		else if (keyVal == 201)
		{
			// 保存
		}
		else if (keyVal == 202)
		{
			// 呼出
			if (checkMobile($(".softphonevalue").val()))
			{
				AppSuiteObject("command", "makecall", $(".softphonevalue").val(), $("#makecalltile").val(), $("#fakecalling").val());
				//alert($(".softphonevalue").val());
			}
			else
			{
				$.messager.alert('错误号码','您输入的号码: ' + $(".softphonevalue").val() + '  格式不正确，不能呼出!','info');
			}
			
		}
		else if (keyVal == 203)
		{
			// 清空
			$(".softphonevalue").val("");
		}
	});
    $("#makecallbutton").click(function(){
         // 呼出
        if (checkMobile($(".softphonevalue").val()))
        {
            AppSuiteObject("command", "makecall", $(".softphonevalue").val(), $("#makecalltile").val(), $("#fakecalling").val());
            //AppSuiteObject("command", "makecall", $(".softphonevalue").val(), $("#makecalltile").val());
            //alert($(".softphonevalue").val());
        }
        else
        {
            $.messager.alert('错误号码','您输入的号码: ' + $(".softphonevalue").val() + '  格式不正确，不能呼出!','info');
        }
    });
	/********************************************************************************************/
	
	/********************************************************************************************/
	//状态区、按钮
	$("#cti_tool_setbusy").click(function(){//置  忙
		checkMax();
		//AppSuiteObject("command", "setbusy");
	});

	$("#cti_tool_setidle").click(function(){//置  闲
		AppSuiteObject("command", "setidle");
		setAgentAutoEnterIdle();//自动置闲
	});

	$("#cti_tool_answer").click(function(){//应 答
		AppSuiteObject("command", "answer");
	});

	$("#cti_tool_over").click(function(){//挂 机
		AppSuiteObject("command", "releasecall");
	});

	/********************************************************************************************/
	
	/********************************************************************************************/
	//咨询
	$("#consultdialogflag_bt").click(function(){
		//AppSuiteObject("command", "consultation", $("#consultdialogflag").combobox('getValue'), $(".consultdialogvalue").val());
        if ($(".consultdialogvalue").val() == "")
        {
            alert("对不起，你咨询的目标不能为空，请输入要咨询的目标信息！");
        }
        else
        {
            if ($("#consultdialogflag").val() == 2)//转技能组
            {
                AppSuiteObject("command", "singlesteptransfertoskill", $(".consultdialogvalue").val());   
            }
            else
            {
                AppSuiteObject("command", "consultation", $("#consultdialogflag").val(),  $(".consultdialogvalue").val());   
            }
        }
        
	});

	
	/********************************************************************************************/

	/********************************************************************************************/
	//监听
	$("#monitored_submit").click(function(){
        if ($("#monitored_agentid").val() == "")
        {
            alert("对不起，你监听的目标不能为空，请输入要监听的目标信息！");
        }
        else
        {
		    AppSuiteObject("command", "listen", $("#monitored_agentid").val());
        }
	});
	/********************************************************************************************/
	
	/********************************************************************************************/
	//强插
	$("#insert_submit").click(function(){
        if ($("#insert_agentid").val() == "")
        {
            alert("对不起，你强插的目标不能为空，请输入要强插的目标信息！");
        }
        else
        {
		    AppSuiteObject("command", "insert", $("#insert_agentid").val());
        }
	});
	/********************************************************************************************/


	/********************************************************************************************/
	//拦截
	$("#intercept_submit").click(function(){
        if ($("#intercept_agentid").val() == "")
        {
            alert("对不起，你拦截的目标不能为空，请输入要拦截的目标信息！");
        }
        else
        {
		    AppSuiteObject("command", "intercept", $("#intercept_agentid").val());
        }
	});
	/********************************************************************************************/

	/********************************************************************************************/
	$("#tt1").tree({
                onClick: function(node) {
					if (node.text == "座席端配制")
					{
						openNowWindowsLocal("座席配制", "/appsuite/setclient", true);
					}
				}
	});

	/********************************************************************************************/
	/*$('#sb').splitbutton({
		menu:'#mm1',
		duration: 3000
	});*/
	//

	/********************************************************************************************/
	//刷新排队数
	$("#refresh_queue_size").click(function(){

		var result = AppSuiteObject('local', 'getparam', "<element name=\"\" type=\"\" value=\"queuewaitnum\" />");
		var resultDom = new xml(result);
	
		//获得根接点
		var nodes = resultDom.documentElement.childNodes;
		
		//得到根接点下共有子接点个数，并循环
		var flag = true;
		for(var i=0; i<nodes.length && flag; i++)
		{
			//如果接点名为 tree
			if(nodes(i).nodeName == "result")
			{
				var resultNodes = nodes(i).childNodes;
				for(var j=0; j<resultNodes.length && flag; j++)
				{
					var name = resultNodes(j).getAttribute("name");
					var value = resultNodes(j).getAttribute("value");

					if (name == "num")
					{
						$("#queue_size").html(value);
						flag = false;
					}
				}
			}
		}
		//删除对象
		delete(resultDom);

		$("#refresh_queue_size").attr("disabled", true);
		setTimeout("refresh_queue_size_enable()", 10000);

	});
	 
	/********************************************************************************************/
	
	
	/********************************************************************************************/
	//设置静音
	$("#setphonemute").click(function(){
		AppSuiteObject("command", "setphonemute", '1');
		$("#setphonemute").hide();
		$("#closephonemute").show();
	});

	//解除静音
	$("#closephonemute").click(function(){
		AppSuiteObject("command", "setphonemute", '0');
		$("#setphonemute").show();
		$("#closephonemute").hide();
	});
	/********************************************************************************************/


	
	/********************************************************************************************/

	/********************************************************************************************/
	//底部按钮
	$("#startService_id").click(function(){
		if ($(this).html() == "签出")
		{
			if (GLOBALESTATUS == 3)
			{
				messageBox("当前坐席状态下不允许签出！！");
			}
			else
			{
				AppSuiteObject("command", "logout");
			}
			
		}
		else
		{
			messageBox("正在签入服务, 请稍等... ...　");
			AppSuiteObject("command", "login");
			
		}
	});

	$("#exit_id").click(function(){ //关闭
		$.messager.confirm('提示', '你确定要退出吗?', function(r){
				if (r){
					//AppSuiteObject("command", "uninit");
					if (GLOBALESTATUS == 0)
					{
						window.opener=null;
						window.close(); 
					}
					else
					{
						messageBox("当前坐席状态下不允许退出！！");
					}
				}
			});
		
	});

	$("#lockscreem_id").click(function(){ //锁屏
		$('#lockscreem_window').window({
				collapsible: false,
				minimizable: false,
				maximizable: false,
				closable: false,
				modal: true,
				shadow: false,
				closed: false
			});
		
	});
	$("#lockscreem_submit").click(function(){
		if ($("#lockscreem_pwd").val() == $("#lockscreem_pwdplaintext").val())
		{
			$("#lockscreem_pwd").val("");
			$('#lockscreem_window').window("close");
		}
		$("#lockscreem_pwd").val("");
	});
	/********************************************************************************************/
	
	/********************************************************************************************/
    //初始化
    $("#busy_free").attr("disabled", true);
    $("#answer_hangup").attr("disabled", true); 
	$("#cti_tool_setbusy").attr("disabled", true);
	set_status(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
    //set_status(0, 0, 0, 0, 0, 0, 0, 0, 0 ,0 ,0 ,0 ,0 );
	$("#startService_id").attr("disabled", true);//签入
	/********************************************************************************************/

	
	//openNowWindows("baidu.com", "http://www.baidu.com", true);

	/********************************************************************************************/
    //咨询
    $('#consultdialog').dialog({
        closed: true,
        title:'咨询',
        width:600,
        height:400,
        onOpen : function() {
            $('#consultaddress-tab').datagrid({ 
                striped: true,
                singleSelect : true ,
                onDblClickRow : function(rowIndex, rowData)
                                {
                                    $(".consultdialogvalue").val(rowData.f1);
                                } 
            });
        }
                            
    });
    
    $("#consultdialogflag").change(function(){
        if ($("#consultdialogflag").val() == 0) //咨询座席工号
        {
            $('#consultaddress').show();
            $('#consultout').hide();
            $('#consultskills').hide();  
                
            $('#consultaddress-tab').datagrid({ 
                striped: true,
                singleSelect : true ,
                onDblClickRow : function(rowIndex, rowData)
                                {
                                    $(".consultdialogvalue").val(rowData.f1);
                                } 
            });
        }
        else if ($("#consultdialogflag").val() == 1) //咨询外部号码
        {
            $('#consultaddress').hide();
            $('#consultout').show();
            $('#consultskills').hide();
        } 
        else if ($("#consultdialogflag").val() == 2) //咨询技能组   
        {
            $('#consultaddress').hide();
            $('#consultout').hide();
            $('#consultskills').show();
            $('#consultskill-tab').datagrid({ 
                striped: true,
                singleSelect : true ,
                onDblClickRow : function(rowIndex, rowData)
                                {
                                    $(".consultdialogvalue").val(rowData.f1);
                                } 
            });
        }
    });
    
	/********************************************************************************************/
    
    /********************************************************************************************/  
    //电话 
    $('#softphone').dialog({
        closed: true,
        toolbar:[{
            text:'内呼',
            iconCls:'icon-telephone-link',
            handler:function(){
                $('#softphone').dialog({closed: false, title:"软电话－－内呼", width:600, height:400});
                $('#softphonekeys').hide();
                $('#softphoneaddress').show();
                
                $('#softphoneaddress-tab').datagrid({ 
                    striped: true,
                    singleSelect : true ,
                    onDblClickRow : function(rowIndex, rowData)
                                    {
                                        $(".softphonevalue").val(rowData.f1);
                                    } 
                });
                
                $("#makecalltile").val("in");
            }
        },'-',{
            text:'外呼',
            iconCls:'icon-telephone-go',
            handler:function(){
                $('#softphone').dialog({closed: false, title:"软电话－－外呼", width:300,height:300});
                $('#softphonekeys').show();
                $('#softphoneaddress').hide();
                $("#makecalltile").val("out");
            }
        }],
        title:'软电话－－外呼',
        width:300,
        height:300                                
    });
    /********************************************************************************************/  
    
    /********************************************************************************************/  
    //监听
    $('#monitor_window').dialog({
        closed: true,
        title:'监听',
        width:600,
        height:400,
        modal: false,
        onOpen : function() {
        $('#monitored-tab').datagrid({ 
            striped: true,
            singleSelect : true ,
            onDblClickRow : function(rowIndex, rowData)
                            {
                                $("#monitored_agentid").val(rowData.f1);
                            } 
        });
        }
                            
    });
    /********************************************************************************************/  
    
    /********************************************************************************************/  
    //强插
    $('#insert_window').dialog({
        closed: true,
        title:'强插',
        width:600,
        height:400,
        modal: false,
        onOpen : function() {
        $('#insert-tab').datagrid({ 
            striped: true,
            singleSelect : true ,
            onDblClickRow : function(rowIndex, rowData)
                            {
                                $("#insert_agentid").val(rowData.f1);
                            } 
        });
        }
                            
    });
    /********************************************************************************************/ 
    
    /********************************************************************************************/  
    //拦截
    $('#intercept_window').dialog({
        closed: true,
        title:'拦截',
        width:600,
        height:400,
        modal: false,
        onOpen : function() {
        $('#intercept-tab').datagrid({ 
            striped: true,
            singleSelect : true ,
            onDblClickRow : function(rowIndex, rowData)
                            {
                                $("#intercept_agentid").val(rowData.f1);
                            } 
        });
        }
                            
    });
    /********************************************************************************************/  
    
    /********************************************************************************************/
    //自定义菜单区  
    $('#case').click(function(){
        var offset = $(this).offset();

        $('#menucustomize').menu('show',{
                    left:offset.left,
                    top:offset.top + $(this).height()
                });
    });
    /********************************************************************************************/  
    
});