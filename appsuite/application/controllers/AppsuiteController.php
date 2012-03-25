<?php
/** Zend_Controller_Action */

class AppsuiteController extends Zend_Controller_Action_Qn
{    
	public function init()
    {
    	Zend_Controller_Action_Qn::init();
    }
    
    public function indexAction()
    {
			$view = Zend_Registry::get('view');
			$view->display('startclient.tpl');
    }
    
    public function heartbeatAction()
    {
    }
    
    public function checkmaxAction()
    {
    	$user = Zend_Registry::get('user');
    	$view = Zend_Registry::get('view');
		$db = Zend_Registry::get('dbAdapter');
        $config = Zend_Registry::get('config'); 
         
        $skillcode =  $this->_getParam('skillcode');   

        $select = $db->select();
        $select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_SKILL, '*');
        $select->where('factory_id = ' . $user['factory_id']);
        $select->where('skill_code = ' . $skillcode); //未删除

        $skillInfo = $db->fetchRow($select);        
        
        $select = $db->select();
        $select->from('OPERATOR_CONFIG', '*');
        $select->where('OC_SKILLID = ?', $skillcode); //未删除
        $confInfo = $db->fetchRow($select);
        
        
        $data = array();
        if ($skillInfo['current_other'] < $confInfo['OC_CLICKETVALUE'])
        {
        	$data[] = "OK";	
        }
        else
        {
        	$data[] = "ON";
        }
        
