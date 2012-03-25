<?php

/** Zend_Controller_Action */
class Zend_Controller_Action_Qn extends Zend_Controller_Action
{    
	public function init()
    {
    	$config = array();
    	$db = Zend_Registry::get('dbAdapter');
    	Zend_Controller_Action_Qn::config($config);
    	Zend_Registry::set('config', $config);
    	
    	$controller = $this->_getParam('controller');    //控件
    	$action = $controller . $this->_getParam('action');  //动作
        $factoryid = $controller . $this->_getParam('fid', '');  //厂商  
       
    	    
    	$sessionId = session_id();
		Zend_Registry::set('sessionId', $sessionId);

		if ($controller !== 'access') //登陆页面
		{
	    	//得到当前用户信息
			$select = $db->select();
			$select->from(TABLE_QNSOFT_SESSION, '*');
			$select->where('sid = "' . $sessionId . '"');
			$select->where('islogin = 1');
			$select->where('refresh > ' . (time() - $config['cookies_time']));

			$sessionData = $db->fetchRow($select);
			if (!$sessionData)
			{
                if ($config['from'] == 'www')
                {
                    header('location: ' . $config['site_url'] . '/access/login/from/www');   
                }
                else
                {
				    header('location: ' . $config['site_url'] . '/access/login');
                }
                exit(0);
			}
			else 
			{
				$username = $sessionData['username'];
	  		  	//验证权限
		//    	echo $this->_getParam('controller') . ' + ' . $this->_getParam('action');
				if(preg_match("/^88[78][0-9][46][0-9]+[0-9]$/", $username) )  //四川
                {         
                    $select = $db->select();
                    $select->from('cs_' . TABLE_QNSOFT_USER, '*');
                    $select->where('workid = ' . $username . '');
                    $select->where('deleteflag = 0'); //未删除

                    $user = $db->fetchRow($select);
                }
                else if(preg_match("/^88[0-9][0-9]4[0-9]+[0-9]$/", $username) )  //四川
                {         
                    $select = $db->select();
                    $select->from('sc_' . TABLE_QNSOFT_USER, '*');
                    $select->where('workid = ' . $username . '');
                    $select->where('deleteflag = 0'); //未删除

                    $user = $db->fetchRow($select);
                }
                else if(preg_match("/^88[0-9][0-9]6[0-9]+[0-9]$/", $username) )
                {         
                    $select = $db->select();
                    $select->from('gz_' . TABLE_QNSOFT_USER, '*');
                    $select->where('workid = ' . $username . '');
                    $select->where('deleteflag = 0'); //未删除

                    $user = $db->fetchRow($select);
                }
                else
                {
				    $select = $db->select();
				    $select->from(TABLE_QNSOFT_USER, '*');
				    $select->where('uid = "' . $sessionData['uid'] . '"');
				    $select->where('deleteflag = 0'); //未删除
				    $user = $db->fetchRow($select);
                }

				if (!$user)
				{
					return $this->render('error');
				}
                
                if ($user['utype'] < 2) //非坐席用户
                {
                    if ($sessionData['refresh'] < time() - $config['cookies_time'])  // 管理员session超时
                    {
                        if ($config['from'] == 'www')
                        {
                            header('location: ' . $config['site_url'] . '/access/login/from/www');   
                        }
                        else
                        {
                            header('location: ' . $config['site_url'] . '/access/login');
                        }
                        exit(0);
                    }
                }
                
                Zend_Controller_Action_Qn::refresh ($sessionId);
				$user['logintime'] = $sessionData['time']; 
                
                $ip = $_SESSION['localhostip'];  //由IP地址得到分机号

				$select = $db->select();
				$select->from(TABLE_QNSOFT_PHONE, '*');
				$select->where('machineip = ?', $ip);
                $select->where('factory_id = ?', $user['factory_id']);
                $select->where('deleteflag = 0'); //未删除  
                
				$phoneInfo = $db->fetchRow($select);

				if ($phoneInfo)
				{
					$user['agentid'] = $user['plain'];
					$user['password'] = $user['plain_pwdmd5'];
					$user['DN'] = $phoneInfo['phone_num'];
				}
                else
                {
                    $user['DN'] = "本机没有分配分机号，请与管理员联系";   
                }

				Zend_Registry::set('user', $user); //当前用户
			}
		}
    }
    
    public function tlog($type, $data)
	{
		$user = Zend_Registry::get('user'); //当前用户
		$db = Zend_Registry::get('dbAdapter');
		
		$in_ary = array(
			'time' => time(),
			'user' => $user['username'],
			'ip' => $_SERVER['REMOTE_ADDR'],
			'type' => $type,
			'data' => $data
		);

		$db->insert(TABLE_QNSOFT_LOG, $in_ary);
	}
    
