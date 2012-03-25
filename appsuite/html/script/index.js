var clientWidth = 0;
var clientHeight = 0;
var tmpPointTop = 0;
var tmpPointRight = 0;
var tmpPointbottom = 0;
var tmpPointLeft = 0;
var tmpWidth = 0;
var tmpheight = 0;

$(function() {
	var offset = $("#qn_left_shortcut").offset();
	/*得到窗口大小*/
	clientWidth = $("#qn_all").width();
	clientHeight = $(window).height();
	$("#databuf").data("screensize", { width: clientWidth, height: clientHeight });/*屏幕大小缓存*/
	
	tmpWidth = $("#qn_left_shortcut").width();
	$("#databuf").data("p-topleft-x",  offset.left + tmpWidth + 4);/*屏幕大小缓存*/
	offset = $("#qn_right_menu").offset();
	$("#databuf").data("p-toprifht-x",  offset.left);
	$("#databuf").data("p-topleft-y",  offset.top - 12);
	$("#databuf").data("l-width",  offset.left - $("#databuf").data("p-topleft-x"));
	$("#databuf").data("2-width", $("#databuf").data("l-width") + $("#qn_right_menu").width());
	
	/*设置主区高度*/
	$("#qn_all").height(clientHeight + "px");
	
	/* 设置快捷键大小和位置 */
	offset = $("#qn_left_shortcut").offset();
	$("#qn_left_shortcut").css("top", (offset.top + (clientHeight / 10)) + "px");
	
	
	/*设置左快捷区效果*/
	$("#qn_left_shortcut").draggable({ revert: true, containment: '#qn_all', scroll: false});
	$("#qn_refresh_button").click(function() {
		refreshWindow();
	});
	$("#qn_pin_button").click(function() {
		$("#aboutchannelsoft_windows").css({top:$("#databuf").data("p-topleft-y") + "px", left: $("#databuf").data("p-topleft-x") + "px"});
	});
	$("#qn_zoomout_button").click(function() {
		$("#aboutchannelsoft_windows .qn_ui-sortable-placeholder-frame").width($("#databuf").data("l-width") - 5); 
		$("#aboutchannelsoft_windows").width($("#databuf").data("l-width")); 
	});
	$("#qn_zoomin_button").click(function() {
		$("#aboutchannelsoft_windows .qn_ui-sortable-placeholder-frame").width($("#databuf").data("2-width") - 8); 
		$("#aboutchannelsoft_windows").width($("#databuf").data("2-width")); 
	});
	
	$("#qn_menu_button").click(function() {
		$("#qn_right_menu").toggle("drop", {direction:"up"}, 1000);
	});// .column
	$("#qn_msg_button").click(function() {
		$("#qn_msg").toggle("drop", {direction:"down"}, 500);
	});

	//hover states on the static widgets
	$("ul#icons li").hover(
		function() { $(this).addClass('ui-state-hover'); }, 
		function() { $(this).removeClass('ui-state-hover'); }
	);
	
	/*右侧目录 子目录*/
	$(".column").sortable({
		connectWith: '.column'
	});

	$(".portlet").addClass("ui-widget ui-widget-content ui-helper-clearfix ui-corner-all")
		.find(".portlet-header")
			.addClass("ui-widget-header ui-corner-all")
			.prepend('<span class="ui-icon ui-icon-plusthick"></span>')
			.end()
		.find(".portlet-content").toggle();

	$(".portlet-header .ui-icon").click(function() {
		$(this).toggleClass("ui-icon-minusthick");
		$(this).parents(".portlet:first").find(".portlet-content").toggle();
		return false; /*停止冒泡*/
	});
	
	$(".column").disableSelection();
	
	/* 右侧目录　动作*/
	$("#qn_menu_1_more").click(function() { /**/
		var offset = $(this).parents(".portlet").offset();
		$("#qn_menu_more_box").css({top: offset.top + "px", left: (offset.left - 200)+ "px"});
		$("#qn_menu_more_box").show();
		$("#qn_menu_more_box .qn_portlet-header-window").show();
		$("#qn_menu_1_more_head").show("drop", 
									   { direction: "right" }, 
									   500, 
									   function() {
										   if ($("#qn_menu_1_more_body").css("display") == "none")
										   {
										       $("#qn_menu_1_more_body").show("blind", {}, 500);
										   }
									   }
									   );
		return false;
	});
	
	$("#qn_menu_2_more").click(function() { /**/
		var offset = $(this).parents(".portlet").offset();
		$("#qn_menu_more_box").css({top: offset.top + "px", left: (offset.left - 200)+ "px"});
		$("#qn_menu_more_box").show();

		$("#qn_menu_more_box .qn_portlet-header-window").show();
		$("#qn_menu_1_more_head").show("drop", 
									   { direction: "right" }, 
									   500, 
									   function() {
										   if ($("#qn_menu_1_more_body").css("display") == "none")
										   {
										       $("#qn_menu_1_more_body").show("blind", {}, 500);
										   }
									   }
									   );
		return false;
	});
	
	$("#qn_menu_3").click(function() {
		$("#dialog_div").append("<div id=\"dialog\" title=\"Basic dialog\" > 您好，甘正瞳</div>");
		$("#dialog").dialog({bgiframe: true});
	});
	
	
	/*右　SYSTEM　->　IP列表　目录按钮　动作*/
	$("#iplist").click(function() { 
		$("#new_windows_title").html("IP地址列表");
		openWindow("iplist_windows", "/admin/iplist");
		return false;
	});
	
	/*右　SYSTEM　->　SLEE流程　目录按钮　动作*/
	$("#chgflowlist").click(function() { 
		$("#new_windows_title").html("SLEE流程列表");
		openWindow("chgflowlist_windows", "/admin/chgflowlist");
		return false;
	});
	
	/*右　系统状态　->　关于青牛　目录按钮　动作*/
	$("#aboutchannelsoft").click(function() { 
		$("#new_windows_title").html("关于青牛");
		openWindow("aboutchannelsoft_windows", "/admin/aboutchannelsoft");
		return false;
	});
	
	/*右　切换流程　目录按钮　动作*/
	$("#qn_menu_4").click(function() { 
		$("#new_windows_title").html("10086切换流程");
		openWindow("chg_flow_10086_windows", "/chgflow/f10086");
		return false;
	});
	
	/*右　切换流程　目录按钮　动作*/
	$("#qn_menu_5").click(function() { 
		$("#new_windows_title").html("12580切换流程");
		openWindow("chg_flow_windows", "/chgflow/f12580");
		return false;
	});

	/*MSG*/
	$(".qn_portlet").addClass("ui-widget ui-widget-content ui-helper-clearfix ui-corner-all")
		.find(".qn_portlet-header")
			.addClass("qn-ui-widget-header ui-corner-all")
			.prepend('<span class="ui-icon ui-icon-arrowthick-1-nw" title="详细"></span>')
			.prepend('<span class="ui-icon ui-icon-closethick"></span>')
			.end()
		.find(".qn_portlet-content");
		
	$("#qn_portlet").draggable({ handle: '.qn_portlet-header', containment: '#qn_all', scroll: false});
	$(".qn_portlet-header .ui-icon:first").click(function() {
		$("#qn_msg").hide("drop", {direction:"down"}, 500);
	});	
	$(".qn_portlet-header .ui-icon-arrowthick-1-nw").click(function() {
		
	});	
			
	/*window menu*/
	$(".qn_portlet-window").addClass("ui-widget ui-widget-content ui-helper-clearfix ui-corner-all")
		.find(".qn_portlet-header-window:first")
			.addClass("qn-ui-widget-header-window ui-corner-all")
			.prepend('<span class="ui-icon ui-icon-carat-1-e"></span>')
			.end()
		.find(".qn_portlet-content-window");
	$(".qn_portlet-window").find(".qn_portlet-header-window:gt(0)").addClass("qn-ui-widget-header-window ui-corner-all")
		
	$(".qn_portlet-window").draggable({ handle: '.qn_portlet-header-window', containment: '#qn_all', scroll: false,revert: true });
	
	/* 二级菜单向回消失 */
	$(".qn_portlet-header-window .ui-icon:first").click(function() {
		$(".qn_portlet-window").hide("drop", {direction:"right"}, 500);
	});	
	
	/*frame ui-widget ui-widget-content */
	$(".qn_portlet-frame").addClass("ui-widget ui-widget-content ui-helper-clearfix ui-corner-all ")
		.find(".qn_portlet-header-frame")
			.addClass("qn-ui-widget-header-window ui-corner-all")
			.prepend('<span class="ui-icon ui-icon-arrowreturnthick-1-w" title="刷新"></span>')
			.prepend('<span class="ui-icon ui-icon-closethick" title="关闭"></span>')
			.end()
		.find(".qn_portlet-content-frame");
	
	$(".qn_portlet-frame").draggable({ handle: '.qn_portlet-header-frame', containment: '#qn_all', scroll: false});
	$(".qn_portlet-header-frame .ui-icon-closethick").click(function() {
		$("#aboutchannelsoft_windows").hide();
	})
	$(".qn_portlet-header-frame .ui-icon-arrowreturnthick-1-w").click(function() {
		refreshWindow();
	});	
});/*end*/
	
