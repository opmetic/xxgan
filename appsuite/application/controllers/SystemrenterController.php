<?php
/** Zend_Controller_Action */

class SystemrenterController extends Zend_Controller_Action_Qn
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
        $config = Zend_Registry::get('config');

        if ($user['workid'] == '88114999' || $user['workid'] == '88114998' || $user['workid'] == '88114997')
        {
            $view->assign('skill', 9);
            $view->assign('pno1', 99);
            $view->assign('pno2', 109);
            $view->display('renter/systemforuser.tpl');     
        }
        else if ($user['workid'] == '88214999' || $user['workid'] == '88214998')   
        {
            $view->assign('skill', 9);
            $view->assign('pno', 111); 
            $view->assign('pno2', 112);
            $view->display('renter/systemforuser.tpl');     
        }
        else if ($user['workid'] == '88116999' || $user['workid'] == '88116998' || $user['workid'] == '88116997'  || $user['workid'] == '88136999')
        {
            $view->assign('skill', 8);
            $view->assign('pno1', 98);
            $view->assign('pno2', 108);
            $view->display('renter/systemforuser.tpl');     
        }
        else if ($user['workid'] == '88216999')
        {
            $view->assign('skill', 8);
            $view->assign('pno', 113); 
            $view->assign('pno2', 114);
            $view->display('renter/systemforuser.tpl');     
        }
        else
        {
            $view->display('renter/system.tpl'); 
        }
    	
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
