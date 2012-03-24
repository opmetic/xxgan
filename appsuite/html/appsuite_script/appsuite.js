var clientWidth = 0;
var clientHeight = 0;

var newWindowsIndex = 0;

/*  function ================================================================ */
function openNowWindows(title, url, closable)
{
	$('#maintab').tabs('add', {
				title:title,
				href: url,
				closable:closable
			});
}

function openStaticWindows(title)
{
	if (title == "软电话")
	{
		var pp = $('#maintab').tabs('getTab', title);
		if (!pp)
		{
			var contentValue =  $('#softphonediv').html();
			$('#softphonediv').empty();
			$('#maintab').tabs('add', {
				title:title,
				content: contentValue,
				iconCls:'icon-telephone',
				closable:true
			});
		}
		else
		{
			var pp = $('#maintab').tabs('select', title);
		}
	}
	else 
	{
		var pp = $('#maintab').tabs('getTab', title);
		if (!pp)
		{
			$('#maintab').tabs('add', {
				title:title,
				content:title,
				closable:true
			});
		}
		else
		{
			var pp = $('#maintab').tabs('select', title);
		}
	}
}

$(function() {
	/*得到窗口大小*/
	clientWidth = $("#qn_all").width();
	clientHeight = $(window).height();
	
	/*设置主区宽高度*/
	$("#maindiv").height((clientHeight - 70) + "px");
	$("#maindiv").width((clientWidth - 302) + "px");

	/*目录*/
	$('#mb1, #mb2').menubutton({
			//		plain:false
				});
					
	/*应答 挂断*/
	$("#answer_hangup").click(function(){
		newWindowsIndex++;
		$('#maintab').tabs('add',{
				title:'CRM系统(' +  newWindowsIndex + ')',
				href:'http://www.baidu.com',
				//content:'<iframe scrolling="yes" frameborder="0"  src="http://localhost:8089" style="width:100%;height:100%;"></iframe>',
				//iconCls:'icon-save',
				closable:true
			});
	});
	
	$(".qn_left_bottom").mouseover(function(){
		$(this).removeClass("qn_left_bottom_default");
		$(this).addClass("qn_left_bottom_hover");
	});
	$(".qn_left_bottom").mouseout(function(){
		$(this).removeClass("qn_left_bottom_hover");
		$(this).addClass("qn_left_bottom_default");
	});
	
	
	/*下拉框效果*/
	$("#use_state").msDropDown().data("dd");
	$("#use_state").change(function(){
		AppSuiteObject('request', $(this).val()); //登陆 登出
	});
	
	/*高级工具*/
	$("#further_tool").click(function(){
		$("#tool_monitoring").toggle();
		$("#tool_intruding").toggle();
		$("#tool_intrudingparty").toggle();
	});
	
	/*工具*/
	$("#sortable").sortable();
	$("#sortable").disableSelection();
	
	$("#tools_back").click(function(){
		alert("tools_back");
	});
	
	
	/*下底菜单*/
	$("#make_call").click(function(){
		openStaticWindows('软电话');
		var mStatusDisplay = new statusDisplay();
		
		mStatusDisplay.set_use_state('login');
		mStatusDisplay.set_status_img("qn_status_agentready");
		mStatusDisplay.set_answer_hangup(true, "挂  断")
		mStatusDisplay.set_msg_callid("你好吗？可不要太长哦");
		mStatusDisplay.set_tool("tools_back", true);
		mStatusDisplay.set_msg_timelong(2661);
	});
	$("#message").click(function(){
		$("#tools_back").attr("disabled", true); 
		
		var mStatusDisplay = new statusDisplay();
		mStatusDisplay.set_tool("tools_back", false);
		
		openStaticWindows('消息');
	});
	$("#history").click(function(){
		$("#busy_free").attr("disabled", false); 
		openStaticWindows('历史记录');
	});
	
	/*软电话键盘*/
	$("#softphonekey li").mouseover(function(){
		$(this).css("background-positionX", "-120px");
	});
	$("#softphonekey li").mouseout(function(){
		$(this).css("background-positionX", "0");
	});
	$("#softphonekey li").mousedown(function(){
		$(this).css("background-positionX", "-240px");
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
		}
		else if (keyVal == 201)
		{
			
		}
		else if (keyVal == 202)
		{
			AppSuiteObject("request", "makecall", $(".softphonevalue").val());
		}
		else if (keyVal == 203)
		{
			$(".softphonevalue").val("");
		}
	});

	//右工具缩进
	$(".qn_use_state_button_off").click(function(){
		$(".qn_left").hide();
		$(".qn_left_small").show();
		
		/*得到窗口大小*/
		clientWidth = $("#qn_all").width();
		clientHeight = $(window).height();
		
		/*设置主区宽高度*/
		$("#maindiv").height((clientHeight - 70) + "px");
		$("#maindiv").width((clientWidth - 30) + "px");
		$('#maintab').tabs('resize');
	});
	
	//右工具展开
	$(".qn_use_state_button_on").click(function(){
		$(".qn_left").show();
		$(".qn_left_small").hide();
		
		/*得到窗口大小*/
		clientWidth = $("#qn_all").width();
		clientHeight = $(window).height();
		
		/*设置主区宽高度*/
		$("#maindiv").height((clientHeight - 70) + "px");
		$("#maindiv").width((clientWidth - 302) + "px");
		$('#maintab').tabs('resize');
	});
	
	// 目录初始化
	$("#ocxinit").click(function(){ 
		csAgentClient.Init();
	});
	
	// 目录 退出
	$("#ocxuninit").click(function(){ 
		AppSuiteObject("request", "logout");
		location.href="/access/logout";   
	});
	
	/*初始*/
	//csAgentClient.Init(); //ocx
	$("#busy_free").attr("disabled", true); //按钮失效
	$("#answer_hangup").attr("disabled", true); //按钮失效
	$("#sortable li").attr("disabled", true); //按钮失效
	
	
	
});
/* 关闭窗口事件， 如果还有未完成的任务，停止关闭动作 
function window.onbeforeunload() 
{
	return false;
} 
*/
document.onkeydown=function() 
{ 
	alert(window.event.keyCode);
if ((window.event.keyCode==116)|| //屏蔽 F5 
(window.event.keyCode==122)|| //屏蔽 F11 
(window.event.shiftKey && window.event.keyCode==121) //shift+F10 
) 
{ 
window.event.keyCode=0; 
window.event.returnValue=false; 
} 
if ((window.event.altKey)&&(window.event.keyCode==115)){ //屏蔽Alt+F4 
window.showModelessDialog("about:blank","","dialogWidth:1px;dialogheight:1px"); 
return false; 
} 
} 

if (window.Event) 
document.captureEvents(Event.MOUSEUP); 
function nocontextmenu(){ 
	/*
event.cancelBubble = true 
event.returnValue = false; 
return false; */
} 
function norightclick(e){ 
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
document.oncontextmenu = nocontextmenu; // for IE5+ 
//document.onmousedown = norightclick; // for all others 
