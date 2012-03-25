<?php /* Smarty version 2.6.20, created on 2011-03-17 17:40:07
         compiled from setclient.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Cache-Control" content="no-cache" />
<title><?php echo $this->_tpl_vars['system_config']['site_name']; ?>
</title>

<script type="text/javascript" src="<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
/client_script/jquery-1.4.2.min.js"></script>
<link rel="stylesheet" href="<?php echo $this->_tpl_vars['system_config']['site_url']; ?>
/appsuite_images/install.css" type="text/css" />

<?php echo '
<script>
	 $(function(){
		$("input[name=\'AutoSignin\']").click(function(){
			$.get("'; ?>
<?php echo $this->_tpl_vars['system_config']['site_url']; ?>
/appsuite/setclient/id/<?php echo $this->_tpl_vars['user']['uid']; ?>
<?php echo '/op/autosignin/value/" + $(this).val());
		//	AppSuiteObject("command", "autosignin", $(this).val());
		});
		$("input[name=\'InitialReady\']").click(function(){
			$.get("'; ?>
<?php echo $this->_tpl_vars['system_config']['site_url']; ?>
/appsuite/setclient/id/<?php echo $this->_tpl_vars['user']['uid']; ?>
<?php echo '/op/initialready/value/" + $(this).val());
		//	AppSuiteObject("command", "initialready", $(this).val());
		});		
		$("input[name=\'AutoAnswer\']").click(function(){
			$.get("'; ?>
<?php echo $this->_tpl_vars['system_config']['site_url']; ?>
/appsuite/setclient/id/<?php echo $this->_tpl_vars['user']['uid']; ?>
<?php echo '/op/autoanswer/value/" + $(this).val()); 
			AppSuiteObject("command", "autoanswer", $(this).val());
		});
		$("input[name=\'AgentAutoEnterIdle\']").click(function(){
			$.get("'; ?>
<?php echo $this->_tpl_vars['system_config']['site_url']; ?>
/appsuite/setclient/id/<?php echo $this->_tpl_vars['user']['uid']; ?>
<?php echo '/op/agentautoenteridle/value/" + $(this).val()); 
			AppSuiteObject("command", "agentautoenteridle", $(this).val());
		});
	});
</script>
'; ?>

</head>
<div class="index_info_div">
	<table class="form-table">
		<tr>
			<th scope="row"><label for="AutoSignin">自动签入CTI服务</label></th>
			<td width=120>
				<input name="AutoSignin" type="radio" value="yes" <?php if ($this->_tpl_vars['user']['autosignin'] == 1): ?>checked<?php endif; ?>/>自动签入<br/>
				<input name="AutoSignin" type="radio" value="no" <?php if ($this->_tpl_vars['user']['autosignin'] == 0): ?>checked<?php endif; ?>/>不自动签入
			</td>
			<td>座席登陆平台后，是否自动签入CTI服务。如何选择 不自动签入，座席登陆后需要主动点击右下角的 <b>签入</b> 来签入CTI服务。</td>
		</tr>
		<tr>
			<th scope="row"><label for="InitialReady">签入后自动示闲</label></th>
			<td width=120>
				<input name="InitialReady" type="radio" value="yes" <?php if ($this->_tpl_vars['user']['initialready'] == 1): ?>checked<?php endif; ?>/>签入后自动示闲<br/>
				<input name="InitialReady" type="radio" value="no" <?php if ($this->_tpl_vars['user']['initialready'] == 0): ?>checked<?php endif; ?>/>不签入后自动示闲
			</td>
			<td>座席签入平台后，是否自动示闲。如何选择签入后自动示闲，座席签入后马会有电话被分进本座席。</td>
		</tr>
		<tr>
			<th scope="row"><label for="AutoAnswer">自动应答</label></th>
			<td>
				<input name="AutoAnswer" type="radio" value="yes" <?php if ($this->_tpl_vars['user']['autoanswer'] == 1): ?>checked<?php endif; ?>/>自动应答<br/>
				<input name="AutoAnswer" type="radio" value="no" <?php if ($this->_tpl_vars['user']['autoanswer'] == 0): ?>checked<?php endif; ?> />不自动应答
			</td>
			<td>当有电话呼入本座席时，是否自动应答，如选择不自动应答，则当电话呼入后，需手动点击 <b>接听</b> 按钮应答呼叫。</td>
		</tr>
		<tr>
			<th scope="row"><label for="AgentAutoEnterIdle">自动示闲</label></th>
			<td>
				<input name="AgentAutoEnterIdle" type="radio" value="yes" <?php if ($this->_tpl_vars['user']['agentautoenteridle'] == 1): ?>checked<?php endif; ?>/>自动示闲<br/>
				<input name="AgentAutoEnterIdle" type="radio" value="no" <?php if ($this->_tpl_vars['user']['agentautoenteridle'] == 0): ?>checked<?php endif; ?>/>不自动示闲
			</td>
			<td>当上一次呼叫结束后，是否自动进入示闲状态。如选择自动示闲，则当一次哦叫结束后，座席立即进入示闲状态，CTI可以接着分配话路到本座席;如选择不自动示闲，则当一次哦叫结束后，需要座席人员手动点击 <b>示闲</b> 按钮进入示闲状态。</td>
		</tr>
	</table>
	<p class="step"><input name="submit" type="submit" value="刷新" class="button" /></p>
</div>

</html>
