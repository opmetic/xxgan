<?php
/** 
 * Zend_Controller_Action 
 * 技能组管理
 */

class QnuserskillgroupController extends Zend_Controller_Action_Qn
{    
	public function init()
    {
    	Zend_Controller_Action_Qn::init();
    }
    
	/**
     * 
     */
    public function indexAction()
    {


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
		$id =  $this->_getParam('id'); //厂商ID，如果有
    	
		$select = $db->select();
		$select->from(TABLE_QNSOFT_FACTORY, '*');
		$select->order("factory_id");
		$listData = $db->fetchAll($select);
		$view->assign('list', $listData);
		$view->assign('id', $id);
    	$view->display('skilladd.tpl');
    }

	public function adddoAction()
    {
		$view = Zend_Registry::get('view');
    	$user = Zend_Registry::get('user');
		$db = Zend_Registry::get('dbAdapter');
		$config = Zend_Registry::get('config');

		$skill_code = $this->_getParam('skillcode');
		$skill_name = $this->_getParam('skillname');
		$factory_id = $this->_getParam('factoryid');
		if ($skill_code && $skill_name)
		{
			$in_ary = array(
					'skill_code' => $skill_code,
					'factory_id' => $factory_id,
					'skill_name' => $skill_name
				);

				$db->insert(TABLE_QNSOFT_SKILL, $in_ary);
		}
		header('location: ' . $config['site_url'] . '/qnskill/list');
    }

	public function listAction()
	{
		$view = Zend_Registry::get('view');
    	$user = Zend_Registry::get('user');
		$db = Zend_Registry::get('dbAdapter');
		$config = Zend_Registry::get('config');
		
		//公司信息
		$select = $db->select();
		$select->from(TABLE_QNSOFT_FACTORY, '*');
		$select->where("factory_id > 0");
		$select->order("factory_id");
		$listData = $db->fetchAll($select);
		$view->assign('list', $listData);

    	$view->display('userskillgroup.tpl');
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
			$select->from(TABLE_QNSOFT_USER, array('uid', 'username', 'nickname'));
			$select->where("factory_id = ?" , $factoryid);
			$listData = $db->fetchAll($select);
			$json = Zend_Json::encode($listData);
			echo $json;
		}
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
    	$id =  $this->_getParam('id');
		$submit = $this->_getParam('submit');
		
		if (!$submit)
		{
			//技能信息
			$select = $db->select();
			$select->from(TABLE_QNSOFT_SKILL, '*');
			$select->where('skill_id = ?', $id);
			$Data = $db->fetchRow($select);
			$view->assign('skillData', $Data);
			
			//公司信息
			$select = $db->select();
			$select->from(TABLE_QNSOFT_FACTORY, '*');
			$select->order("factory_id");
			$listData = $db->fetchAll($select);
			$view->assign('list', $listData);

			$view->display('skilledit.tpl');
		}
		else
		{
			$skill_code = $this->_getParam('skillcode');
			$skill_name = $this->_getParam('skillname');
			$factory_id = $this->_getParam('factoryid');
			if ($skill_code && $skill_name)
			{
				$up_ary = array(
						'skill_code' => $skill_code,
						'factory_id' => $factory_id,
						'skill_name' => $skill_name
					);
				
				$where = $db->quoteInto('skill_id = ?', $id);
				$db->update(TABLE_QNSOFT_SKILL, $up_ary, $where);
			}

			header('location: ' . $config['site_url'] . '/qnskill/list');
		}
	}

	public function delAction()
	{
		$config = Zend_Registry::get('config');

		$id =  $this->_getParam('id');
		$db = Zend_Registry::get('dbAdapter');
		$where = $db->quoteInto('skill_id = ?', $id);
		$db->delete(TABLE_QNSOFT_SKILL, $where);
		header('location: ' . $config['site_url'] . '/qnskill/list');
	}
    
    
    /**
     * 脚本编辑
     */
    public function scriptAction()
    {
    	$config = Zend_Registry::get('config');
    	header('location: ' . $config['site_url'] . '/qnfactory/list');
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
