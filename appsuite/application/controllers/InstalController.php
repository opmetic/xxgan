<?php
/** Zend_Controller_Action */

class InstalController extends Zend_Controller_Action_Qn
{    
	public function init()
    {
    	Zend_Controller_Action_Qn::init();
    }
    
    /**
     * 安装后台
     */
    public function indexAction()
    {
    	$view = Zend_Registry::get('view');
    	$user = Zend_Registry::get('user');
		$db = Zend_Registry::get('dbAdapter');
		$config = Zend_Registry::get('config');

    	$view->display('instal.tpl');
    }

	public function step1Action()
    {
    	$view = Zend_Registry::get('view');
    	$user = Zend_Registry::get('user');
		$db = Zend_Registry::get('dbAdapter');
		$config = Zend_Registry::get('config');

		$view->assign('model', $user['agentid']);

		$view->display('step1.tpl');
    }

	public function step2Action()
    {
    	$view = Zend_Registry::get('view');
    	$user = Zend_Registry::get('user');
		$db = Zend_Registry::get('dbAdapter');
		$config = Zend_Registry::get('config');
			
		$model = $this->_getParam('model');
		$ctiip = $this->_getParam('ctiip');
		$ctiport = $this->_getParam('ctiport');
		$proxynum = $this->_getParam('proxynum');
		$acdip = $this->_getParam('acdip');
		$acdport = $this->_getParam('acdport');
		$areacord = $this->_getParam('areacord', '571');

		$localIP = $this->_getParam('localIP');
		

		$view->assign('ip', $localIP);
		$view->assign('model', $model);

		$view->assign('ctiip', $ctiip);
		$view->assign('ctiport', $ctiport);
		$view->assign('proxynum', $proxynum);
		$view->assign('acdip', $acdip);
		$view->assign('acdport', $acdport);
		$view->assign('areacord', $areacord);

		$view->display('step2.tpl');
    }

	/**
	 * 不存在的方法
	 *
	 * @param unknown_type $method
	 * @param unknown_type $args
	 * @return unknown
	 */
    public function __call($method, $args)
    {
    	echo '>>>>>>>>>>>>>>>' . $method;
    	exit;
        if ('Action' == substr($method, -6)) {
            // If the action method was not found, render the error
            // template
            return $this->render('error');
        }

        // all other methods throw an exception
        throw new Exception('Invalid method "'
                            . $method
                            . '" called',
                            500);
    }
}
?>
