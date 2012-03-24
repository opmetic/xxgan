<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Cache-Control" content="no-cache" />
<title>{$system_config.site_name}</title>
<link type="text/css" href="{$system_config.img_url}/images/jquery-ui-1.7.2.custom.css" rel="stylesheet" />
<script type="text/javascript" src="{$system_config.img_url}/script/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="{$system_config.img_url}/script/jquery-ui-1.7.2.custom.min.js"></script>

<link type="text/css" href="{$system_config.img_url}/images/index.css" rel="stylesheet" />
<script type="text/javascript" src="{$system_config.img_url}/script/index.js"></script>

{if $lastwindow}
{literal}
<script type="text/javascript">
$(document).ready(function(){
	{/literal}
	openWindow("{$lastwindow.windowname}", "{$lastwindow.url}");
	{literal}
}); 
</script>
{/literal}
{/if}
</head>

<body>
<div id="qn_all" class="qn_all">
  <!-- head -->
  <div id="qn_head" class="qn_head">
    <div class="logo_div"><img src="/images/logo.gif"/></div>
    <div class="content_div"><span>用户名：{$param.username} </span><span>登陆时间：{$param.logintime|date_format:"%Y/ %m/ %d %T"}
登陆IP:{$param.ip}<br/><a href="/access/logout">QUIT</a></span></div>
  </div>

  <!-- left -->
  <div id="qn_left_shortcut" class="qn_left_shortcut">
    <span class="qn-ui-icon-shortcut qn-ui-icon-grip-dotted-horizontal" style="margin-left:7px !important;margin-left:12px;" ></span>
    <ul id="icons" class="ui-widget ui-helper-clearfix">
      <li class="ui-state-default ui-corner-all" title="刷新" id="qn_refresh_button"><span class="ui-icon ui-icon-refresh"></span></li>
      <li class="ui-state-default ui-corner-all" title="整理" id="qn_pin_button"><span class="ui-icon ui-icon-pin-s"></span></li>
      <li class="ui-state-default ui-corner-all" title="主菜单" id="qn_menu_button"><span class="ui-icon ui-icon-home"></span></li>
      <li class="ui-state-default ui-corner-all" title="放大" id="qn_zoomin_button"><span class="ui-icon ui-icon-circle-zoomin"></span></li>
      <li class="ui-state-default ui-corner-all" title="缩小" id="qn_zoomout_button"><span class="ui-icon ui-icon-circle-zoomout"></span></li>
      <li class="ui-state-default ui-corner-all" title="提示信息" id="qn_msg_button"><span class="ui-icon ui-icon-info"></span></li>
    </ul>
  </div><!--qn_left_shortcut -->

  <!-- right_menu -->
  <div id="qn_right_menu" class="qn_right_menu">
    <div class="column">
	  <div class="portlet">
		<div id="qn_menu_1" class="portlet-header"><div id="qn_menu_1_more" class="qn-ui-icon qn-ui-icon-triangle-1-w"></div>SYSTEM</div>
		<div class="portlet-content"></div>
	  </div>
	  <div class="portlet" style="display: none;">
		<div id="qn_menu_2" class="portlet-header"><div id="qn_menu_2_more" class="qn-ui-icon qn-ui-icon-triangle-1-w"></div>10086</div>
		<div class="portlet-content"></div>
	  </div>
      <div class="portlet" style="display: none;">
		<div id="qn_menu_3" class="portlet-header"><div id="qn_menu_3_more" class="qn-ui-icon qn-ui-icon-triangle-1-w"></div>12580</div>
		<div class="portlet-content"></div>
	  </div>
      <div class="portlet">
		<div id="qn_menu_4" class="portlet-header"><div class="qn-ui-icon qn-ui-icon-grip-dotted-vertical"></div>流程切换10086</div>
		<div class="portlet-content"></div>
	  </div>
      <div class="portlet">
		<div id="qn_menu_5" class="portlet-header"><div class="qn-ui-icon qn-ui-icon-grip-dotted-vertical"></div>流程切换12580</div>
		<div class="portlet-content"><a href="#">全部正常流程[0] </a><br/><a href="#">全部50%限流[8] </a></div>
	  </div>
    </div> <!-- column-->
    <!-- msg-->
    <div style="clear:left;"></div>
    <div id="qn_msg" class="qn_column">
	  <div id="qn_portlet" class="qn_portlet">
		<div class="qn_portlet-header">MESSAGE</div>
		<div class="qn_portlet-content">
          <span>最新SLEE机器列表</span><br/>
          <span>坏的IP地址列表</span><br/>
          <span>青件值班人员注意</span><br/>
        </div>
	  </div>
    </div> <!-- qn_column-->
  </div><!-- right_menu-->
  
    

  <!-- dialog -->
  <div id="dialog_div" style="position: absolute; display:none;">
  </div>
  
  <!-- windowarea -->
  <div id="windowarea" class="qn_column-window">
  </div>
  
  <!-- temp -->
  <div id="temp" style="position: absolute; display:none;">
  </div>
  
  <!-- qn_menu_more -->
  <div id="qn_menu_more_box" class="qn_column-window">
	<div id="qn_menu_1_more_head" class="qn_portlet-window">
	  <div class="qn_portlet-header-window">SYSTEM</div>
      <div id="qn_menu_1_more_body" class="qn_portlet-content-window">
          <div class="qn_portlet-header-window" id="iplist">IP地址列表</div>
          <div class="qn_portlet-header-window" id="chgflowlist">SLEE流程列表</div>
          <div class="qn_portlet-header-window" id="aboutchannelsoft">关于青牛</div>
      </div>
	</div>
  </div> <!-- qn_column-->
  
  <!-- aboutchannelsoft_windows -->
  <div id="aboutchannelsoft_windows" class="qn_column-frame">
	<div id="aboutchannelsoft_windows_head" class="qn_portlet-frame">
	  <div class="qn_portlet-header-frame"><span id="new_windows_title">关于青牛</span></div>
      <div id="aboutchannelsoft_windows_body" class="qn_portlet-content-frame">
        <div class="qn_ui-sortable-placeholder-frame">
          <span>&nbsp;</span><br/>          
        </div>
      </div>
	</div>
  </div> <!-- aboutchannelsoft_windows-->
  
  <!-- chg_flow windows -->
  <div id="chg_flow_windows" class="qn_column-frame">
	<div id="chg_flow_windows_head" class="qn_portlet-frame">
	  <div class="qn_portlet-header-frame">切换流程12580</div>
      <div id="chg_flow_windows_body" class="qn_portlet-content-frame">
        <div class="qn_ui-sortable-placeholder-frame">
          <span>&nbsp;</span><br/>          
        </div>
      </div>
	</div>
  </div> <!--chg_flow windows-->