/*打开一个新窗口*/
function openWindow(name, url)
{
	$(".qn_column-frame").hide();
	if ($(".qn_portlet-window").css("display") != "none")
	{
		$(".qn_portlet-window").hide("drop", {direction:"right"}, 500); /*二级菜单消失*/
	}
	
	$("#aboutchannelsoft_windows").css({top:$("#databuf").data("p-topleft-y") + "px", left: $("#databuf").data("p-topleft-x") + "px"});
	$("#aboutchannelsoft_windows").css({width:$("#databuf").data("l-width") + "px"});
	$("#aboutchannelsoft_windows").css({height:($("#databuf").data("screensize").height - $("#databuf").data("p-topleft-y")) + "px"});
	$("#aboutchannelsoft_windows .qn_ui-sortable-placeholder-frame").css({width: ($("#databuf").data("l-width") - 5) + "px"});
	$("#aboutchannelsoft_windows .qn_ui-sortable-placeholder-frame").css({height:($("#databuf").data("screensize").height - $("#databuf").data("p-topleft-y")- 32) + "px"});
	$("#aboutchannelsoft_windows").show();
	$("#aboutchannelsoft_windows .qn_portlet-header-frame").show();
	$("#aboutchannelsoft_windows_head").show();
	$("#aboutchannelsoft_windows_body").show();
	$("#aboutchannelsoft_windows_body .qn_ui-sortable-placeholder-frame").empty();
	$("#aboutchannelsoft_windows_body .qn_ui-sortable-placeholder-frame").prepend("<img src=\"/images/021.gif\"/>");
	$("#aboutchannelsoft_windows_body .qn_ui-sortable-placeholder-frame").load(url); 

	$("#databuf").data("alivewindow", name);/*放入数据缓存*/
}

function refreshWindow()
{        
	if ($("#databuf").data("alivewindow") == "aboutchannelsoft_windows")
	{
		$("#aboutchannelsoft_windows .qn_ui-sortable-placeholder-frame").load("/admin/aboutchannelsoft"); 
	}
	else if ($("#databuf").data("alivewindow") == "chg_flow_windows")
	{	
		$("#aboutchannelsoft_windows .qn_ui-sortable-placeholder-frame").load("/chgflow/f12580"); 
	}
	else if ($("#databuf").data("alivewindow") == "iplist_windows")
	{	
		$("#aboutchannelsoft_windows .qn_ui-sortable-placeholder-frame").load("/admin/iplist"); 
	}
	else if ($("#databuf").data("alivewindow") == "chgflowlist_windows")
	{	
		$("#aboutchannelsoft_windows .qn_ui-sortable-placeholder-frame").load("/admin/chgflowlist"); 
	}
	else if ($("#databuf").data("alivewindow") == "chg_flow_10086_windows")
	{
		$("#aboutchannelsoft_windows .qn_ui-sortable-placeholder-frame").load("/chgflow/f10086"); 
	}
}
