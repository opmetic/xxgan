{literal}
<style type="text/css">

.servicelist {border-right: 1px solid #a6c9e2; margin: 0 2px; padding-botton: 20px; overflow: auto ; font-size:12px; }
.serviceop {border: 0px solid #a6c9e2; width: auto;}
.submain {border: 0px solid #a6c9e2; margin: 5px;}

#selectable .ui-selecting { background: #70e1ff; width: 150px;}
#selectable .ui-selected { background: #049ff1; color: white; } /*#F39814*/
#selectable { list-style-type: none; margin: 0; padding: 0; width: auto; }
#selectable li { margin: 3px; padding: 0.4em; font-size: 14px; height: 18px; width: 150px;}
#selectedservicelist {padding-left: 10px;}
.chgflow10086window {height: 100%; width:auto; border-top: 1px dotted #a6c9e2; margin-top: 2px;}

.chgflowtab {color:#111111; text-decoration: none; cursor: pointer;}
.chgflowtab-hover { color:#f98821; text-decoration: underline;}

.chgflowselect {margin: 1px 3px; padding: 0.4em; border: 1px solid #a6c9e2; height: 24px; }
.chgflowselect select {width:80%;}
.chgflow10086 {margin: margin: 0; height: 26px; width:88px; border: 0px solid #a6c9e2; color:#ffffff;
background-image: url(/images/021.png); background-position: 50% 50%; width:100px; height: 24px;  background-repeat:repeat ;}

.chgflow10086windowon {background: url("images/001_06.gif") repeat-y; border: 0px solid #a6c9e2; width:120px; height: 24px; alert: right; text-align :center; cursor: pointer;}
.chgflow10086windowoff {background: url("images/001_05.gif") repeat-y; border: 0px solid #a6c9e2; width:120px; height: 24px; alert: right; text-align :center; cursor: pointer; }

.chgflowselectexpo{margin: 10px 0px; padding: 0.4em; border: 0px solid #a6c9e2; height: 24px; }
.chgflowselectexpo select {width:90%;}
</style>
<script type="text/javascript">
var chgflow10086op;
var selectedservicelistsubmit;
$(function() {
	$("#selectable").selectable({
		stop: function(){
			var result = $("#selectedservicelist").empty();
			selectedservicelistsubmit = "";
			$(".ui-selected", this).each(function(){
				result.append("<br/>" + $(this).html() );
				selectedservicelistsubmit += $(this).attr("value");
				selectedservicelistsubmit += ';';
			});
		}
	});
	
	$(".chgflowtab").mousemove(function(){
		$(this).addClass("chgflowtab-hover");
	}).mouseout(function(){
		if (chgflow10086op != $(this).attr("id"))
		{
			$(this).removeClass("chgflowtab-hover");
		}
	}).click(function(){
		chgflow10086op = $(this).attr("id");
		$(".chgflowtab").removeClass("chgflowtab-hover");
		$("#" + chgflow10086op).addClass("chgflowtab-hover");
		switchview(chgflow10086op);
	});
	
	/*实时显示*/
	$("#chgflow10086select").change(function(){
		if ($(this).val() == 'no')
		{
			$("#chgflow10086flowwindowdes").html('&nbsp;');
			return false;
		}
		$("#chgflow10086flowwindowdes").show();
		$.post('/chgflow/getdes',
				{id: $(this).val()},
				function(data){
					$("#chgflow10086flowwindowdes").html(data);
				});
	});
	$(".chgflowselectexpo > select").change(function(){
		var id = $(this).attr('id');
		if ($(this).val() == 'no')
		{
			$("#" + id + "des").html('&nbsp;');
			return false;
		}
		$("#" + id + "des").show();
		$.post('/chgflow/getdes',
				{id: $(this).val()},
				function(data){
					$("#" + id + "des").html(data);
				});
	});
	$(".chgflowselect > input:button").mouseover(function(){
		var id = $(this).attr('name');
		var msg = $(this).parent(".chgflowselect").next().find("span:last");
		$.post('/chgflow/getdes',
				{id: id},
				function(data){
					msg.html(data);
				});
	}).mouseout(function(){
		$(this).parent(".chgflowselect").next().find("span:last").empty();
	});
	
	
	/*提交表单*/
	$(".chgflow10086, .chgflow10086windowon, .chgflow10086windowoff").click(function(){
		var id = $(this).attr('id');
		if (id == 'chgflow10086_submit') /*切换流程*/
		{
			if ($("#chgflow10086select").val() != 'no')
			{
				switchview('chgflow10086flow', 'submit', $("#chgflow10086select").val());
			}
		}
		else if (id == 'chgflow10086_expo')/*expo相关*/
		{
			var param = '';
			$("#chgflow10086expowindow select").each(function(){
				param += $(this).attr('id');
				param += ':';
				param += $(this).val();
				param += ';';
			});
			switchview('chgflow10086expo', 'submit', param);
		}
		else if (id == 'chgflow10086ctiwindowon' || id == 'chgflow10086ctiwindowoff') /*启动 关闭 CTI转人工提醒*/
		{
			switchview('chgflow10086cti', 'submit', $(this).attr('name'));
		}
		else if (id == 'chgflow10086fifowindowon' || id == 'chgflow10086fifowindowoff') /*启动  关闭IVR预排队先进先出*/
		{
			switchview('chgflow10086fifo', 'submit', $(this).attr('name'));
		}

		else if (id == 'chgflow10086otherplacewindowon' || id == 'chgflow10086otherplacewindowoff') /*启动 关闭 外地用户转回本地10086*/
		{
			switchview('chgflow10086otherplace', 'submit', $(this).attr('name'));
		}
	});

});

$(document).ready(function(){
	var result = $("#selectedservicelist").empty();
	selectedservicelistsubmit = "";
	$("#selectable li").each(function(){
		$(this).addClass("ui-selected");
		result.append("<br/>" + $(this).html() );
		selectedservicelistsubmit += $(this).attr("value");
		selectedservicelistsubmit += ';';
	});
	switchview('chgflow10086view', 'submit');
}); 

function switchview(type, operator, param)
{	
	$("#" + type).addClass("chgflowtab-hover");
	if (operator == 'submit' || type == 'chgflow10086view')
	{
		$(".chgflow10086window").hide();
		$("#chgflow10086window").empty();
		$("#chgflow10086window").show();
		$.post('/chgflow/f10086update',
				{type: type, servicelist: selectedservicelistsubmit, param: param},
				function(data){
					$("#chgflow10086window").html(data);
				});
	}
	else
	{
		$(".chgflow10086window").hide();
		$("#" + type + "window > div:first").empty();
		$("#" + type + "window > div:first").html($("#" + type + "windowview").html());
		$("#" + type + "window").show();
	}
}
</script>
{/literal}

<table cellpadding="0" cellspacing="0" width="98%" height="95%" cellpadding="0" class="submain">
<tr>
	<td height="100%" width="10%" class="servicelist" align="left" valign="top">
		<div class="ui-widget qn-ui-state-highlight" style="width: 170px;">
			<div class="ui-state-highlight ui-corner-all" style="margin: 3px; padding: 0 .7em;  "> 
				<p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
				<span style="font-weight: bold; ">已被选中的服务器</span>
				<span id="selectedservicelist">
				</span>
			</div>
		</div>
		<ol id="selectable">
			{foreach from=$service10086Data item=item}
			<li class="ui-widget-content" value="{$item.id}">{$item.ipaddr}</li>
			{/foreach}
		</ol>
	</td>
	<td class="serviceop" align="left" valign="top">
		<span class="chgflowtab" id="chgflow10086view">查看</span>　
		<span class="chgflowtab" id="chgflow10086flow">切换流程</span>　
		<span class="chgflowtab" id="chgflow10086cti">CTI转人工提醒</span>　
		<span class="chgflowtab" id="chgflow10086fifo">IVR预排队先进先出</span>　
		<span class="chgflowtab" id="chgflow10086otherplace">外地用户转回本地</span>　
		<span class="chgflowtab" id="chgflow10086expo">世博保障应急开关</span>

		<div id="chgflow10086window" class="chgflow10086window">
		</div>
		<!--切换流程  -->
		<div id="chgflow10086flowwindow" class="chgflow10086window" style="display: none;">
			<div class="chgflow10086view"></div>
			<div class="chgflowselect" >
			<select id="chgflow10086select">
				<option value="no"></option>
				{foreach from=$chgflow10086Data item=item}
				<option value="{$item.id}">[{$item.value}] {$item.title}</option>
				{/foreach}
			</select>
			<input class="chgflow10086" id="chgflow10086_submit" type="submit" name="submit" value=" 确   定 " />
			</div>
			<div class="ui-widget qn-ui-state-highlight">
				<div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;"> 
					<p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
					<span id="chgflow10086flowwindowdes">
						切换流程
					</span>
				</div>
			</div>
		</div>
		
		<!-- 启动 ／ 关闭 CTI转人工提醒 -->
		<div id="chgflow10086ctiwindow" class="chgflow10086window" style="display: none;">
			<div class="chgflow10086view"></div>
			<div align="center" class="chgflowselect" >
				<input type="button" class="chgflow10086windowon" id="chgflow10086ctiwindowon" name="{$chgflow10086ctiData[1].id}" value="点击{$chgflow10086ctiData[1].title}"/>
				<input type="button" class="chgflow10086windowoff" id="chgflow10086ctiwindowoff" name="{$chgflow10086ctiData[0].id}" value="点击{$chgflow10086ctiData[0].title}"/>
				
			</div>
			<div class="ui-widget qn-ui-state-highlight">
				<div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;"> 
					<p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
					CTI转人工提醒<br/>
					<span>
					</span>
				</div>
			</div>
		</div>
		
		<!-- 启动 ／ 关闭 IVR预排队先进先出 -->
		<div id="chgflow10086fifowindow" class="chgflow10086window" style="display: none;">
			<div class="chgflow10086view"></div>
			<div align="center" class="chgflowselect" >
				<input type="button" class="chgflow10086windowon" name="{$chgflow10086fifoData[1].id}" id="chgflow10086fifowindowon" value="点击{$chgflow10086fifoData[1].title}"/>
				<input type="button" class="chgflow10086windowoff" name="{$chgflow10086fifoData[0].id}" id="chgflow10086fifowindowoff" value="点击{$chgflow10086fifoData[0].title}"/>
				
			</div>
			<div class="ui-widget qn-ui-state-highlight">
				<div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;"> 
					<p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
					<span>
						IVR预排队先进先出
					</span><br/>
					<span></span>
				</div>
			</div>
		</div>
		
		<!-- 启动 ／ 关闭 外地用户转回本地10086 -->
		<div id="chgflow10086otherplacewindow" class="chgflow10086window" style="display: none;">
			<div class="chgflow10086view"></div>
			<div align="center" class="chgflowselect" >
				<input type="button" class="chgflow10086windowon" id="chgflow10086otherplacewindowon" name="{$chgflow10086wdData[1].id}" value="点击{$chgflow10086wdData[1].title}"/>
				<input type="button" class="chgflow10086windowoff" id="chgflow10086otherplacewindowoff" name="{$chgflow10086wdData[0].id}" value="点击{$chgflow10086wdData[0].title}"/>
				
			</div>
			<div class="ui-widget qn-ui-state-highlight">
				<div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;"> 
					<p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
					<span>
						外地用户转回本地10086
					</span><br/>
					<span></span>
				</div>
			</div>
		</div>
		
		<!-- 世博保障应急开关 -->
		<div id="chgflow10086expowindow" class="chgflow10086window" style="display: none;">
			<div class="chgflow10086view"></div>
			<table width="100%" cellpadding="0" cellspacing="0">
			{foreach from=$expochgflowdata item=item}
				<tr>
					<td width="40%">
					<div class="chgflowselectexpo" >
					{$item.title}:
					<select id="{$item.id}">
						<option value="no"></option>
						{foreach from=$item.data item=cell}
						<option value="{$cell.id}">[{$cell.value}] {$cell.title}</option>
						{/foreach}
					</select>
					</div>
					</td>
					<td>
					<div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;"> 
						<span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
						<span id="{$item.id}des">
							{$item.title}
						</span>
					</div>
					</td>
				</tr>
				{/foreach}	
			</table>
			<input class="chgflow10086" id="chgflow10086_expo" type="submit" name="submit" value=" 确   定 " align="middle"/>
		</div><!-- 世博保障应急开关 -->
	</td>
</tr>
</table>
