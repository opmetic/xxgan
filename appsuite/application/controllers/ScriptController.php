<?php
/** Zend_Controller_Action */

class ScriptController extends Zend_Controller_Action_Qn
{    
	public function init()
    {
    	Zend_Controller_Action_Qn::init();
    }
    

	public function listAction()
	{
		$view = Zend_Registry::get('view');
    	$user = Zend_Registry::get('user');
		$db = Zend_Registry::get('dbAdapter');
		$config = Zend_Registry::get('config');

		$factoryid = $this->_getParam('factoryid');
		$userid = $this->_getParam('userid');
		$submit = $this->_getParam('submit');

		$select = $db->select();
		$select->from(TABLE_QNSOFT_FACTORY , '*');
		$select->where('deleteflag = 0'); //未删除
		$listData = $db->fetchAll($select);

		
		$view->assign('id', $factoryid);
		$view->assign('list', $listData);

		if ($submit && $userid)
		{
			$select = $db->select();
			$select->from(TABLE_QNSOFT_USER, '*');
			$select->where('uid = ?', $userid);
			$select->where('deleteflag = 0'); //未删除
			$userData = $db->fetchRow($select);

			$view->assign('userData', $userData);

			//$userid
			$select = $db->select();
			$select->from(TABLE_QNSOFT_SCRIPTDB . ' as s', '*');
			$select->where('s.user_id = ?', $userid);
			$select->where('s.deleteflag = 0'); //未删除
			$select->join(TABLE_QNSOFT_USER . ' as u', 'u.uid = s.user_id', 'nickname');//多表联合查询
			$scriptData = $db->fetchAll($select);

			
			$view->assign('scriptlist', $scriptData);
		}

    	$view->display('scriptlist.tpl');
	}

	public function addAction()
	{
		global $qnsoft_script_type;
		$view = Zend_Registry::get('view');
    	$user = Zend_Registry::get('user');
		$db = Zend_Registry::get('dbAdapter');
		$config = Zend_Registry::get('config');

		$uid = $this->_getParam('id');
		

		if ($uid > 0)
		{
			$select = $db->select();
			$select->from(TABLE_QNSOFT_USER . ' as u', '*');
			$select->where('u.uid = ?', $uid);
			$select->where('u.deleteflag = 0'); //未删除
			$select->join(TABLE_QNSOFT_FACTORY . ' as f', 'u.factory_id = f.factory_id', 'factory_name');//多表联合查询
			$userData = $db->fetchRow($select);

			$view->assign('userData', $userData);
		}
		
		$view->assign('qnsoft_script_type', $qnsoft_script_type);
		$view->display('scriptadd.tpl');
	}

	public function adddoAction()
	{
		$view = Zend_Registry::get('view');
    	$user = Zend_Registry::get('user');
		$db = Zend_Registry::get('dbAdapter');
		$config = Zend_Registry::get('config');
		
		$uid = $this->_getParam('uid');
		$script_name = $this->_getParam('script_name');
		$flag = $this->_getParam('flag');
		$script_key_com = $this->_getParam('script_key_com');
		$script_key = $this->_getParam('script_key');
		$script_dsc = $this->_getParam('script_dsc');
		$script_info = $this->_getParam('script_info');
		$submit = $this->_getParam('submit');

        if ( !get_magic_quotes_gpc() )
        {
            $script_info = addslashes($script_info); 
        }
        
		if ($flag == 0)
		{
			$script_key = $script_key_com;
		}
		if ($submit && $uid && $script_key)
		{
			$in_ary = array(
					'scriptdb_name' => $script_name,
					'user_id' => $uid,
					'scriptdb_key' => $script_key,
					'scriptdb_info' => $script_info,
					'scriptdb_dsc' => $script_dsc,
					'flag' => $flag,
					'deleteflag' => 0
				);

			$db->insert(TABLE_QNSOFT_SCRIPTDB, $in_ary);
		}
		$view->display('scriptadd.tpl');
	}