</div>

</div><!--qn_all -->

<!-- 弹出对话框 	<fieldset> IP地址用 -->
<div id="idcell" style="display: none;">
	<p id="validateTips">新增IP地址，请输入以下内容：</p>
	<form>
		<label for="ip" ><div style="width:60px; float:left;">IP:</div></label>
		<input type="text" name="ip" id="ip" class="text ui-widget-content" /><br/>
		<label for="ipgroup"><div style="width:60px; float:left;">机器组别:</div></label>
		<select name="ipgroup" id="ipgroup" value="0" class="text ui-widget-content">
			<option value="0">未分类</option>
			<option value="1">10086</option>
			<option value="2">12580</option>
		</select><br/>
		<label for="iptype"><div style="width:60px; float:left;">类别:</div></label>
		<select name="iptype" id="iptype" value="0" class="text ui-widget-content">
			<option value="0">未分类</option>
			<option value="1">SLEE</option>
			<option value="2">接口服务器</option>	
		</select><br/>
		<label for="addr"><div style="width:60px; float:left;">机器地址:</div></label>
		<input type="text" name="addr" id="addr" class="text ui-widget-content" /> (钦州机房|金桥机房)<br/>
		<label for="pcname"><div style="width:60px; float:left;">机器名:</div></label>
		<input type="text" name="pcname" id="pcname" class="text ui-widget-content" /><br/>
		<label for="des"><div style="width:60px; float:left;">描述:</div></label>
		<textarea name="des" id="des" class="text ui-widget-content" cols="38"></textarea>
		<input type="hidden" id="op" name="op" value="add" />
		<input type="hidden" id="id" name="id" value="0" />
	</form>
</div>

<!-- 弹出对话框 	<chgflow> chgflow地址用 -->
<div id="chgflowcell" style="display: none;">
	<p id="validateTips">新增特殊流程项，请输入以下内容：</p>
	<form>
		<label for="chgflowvalue" ><div style="width:60px; float:left;">值:</div></label>
		<input type="text" name="chgflowvalue" id="chgflowvalue" class="text ui-widget-content" /><br/>
		<label for="flowgroup"><div style="width:60px; float:left;">类别:</div></label>
		<select name="flowgroup" id="flowgroup" value="0" class="text ui-widget-content">
			<option value="0">没有组别</option>
			<option value="1">10086流程</option>
			<option value="2">12580流程</option>
			<option value="3">CTI转人工提醒</option>
			<option value="4">IVR预排队先进先出</option>
			<option value="5">外地用户转回本地10086</option>
			<option value="6">世博保障应急开关</option>
		</select><br/>
		<label for="chgflowtitle"><div style="width:60px; float:left;">标题:</div></label>
		<input type="text" name="chgflowtitle" id="chgflowtitle" class="text ui-widget-content" style="width:200px;"/><br/>
		<label for="chgflowdes"><div style="width:60px; float:left;">描述:</div></label>
		<textarea name="chgflowdes" id="chgflowdes" class="text ui-widget-content" cols="38"></textarea>
		<input type="hidden" id="chgflowop" name="chgflowop" value="add" />
		<input type="hidden" id="chgflowid" name="chgflowid" value="0" />
	</form>
</div>


<div id="databuf"></div>
</body>
</html>