        $data[] = $skillcode;
        $data[] = $skillInfo['current_other'];
        $data[] = $confInfo['OC_CLICKETVALUE'];
        $json = Zend_Json::encode($data);
		echo $json;
    }
    
    public function clientAction()
    {
		$user = Zend_Registry::get('user');
    	$view = Zend_Registry::get('view');
		$db = Zend_Registry::get('dbAdapter');
        $config = Zend_Registry::get('config'); 

        //初始化脚本信息
		$script = array();
		
		//公司脚本
		$selectAll = $db->select();
		$selectAll->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_SCRIPTDB, '*');
		$selectAll->where('ugroup = 2');
		$selectAll->where('deleteflag = 0'); //未删除	
		$scriptTmpAll = $db->fetchAll($selectAll);

		foreach($scriptTmpAll as $key => $value)
		{
			$value['scriptdb_info'] = str_replace("\r\n", "[[return]]", $value['scriptdb_info']);
			$value['scriptdb_info'] = str_replace("&", "[[and]]", $value['scriptdb_info']);
            $value['scriptdb_info'] = str_replace("<", "[[angularL]]", $value['scriptdb_info']); 
            $value['scriptdb_info'] = str_replace(">", "[[angularR]]", $value['scriptdb_info']); 
			$script[] = $value;
		}
		
		//坐席脚本
		
		$select = $db->select();
		
		$select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_SCRIPTDB, '*');
		$select->where('user_id = ' . $user['uid']);
		$select->where('deleteflag = 0'); //未删除
		$scriptTmp = $db->fetchAll($select);
		
		foreach($scriptTmp as $key => $value)
		{
			//$value['scriptdb_info'] = stripslashes($value['scriptdb_info']);
			$value['scriptdb_info'] = str_replace("\r\n", "[[return]]", $value['scriptdb_info']);
			$value['scriptdb_info'] = str_replace("&", "[[and]]", $value['scriptdb_info']);
            $value['scriptdb_info'] = str_replace("<", "[[angularL]]", $value['scriptdb_info']); 
            $value['scriptdb_info'] = str_replace(">", "[[angularR]]", $value['scriptdb_info']); 
			$script[] = $value;
		}
        
        //用户列表
        $select = $db->select();
        $select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USER, array('uid', 'workid', 'role', 'nickname', 'plain'));
        $select->where('uid = ' . $user['uid']); 
        $select->where('deleteflag = 0'); //未删除
        $selfTmp = $db->fetchRow($select); 
        
        
        $select = $db->select();
        $select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USER, array('uid', 'workid', 'role', 'nickname', 'plain'));
        $select->where('factory_id = ' . $user['factory_id']); 
        $select->where('role = 1'); //班长座席
        $select->where('deleteflag = 0'); //未删除
        $select->limit(30);

        $agentListTmp = $db->fetchAll($select); 
        $agentListTmp[] = $selfTmp;
        
        $agentList = array();
        foreach($agentListTmp as $value)
        {
            //角色
            if ($value['role'] == 1)
            {
                $value['rolename'] = "班长座席";
            }
            else
            {
                $value['rolename'] = "普通座席";
            }
            
            //技能
            $select = $db->select();
            $select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USERSKILLGROUP . ' as u', '*');
            $select->where("u.user_id = ?", $value['uid']);
            $select->where('u.deleteflag = 0'); //未删除 
            $select->join($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_SKILL . ' as s', 'u.skill_id = s.skill_id', '*');//多表联合查询
            $tmp = $db->fetchAll($select);

            $str = "";
            foreach($tmp as $node)
            {
                $str = $str . $node['skill_name'];
                $str = $str . ' ';
            }
            $value['skills'] = $str;
            
            $agentList[] = $value;
            
            if ($value['uid'] == $user['uid'])
            {
                $user['skills'] = $str;
            }
        }
        $view->assign('agentList', $agentList);
        
        //分机号问题
        /*
        $select = $db->select();
        $select->from(TABLE_QNSOFT_PHONE, '*');
        $select->where('phone_num = ' . $user['DN']);
        $phoneInfo = $db->fetchRow($select);
        if ($phoneInfo['phone_status'] != 0)  //已经被使用
        {
            $select = $db->select();
            $select->from(TABLE_QNSOFT_PHONE, '*');
            $select->where('phone_status = 0');
            
            $newPhoneInfo = $db->fetchRow($select);
            if ($newPhoneInfo)   //有空分机
            {
                $user['DN'] = $newPhoneInfo['phone_num']; 
                
                $up_ary = array(
                    'phone_status' => $user['workid']
                );
                $where = $db->quoteInto('phone_id = ?', $newPhoneInfo['phone_id']);
                $db->update(TABLE_QNSOFT_PHONE, $up_ary, $where);
                
            }
            else   //决有空分机
            {
                $user['DN'] = 0; 
            }
        }
        */
        
        // 技能组
        $select = $db->select();
        $select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_SKILL, '*');
        $select->where('factory_id = ' . $user['factory_id']);
        $select->where('deleteflag = 0'); //未删除
        $skillList = $db->fetchAll($select);
        $view->assign('skillList', $skillList); 
        
        //技能
        $select = $db->select();
        $select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USERSKILLGROUP . ' as u', '*');
        $select->where("u.user_id = ?", $user['uid']);
        $select->where('u.deleteflag = 0'); //未删除 
        $select->join($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_SKILL . ' as s', 'u.skill_id = s.skill_id', '*');//多表联合查询
        $userSkill = $db->fetchAll($select);
        
        $user['skillinternationflag'] = 0;
        foreach($userSkill as $skill)
        {
            if ($skill['skill_code'] == 9 || $skill['skill_code'] == 17)
            {
                $user['skillinternationflag'] = 1;
            }
            else if ($skill['skill_code'] == 4 || $skill['skill_code'] == 14 || $skill['skill_code'] == 16)   //公众机票前台  || 国际机票前台
            {
                $user['skillinternationflag'] = 2;
            }
            $view->assign('fakecalling', $skill['fakecalling']); 
            $view->assign('skillcode', $skill['skill_code']);   
        }
        
        //厂商
        $select = $db->select();
        $select->from(TABLE_QNSOFT_FACTORY, '*');
        $select->where('factory_id = ' . $user['factory_id']);
        $select->where('deleteflag = 0'); //未删除
        $factoryInfo = $db->fetchRow($select);
        
        //自定义按键 — 100     userdef_button
        $select = $db->select();
        $select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_BUTTON, '*');
        $select->where('button_group = 100');
        $select->where('deleteflag = 0'); //未删除
        $userdef_button100 = $db->fetchAll($select); 
        $view->assign('userdefButton100', $userdef_button100);
        
        //自定义按键 — 101    userdef_button
        $select = $db->select();
        $select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_BUTTON, '*');
        $select->where('button_group = 101');
        $select->where('deleteflag = 0'); //未删除
        $userdef_button101 = $db->fetchAll($select); 
        $view->assign('userdefButton101', $userdef_button101);
        
        
        //测试用，要删除的
        if ($skill['skill_code'] == 16 || $skill['skill_code'] == 17)
        {
            //自定义按键 — 102    userdef_button
            $select = $db->select();
            $select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_BUTTON, '*');
            $select->where('button_group = 102');
            $select->where('deleteflag = 0'); //未删除
            $userdef_button101 = $db->fetchAll($select); 
            $view->assign('userdefButton101', $userdef_button101);
        }
         //测试用，要删除的 end
         
        //自定义按键 — 话路转接
        $select = $db->select();
        $select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_BUTTON, '*');
        $select->where('button_group = ' . $skill['skill_code']);
        $select->where('deleteflag = 0'); //未删除
        $userdef_buttonex = $db->fetchAll($select); 
        $view->assign('userdefButtonex', $userdef_buttonex);

        $view->assign('factoryInfo', $factoryInfo);
        $view->assign('user', $user);
        $view->assign('script', $script);
        header('P3P: CP=CAO PSA OUR');
        
        //加载区号
        $select = $db->select();
        $select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_AREACODE, '*');
        $select->where('deleteflag = 0'); //未删除 
        $listData = $db->fetchAll($select);

        $json = Zend_Json::encode($listData);
        $view->assign('areajson', $json);
        
        
        if ($factoryInfo)
        {
            if ($factoryInfo['factory_userdefined'] == 1)
            {
                //有定制
                $view->display($factoryInfo['factory_enterprisecode'] . '/client.tpl');     
            }
            else
            {
                //没定制
                $view->display('client.tpl');     
            }
        }
        
		
    }

    public function setAction()  
    {
        $user = Zend_Registry::get('user');
        $view = Zend_Registry::get('view');
        $db = Zend_Registry::get('dbAdapter');
        
        $view->display('test.tpl');  
    }
    
	public function testAction()
	{
        $user = Zend_Registry::get('user');
        $view = Zend_Registry::get('view');
        $db = Zend_Registry::get('dbAdapter');
        
        echo 'why';
        $view->display('test.tpl');
		//print_r($this->_getAllParams());
		//header('P3P: CP=CAO PSA OUR');
	//	echo "<h1>测试来电弹屏：主叫：" . $this->_getParam("calling") . "被叫：" . $this->_getParam("called") . " </h1>";
	}
	
	public function setclientAction()
	{
		$user = Zend_Registry::get('user');
    	$view = Zend_Registry::get('view');
		$db = Zend_Registry::get('dbAdapter');

		$id = $this->_getParam('id');
		$op = $this->_getParam('op');
		$value = $this->_getParam('value');

		if ($op == "autosignin")
		{
			$up_ary = array(
						'autosignin' => ($value == 'yes') ? 1 : 0
					);			
		}
		else if ($op == "initialready")
		{
			$up_ary = array(
						'initialready' => ($value == 'yes') ? 1 : 0
					);	
		}
		else if ($op == "autoanswer")
		{
			$up_ary = array(
						'autoanswer' => ($value == 'yes') ? 1 : 0
					);	
		}
		else if ($op == "agentautoenteridle")
		{
			$up_ary = array(
						'agentautoenteridle' => ($value == 'yes') ? 1 : 0
					);	
		}
		if ($up_ary)
		{
			$where = $db->quoteInto('uid = ?', $id);
			$db->update(TABLE_QNSOFT_USER, $up_ary, $where);
		}

		$view->assign('user', $user);
		$view->display('setclient.tpl');
	}
    
    public function getclientAction()
    {
        $user = Zend_Registry::get('user');
        $id = $this->_getParam('id');
        $db = Zend_Registry::get('dbAdapter');
        
        echo 'var c_autosignin = ' . $user['autosignin'] . ';';
         echo 'var c_role  = ' . $user['role'] . ';';  
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
