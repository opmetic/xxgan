<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Cache-Control" content="no-cache" />
<title>{$system_config.site_name}</title>
<link type="text/css" href="{$system_config.img_url}/appsuite_images/jquery-ui-1.8.1.custom.css" rel="stylesheet" />
<script type="text/javascript" src="{$system_config.img_url}/appsuite_script/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="{$system_config.img_url}/appsuite_script/jquery-ui-1.8.1.custom.min.js"></script>

<!-- css -->
<link type="text/css" href="{$system_config.img_url}/appsuite_images/admin.css" rel="stylesheet" />

<!-- easyui -->
<link rel="stylesheet" type="text/css" href="{$system_config.img_url}/appsuite_images/themes/default/easyui.css">
<link rel="stylesheet" type="text/css" href="{$system_config.img_url}/appsuite_images/themes/icon.css">
<script type="text/javascript" src="{$system_config.img_url}/appsuite_script/jquery.easyui.min.js"></script>

{literal}
	<script>
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
		var tab = $('#maintab').tabs('getSelected');
			$('#maintab').tabs('update', {
				tab: tab,
				options:{
		//			title:'new title'
				}
			});
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

		$(function(){
			var p = $('body').layout('panel','west').panel({
				onCollapse:function(){
				}
			});			

			$(".easyui-tree").tree({
                onClick: function(node) {
					if (node.text == "新增公司")
					{
						openNowWindows("新增公司", "/qnfactory/add", true);
					}
					else if (node.text == "公司列表")
					{
					openNowWindows("新增列表", "/qnfactory/list", true);
					}
                	else if (node.text == "登陆")
                	{
						openNowWindows("登陆脚本", "/script/index/scriptdb_key/onsignin", true);
                	}
                	else if (node.text == "振铃")
                	{
						openNowWindows("振铃脚本", "/script/index/scriptdb_key/onanswerrequest", true);
                	} 
					else if (node.text == "应答")
                	{
						openNowWindows("应答脚本", "/script/index/scriptdb_key/onanswersuccess", true);
                	}
					else if (node.text == "保持")
                	{
						openNowWindows("保持脚本", "/script/index/scriptdb_key/onholdsuccess", true);
                	} 
					else if (node.text == "呼转")
                	{
						openNowWindows("呼转脚本", "/script/index/scriptdb_key/ontrans", true);
                	}
					else if (node.text == "挂机")
                	{
						openNowWindows("挂机脚本", "/script/index/scriptdb_key/onrelease", true);
                	}
                }
            });
            
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

		});
		
		
	</script>
{/literal}
</head>

<body class="easyui-layout">
	<div region="north" border="false" style="height:93px;background:#B3DFDA; overflow:hidden;background: url(client_images/top.jpg) no-repeat;"></div>
	
	<!-- 目录菜单 -->
	<div region="west" split="true" title="目录" style="width:200px;padding1:1px;">
		<div class="easyui-accordion" fit="true" border="false">
			<div title="公司管理" style="overflow:auto;">
				<ul class="easyui-tree" animate="true">
				<li><span>新增公司</span></li>
				<li><span>公司列表</span></li>
				</ul>
			</div>
			<div title="技能组管理" style="overflow:auto;">
				<p>content1</p>
			</div>
			<div title="用户管理" style="overflow:auto;">
				<p>content1</p>
			</div>
			<div title="脚本管理">
				<ul id="tt1" class="easyui-tree" animate="true">
					<li>
						<span>事件脚本</span>
						<ul>
							<li><span>登陆</span></li>
							<li><span>振铃</span></li>
							<li><span>应答</span></li>
							<li><span>保持</span></li>
							<li><span>呼转</span></li>
							<li><span>挂机</span></li>
						</ul>
					</li>
					<li  state="closed">
						<span>自定义事件</span>
						<ul>
							<li><span>同步到本地文件</span></li>
							<li><span>同步到数据库</span></li>
						</ul>
					</li>
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
{literal}
{/literal}

</body>

</html>

