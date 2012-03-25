<?php
/** 
 * Zend_Controller_Action 
 * 用户管理
 */

class QnuserrenterController extends Zend_Controller_Action_Qn
{    
	public function init()
    {
    	Zend_Controller_Action_Qn::init();
    }
    
	/**
     * add
     */
    public function addAction()
    {
    	$view = Zend_Registry::get('view');
    	$user = Zend_Registry::get('user');
		$db = Zend_Registry::get('dbAdapter');
		$config = Zend_Registry::get('config');
		$id = $this->_getParam('id'); //厂商ID，如果有
    	
		
        $select = $db->select();
        $select->from(TABLE_QNSOFT_PHONE, '*');
        $select->where('factory_id = ' . $config['factory_id']);
        $select->order('phone_num');
        $select->where('deleteflag = 0'); //未删除
        $phonelist = $db->fetchAll($select);
        
        $select = $db->select();
        $select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_SKILL, '*');
        $select->where('factory_id = ' . $config['factory_id']);
        $select->where('deleteflag = 0'); //未删除

        $skilllist = $db->fetchAll($select);

		$view->assign('id', $id);
        $view->assign('phonelist', $phonelist);   
        $view->assign('skilllist', $skilllist);

    	$view->display('renter/useradd.tpl');
    }

	public function adddoAction()
    {              
		$view = Zend_Registry::get('view');
    	$user = Zend_Registry::get('user');
		$db = Zend_Registry::get('dbAdapter');
		$config = Zend_Registry::get('config');

		$username = $this->_getParam('username');
		$role = $this->_getParam('role');
		$nickname = $this->_getParam('nickname');
		$factory_id = $config['factory_id'];
		$agentid = $this->_getParam('agentid');
		$pwdplaintext = $this->_getParam('pwdplaintext');
		$fakecalling = $this->_getParam('fakecalling'); //显示分机号
        $plain = $this->_getParam('plain');
        $plain_pwd = $this->_getParam('plain_pwd');  // 平台密码
        $basemodelid = $this->_getParam('basemodelid'); //用于设置基础平台配制文件

		$skillarray = $this->_getParam('skillarray');

		if ($username)
		{
			$in_ary = array(
					'username' => $username,
					'workid' => $username,
					'role' => $role,
					'nickname' => $nickname,
					'factory_id' => $factory_id,
					'agentid' => $agentid,
                    'plain' =>$plain,
					'pwdplaintext' => $pwdplaintext,
					'password' => strtoupper(md5($pwdplaintext)),
                    'plain_pwd' => $plain_pwd,  
                    'plain_pwdmd5' => strtoupper(md5($plain_pwd)),
                    'fakecalling' => $fakecalling,
                    'basemodelid' => $basemodelid
				);
            try
            {
			    $db->insert($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USER, $in_ary);
            }
            catch(Exception $e)
            {
                //返回到新增页面
                $id = $this->_getParam('id'); //厂商ID，如果有
        
                
                $select = $db->select();
                $select->from(TABLE_QNSOFT_PHONE, '*');
                $select->where('factory_id = ' . $config['factory_id']);
                $select->where('deleteflag = 0'); //未删除
                $phonelist = $db->fetchAll($select);
                
                $select = $db->select();
                $select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_SKILL, '*');
                $select->where('factory_id = ' . $config['factory_id']);
                $select->where('deleteflag = 0'); //未删除

                $skilllist = $db->fetchAll($select);

                $view->assign('id', $id);
                $view->assign('phonelist', $phonelist);   
                $view->assign('skilllist', $skilllist);

        
                $_POST['errmsg'] = '您输入的信息不正确，请重新输入';
                $view->assign('post', $_POST);  
                $view->display('renter/useradd.tpl'); 
                exit(0);
            }
			//用户信息
			$select = $db->select();
			$select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USER, '*');
			$select->where('workid = ?', $username);
			$select->where('factory_id = ?', $factory_id);
			$select->where('deleteflag = 0'); //未删除
			$userData = $db->fetchRow($select);

            if ($skillarray)
            {
			    foreach($skillarray as $skillId)
			    {
				    $in_ary = array(
								    'user_id' => $userData['uid'],
								    'user_name' => $userData['nickname'],
								    'skill_id' => $skillId,
								    'factory_id' => $factory_id
							    );

                    $db->insert($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USERSKILLGROUP, $in_ary);

			    }
            }
            
            //header('location: ' . $config['site_url'] . '/qnuser/list');
            $this->msg("新增用户成功", "/qnuserrenter/add"); 
		}
        else
        {
            $_POST['errmsg'] = '您输入的信息不正确，请重新输入';
            $view->assign('post', $_POST);  
            $view->display('renter/useradd.tpl'); 
            exit(0);
        }
		
    }

	public function showAction()
    {
		$view = Zend_Registry::get('view');
    	$user = Zend_Registry::get('user');
		$db = Zend_Registry::get('dbAdapter');
		$config = Zend_Registry::get('config');
		$id = $this->_getParam('id');
		
		if ($id > 0)
		{
			//用户信息
			$select = $db->select();
			$select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USER, '*');
			$select->where('uid = ?', $id);
			$select->where('deleteflag = 0'); //未删除
			$Data = $db->fetchRow($select);
			$view->assign('userData', $Data);
				
			if ($Data)
			{
				//公司信息
				$select = $db->select();
				$select->from(TABLE_QNSOFT_FACTORY, '*');
				$select->where("factory_id = ?", $Data['factory_id']);
				$select->where('deleteflag = 0'); //未删除
				$factoryData = $db->fetchRow($select);
				$view->assign('factoryData', $factoryData);

				//技能信息
				$select = $db->select();
				$select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USERSKILLGROUP . ' as u', '*');
				$select->join($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_SKILL . ' as s', 'u.skill_id = s.skill_id', 's.skill_name');//多表联合查询
				$select->where("u.user_id = ?", $Data['uid']);
				$select->where("u.factory_id = ?", $Data['factory_id']);
				$select->where('u.deleteflag = 0'); //未删除

				$skillsData = $db->fetchAll($select);
				$view->assign('skillsData', $skillsData);
			}
		}

    	$view->display('renter/userview.tpl');
	}

	public function listAction()
	{
        $per_page_num = 15; //每页15
        
		$view = Zend_Registry::get('view');
    	$user = Zend_Registry::get('user');
		$db = Zend_Registry::get('dbAdapter');
		$config = Zend_Registry::get('config');
		
		$workid =  $this->_getParam('workid');
		$username =  $this->_getParam('username');
		$skillid =  $this->_getParam('skillid');
        
        //技能组
        $select = $db->select();
        $select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_SKILL, '*');
        $select->order('skill_id');
        $select->where('deleteflag = 0'); //未删除
        $skills = $db->fetchAll($select);
        $view->assign('skills', $skills);
        
        
        //分页
        $page =  $this->_getParam('page', 1);
        $select = $db->select();
        $select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USER . ' as u', 'count(*)');
        $select->join($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USERSKILLGROUP . ' as s', 'u.uid = s.user_id', '');//多表联合查询

        $select->order('u.workid');
        $select->where('u.utype > 0');//非系统用户
        $select->where('u.deleteflag = 0'); //未删除
        
        if ($workid) 
        {
        	//$select->where('u.workid = ?', $workid);
        	$select->where("u.workid like '%" . $workid . "%'");
        }
        if ($username) 
        {
        	$select->where("u.nickname like '%" . $username . "%'");
        }
        if ($skillid && $skillid != "all") 
        {
        	$select->where('s.skill_id = ?', $skillid);
        }

        $sum = $db->fetchOne($select);
        
    	
    	//用户列表数据
		$select = $db->select();
		$select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USER . ' as u', '*');
		$select->join($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USERSKILLGROUP . ' as s', 'u.uid = s.user_id', '');//多表联合查询
		$select->order('u.workid');
        $select->where('u.utype > 0');//非系统用户
        $select->where('u.deleteflag = 0'); //未删除
		
		if ($workid) 
        {
        	//$select->where('workid = ?', $workid);
        	$select->where("u.workid like '%" . $workid . "%'");
        }
        if ($username) 
        {
        	$select->where("nickname like '%" . $username . "%'");
        }
        if ($skillid && $skillid != "all") 
        {
        	$select->where('s.skill_id = ?', $skillid);
        }
        
        $select->limitPage($page, $per_page_num); 
		$select->order("u.workid");
		$listDataTmp = $db->fetchAll($select);

		$listData = array();
		foreach($listDataTmp as $node)
		{
			$node['factory_name'] = $config['factory_name'];
			$node['role_txt'] = $node['role'] == 1 ? "班长座席" : "普通座席";
            
            //技能信息
            $select = $db->select();
            $select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USERSKILLGROUP . ' as u', '*');
            $select->join($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_SKILL . ' as s', 'u.skill_id = s.skill_id', 's.skill_name');//多表联合查询
            $select->where("u.user_id = ?", $node['uid']);
            $select->where("u.factory_id = ?", $node['factory_id']);
            $select->where('u.deleteflag = 0'); //未删除

            $tmp = $db->fetchAll($select); 
            $str = "";
            foreach($tmp as $nodetmp)
            {
                $str = $str . $nodetmp['skill_name'];
                $str = $str . ' ';
            }
            $node['skills'] = $str; 

			$listData[] = $node;
		}

		$view->assign('list', $listData);
        
        //分页 
        $url_start = $config['site_url'] . '/qnuserrenter/list';

        if ($workid) 
        {
        	$url_start .= '/workid/';
        	$url_start .= $workid;
        	$view->assign('workid', $workid);
        }
        if ($username) 
        {
        	$url_start .= '/username/';
        	$url_start .= $username;
        	$view->assign('username', $username);
        }
        if ($skillid && $skillid != "all") 
        {
        	$url_start .= '/skillid/';
        	$url_start .= $skillid;
        	$view->assign('skillid', $skillid);

        }
        $url_start .= '/';
        

        $page_arr = array(
            'url_start' => $url_start,
            'cur_page' => $page, 
            'total_item' => $sum, //总记录条数
            'per_page_num' => $per_page_num,  //每页记录数
            'cur_item_str' => '',   //当前页多少条，如果为空表示不要此项 
        );
        $pager_class = new pager_str($page_arr);

        $page_str = $pager_class->page_str; //分页内容
        $page = $pager_class->get_cur_page(); //得到当前页码
        $view->assign('page_str', $page_str);
        $view->assign('page', $page);
        //分页　end
        

    	$view->display('renter/userlist.tpl');
	}


	/**
	 * 编辑
	 */
	public function editAction()
	{
		$view = Zend_Registry::get('view');
    	$user = Zend_Registry::get('user');
		$db = Zend_Registry::get('dbAdapter');
		$config = Zend_Registry::get('config');
    	$id = $this->_getParam('id');
		$submit = $this->_getParam('submit');
		
		if (!$submit)
		{
			if ($id > 0)
			{
				//用户信息
				$select = $db->select();
				$select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USER, '*');
				$select->where('uid = ?', $id);
				$select->where('deleteflag = 0'); //未删除
				$Data = $db->fetchRow($select);
				$view->assign('userData', $Data);
				if ($Data)
				{
					//公司信息
					$select = $db->select();
					$select->from(TABLE_QNSOFT_FACTORY, '*');
					$select->where("factory_id = ?", $Data['factory_id']);
					$select->where('deleteflag = 0'); //未删除
					$factoryData = $db->fetchRow($select);
					$view->assign('factoryData', $factoryData);

					//分机信息
					$select = $db->select();
					$select->from(TABLE_QNSOFT_PHONE, '*');
					$select->where("factory_id = ?", $Data['factory_id']);
					$select->where('deleteflag = 0'); //未删除
					$phoneData = $db->fetchAll($select);
					$view->assign('phoneData', $phoneData);

					//技能信息
					$select = $db->select();
					$select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_SKILL, '*');
					$select->where("factory_id = ?", $Data['factory_id']);
					$select->where('deleteflag = 0'); //未删除
					$skillsDataTmp = $db->fetchAll($select);

					$skillsData = array();
					foreach($skillsDataTmp as $cell)
					{
						$select = $db->select();
						$select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USERSKILLGROUP, '*');
						$select->where("user_id = ?", $Data['uid']);
						$select->where("skill_id = ?", $cell['skill_id']);
						$select->where('deleteflag = 0'); //未删除 
                        
						$temp = $db->fetchAll($select);
						if ($temp)
						{
							$cell['checked'] = 'checked';
						}
						else
						{
							$cell['checked'] = '';
						}
						$skillsData[] = $cell;
					}
					$view->assign('skillsData', $skillsData);
				}
			}

			$view->display('renter/useredit.tpl');
		}
		else
		{
			$role = $this->_getParam('role');
			$nickname = $this->_getParam('nickname');
			$factory_id = $this->_getParam('factoryid');
			$pwdplaintext = $this->_getParam('pwdplaintext');
            $plain = $this->_getParam('plain');
            $plain_pwd = $this->_getParam('plain_pwd');
            $basemodelid = $this->_getParam('basemodelid');

			$skillarray = $this->_getParam('skillarray');

			if ($nickname)
			{
				$up_ary = array(
						'role' => $role,
						'nickname' => $nickname,
                        'plain' => $plain,
						'pwdplaintext' => $pwdplaintext,
						'password' => strtoupper(md5($pwdplaintext)),
                        'plain_pwd' => $plain_pwd,  
                        'plain_pwdmd5' => strtoupper(md5($plain_pwd)),
					);

					$where = $db->quoteInto('uid = ?', $id);
					$db->update($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USER, $up_ary, $where);

				//技能
				$up_ary = array(
						'deleteflag' => 1
					);
				$where = array('user_id' => $id, 'factory_id' => $factory_id);
				$db->update($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USERSKILLGROUP, $up_ary, "user_id = " . $id . " and factory_id = " . $factory_id);
	
                if ($skillarray)
                {
				    foreach($skillarray as $cell)
				    {       
					    //判断关系是否存在
					    $select = $db->select();
					    $select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USERSKILLGROUP, '*');
					    $select->where("user_id = ?", $id);
					    $select->where("skill_id = ?", $cell);
					    $temp = $db->fetchAll($select);
					    
					    if ($temp)
					    {
						    //存在，使生效
						    $up_ary = array(
								    'deleteflag' => 0
							    );
						    //$where = $db->quoteInto('user_id = ' . $id ' and skill_id = ' . $cell['skill_id']);
						    $where = array('user_id' => $id, 'skill_id' => $cell);
						    $db->update($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USERSKILLGROUP, $up_ary, "user_id = " . $id . " and skill_id = " . $cell);
					    }
					    else
					    {
						    //不存在,新增
						    $in_ary = array(
									    'user_id' => $id,
									    'user_name' => $nickname,
									    'skill_id' => $cell,
									    'factory_id' => $factory_id
								    );
						    $db->insert($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USERSKILLGROUP, $in_ary);
					    }	
				    }//foreach
                }
			}

			header('location: ' . $config['site_url'] . '/qnuserrenter/show/id/' . $id);
		}
	}

	public function delAction()
	{
		$config = Zend_Registry::get('config');

		$id =  $this->_getParam('id');
		$db = Zend_Registry::get('dbAdapter');

		$up_ary = array(
						'deleteflag' => 1
					);


		$where = $db->quoteInto('uid = ?', $id);
		$db->update($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USER, $up_ary, $where);
		header('location: ' . $config['site_url'] . '/qnuserrenter/list');
	}

    public function resetpwdAction()
    {
    	$config = Zend_Registry::get('config');
    	
    	$page =  $this->_getParam('page', 1);//分页

		$id =  $this->_getParam('id');
		$db = Zend_Registry::get('dbAdapter');

		$up_ary = array(
						'pwdplaintext' => "000000",
						'password' => strtoupper(md5("000000")),
					);


		$where = $db->quoteInto('uid = ?', $id);
		$db->update($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USER, $up_ary, $where);
		header('location: ' . $config['site_url'] . '/qnuserrenter/list/page/' . $page);
    }
    
    /**
    * 冻结
    * 
    */
    public function lockAction()
    {
        $config = Zend_Registry::get('config');

        $id =  $this->_getParam('id');
        $db = Zend_Registry::get('dbAdapter');

        $up_ary = array(
                        'uflag' => 1
                    );


        $where = $db->quoteInto('uid = ?', $id);
        $db->update($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USER, $up_ary, $where);
        header('location: ' . $config['site_url'] . '/qnuserrenter/list');
    }
    
    public function unlockAction()
    {
        $config = Zend_Registry::get('config');

        $id =  $this->_getParam('id');
        $db = Zend_Registry::get('dbAdapter');

        $up_ary = array(
                        'uflag' => 0
                    );


        $where = $db->quoteInto('uid = ?', $id);
        $db->update($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USER, $up_ary, $where);
        header('location: ' . $config['site_url'] . '/qnuserrenter/list');
    }
    
	public function setagentAction()
	{
		$view = Zend_Registry::get('view');
    	$user = Zend_Registry::get('user');
		$db = Zend_Registry::get('dbAdapter');
		$config = Zend_Registry::get('config');
    	$id = $user['uid'];
		$submit = $this->_getParam('submit');
		
		//用户信息
		$select = $db->select();
		$select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USER, '*');
		$select->where('uid = ?', $id);
		$select->where('deleteflag = 0'); //未删除
		$Data = $db->fetchRow($select);
		
		if (!$submit)
		{
			if ($id > 0)
			{
				$view->assign('userData', $Data);
			}

			$view->display('renter/setagent.tpl');
		}
		else
		{
			$nickname = $this->_getParam('nickname');
			$mobilephone = $this->_getParam('mobilephone');
			$password = $this->_getParam('password', "");
			$newpassword = $this->_getParam('newpassword');
            $newpassword2 = $this->_getParam('newpassword2');

			if (!$nickname) //用户名为空
			{
				$view->assign('userData', $Data);
				$view->assign('msg', "用户名不能为空");
				$view->display('renter/setagent.tpl');
				
				exit(0);
			}
			
			$up_ary = array(
					'nickname' => $nickname,
                    'mobilephone' => $mobilephone
				);
			
			if ($password != "") //修改密码
			{
				if ($password != $user['pwdplaintext'])
				{
					$Data['nickname'] = $nickname;
					$Data['mobilephone'] = $mobilephone;
					
					$view->assign('userData', $Data);
					$view->assign('msg', "您输入的原密码不正确，请重新输入！");	
					$view->display('renter/setagent.tpl');
					exit(0);
				}
				
				if ($newpassword != $newpassword2)//两次密码不一致
				{					
					$Data['nickname'] = $nickname;
					$Data['mobilephone'] = $mobilephone;
					
					$view->assign('userData', $Data);
					$view->assign('msg', "两次密码输入不一致，请重新输入！");	
					$view->display('renter/setagent.tpl');
					exit(0);
				}
				
				if ($newpassword == "")//密码为空
				{
					$Data['nickname'] = $nickname;
					$Data['mobilephone'] = $mobilephone;
					
					$view->assign('userData', $Data);
					$view->assign('msg', "新密码不能为空，请重新输入！");	
					$view->display('renter/setagent.tpl');
					exit(0);
				}
				
				$up_ary['pwdplaintext'] = $newpassword;
				$up_ary['password'] = strtoupper(md5($newpassword));
			}

			$where = $db->quoteInto('uid = ?', $id);
			$db->update($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USER, $up_ary, $where);

			header('location: ' . $config['site_url'] . '/qnuserrenter/setagent/');
		}
	}
    /**
     * 
     */
    public function indexAction()
    {
    	$view = Zend_Registry::get('view');
    	$user = Zend_Registry::get('user');
		$config = Zend_Registry::get('config');
		
    	$view->display('admin.tpl');
    }
     
	 public function jsonlistAction()
	{
		$user = Zend_Registry::get('user');
		$db = Zend_Registry::get('dbAdapter');
		$config = Zend_Registry::get('config');
		$factoryid = $this->_getParam('factoryid');

		if ($factoryid > 0)
		{
			$select = $db->select();
			$select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USER, '*');
			$select->where("factory_id = ?" , $factoryid);
			$select->where('deleteflag = 0'); //未删除
			$listData = $db->fetchAll($select);
			$json = Zend_Json::encode($listData);
			echo $json;
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
}
?>
