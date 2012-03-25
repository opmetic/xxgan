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
    	$userPwdStatus = 0; //用户密码状态   1：零时密码2：正常密码3：锁定密码'
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
    		
    		//查看密码管理表
    		$select = $db->select();
            $select->from('qnsoft_pwdmanage', '*');
            $select->where('pm_workid = ? ', $username);

            $userPwdInfo = $db->fetchRow($select);
            if ($userPwdInfo) //有密码信息
            {
            	$userPwdStatus = $userPwdInfo['pm_status'];  //	密码当前状态
            	
            	if ($userPwdStatus == 3)//密码已被冻结
            	{
            		$view->assign('alert', '密码已被锁定，请与管理员联系！！'); 
            		$view->display('login.tpl');
					exit(0); //结束
            	}
            }
            
            if ($userPwdStatus != 0) //有密码信息,从密码信息中得到租户标志
            {
            	$select = $db->select();
            	if ($userPwdInfo['pm_enterprisecode'] != "")
            	{
            		$select->from($userPwdInfo['pm_enterprisecode'] . '_' . TABLE_QNSOFT_USER, '*');
            		$select->where('workid = ?', $username);
            	}
            	else
            	{
            		$select->from(TABLE_QNSOFT_USER, '*');
            		$select->where('username = ?', $username);
            	}
		        
		        $select->where('deleteflag = 0'); //未删除

		        $userData = $db->fetchRow($select);
            	
            }
            //工号登陆，是坐席
            else if(preg_match("/^88[78][0-9][46][0-9]+[0-9]$/", $username) )  //测试
		    {       
		        $select = $db->select();
		        $select->from('cs_' . TABLE_QNSOFT_USER, '*');
		        $select->where('workid = ?', $username);
		        $select->where('deleteflag = 0'); //未删除

		        $userData = $db->fetchRow($select);
		    }
		    else if(preg_match("/^88[0-9][0-9]4[0-9]+[0-9]$/", $username) )  //四川
		    {         
		        $select = $db->select();
		        $select->from('sc_' . TABLE_QNSOFT_USER, '*');
		        $select->where('workid = ?', $username);
		        $select->where('deleteflag = 0'); //未删除

		        $userData = $db->fetchRow($select);
		    }
            else if(preg_match("/^88[0-9][0-9]6[0-9]+[0-9]$/", $username) )
            {         
                $select = $db->select();
                $select->from('gz_' . TABLE_QNSOFT_USER, '*');
                $select->where('workid = ?', $username);
                $select->where('deleteflag = 0'); //未删除

                $userData = $db->fetchRow($select);
            }
            else
            {
                //非工号登陆
                
                $select = $db->select();
                $select->from(TABLE_QNSOFT_USER, '*');
                $select->where('username = ?', $username);
                $select->where('deleteflag = 0'); //未删除

                $userData = $db->fetchRow($select);
            }
            
            
            if ($userData && $userData['uflag'] != 0)
            {
                $view->assign('alert', '坐席已被冻结，请与管理员联系！！'); 
            }
            else
            {
            	//没有密码信息,视为初始状态, 插入密码信息
                if ($userPwdStatus == 0)
                {
                	//得到租户标志
                	$select = $db->select();
		            $select->from(TABLE_QNSOFT_FACTORY, '*');
		            $select->where('factory_id = ?', $userData['factory_id']);
		            $select->where('deleteflag = 0'); //未删除
		
		            $fdata = $db->fetchRow($select);
		            if (!$fdata) 
		            {
		            	$fdata['factory_enterprisecode'] = '';
		            }
		            
		            //插入密码管理信息
                	$in_ary = array(
                		'pm_workid' => $userData['workid'] ? $userData['workid'] : $userData['username'],
                		'pm_status' => 1, //初始状态
                		'pm_lastpwdtime' => 0,
                		'pm_errorpwdtime' => 0,
                		'pm_errorpwdcount' => 0,
					    'pm_sessionid' => Zend_Registry::get('sessionId'),
					    'pm_enterprisecode' => $fdata['factory_enterprisecode'] 
				    );	
				    $db->insert('qnsoft_pwdmanage', $in_ary);
				    
				    //重新得到密码信息
				    $select = $db->select();
	                $select->from('qnsoft_pwdmanage', '*');
	                $select->where('pm_workid = ?', $username);

	            	$userPwdInfo = $db->fetchRow($select);
                } 
        
			    if ($userData && $userData['password'] === strtoupper(md5($this->_getParam('userpwd'))))
			    {
                    $_SESSION['fid'] = $userData['factory_id'];
                    $_SESSION['localhostip'] =  $this->_getParam('ip', '');
                    
                    //密码当前为初始状态
                    if ($userPwdInfo['pm_status'] == 1)
                    {
                    	//引用模板文件
                    	$view->assign('user', $userData); //用户信息
                    	$view->assign('setpwd', '您的密码当前为初始状态，请修改密码后再登陆'); //强制要求修改密码
						$view->display('login.tpl');
						exit(0); //结束
                    }
                    
                    //判断密码是否已过期
					
					//0表示上个月的最后一天
				    $last_month_time = mktime(0, 0, 0, date('n'), 0, date('Y'));
				    //上个月的总天数
				    $last_month_days = date('t', $last_month_time);
				    
				    //今天
   					$c = date('j');
   					
   					if ($last_month_days > $c)
   					{
   						$last_month_days = $c;
   					}
    				
    				//上月时间点
					$lastMonthDay = mktime(date('H'), date('i'), date('s'), date('m') - $config['pwd_age'], $last_month_days, date( 'Y'));
					
                    if ($userPwdInfo['pm_lastpwdtime'] < $lastMonthDay)
                    {
                    	$view->assign('setpwd', '您的密码已过期，请修改密码后再登陆'); //强制要求修改密码
						$view->display('login.tpl');
						exit(0); //结束
                    }
					
					//密码正确,写入session
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
				    
					//成功登陆
				    header('location: ' . $config['site_url'] . '/index/start');
				    
				    //删除session数据库历史数据
					$currectHour = date('H', time());
					if ((int)$currectHour > 12 )
					{
						$day_s = mktime(0, 0, 0, date("m", strtotime("-3 day")), date("d", strtotime("-3 day")), date("Y", strtotime("-3 day")));
			
						$db->delete(TABLE_QNSOFT_SESSION, "time < " . $day_s);
			    	}
                    exit(0); //成功登陆,结束
			    }
			    else
			    {
			    	//密码不正确
			    	$userPwdInfo = $this->errorPwd($userPwdInfo);
    		    	$view->assign('alert', '用户名或密码错误！！您还有 ' . ($config['pwd_checkerrortimes'] - $userPwdInfo['pm_errorpwdcount']) . ' 次机会!');
			    }
            }
    	}
    	
		//引用模板文件
		$view->assign('ip', $_SERVER['REMOTE_ADDR']);
		$view->display('login.tpl');
    }
    
    //处理错误密码
    private function errorPwd($userPwdInfo)
    {
    	$config = Zend_Registry::get('config');
    	$db = Zend_Registry::get('dbAdapter');
    	
    	$up_ary = array(
			'pm_sessionid' => Zend_Registry::get('sessionId')		
    	);
    	
    	if ($config['pwd_checkerrorperiod'] <= 0) //使用session判断
    	{
    		if ($userPwdInfo['pm_sessionid'] == Zend_Registry::get('sessionId'))
    		{
    			//同一个session
    			$userPwdInfo['pm_errorpwdcount']++;
    			$up_ary['pm_errorpwdcount'] = $userPwdInfo['pm_errorpwdcount'];
    		}
    		else
    		{
    			//不同session
    			$userPwdInfo['pm_errorpwdcount'] = 1;
    			$up_ary['pm_errorpwdcount'] = $userPwdInfo['pm_errorpwdcount'];
    			$up_ary['pm_errorpwdtime'] = time(); //最后错误时间
    		}
    	}
    	else
    	{
    		if($userPwdInfo['pm_errorpwdtime'] >= (time() - ($config['pwd_checkerrorperiod'] * 60)))
    		{
    			//在计算错误时间内
    			$userPwdInfo['pm_errorpwdcount']++;
    			
    			//更新密码管理信息表
		    	$up_ary['pm_errorpwdcount'] = $userPwdInfo['pm_errorpwdcount'];	
    		}
    		else
    		{
    			//不在计算错误时间内
    			$userPwdInfo['pm_errorpwdcount'] = 1;
    			$up_ary['pm_errorpwdcount'] = $userPwdInfo['pm_errorpwdcount'];
    			$up_ary['pm_errorpwdtime'] = time(); //最后错误时间
    		}		
    	}
    	$where = $db->quoteInto('pm_id = ?', $userPwdInfo['pm_id']);
		$db->update('qnsoft_pwdmanage', $up_ary, $where);
    	
    	if ($userPwdInfo['pm_errorpwdcount'] >= $config['pwd_checkerrortimes'])
    	{
    		//已错误 3 次 锁定坐席
    		$this->lockPwd($userPwdInfo);
    	}
    	
    	return $userPwdInfo;
    }
    
    //锁定坐席
    private function lockPwd($userPwdInfo)
	{
		$config = Zend_Registry::get('config');
    	$db = Zend_Registry::get('dbAdapter');
    	
		//更新密码管理信息表
    	$up_ary = array(
			'pm_status' => 3, //锁定坐席		
    	);
		$where = $db->quoteInto('pm_workid = ?', $userPwdInfo['pm_workid']);
		$db->update('qnsoft_pwdmanage', $up_ary, $where);
		
		//更新用户密码
		$up_ary = array(
			'uflag' => 1
		);

		$where = $db->quoteInto('workid = ?', $userPwdInfo['pm_workid']);
		$db->update($userPwdInfo['pm_enterprisecode'] . '_' . TABLE_QNSOFT_USER, $up_ary, $where);
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
		
		//删除session数据库历史数据
		$currectHour = date('H', time());
		if ((int)$currectHour > 12 )
		{
			$day_s = mktime(0, 0, 0, date("m", strtotime("-3 day")), date("d", strtotime("-3 day")), date("Y", strtotime("-3 day")));

			$db->delete(TABLE_QNSOFT_SESSION, "time < " . $day_s);
    	}
    	
		header('location: ' . $config['site_url']);
    }
    
    //修改密码
    public function resetpasswordAction()
    {
    	$view =Zend_Registry::get('view');
    	$config = Zend_Registry::get('config');
    	$db = Zend_Registry::get('dbAdapter');	
    	
    	$oldpasspwrod = $this->_getParam('oldpasspwrod', '');
    	$newpasspwrod = $this->_getParam('newpasspwrod', '');
    	$newpasspwrod2 = $this->_getParam('newpasspwrod', '');
    	$userid = $this->_getParam('userid', '');
    	$workid = $this->_getParam('workid', '');
    	
    	//不是从登陆跳转过来的
    	if (!isset($_SESSION['fid']))
    	{
    		$view->display('login.tpl');
    		exit(0);
    	}
    	//得到 租户信息
    	$select = $db->select();
        $select->from(TABLE_QNSOFT_FACTORY, '*');
        $select->where('factory_id = ' . $_SESSION['fid']);
        $select->where('deleteflag = 0'); //未删除

        $fdata = $db->fetchRow($select);
        
        //得到用户信息
        $select = $db->select();
        $select->from($fdata['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USER, '*');
        $select->where('workid = ' . $workid . '');
        $select->where('deleteflag = 0'); //未删除

        $userData = $db->fetchRow($select);
        
        //获取用户信息失败
        if (!$userData)
        {
        	$view->assign('alert', '获取用户信息失败，请重新登陆！！'); 
        	$view->display('login.tpl');
        	exit(0);	
        }
        
        if ($userData['password'] === strtoupper(md5($oldpasspwrod)))
	    {
	    	//密码正确
	    	//更新密码管理信息表
	    	$up_ary = array(
				'pm_status' => 2, //初始状态
				'pm_lastpwdtime' => time(),
				'pm_sessionid' => Zend_Registry::get('sessionId')		
	    	);
			$where = $db->quoteInto('pm_workid = ?', $workid);
			$db->update('qnsoft_pwdmanage', $up_ary, $where);
			
			//更新用户密码
			$up_ary = array(
				'pwdplaintext' => $newpasspwrod,
				'password' => strtoupper(md5($newpasspwrod))
			);

			$where = $db->quoteInto('uid = ?', $userid);
			$db->update($fdata['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USER, $up_ary, $where);
			
			//成功登陆
			//echo '<script>alert("修改密码成功，请使用新密码重新登陆坐席!");</script>';
			//header('location: ' . $config['site_url'] . '/access/login');
			$view->assign('alert', '<span style="color:#00ff00;">修改密码成功，请使用新密码重新登陆坐席!</span>'); 
			$view->display('login.tpl');
	    }
	    else
	    {
	    	//密码错误
	    	
	    	//查看密码管理表
    		$select = $db->select();
            $select->from('qnsoft_pwdmanage', '*');
            $select->where('pm_workid = ? ', $userData['workid']);

            $userPwdInfo = $db->fetchRow($select);
            
	    	$userPwdInfo = $this->errorPwd($userPwdInfo); 
	    	$view->assign('alert', '用户名或密码错误！！您还有 ' . ($config['pwd_checkerrortimes'] - $userPwdInfo['pm_errorpwdcount']) . ' 次机会!');
	    	$view->assign('user', $userData); //用户信息
            $view->assign('setpwd', 'setpwd'); //强制要求修改密码
        	$view->display('login.tpl');
	    	
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
