<?php /* Smarty version 2.6.20, created on 2011-08-02 22:05:46
         compiled from renter/systemforuser.tpl */ ?>
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

<!-- css -->
<link type="text/css" href="<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
/appsuite_images/admin.css" rel="stylesheet" />

<!-- easyui -->
<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
/appsuite_images/themes/default/easyui.css">
<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
/appsuite_images/themes/icon.css">
<script type="text/javascript" src="<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
/appsuite_script/jquery.easyui.min.js"></script>

<?php echo '
	<script>
//以iframe 的方式弹出一个新窗口，不受域名限制
function openNowWindows(title, url, closable)
{
	var strContent;

	if (!title || title == "")
	{
		title = "new window";
	}

	var pp = $(\'#maintab\').tabs(\'getTab\', title);
	if (!pp)
	{
		strContent = "<iframe scrolling=\\"yes\\" frameborder=\\"0\\" src=\\"" + url + "\\" style=\\"width:100%;height:100%;\\"></iframe>";
		$(\'#maintab\').tabs(\'add\', {
			title: title,
			content:strContent,
			closable:true
		});
	}
	else
	{
		var pp = $(\'#maintab\').tabs(\'select\', title);
	}
}

//以iframe 的方式弹出一个新窗口，不受域名限制
function updateWindows(title, url, closable)
{
	var strContent;

	if (!title || title == "")
	{
		title = "new window";
	}
    try
    {
	    var pp = $(\'#maintab\').tabs(\'getTab\', title);
	    if (!pp)
	    {
		    strContent = "<iframe scrolling=\\"yes\\" frameborder=\\"0\\" src=\\"" + url + "\\" style=\\"width:100%;height:100%;\\"></iframe>";
		    $(\'#maintab\').tabs(\'add\', {
			    title: title,
			    content:strContent,
			    closable:true
		    });
	    }
	    else
	    {
		    var pp = $(\'#maintab\').tabs(\'select\', title);

		    strContent = "<iframe scrolling=\\"yes\\" frameborder=\\"0\\" src=\\"" + url + "\\" style=\\"width:100%;height:100%;\\"></iframe>";
		    var tab = $(\'#maintab\').tabs(\'getSelected\');
			    $(\'#maintab\').tabs(\'update\', {
				    tab: tab,
				    options:{
					    content:strContent
		    //			title:\'new title\'
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
	var pp = $(\'#maintab\').tabs(\'getTab\', title);
	if (!pp)
	{
		$(\'#maintab\').tabs(\'add\', {
					title:title,
					href:url,
					closable:closable
				});
	}
}

$(function(){
	var p = $(\'body\').layout(\'panel\',\'west\').panel({
		onCollapse:function(){
		}
	});			

	$(".easyui-tree").tree({
		onClick: function(node) {
			if (node.text == "新增公司")
			{
				updateWindows("新增公司", "'; ?>
<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
<?php echo '/qnfactory/add", true);
			}
			else if (node.text == "公司列表")
			{
				updateWindows("公司列表", "'; ?>
<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
<?php echo '/qnfactory/list", true);
			}
			else if (node.text == "新增分机")
			{
				updateWindows("新增分机", "'; ?>
<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
<?php echo '/qnphone/add", true);
			}
			else if (node.text == "分机列表")
			{
				updateWindows("分机列表", "'; ?>
<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
<?php echo '/qnphone/list", true);
			}
			else if (node.text == "新增技能")
			{
				updateWindows("新增技能", "'; ?>
<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
<?php echo '/qnskillrenter/add", true);
			}
			else if (node.text == "技能列表")
			{
				updateWindows("技能列表", "'; ?>
<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
<?php echo '/qnskillrenter/list", true);
			}
			else if (node.text == "新增用户")
			{
				updateWindows("新增用户", "'; ?>
<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
<?php echo '/qnuserrenter/add", true);
			}
			else if (node.text == "用户列表")
			{
				updateWindows("用户列表", "'; ?>
<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
<?php echo '/qnuserrenter/list", true);
			}
			else if (node.text == "接用户查看")
			{
				updateWindows("接用户查看", "'; ?>
<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
<?php echo '/qnuserskillgrouprenter/list", true);
			}
			else if (node.text == "新增菜单")
			{
				updateWindows("新增菜单", "'; ?>
<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
<?php echo '/qnmenurenter/add", true);
			}
			else if (node.text == "菜单列表")
			{
				updateWindows("菜单列表", "'; ?>
<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
<?php echo '/qnmenurenter/list", true);
			}
            else if (node.text == "录音查询")
            {
                updateWindows("录音查询", "http://10.74.45.145/rms/Record/recordFileAction.do?reqCode=queryUrl&enterpriseId='; ?>
<?php echo $this->_tpl_vars['skill']; ?>
<?php echo '", true);
            }
            else if (node.text == "状态监控")
            {
                updateWindows("系统实时监控", "'; ?>
<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
<?php echo '/monitor/showstatus", true); 
            }
            else if (node.text == "坐席监控")
            {
                updateWindows("坐席实时监控", "'; ?>
<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
<?php echo '/monitor/agentstatus", true); 
            }
            
            else if (node.text == "新增角色")
            {
                updateWindows("新增角色", "'; ?>
<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
<?php echo '/qnrolerenter/add", true);
            }
            else if (node.text == "角色列表")
            {
                updateWindows("角色列表", "'; ?>
<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
<?php echo '/qnrolerenter/list", true);
            }
            
            else if (node.text == "新增资源")
            {
                updateWindows("新增资源", "'; ?>
<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
<?php echo '/qnresourcerenter/add", true);
            }
            else if (node.text == "资源列表")
            {
                updateWindows("资源列表", "'; ?>
<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
<?php echo '/qnresourcerenter/list", true);
            }
                        
			else if (node.text == "查看脚本")
			{
				updateWindows("查看脚本", "'; ?>
<?php echo $this->_tpl_vars['system_config']['img_url']; ?>
<?php echo '/scriptrenter/list", true);
			}
		}
	});
	
	$(\'#editscript\').form({
		url: \'/admin/script\',
		onSubmit: function(){
				// do some check
				// return false to prevent submit;
		},
		success:function(data){
				alert(data)
		}
	});
});
		
		
</script>
<script>
function logout()
{
	window.location.href = "'; ?>
<?php echo $this->_tpl_vars['system_config']['site_url']; ?>
<?php echo '/access/logout";
}
</script>
'; ?>

</head>

<body class="easyui-layout">
	<div region="north" border="false" style="height:13px;background:#B3DFDA; overflow:hidden;background: url(client_images/top.jpg) no-repeat;text-align:right;">
	<a href='<?php echo $this->_tpl_vars['system_config']['site_url']; ?>
/access/logout' style="color:#ffffff">退出</a>
	</div>
	
	<!-- 目录菜单 -->
	<div region="west" split="false" title="<?php echo $this->_tpl_vars['system_config']['factory_name']; ?>
" style="width:200px;padding1:1px;">
		<div class="easyui-accordion" fit="true" border="false">
            <div title="录音管理" style="overflow:auto;">
                <ul class="easyui-tree" animate="true">
                <li><span>录音查询</span></li>
                </ul>
            </div>
            <div title="监控" style="overflow:auto;">
                <ul class="easyui-tree" animate="true">
                <li><span>状态监控</span></li>
                <li><span>坐席监控</span></li>
                </ul>
            </div>
		</div> 
	</div>
	<!-- 目录菜单 end -->

	<div region="center" title="" id="center">
		<div id="maintab" class="easyui-tabs" border="false" fit="true">
		</div>
	</div>
	<!-- edit script -->
	<form id="editscript" method="post" style="display: none;">
		<textarea required="true" rows="25" cols="100"></textarea> <p/>
		<input type="submit" value="提交"></div>
	</form>
	<!-- edit script end -->
<?php echo '
'; ?>


</body>

</html>
