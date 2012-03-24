<?php

/**
 * 
 */
error_reporting(E_ALL & ~E_NOTICE);

/**
 * 
 */
ini_set("display_errors", 1);
/** 
 * 开启session
 */
@session_start(); 
 

/*
$last_line = system('dir', $retval);
echo 'Last line of the output: ' . $last_line;
echo '<hr />Return value: ' . $retval;




exit(0);*/
/**
 * 设置时区
 */
if(function_exists('date_default_timezone_set')) date_default_timezone_set("Etc/GMT-8");
	
$paths = array(
    realpath(dirname(__FILE__) . '/../library'),
    realpath(dirname(__FILE__) . '/../application/models'),
    '.'
);
set_include_path(implode(PATH_SEPARATOR, $paths));

require_once 'Zend/Loader/Autoloader.php';
require_once 'Smarty/Smarty.class.php';
require_once 'constants.php';
require_once 'SoapModel.php';
require_once 'functions.php';
require_once 'pager.php';
require_once 'upload.php';

Zend_Loader_Autoloader::getInstance()->setFallbackAutoloader(true);

/**
 * 引入初始化文件，分配权限
 */
require_once 'Zend_Controller_Action_Qn.php'; 

$config = new Zend_Config_Ini('../application/config/config.ini',null, true);



//配置数据库参数,并连接数据库
$dbAdapter=Zend_Db::factory(
	$config->general->db->adapter,
	$config->general->db->config->toArray()
	);

$dbAdapter->query('SET NAMES utf8');
Zend_Db_Table::setDefaultAdapter($dbAdapter);
Zend_Registry::set('dbAdapter', $dbAdapter);
Zend_Registry::set('dbConnConfig', $config); //数据库配制信息

$smarty = new Smarty();
$smarty -> caching 		= false;//是否开启缓存
$smarty -> template_dir = '../application/views/';
$smarty -> compile_dir 	= './templates';
$smarty -> cache_dir 	= './templates/cache';
Zend_Registry::set('view', $smarty);

$frontController =Zend_Controller_Front::getInstance();
$frontController->setBaseUrl('/')//设置基本路径
  ->setParam('noViewRenderer', true) //不使用zend view
  ->setControllerDirectory('../application/controllers')
//  ->setParam('useDefaultControllerAlways', true) //启用默认的处理器
  ->throwExceptions(true) //启用自带的的出错处理
  ->dispatch();

?>