	private function config(&$config)
    {
    	//配制表
    	$db = Zend_Registry::get('dbAdapter');
    	$view = Zend_Registry::get('view');
        $from = $this->_getParam('from');
    	
		$select = $db->select();
		$select->from(TABLE_QNSOFT_CONFIG, '*');
		$system_list = $db->fetchAll($select);
        if ($from == 'www' || $_SESSION['from'] == 'www')
        {
            $system_list[] = array('variable' => 'from', 
                                    'value' => 'www',
                                    'type' => 1);
            $from = 'www'; //如果从session中读到了公网标志，设置此标志位
        }
        
        if ($_SESSION['fid'])
        {
            $select = $db->select();
            $select->from(TABLE_QNSOFT_FACTORY, '*');
            $select->where('factory_id = ' . $_SESSION['fid']);
            $select->where('deleteflag = 0'); //未删除
            $fdata = $db->fetchRow($select);
            if ($fdata)
            {
                $system_list[] = array('variable' => 'factory_id', 
                                    'value' => $fdata['factory_id'],
                                    'type' => 1);
                $system_list[] = array('variable' => 'factory_name', 
                                    'value' => $fdata['factory_name'],
                                    'type' => 1);
                $system_list[] = array('variable' => 'factory_enterprisecode', 
                                    'value' => $fdata['factory_enterprisecode'],
                                    'type' => 1);
            }
        }
		
		foreach ($system_list as $key=>$value)
		{
            //如果有公网标记，刚走公网通道，否则走CN2网络
            if ($from == 'www')
            {
                if ($value['variable'] == 'site_url_web')
                {
                    $value['value'] = 'http://122.225.204.237/qn/appsuite';
                }
                
                if ($value['variable'] == 'acd_server_port')
                {
                    $value['value'] = '5090';
                }
                
                if ($value['variable'] == 'cti_server')
                {
                    $value['value'] = '122.225.204.232';
                }
                
                if ($value['variable'] == 'acd_server')
                {
                    $value['value'] = '122.225.204.249';
                }
                
                if ($value['variable'] == 'db_server')
                {
                    $value['value'] = '122.225.204.233';
                }
            }
            
			if ($value['type'] > 0)
			{
				$system_config[$value['variable']] = $value['value'];
			}
			$config[$value['variable']] = $value['value'];
		}
		
		if (substr_count($_SERVER['HTTP_HOST'], $config['site_flag_1']) > 0 || 
    		substr_count($_SERVER['HTTP_HOST'], $config['site_flag_2']) > 0)
		{
			$config['site_url'] = $config['site_url_web'];
			$config['img_url'] = $config['site_url_web'];
			$system_config['site_url'] = $config['site_url_web'];
			$system_config['img_url'] = $config['site_url_web'];

		}
		
		$view->assign('system_config', $system_config);
    }
    
    
		
    private function refresh ($sessionId)
    {
    	$db = Zend_Registry::get('dbAdapter');
    	$up_ary = array(
			'refresh' => time()
		);
		$where = $db->quoteInto('sid = ?', $sessionId);
		//$where = $db->quoteInto('islogin = ?', 1);
		$db->update(TABLE_QNSOFT_SESSION, $up_ary, $where);
    }
    
    /**
	 * 得到 flow 详细
	 *
	 */
	public  function getflowByValue($param, $flowgroup, $subgroup)
	{	
		if ($param !== '')
		{
			$db = Zend_Registry::get('dbAdapter');
			$select = $db->select();
			$select->from(TABLE_QNSOFT_CHGFLOW, '*');
			$select->where('value = ?', $param);
			$select->where('flowgroup = ?', $flowgroup); // 
			$select->where('subgroup = ?', $subgroup); //
			$select->where('alive = 1');

			$chgflowData = $db->fetchRow($select);
			if ($chgflowData)
			{
				return $chgflowData;
			}
		}
	}
	
	/**
	 * 通过 ID 得到 IP 
	 */
	public function getIPByID($id)
	{
		$db = Zend_Registry::get('dbAdapter');
		$select = $db->select();
		$select->from(TABLE_QNSOFT_IP, '*');
		$select->where('id = ?', $id);
		$select->where('alive = 1');

		$ipData = $db->fetchRow($select);
		if ($ipData)
		{
			return $ipData;
		}
	}
	
	/**
	 * 通过 ID 得到 flow 
	 */
	public function getFlowByID($id)
	{
		$db = Zend_Registry::get('dbAdapter');
		$select = $db->select();
		$select->from(TABLE_QNSOFT_CHGFLOW, '*');
		$select->where('id = ?', $id);
		$select->where('alive = 1');

		$flowData = $db->fetchRow($select);
		if ($flowData)
		{
			return $flowData;
		}
	}
    
    public function msg($msg, $url)
    {   
        $view = Zend_Registry::get('view');
        $user = Zend_Registry::get('user');
        $db = Zend_Registry::get('dbAdapter');
        $config = Zend_Registry::get('config');
  
        $urlArray = array(
            array('title' => "新增", 'url' => $url)
        );
        $view->assign('msg', $msg);
        $view->assign('urlArray', $urlArray);

        $view->display('msg.tpl');   
    }
    
    public function msgUrl($msg, $urlArray)
    {   
        $view = Zend_Registry::get('view');
        $user = Zend_Registry::get('user');
        $db = Zend_Registry::get('dbAdapter');
        $config = Zend_Registry::get('config');
  
        $view->assign('msg', $msg);
        $view->assign('urlArray', $urlArray);

        $view->display('msg.tpl');   
    }
}
?>
