<?php /* Smarty version 2.6.20, created on 2010-10-30 16:39:35
         compiled from appsuite.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'appsuite.tpl', 33, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Cache-Control" content="no-cache" />
<title><?php echo $this->_tpl_vars['system_config']['site_name']; ?>
</title>
<link type="text/css" href="<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
/appsuite_images/jquery-ui-1.8.1.custom.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
/appsuite_script/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
/appsuite_script/jquery-ui-1.8.1.custom.min.js"></script>

<!-- easyui -->
<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
/appsuite_images/themes/default/easyui.css">
<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
/appsuite_images/themes/icon.css">

<link type="text/css" href="<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
/appsuite_images/appsuite.css" rel="stylesheet"/>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
/appsuite_script/appsuite.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
/appsuite_script/appsuiteDB.js"></script>
	 
<!-- 下拉菜单 -->
<link rel="stylesheet" href="<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
/appsuite_images/dd.css" type="text/css" />
<script type="text/javascript" src="<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
/appsuite_script/jquery.dd.js"></script>
	
<?php echo '
'; ?>

</head>

<body>
<OBJECT ID="csAgentClient" CLASSID="CLSID:167CE366-D521-4457-9216-6AE78AB6DF1B" VIEWASTEXT height=0 width=0></OBJECT>
<div id="qn_all" class="qn_all">
  <!-- head -->
  <div id="qn_head" class="qn_head">
    <div class="logo_div"><img src="/images/logo.gif"/></div>
    <div class="content_div"><span>用户名：<?php echo $this->_tpl_vars['param']['username']; ?>
 </span><span>登陆时间：<?php echo ((is_array($_tmp=$this->_tpl_vars['param']['logintime'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y/ %m/ %d %T") : smarty_modifier_date_format($_tmp, "%Y/ %m/ %d %T")); ?>

登陆IP:<?php echo $this->_tpl_vars['param']['ip']; ?>
<br/><a href="/access/logout" style="display:;">QUIT</a></span></div>
  </div>
  <!-- head end -->
  
  <!-- menu -->
  <div style="border-bottom: 0px solid #ffffff; border-top: 1px solid #ffffff; ">
	<div style="background:#C7DCFB; padding:0px;">
		<a href="javascript:void(0)" id="mb1" class="easyui-menubutton" menu="#mm1" style="color:#000000; text-decoration:none;">系统</a>
		<a href="javascript:void(0)" id="mb2" class="easyui-menubutton" menu="#mm2" style="color:#000000; text-decoration:none;">工具</a>
		<a href="javascript:void(0)" id="mb3" class="easyui-menubutton" menu="#mm3" style="color:#000000; text-decoration:none;">视图</a>
		<a href="javascript:void(0)" id="mb4" class="easyui-menubutton" menu="#mm4" style="color:#000000; text-decoration:none;">帮助</a>
	</div>
	<div id="mm1" style="width:150px;">
		<div id="ocxinit">初始化</div>
		<div icon="icon-undo">修改密码</div>
		<div class="menu-sep"></div>
		<div id="ocxuninit" icon="icon-redo">退 出</div>
	</div>
	<div id="mm2" style="width:150px;">
		<div>选 项</div>
	</div>
	<div id="mm3" style="width:150px;">
		<div>客户关系管理</div>
		<div>外呼任务管理</div>
	</div>
	<div id="mm4" style="width:150px;">
		<div>关 于</div>
	</div>
  </div>
  <!-- menu end -->
  
  <!-- left -->
  <div class="qn_left">
	  <!-- left top status -->
	  <div class="qn_left_top_status">
	  
	    <!-- select -->
	  	<div class="qn_use_state">
			<select name="use_state" id="use_state" style="width:200px;">
				<option value="login" title="<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
/appsuite_images/icons/flag_green.png">登陆</option>
				<option value="logout" selected="selected"  title="<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
/appsuite_images/icons/flag_red.png">退出</option>
			</select> 
			<div class="qn_use_state_button_off">&nbsp;</div>
	  	</div>
	  	
	  	<div style="clear:both; height: 0px;"></div>
	  	<!-- select end -->
	  	<div style="float:left;height:80px; border:#000000 0px solid; margin: 0 !important;margin-top: -15px;">
	  		<div id="status_img" class="qn_status_agentnull">&nbsp;</div>
	  	</div>
	  	<div style="float:left; margin: 0 !important;margin-top: -15px;">
	  		<div class="qn_status_dec">
	  			<div style="border:#000000 0px solid; height:47px; width: 190px;">
	  			<h3 style="color:#808080;" id="qn_status_txt">未登录</h3>
	  			<h3 style="color:#c0c0c0;" id="qn_do_txt"></h3>
	  			</div>
	  			<input type="button" class="qn_button_1" id="busy_free" value="置  闲" />&nbsp;&nbsp;
	  			<input type="button" class="qn_button_1" id="answer_hangup" value="应  答" title="answer"/>
	  		</div>
	  	</div>
	  	<div class="messagepanel">
	  		<b>主 叫 : </b><span id="msg_calling"></span>
	  		<p/>
	  		<b>被 叫 : </b><span id="msg_callid"></span>
	  		<p/>
	  		<b>时 长 : </b><span id="msg_timelong">00 : 00 : 00</span>
	  	</div>
	  </div>
	  <!-- left top status end -->
	  
	  <!-- left middle tools -->
	  <div class="left_middle_tools">
	  	<div style="padding: 5px 0 0 17px;">
	  		<span style="color:#404040;font-size: 16px; font-weight: bolder;" >工 具</span>
	  		<span style="color:#404040;font-size: 16px; font-weight: bolder; margin-left: 45px; cursor: hand;" id="further_tool">高 级 工 具</span>
	  	</div>
	  	<div style="height:294px; border:#000000 0px solid; margin: 1px; overflow: auto;">
			<ul id="sortable">
				<li class="tools_hold" id="tools_hold" style="font-size: 14px;"><img src="<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
/appsuite_images/icon_lockopen.gif" style="display:;" /></li>
				<li class="tools_back" id="tools_back" style="font-size: 14px;"><img src="<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
/appsuite_images/icon_lockopen.gif" style="display:;" /></li>
				<li class="tool_consult" id="tool_consult" style="font-size: 14px;"><img src="<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
/appsuite_images/icon_lockopen.gif" style="display:;" /></li>
				<li class="tool_transfer" id="tool_transfer" style="font-size: 14px;"><img src="<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
/appsuite_images/icon_lockopen.gif" style="display:;" /></li>
				<li class="tools_Conference" id="tool_Conference" style="font-size: 14px;"><img src="<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
/appsuite_images/icon_lockopen.gif" style="display:;" /></li>
				<li class="tool_addressbook" id="tool_addressbook" style="font-size: 14px;"><img src="<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
/appsuite_images/icon_lockopen.gif" style="display:;" /></li>
				<li class="ui-state-default" id="tool_monitoring" style="display: none;"><img src="<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
/appsuite_images/icon_lockopen.gif" style="display:;" /></li>
				<li class="ui-state-default" id="tool_intruding" style="display: none;"><img src="<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
/appsuite_images/icon_lockopen.gif" style="display:;" /></li>
				<li class="ui-state-default" id="tool_intrudingparty" style="display: none;"><img src="<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
/appsuite_images/icon_lockopen.gif" style="display:;" /></li>
			</ul>
	  	</div>
	  	<div style="height:13px; border:#000000 px solid; margin: 1px;">&nbsp;</div>
	  	
	  </div>
	  <!-- left middle tools end -->
	  
	  <!-- left bottom icon -->
	  <div class="qn_left_bottom qn_icon qn_left_bottom_default" id="make_call">
	  	<div class="qn_left_bottom_img_1">&nbsp;</div>
	  	<div style="color:#404040;font-size: 16px; font-weight: bolder; margin-top: 3px;" >拨 打 电 话</div>
	  </div>
	  <div class="qn_left_bottom qn_icon qn_left_bottom_default" id="message">
	  	<div class="qn_left_bottom_img_2">&nbsp;</div>
	  	<div style="color:#404040;font-size: 16px; font-weight: bolder; margin-top: 3px;" >消 息</div>
	  </div>
	  <div class="qn_left_bottom qn_icon qn_left_bottom_default" id="history">
	  	<div class="qn_left_bottom_img_3">&nbsp;</div>
	  	<div style="color:#404040;font-size: 16px; font-weight: bolder; margin-top: 3px;" >历 史 记 录</div>
	  </div>
	  <!-- left bottom icon end -->
  </div>
  <!-- left end -->
  <div class="qn_left_small"><div class="qn_use_state_button_on">&nbsp;</div></div>
  
  <!-- main -->
  <div id="maindiv" style="width: 28px; height: 24px; border:#000000 0px solid; margin: 2px; float: left; overflow:auto;">
  <div id="maintab" class="easyui-tabs" fit="true">
	<div title="启始页" style="padding:20px;">启始页
	</div>
	<div title="软电话" closable="falue" class="softphone">
    	<input type="text" class="softphonevalue"/>
	  	<div style="border:#000000 0px solid; margin: 1px; overflow: auto;">
			<ul id="softphonekey">
				<li class="key_1" value="1"/></li>
				<li class="key_2" value="2"/></li>
				<li class="key_3" value="3"/></li>
				<li class="key_4" value="4"/></li>
				<li class="key_5" value="5"/></li>
				<li class="key_6" value="6"/></li>
				<li class="key_7" value="7"/></li>
				<li class="key_8" value="8"/></li>
				<li class="key_9" value="9"/></li>
				<li class="key_xing" value="101"/></li>
				<li class="key_0" value="0"/></li>
				<li class="key_jing" value="102"/></li>
				<li class="key_save" value="201"/></li>
				<li class="key_call" value="202"/></li>
				<li class="key_refresh" value="203"/></li>
			</ul>
	  	</div>
  	</div>
  </div>
  </div>
  <!-- main end -->
  <!-- other -->
  <div id="databuf" style="display: none;"></div>
  
  <div id="softphonediv" style="display: none;">
  </div>
  
  <!-- other end -->
  
</div><!--qn_all -->

<script type="text/javascript" src="<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
/appsuite_script/jquery.easyui.min.js"></script>
<?php echo '
<script type="text/javascript">
//setTimeout("csAgentClient.Init()", 1000);
//setInterval("updateStatus()", 1000); 
</script>

<!-- 消息响应 -->
<script language="javascript" for="csAgentClient" event="OnEvent(xml)">
	manageEvent(xml);
</script>
'; ?>

</body>
</html>