	/**
	 *
	 */
	public function editAction()
	{
		$view = Zend_Registry::get('view');
    	$user = Zend_Registry::get('user');
		$db = Zend_Registry::get('dbAdapter');
		$config = Zend_Registry::get('config');

		$id =  $this->_getParam('id');
		$submit = $this->_getParam('submit');

		if ($submit && $id)
		{

			$script_name = $this->_getParam('script_name');
			$script_dsc = $this->_getParam('script_dsc');
			$script_info = $this->_getParam('script_info');

            if ( !get_magic_quotes_gpc() )
            {
                $script_info = addslashes($script_info); 
            }
        
			$in_ary = array(
				'scriptdb_name' => $script_name,
				'scriptdb_dsc' => $script_dsc,
				'scriptdb_info' => $script_info
			);


			$where = $db->quoteInto('scriptdb_id = ?', $id);
			$db->update(TABLE_QNSOFT_SCRIPTDB, $in_ary, $where);


			header('location: ' . $config['site_url'] . '/script/list');
		}
		else
		{
			$select = $db->select();
			$select->from(TABLE_QNSOFT_SCRIPTDB . ' as s', '*');
			$select->where('s.scriptdb_id = ?', $id);
			$select->where('s.deleteflag = 0'); //未删除
			$select->join(TABLE_QNSOFT_USER . ' as u', 'u.uid = s.user_id', 'nickname');//多表联合查询
			$scriptData = $db->fetchRow($select);
			$scriptData['scriptdb_info'] = stripslashes($scriptData['scriptdb_info']);
			$view->assign('scriptData', $scriptData);
			$view->display('scriptedit.tpl');
		}
	}

	/**
	 *
	 */
	public function delAction()
	{
		$view = Zend_Registry::get('view');
    	$user = Zend_Registry::get('user');
		$db = Zend_Registry::get('dbAdapter');
		$config = Zend_Registry::get('config');

		$id = $this->_getParam('id');

		if ($id)
		{
			$up_ary = array(
						'deleteflag' => 1
					);
			$where = $db->quoteInto('scriptdb_id = ?', $id);

			$db->update(TABLE_QNSOFT_SCRIPTDB, $up_ary, $where);
			
		}
		header('location: ' . $config['site_url'] . '/script/list');
	}
    /**
     * 
     */
    public function indexAction()
    {
    	$view = Zend_Registry::get('view');
    	$user = Zend_Registry::get('user');
		$user_id =  $this->_getParam('agent', 0);
		$scriptdb_key =  $this->_getParam('scriptdb_key');
		$scriptdb_id = $this->_getParam('scriptdb_id');
		$db = Zend_Registry::get('dbAdapter');
		$user_name = "null";

		$op = $this->_getParam('submit');

		if ($op == "提交")
		{
			$in_ary = array(
				'user_id' => $user_id,
				'scriptdb_key' => $scriptdb_key,
				'scriptdb_info' => $this->_getParam('scriptdb_info', ""),
				'flag' => 1
			);

			if ($scriptdb_id > 0)
			{
				$where = $db->quoteInto('scriptdb_id = ?', $scriptdb_id);

				$db->update(TABLE_QNSOFT_SCRIPTDB, $in_ary, $where);
			}
			else
			{
				$db->insert(TABLE_QNSOFT_SCRIPTDB, $in_ary);
			}

			$select = $db->select();
			$select->from(TABLE_QNSOFT_SCRIPTDB, '*');
			$select->where('user_id = ' . $user_id);
			$select->where('scriptdb_key = "' . $scriptdb_key . '"');

			$script = $db->fetchRow($select);
			$script['scriptdb_info'] = stripslashes($script['scriptdb_info']);
			$view->assign('script', $script);

		}
		else if($op == "查看")
		{

			if ($user_id > 0)
			{
				$select = $db->select();
				$select->from(TABLE_QNSOFT_SCRIPTDB, '*');
				$select->where('user_id = ' . $user_id);
				$select->where('deleteflag = 0'); //未删除
				$select->where('scriptdb_key = "' . $scriptdb_key . '"');

				$script = $db->fetchRow($select);
				$script['scriptdb_info'] = stripslashes($script['scriptdb_info']);

				$view->assign('script', $script);
			}
		}

		$select = $db->select();
		$select->from(TABLE_QNSOFT_USERSKILLGROUP, '*');
		$conflist = $db->fetchAll($select);
		$view->assign('conflist', $conflist);
		$view->assign('scriptdb_key', $scriptdb_key);
		$view->assign('user_name', $user_id);
		$view->assign('script', $script);
		$view->display('scriptmamage.tpl');
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
