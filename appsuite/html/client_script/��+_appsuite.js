/**
 * 关闭窗口事件， 如果还有未完成的任务，停止关闭动作
 */
function window.onbeforeunload(event) 
{
	//AppSuiteObject("request", "logout");
	//return "确定要退出？";
	
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
	if ((window.event.altKey)&&(window.event.keyCode==115)) //屏蔽Alt+F4 
	{
		window.event.keyCode = 0; 
		window.event.returnValue = false; 
		//window.showModelessDialog("about:blank","","dialogWidth:1px;dialogheight:1px"); 
		return false; 
	} 
}

/**
 * 鼠标
 */
if (window.Event)
{
	document.captureEvents(Event.MOUSEUP);
}

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

	if (!title || title == "")
	{
		title = "new window";
	}

	var pp = $('#maintab').tabs('getTab', title);
	if (!pp)
	{
		strContent = "<div title=\"" + title + "\" closable=\"" + closable + "\"><iframe scrolling=\"yes\" frameborder=\"0\" src=\"" + url + "\" style=\"width:100%;height:100%;\"></iframe></div>";

		$('#maintab').tabs('add', {
			title: title,
			content:strContent,
			closable:true
		});
	}
	else
	{
		var pp = $('#maintab').tabs('select', title);
	}
	
	

}

//通过ajax 的方式弹出一个本地新窗口，受域名限制,会干扰原界面的JS 和 css
function openNowWindowsLocal(title, url, closable)
{
	if (!title || title == "")
	{
		title = "new window";
	}
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

function messageBox(info, title)
{
    if (!title || title == "")
    {
        title = "消息";
    }
    $.messager.show({
            title:title,
            msg:info,
            timeout:5000,
            height:150,
			showSpeed:100,
            showType:'slide'
        });
}

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
    var p = $('body').layout('panel','west').panel({
		onCollapse:function(){
		}
	});
	setTimeout(function(){
		$('body').layout('collapse','east');
	}, 0);
	/********************************************************************************************/

	/********************************************************************************************/
    // 左则树
	$(".easyui-tree").tree({
        onClick: function(node) {
        	if (node.text == "登陆")
        	{
        		//$('body').layout('panel', 'center').panel({title: "登陆脚本"});
        		$("#editscript").hide();
        		$("#testtree").show();
        		//$('body').layout('resize');
        	}
        	else if (node.text == "振铃")
        	{
        		$("#testtree").hide();
        		$("#editscript").show();
        		//$('body').layout('resize');
        	}  
        }
    });
	/********************************************************************************************/
    
	/********************************************************************************************/
    // 表单提交
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
    /********************************************************************************************/
	
    /********************************************************************************************/
    // CTI工具栏
	$("#ctitoolbar").sortable();
	$("#ctitoolbar").disableSelection();

	$("#cti_tool_hold").click(function(){ //hold
		AppSuiteObject("request", "hold");
	});

	$("#cti_tool_conference").click(function(){
	});

	$("#cti_tool_back").click(function(){ //back
		AppSuiteObject("request", "back");
	});

	$("#cti_tool_transfer").click(function(){ //转接

		$.messager.prompt('转接', '请输入转接端分机号', function(r){
			if (r){
				//alert('you type:'+r);
			}
		});
	});
	$("#cti_tool_consult").click(function(){ //咨询
		using(['dialog'], function(){
			$('#consultdialog').dialog({
				title:'咨询',
				width:400,
				height:200								
			});
		});
	});
	/********************************************************************************************/
	
	
	/********************************************************************************************/
	//共公工具栏
	$("#commontoolbar").sortable();
	$("#commontoolbar").disableSelection();
	$(".com_tool_phone").click(function(){ //打开软电话
		using(['dialog'], function(){
			$('#softphone').dialog({
				toolbar:[{
					text:'内呼',
					//iconCls:'icon-call-in',
					handler:function(){
						$('#softphone').dialog({title:"软电话－－内呼"});
						//$('#softphonekeys').hide();
						//$('#softphoneaddress').show();
						$("#makecalltile").val("in");
					}
				},'-',{
					text:'外呼',
					//iconCls:'icon-call-out',
					handler:function(){
						$('#softphone').dialog({title:"软电话－－外呼"});
						//$('#softphonekeys').show();
						//$('#softphoneaddress').hide();
						$("#makecalltile").val("out");
					}
				}],
				title:'软电话－－外呼',
				width:300,
				height:300								
			});
		});
		
	});
	$(".com_tool_msg").click(function(){
		
	});
	/********************************************************************************************/

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
				AppSuiteObject("request", "makecall", $(".softphonevalue").val(), $("#makecalltile").val());
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
	/********************************************************************************************/
	
	/********************************************************************************************/
	//状态区、按钮
	$("#busy_free").click(function(){
		var action = $("#busy_free div").html();
		if (action == "置 忙")
		{
			//置  忙
			AppSuiteObject("request", "setbusy");
		}
		else if (action == "置 闲")
		{
			//置  闲
			AppSuiteObject("request", "setidle");
		}
		else if (action == "挂 机")
		{
			//挂 机
			AppSuiteObject("request", "releasecall");
		}
	});
	$("#answer_hangup").click(function(){
		var action = $("#answer_hangup div").html();
		if (action == "应 答")
		{
			//应 答
			AppSuiteObject("request", "answer");
		}
		else if (action == "挂 机")
		{
			//挂 机
			AppSuiteObject("request", "releasecall");
		}
		else if (action == "置 闲")
		{
			AppSuiteObject("request", "setidle");
		}
	});
	
	/********************************************************************************************/
	
	/********************************************************************************************/
	//咨询
	$("#consultdialogflag_bt").click(function(){
		AppSuiteObject("request", "consultation", $("#consultdialogflag").combobox('getValue'), $(".consultdialogvalue").val());
	});

	
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

	/********************************************************************************************/
	//底部按钮
	$("#startService_id").click(function(){
		if ($(this).html() == "签出")
		{
			AppSuiteObject("request", "logout");
			$(this).html("签入");
		}
		else
		{
			messageBox("正在签入服务, 请稍等... ...　");
			AppSuiteObject("request", "login");
			$(this).html("签出");
		}
	});

	$("#exit_id").click(function(){ //关闭
		//AppSuiteObject("request", "uninit");
		//window.opener = null;     
		//window.close(); 
		alert("why");
	});
	/********************************************************************************************/
	
	/********************************************************************************************/
    //初始化
    $("#busy_free").attr("disabled", true);
    $("#answer_hangup").attr("disabled", true); 
	/********************************************************************************************/
    
});