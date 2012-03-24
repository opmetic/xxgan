<?php /* Smarty version 2.6.20, created on 2010-11-02 08:49:56
         compiled from iplist.tpl */ ?>
<?php echo '
<style type="text/css">

.iplist {}
.iplist tr {border-bottom: 1px solid #a6c9e2; height: 24px;}
.iplist th {border-bottom: 1px solid #a6c9e2; }
.iplist td {border-bottom: 1px solid #a6c9e2; }
.ipedit {margin: 0; height: 24px; width: 30px; float: left; background-image: url(/images/200811222014050877801.jpg); background-position: -357px -183px; cursor: hand; margin-right: 3px; }
.ipdel {margin: 0; height: 24px; width: 30px; float: left; background-image: url(/images/200811222014050877801.jpg); background-position: -200px -23px; cursor: hand; }
#idcell {background-color: #ffffff;}
input, select {margin-bottom : 3px;}
</style>
<script type="text/javascript">
$(function() {
	var ip = $("#ip"),
		addr = $("#addr"),
		pcname = $("#pcname"),
		allFields = $([]).add(ip).add(addr).add(pcname),
		tips = $("#validateTips");

	function updateTips(t) {
		tips.text(t).effect("highlight",{},1500);
	}

	function checkLength(o,n,min,max) {

		if ( o.val().length > max || o.val().length < min ) {
			o.addClass(\'ui-state-error\');
			//updateTips("Length of " + n + " must be between "+min+" and "+max+".");
			updateTips("不能为空值");
			return false;
		} else {
			return true;
		}

	}

	function checkRegexp(o,regexp,n) {

		if ( !( regexp.test( o.val() ) ) ) {
			o.addClass(\'ui-state-error\');
			updateTips(n);
			return false;
		} else {
			return true;
		}

	}
	
	$("#idcell").dialog({
		bgiframe: true,
		autoOpen: false,
		height: 300,
		width: 450,
		modal: true,
		buttons: {
			\'取消\': function() {
				$(this).dialog(\'close\');
			},
			\'提交\': function() {
				var bValid = true;
				allFields.removeClass(\'ui-state-error\');

				bValid = bValid && checkLength(ip, "ip", 1, 128);
				bValid = bValid && checkLength(addr, "addr", 1, 128);
				bValid = bValid && checkLength(pcname, "pcname", 1, 128);


				//bValid = bValid && checkRegexp(name,/^[a-z]([0-9a-z_])+$/i,"Username may consist of a-z, 0-9, underscores, begin with a letter.");
				// From jquery.validate.js (by joern), contributed by Scott Gonzalez: http://projects.scottsplayground.com/email_address_validation/
				//bValid = bValid && checkRegexp(email,/^((([a-z]|\\d|[!#\\$%&\'\\*\\+\\-\\/=\\?\\^_`{\\|}~]|[\\u00A0-\\uD7FF\\uF900-\\uFDCF\\uFDF0-\\uFFEF])+(\\.([a-z]|\\d|[!#\\$%&\'\\*\\+\\-\\/=\\?\\^_`{\\|}~]|[\\u00A0-\\uD7FF\\uF900-\\uFDCF\\uFDF0-\\uFFEF])+)*)|((\\x22)((((\\x20|\\x09)*(\\x0d\\x0a))?(\\x20|\\x09)+)?(([\\x01-\\x08\\x0b\\x0c\\x0e-\\x1f\\x7f]|\\x21|[\\x23-\\x5b]|[\\x5d-\\x7e]|[\\u00A0-\\uD7FF\\uF900-\\uFDCF\\uFDF0-\\uFFEF])|(\\\\([\\x01-\\x09\\x0b\\x0c\\x0d-\\x7f]|[\\u00A0-\\uD7FF\\uF900-\\uFDCF\\uFDF0-\\uFFEF]))))*(((\\x20|\\x09)*(\\x0d\\x0a))?(\\x20|\\x09)+)?(\\x22)))@((([a-z]|\\d|[\\u00A0-\\uD7FF\\uF900-\\uFDCF\\uFDF0-\\uFFEF])|(([a-z]|\\d|[\\u00A0-\\uD7FF\\uF900-\\uFDCF\\uFDF0-\\uFFEF])([a-z]|\\d|-|\\.|_|~|[\\u00A0-\\uD7FF\\uF900-\\uFDCF\\uFDF0-\\uFFEF])*([a-z]|\\d|[\\u00A0-\\uD7FF\\uF900-\\uFDCF\\uFDF0-\\uFFEF])))\\.)+(([a-z]|[\\u00A0-\\uD7FF\\uF900-\\uFDCF\\uFDF0-\\uFFEF])|(([a-z]|[\\u00A0-\\uD7FF\\uF900-\\uFDCF\\uFDF0-\\uFFEF])([a-z]|\\d|-|\\.|_|~|[\\u00A0-\\uD7FF\\uF900-\\uFDCF\\uFDF0-\\uFFEF])*([a-z]|[\\u00A0-\\uD7FF\\uF900-\\uFDCF\\uFDF0-\\uFFEF])))\\.?$/i,"eg. ui@jquery.com");
				//bValid = bValid && checkRegexp(password,/^([0-9a-zA-Z])+$/,"Password field only allow : a-z 0-9");
				
				if (bValid) {
					$.post(
						\'/admin/ipcell\',
						{ip: $("#ip").val(), ipgroup: $("#ipgroup").val(), iptype: $("#iptype").val()
						     , addr: $("#addr").val(), pcname: $("#pcname").val(), des: $("#des").val() 
						     , op: $("#op").val(), id: $("#id").val()
						},
						function(data) {
							$("#aboutchannelsoft_windows .qn_ui-sortable-placeholder-frame").load("/admin/iplist"); 
						}
					);
					$(this).dialog(\'close\');
				}
			}
		},
		close: function() {
			allFields.val(\'\').removeClass(\'ui-state-error\');
		}
	});
		
		
	/*add*/
	$(\'#create-ip\').click(function() {
			$("#op").val(\'add\');
			$("#id").val(\'0\');
			$(\'#idcell\').dialog(\'open\');
		})
		.hover(
			function(){ 
				$(this).addClass("ui-state-hover"); 
			},
			function(){ 
				$(this).removeClass("ui-state-hover"); 
			}
		)/*add*/
		
	/*edit*/
	$(".ipedit").click(function(){
		var ipid = $(this).parents("tr:first").attr("id"); /*id*/
		$.ajax({
			type: "GET",
			url: "/admin/ipcell",
			dataType: "json",
			data: {op: \'fetch\', id: ipid},
			success: function(msg){
				$("#idcell #ip").val(msg.ipaddr);
				$("#idcell #ipgroup").val(msg.ipgroup);
				$("#idcell #iptype").val(msg.type);
				$("#idcell #addr").val(msg.addr);
				$("#idcell #des").val(msg.des);
				$("#idcell #pcname").val(msg.pcname);
				$("#idcell #op").val(\'edit\');
				$("#idcell #id").val(msg.id);
				
				$(\'#idcell\').dialog(\'open\');
			}
		}); 
	});/*edit*/
	
	/*del*/
	$(".ipdel").click(function(){
		var ipid = $(this).parents("tr:first").attr("id"); /*id*/
		$("#dialog_div").html("");
		$("#dialog_div").append("<div id=\\"dialog\\" title=\\"\\" ><p><span class=\\"ui-icon ui-icon-alert\\" style=\\"float:left; margin:0 7px 20px 0;\\"></span>您真的要删除该条记录吗？</p></div>");
		$("#dialog").dialog({
			bgiframe: true,
			resizable: false,
			height:140,
			modal: true,
			overlay: {
				backgroundColor: \'#000\',
				opacity: 0.5
			},
			buttons: {
				\'取消\': function() {
					$(this).dialog(\'close\');
				},
				\'确认\': function() {
					$.post(
						\'/admin/ipcell\',
						{ op: \'del\', id: ipid},
						function(data) {
							$("#" + ipid).hide(\'highlight\');
							//$("#aboutchannelsoft_windows .qn_ui-sortable-placeholder-frame").load("/admin/iplist"); 
						}
					);
					$(this).dialog(\'close\');
				}

			}
		});
	});/*del*/
	
	$("#selectbygroup").change(function(){
		groupid = $(this).val();
		$.post(
			\'/admin/iplist\',
			{ groupid: groupid},
			function(data) {
				$("#aboutchannelsoft_windows .qn_ui-sortable-placeholder-frame").html(data); 
				$("#selectbygroup").val(groupid);
			}
		);
	});
});

</script>
'; ?>

<div>
<table cellpadding="0" cellspacing="0" width="98%" align="center" class="iplist">
<col width='5%'>
<col width='15%'>
<col width='10%'>
<col width='10%'>
<col width='10%'>
<col width='10%'>
<col width='28%'>
<col width='10%'>
<tr>
	<th>&nbsp;</th>
	<th>IP</th>
	<th>
		<select style="font-weight: bold; width: 100%;" id="selectbygroup">
			<option value="all">机器组别</option>
			<?php $_from = $this->_tpl_vars['qnsoftip']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
			<option value="<?php echo $this->_tpl_vars['key']; ?>
"><?php echo $this->_tpl_vars['item']; ?>
</option>
			<?php endforeach; endif; unset($_from); ?>
		</select>
	</th>
	<th>类别</th>
	<th>机器地址</th>
	<th>机器名</th>
	<th>描述</th>
	<th>&nbsp;</th>
</tr>
<?php $_from = $this->_tpl_vars['iplist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['iplistloop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['iplistloop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['iplistloop']['iteration']++;
?>
<tr align="center" id="<?php echo $this->_tpl_vars['item']['id']; ?>
">
	<td align="right"><?php echo $this->_foreach['iplistloop']['iteration']; ?>
</td>
	<td><?php if ($this->_tpl_vars['item']['ipaddr']): ?><?php echo $this->_tpl_vars['item']['ipaddr']; ?>
<?php else: ?>&nbsp;<?php endif; ?></td>
	<td><?php if ($this->_tpl_vars['item']['ipgroup_txt']): ?><?php echo $this->_tpl_vars['item']['ipgroup_txt']; ?>
<?php else: ?>&nbsp;<?php endif; ?></td>
	<td><?php if ($this->_tpl_vars['item']['type_txt']): ?><?php echo $this->_tpl_vars['item']['type_txt']; ?>
<?php else: ?>&nbsp;<?php endif; ?></td>
	<td><?php if ($this->_tpl_vars['item']['addr']): ?><?php echo $this->_tpl_vars['item']['addr']; ?>
<?php else: ?>&nbsp;<?php endif; ?></td>
	<td><?php if ($this->_tpl_vars['item']['pcname']): ?><?php echo $this->_tpl_vars['item']['pcname']; ?>
<?php else: ?>&nbsp;<?php endif; ?></td>
	<td><?php if ($this->_tpl_vars['item']['des']): ?><?php echo $this->_tpl_vars['item']['des']; ?>
<?php else: ?>&nbsp;<?php endif; ?></td>
	<td>
		<div class="ipedit" title="编辑"></div>
		<div class="ipdel" title="删除"></div>
	</td>
</tr>
<?php endforeach; endif; unset($_from); ?>
</table>
</div>
<p/>
<div align="center">
	<button id="create-ip" class="ui-button ui-state-default ui-corner-all">Create new IP</button>
</div>
<a href='javascript:parent.openNowWindows("新窗口2", "http://localhost:8089/admin/iplist", "true");'>aaa</a>
<a href='http://localhost:8089/admin/iplist'>bbb</a>
