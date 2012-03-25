{literal}
<style type="text/css">
.chg-ui-widget-content { border-bottom: 1px solid #a6c9e2; background: #FFFFFF;}
.flow-12580-list-head {margin: 1px 3px; padding: 0.4em; border-bottom: 1px solid #a6c9e2; height: 12px; }
.flow-12580-list-head span {margin:0 5px 0 0; padding: 0 5px 0 0; border-right: 2px dotted #ffffff; float: left; font-weight: bold;}

#selectable .ui-selecting { background: #FFFFFF; }/*#FECA40; #F39814 color: white;*/
#selectable .ui-selected {  background: #8ec2f5 url(/images/ui-bg_highlight-soft_80_8ec.png) 50% bottom repeat-x; color: #222222;   }
#selectable { list-style-type: none; margin: 0; padding: 0; width: 100% !important; width: 100%; }
#selectable li { margin: 1px 3px; padding: 0.4em; font-size: 12px; height: 14px; }
#selectable li span {margin:0 5px 0 0; padding: 0 5px 0 0; border-right: 2px dotted #a6c9e2; float: left; }
.chgflowselect {margin: 1px 3px; padding: 0.4em; border: 1px solid #a6c9e2; height: 24px; }
.chgflowselect select {width:80%;}
.chgflow-submit {margin: margin: 0; height: 26px; width:88px; border: 0px solid #a6c9e2; color:#ffffff;
background-image: url(/images/021.png); background-position: 50% 50%; width:100px; height: 24px;  background-repeat:repeat ;}
.qn-ui-state-highlight { margin: 1px 3px; padding: 0.4em; }

.slelectall{font-size: 12px;}
.slelectall a{margin: 0 0 0 10px;}
</style>
<script type="text/javascript">
var chickFlag = true;
$(function() {
	$("#selectable li").click(function(){
		if ($(this).find(":checkbox").attr("checked") && chickFlag) {
			$(this).find(":checkbox").removeAttr("checked");
		}
		else if (chickFlag){
			$(this).find(":checkbox").attr("checked", 'true');
		}
		chickFlag = true;
	});
	
	$(":checkbox").parent("span").click(function(){
		chickFlag = false;
	});
	
	/*实时显示*/
	$(".chgflowselect > select").change(function(){
		if ($(this).val() == 'no')
		{
			$("#flowdes").html('&nbsp;');
			$("#flowmsgpanel").hide();
			return false;
		}
		$("#flowmsgpanel").show();
		$.post('/chgflow/getdes',
				{id: $(this).val()},
				function(data){
					$("#flowdes").html(data);
				});
	});
	
	/*提交数据*/
	$(".chgflow-submit").click(function(){
		if ($("#chgflowselect").val() == 'no')
		{
			return false;
		}
		
		var iplist = "";
		$("#selectable li").each(function(){
			if ($(this).find(":checkbox").attr("checked")) {
				iplist += $(this).find(":checkbox").val();
				iplist += ';';
			}
		}); 

		$.ajax({
			type: "POST",
			data: "newflow=" + $("#chgflowselect").val() + "&iplist=" + iplist,
			url: "/chgflow/f12580update",
			cache: false,
			success: function(html){
			$("#aboutchannelsoft_windows_body .qn_ui-sortable-placeholder-frame").html(html);
			}
		}); /*ajax*/
	});/*chgflow-submit*/
	
	$(".slelectall a:first").click(function(){
		$(":checkbox").attr('checked', 'true');
	}).next().click(function(){
		$(":checkbox").attr('checked', '');
	});
});

</script>
{/literal}
<div>
	<div class="flow-12580-list-head">
	<span style="width:50px;">&nbsp;</span><span style="width:90px;">IP地址</span><span>当前流程</span>
	</div>
	
	<ol id="selectable">
	{foreach from=$sleelistData item=item name=sleelist}
		<li class="chg-ui-widget-content">
		<span style="width:20px;"><input type="checkbox" name="selectip" checked="checked" value="{$item.id}"/></span>
		<span style="width:20px;">{$smarty.foreach.sleelist.iteration}</span><span style="width:90px;">{$item.ipaddr}</span><div>{$item.flow_txt}</div>
		</li>
		{/foreach}
	</ol>
</div><!-- End demo -->
<div class="slelectall"><a href="javascript:void(0);">全选</a><a href="javascript:void(0);">不选</a></div>
<div class="chgflowselect" >
<select id="chgflowselect">
	<option value="no"></option>
	{foreach from=$chgflowData item=item}
	<option value="{$item.id}">[{$item.value}] {$item.title}</option>
	{/foreach}
</select>
<input class="chgflow-submit" type="submit" name="submit" value=" 确   定 " />
</div>
<div class="ui-widget qn-ui-state-highlight" id="flowmsgpanel" style="display:none;">
			<div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;"> 
				<p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
				<span id="flowdes">&nbsp;</span>
			</div>
</div>


