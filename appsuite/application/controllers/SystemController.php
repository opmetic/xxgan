<?php
/** Zend_Controller_Action */

class SystemController extends Zend_Controller_Action_Qn
{    
	public function init()
    {
    	Zend_Controller_Action_Qn::init();
    }
    
    /**
     * 管理后台
     */
    public function indexAction()
    {
    	$view = Zend_Registry::get('view');
    	$user = Zend_Registry::get('user');
 
    	$view->display('system.tpl');
    }
    
    public function environmentAction()
    {
        $view = Zend_Registry::get('view');
        $user = Zend_Registry::get('user');
        $db = Zend_Registry::get('dbAdapter');
 
        $view->display('environment.tpl');
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
