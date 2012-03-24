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
	   window.event.returnValue = "是否关闭？";    
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
    AppSuiteObject("command", "makecall", tel, "out"); 
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
	/********************************************************************************************/

	
	
	
	/********************************************************************************************/
	//共公工具栏
	$("#com_tool_phone").click(function(){ //打开软电话
        $("#softphone").dialog('open');
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
				AppSuiteObject("command", "makecall", $(".softphonevalue").val(), $("#makecalltile").val());
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
            AppSuiteObject("command", "makecall", $(".softphonevalue").val(), $("#makecalltile").val());
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
		AppSuiteObject("command", "setbusy");
	});

	$("#cti_tool_setidle").click(function(){//置  闲
		AppSuiteObject("command", "setidle");
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
        AppSuiteObject("command", "consultation", $("#consultdialogflag").val(),  $(".consultdialogvalue").val());
	});

	
	/********************************************************************************************/

	/********************************************************************************************/
	//监听
	$("#monitored_submit").click(function(){
		AppSuiteObject("command", "listen", $("#monitored_agentid").val());
	});
	/********************************************************************************************/
	
	/********************************************************************************************/
	//强插
	$("#insert_submit").click(function(){
		AppSuiteObject("command", "insert", $("#insert_agentid").val());
	});
	/********************************************************************************************/


	/********************************************************************************************/
	//拦截
	$("#intercept_submit").click(function(){
		AppSuiteObject("command", "intercept", $("#insert_agentid").val());
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
			AppSuiteObject("command", "logout");
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
					window.opener=null;
					window.close(); 
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
                                    $(".consultdialogvalue").val(rowData.f6);
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
                                    $(".consultdialogvalue").val(rowData.f6);
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
                                        $(".softphonevalue").val(rowData.f6);
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
                                $("#monitored_agentid").val(rowData.f6);
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
                                $("#insert_agentid").val(rowData.f6);
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
                                $("#intercept_agentid").val(rowData.f6);
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