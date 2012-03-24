<?php
/** Zend_Controller_Action */

class AccessController extends Zend_Controller_Action_Qn
{    
	public function init()
    {
    	Zend_Controller_Action_Qn::init();
    }

    public function loginAction()
    {
    	AccessController::checkloaded();
		
        $factoryid = $this->_getParam('fid', '');  //厂商  
        $from = $this->_getParam('from');
        
        if ($from == 'www')
        {
            $_SESSION['from'] = 'www';
        }
        
    	$view = Zend_Registry::get('view');

    	if ($this->_getParam('act') === 'submit')
    	{
    		$db = Zend_Registry::get('dbAdapter');
    		$config = Zend_Registry::get('config');
            $username = $this->_getParam('username', 'null');
    		
//    		$select = $db->select();
//			$select->from(TABLE_QNSOFT_USER, '*');
//			$select->where('username = "' . $this->_getParam('username', 'null') . '"');
//			$select->where('deleteflag = 0'); //未删除

//			$userData = $db->fetchRow($select);

            //工号登陆，是坐席
            if(preg_match("/^88[78][0-9][46][0-9]+[0-9]$/", $username) )  //测试
		    {       
		        $select = $db->select();
		        $select->from('cs_' . TABLE_QNSOFT_USER, '*');
		        $select->where('workid = ' . $username . '');
		        $select->where('deleteflag = 0'); //未删除

		        $userData = $db->fetchRow($select);
		    }
		    else if(preg_match("/^88[0-9][0-9]4[0-9]+[0-9]$/", $username) )  //四川
		    {         
		        $select = $db->select();
		        $select->from('sc_' . TABLE_QNSOFT_USER, '*');
		        $select->where('workid = ' . $username . '');
		        $select->where('deleteflag = 0'); //未删除

		        $userData = $db->fetchRow($select);
		    }
            else if(preg_match("/^88[0-9][0-9]6[0-9]+[0-9]$/", $username) )
            {         
                $select = $db->select();
                $select->from('gz_' . TABLE_QNSOFT_USER, '*');
                $select->where('workid = ' . $username . '');
                $select->where('deleteflag = 0'); //未删除

                $userData = $db->fetchRow($select);
            }
            else
            {
                //非工号登陆
                $select = $db->select();
                $select->from(TABLE_QNSOFT_USER, '*');
                $select->where('username = "' . $username . '"');
                $select->where('deleteflag = 0'); //未删除

                $userData = $db->fetchRow($select);
            }
            
            if ($userData && $userData['uflag'] != 0)
            {
                $view->assign('alert', '坐席已被冻结，请与管理员联系！！'); 
            }
            else
            {
			    if ($userData && $userData['password'] === strtoupper(md5($this->_getParam('userpwd'))))
			    {
				    $in_ary = array(
					    'sid' => Zend_Registry::get('sessionId'),
					    'uid' => $userData['uid'],
					    'username' => $userData['username'],
					    'code' => '',
					    'islogin' => 1,
					    'time' => time(),
					    'refresh' => time(),
					    'referer' => '',
				    );
		    
				    $db->insert(TABLE_QNSOFT_SESSION, $in_ary);
                    $_SESSION['fid'] = $userData['factory_id'];
                    $_SESSION['localhostip'] =  $this->_getParam('ip', '');

				    header('location: ' . $config['site_url'] . '/index/start');
                    exit(0);
			    }
    		    $view->assign('alert', '用户名或密码错误！！');
            }
    	}
    	
		//引用模板文件
		$view->assign('ip', $_SERVER['REMOTE_ADDR']);
		$view->display('login.tpl');
    }
    
    public function logoutAction()
    {
        $config = Zend_Registry::get('config');
    	$db = Zend_Registry::get('dbAdapter');

    	$up_ary = array(
			'islogin' => 0
		);

		$where = $db->quoteInto('sid = ?', Zend_Registry::get('sessionId'));
		$db->update(TABLE_QNSOFT_SESSION, $up_ary, $where);  
        //得到当前用户信息
		$select = $db->select();
		$select->from(TABLE_QNSOFT_SESSION, '*');
		$select->where('sid = "' . $sessionId . '"');
		$user = $db->fetchRow($select);
		
        $up_ary = array(
            'phone_status' => 0
        );
        $where = $db->quoteInto('phone_status = ?', $user['uid']);
        $db->update(TABLE_QNSOFT_PHONE, $up_ary, $where);
        
		setcookie('PHPSESSID', '', time() - 100); //cookie失效
		
		$currectHour = date('H', time());
		if ((int)$currectHour > 23 )
		{
			$day_s = mktime(0,0,0,date("m", strtotime("-3 day")), date("d",strtotime("-3 day")), date("Y",strtotime("-3 day")));

			$db->delete(TABLE_QNSOFT_SESSION, "time < " . $day_s);
    	}
    	
		
		header('location: ' . $config['site_url']);
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
    
    /////////////////////////////////////////
    private function checkloaded()
    {
    	$db = Zend_Registry::get('dbAdapter');
    	$config = Zend_Registry::get('config');
    	
    	//得到当前用户信息
		$select = $db->select();
		$select->from(TABLE_QNSOFT_SESSION, '*');
		$select->where('sid = "' . Zend_Registry::get('sessionId') . '"');
		$select->where('islogin = 1');
		$select->where('refresh > ' . (time() - $config['cookies_time']));
		$sessionData = $db->fetchRow($select);
		if ($sessionData)
		{            
			header('location: ' . $config['site_url'] . '/index/index');
		}
    }
}
?>
