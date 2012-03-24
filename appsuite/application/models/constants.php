<?php
/**
 * 数据库表名常量
 */
define('TABLE_QNSOFT_CONFIG', 'qnsoft_setting'); //常量表
define('TABLE_QNSOFT_SESSION', 'qnsoft_session'); //
define('TABLE_QNSOFT_USER', 'qnsoft_user'); //用户

define('TABLE_QNSOFT_FACTORY', "qnsoft_factory");//企业表
define('TABLE_QNSOFT_PHONE', "qnsoft_phone");//分机表
define('TABLE_QNSOFT_SKILL', "qnsoft_skill");//技能表
define('TABLE_QNSOFT_USERSKILLGROUP', "qnsoft_userskillgroup");//用户技能组 
define('TABLE_QNSOFT_SCRIPTDB', "qnsoft_scriptdb");//脚本库
define('TABLE_QNSOFT_MENU', "qnsoft_menu"); //目录树
define('TABLE_QNSOFT_ROLE', "qnsoft_role"); //角色表
define('TABLE_QNSOFT_RESOURCE', "qnsoft_resource"); //资源表  
define('TABLE_QNSOFT_AUTH', "qnsoft_auth"); //权限表  
define('TABLE_QNSOFT_BUTTON', "qnsoft_button"); //按钮表    
define('TABLE_QNSOFT_AREACODE', "qnsoft_areacode"); //区号表  


/**
 * 脚本key常量
 */
 $qnsoft_script_type = array(
    array('type' => "appsuiteinitial", 'dsc' => "座席初始化"),
    array('type' => "initial", 'dsc' => "初始化CTI"),
	array('type' => "onsignin", 'dsc' => "登陆脚本"),
	array('type' => "onanswerrequest", 'dsc' => "振铃脚本"),
	array('type' => "onanswersuccess", 'dsc' => "应答脚本"),
	array('type' => "onholdsuccess", 'dsc' => "保持脚本"),
	array('type' => "ontrans", 'dsc' => "呼转脚本"),
	array('type' => "onrelease", 'dsc' => "挂机脚本"),
	array('type' => "onoutcall", 'dsc' => "外呼脚本")
 );

$user_type = array(
    '0' => '系统管理员',
    '1' => '业务管理员',
    '2' => '座席'
 );
  
 $resource_type = array(
    '0' => '自定义资源',
    '1' => '应用资源',
    '2' => '系统资源'
 );

/**
 * qnsoft_ip组别常量
 */

$qnsoft_ip = array(
	'type' => array(
		'0' => '未分类',
		'1' => 'SLEE',
		'2' => '接口服务器'
	),
	'group' => array(
		'0' => '未分类',
		'1' => '10086',
		'2' => '12580'
	)
);

/**
 * qnsoft_chgflow常量
 */
$qnsoft_chgflow = array(
	'group' => array(
		'0' => '没有组别',
		'1' => '10086流程',
		'2' => '12580流程',
		'3' => 'CTI转人工提醒',
		'4' => 'IVR预排队先进先出',
		'5' => '外地用户转回本地10086',
		'6' => '世博保障应急开关'
	),
	'expo' => array(
		'1' => '业务范围',
		'2' => '播报语音',
		'3' => '引导用户出向',
		'4' => '话路转向',
	),
	'expoid' => array(
		'1' => 'expokeybusiness',
		'2' => 'expovoxtype',
		'3' => 'expochannel',
		'4' => 'expogoto',
	),
	'expoidkey' => array(
		'1' => 'EXPOKEYBUSINESS',
		'2' => 'EXPOVOXTYPE',
		'3' => 'EXPOCHANNEL',
		'4' => 'EXPOGOTO',
	)
);

$commonflow = array(
	'yingjislee' => array('tag' => 'YINGJISLEE', 'group' => 3, 'subgroup' => 0),//CTI转人工提醒 
	'yupaidui' => array('tag' => 'YUPAIDUI', 'group' => 4, 'subgroup' => 0),//预排队
	'waidi' => array('tag' => 'waidi10086', 'group' => 5, 'subgroup' => 0),//外地用户转回本地10086 
	'expokeybusiness' => array('tag' => 'EXPOKEYBUSINESS', 'group' => 6, 'subgroup' => 1),//可供选择是所有还是关键的7项业务 
	'expovoxtype' => array('tag' => 'EXPOVOXTYPE', 'group' => 6, 'subgroup' => 2),//选择是播报语音 
	'expochannel' => array('tag' => 'EXPOCHANNEL', 'group' => 6, 'subgroup' => 3),//引导用户 
	'expogoto' => array('tag' => 'EXPOGOTO', 'group' => 6, 'subgroup' => 4)//去向 
);
?>