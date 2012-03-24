<?php
/** Zend_Controller_Action */

class IndexController extends Zend_Controller_Action_Qn
{    
	public function init()
    {
    	Zend_Controller_Action_Qn::init();

    }
    
    public function indexAction()
    {
    	$view = Zend_Registry::get('view');
    	$user = Zend_Registry::get('user');
    	$config = Zend_Registry::get('config');
		     if ($user['utype'] == 0)
        {
            header('location: ' . $config['site_url'] . '/system');
            return;
        }
        else if ($user['utype'] == 1)
        {
            header('location: ' . $config['site_url'] . '/systemrenter');
            return;
        }
        else if ($user['utype'] == 2)
        {
            header('location: ' . $config['site_url'] . '/appsuite');
            return;
        }

    	header('location: ' . $config['site_url'] . '/appsuite');
		exit(0);
		//$smarty->assign($param);
		//$smarty->assign('code', 'images.php');
		//引用模板文件
		$param = array(
			'ip' => $_SERVER['REMOTE_ADDR'],
			'username' => $user['username'],
			'logintime' => $user['logintime']
		);

		$view->assign('param', $param);
		if ($this->_getParam('lastwindow'))
		{
			echo $this->_getParam('lastwindow');
			$view->assign('lastwindow', $this->_getParam('lastwindow'));
		}
		//$view->display('index.tpl');
		$view->display('appsuite.tpl');
    }
    
    public function startAction()
    {
    	$user = Zend_Registry::get('user');
 		$config = Zend_Registry::get('config');
 		
    	if ($user['utype'] == 0)
    	{
    		header('location: ' . $config['site_url'] . '/system');
    		return;
    	}
        else if ($user['utype'] == 1)
        {
            header('location: ' . $config['site_url'] . '/systemrenter');
            return;
        }
		else if ($user['utype'] == 2)
		{
			header('location: ' . $config['site_url'] . '/appsuite');
            return;
		}
    	else 
    	{
    		echo "error";
    	}
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
