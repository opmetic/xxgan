<?php /* Smarty version 2.6.20, created on 2011-03-21 02:35:49
         compiled from instal.tpl */ ?>
<HTML>
<HEAD>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE><?php echo $this->_tpl_vars['system_config']['site_name']; ?>
</TITLE>
</HEAD>
<BODY>
<OBJECT height=10 width=10 ID="ASInstal" CLASSID="CLSID:4E3E6827-8BDF-48C0-9DB4-EAAA90F5B2A5"  codebase="<?php echo $this->_tpl_vars['system_config']['site_url']; ?>
/instal/AppSuiteInstal.cab#version=1,0,0,4"></OBJECT>
<script type="text/javascript">   

     
</script>

<a href="javascript:onloadFun1()">下一步</a>
</BODY>
<?php echo '
<script type="text/javascript">
function   onloadFun()
{
    var obj=document.getElementById("ASInstal");   
    //readyState为4时,代表完全加载了.   
    if(obj.readyState==4){   
     //alert("加载/成功!");   
     ASInstal.CreateInstal("122.225.204.237"); 
     setTimeout("onloadFun1()", 8000);  
    }else{   
     alert("加载失败!");   
    }  
   // 
}

function onloadFun1()
{    
	window.location.href = "'; ?>
<?php echo $this->_tpl_vars['system_config']['site_url']; ?>
<?php echo '/instal/step1";
}
</script>

'; ?>

</HTML>