<?php
/** 
 * Zend_Controller_Action 
 * 技能组管理
 */

class QnskillrenterController extends Zend_Controller_Action_Qn
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
		$id =  $this->_getParam('id'); //厂商ID，如果有
    	
    	$view->display('renter/skilladd.tpl');
    }

	public function adddoAction()
    {
		$view = Zend_Registry::get('view');
    	$user = Zend_Registry::get('user');
		$db = Zend_Registry::get('dbAdapter');
		$config = Zend_Registry::get('config');

		$skill_code = $this->_getParam('skillcode');
		$skill_name = $this->_getParam('skillname');
        $fakecalling = $this->_getParam('fakecalling');
		$factory_id = $config['factory_id'];
        
        $select = $db->select();
        $select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_SKILL, '*'); 
        $select->where('deleteflag = 0'); //未删除     
        $select->where('factory_id = ' . $factory_id);   
        $select->where('skill_name = "' . $skill_name . '"');    

        $listData = $db->fetchAll($select);
        if ($listData)
        {
            $id =  $this->_getParam('id'); //厂商ID，如果有
        
            $select = $db->select();
            $select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_FACTORY, '*');
            $select->order("factory_id");
            $select->where('deleteflag = 0'); //未删除 
            $listData = $db->fetchAll($select);
            $view->assign('list', $listData);
            $view->assign('id', $id);
            $_POST['errmsg'] = '技能名称 ' . $skill_name .  '已存在，请重新输入';
            $view->assign('post', $_POST);  
                    
            $view->display('renter/skilladd.tpl');
            exit(0);
        }
        
		if ($skill_code && $skill_name)
		{
			$in_ary = array(
					'skill_code' => $skill_code,
					'factory_id' => $factory_id,
					'skill_name' => $skill_name,
                    'fakecalling' => $fakecalling
				);

				$db->insert($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_SKILL, $in_ary);
		}
		//header('location: ' . $config['site_url'] . '/qnskill/list');
        $this->msg("新增技能组成功", "/qnskillrenter/add"); 
    }

	public function listAction()
	{
        $per_page_num = 15; //每页15
        
		$view = Zend_Registry::get('view');
    	$user = Zend_Registry::get('user');
		$db = Zend_Registry::get('dbAdapter');
		$config = Zend_Registry::get('config');
    	
        $page =  $this->_getParam('page', 1);//分页
        $select = $db->select();
        $select->from($config['factory_enterprisecode'] .'_' . TABLE_QNSOFT_SKILL, 'count(*)');
        $select->where('deleteflag = 0'); //未删除
        $sum = $db->fetchOne($select);
        
		$select = $db->select();
		$select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_SKILL . ' as p', '*');
		$select->where('p.deleteflag = 0'); //未删除
        $select->limitPage($page, $per_page_num);
		$listData = $db->fetchAll($select);
		$view->assign('list', $listData);

        //分页 
        $page_arr = array(
            'url_start' => $config['site_url'] . '/qnskillrenter/list/',
            'cur_page' => $page, 
            'total_item' => $sum, //总记录条数
            'per_page_num' => $per_page_num,  //每页记录数
            'cur_item_str' => '',   //当前页多少条，如果为空表示不要此项 
        );
        $pager_class = new pager_str($page_arr);

        $page_str = $pager_class->page_str; //分页内容
        $page = $pager_class->get_cur_page(); //得到当前页码
        $view->assign('page_str', $page_str);
        //分页　end
        
    	$view->display('renter/skilllist.tpl');
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
			$select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_SKILL, '*');
			$select->where("factory_id = ?" , $factoryid);
            $select->where('deleteflag = 0'); //未删除 
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
			$select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_SKILL, '*');
			$select->where('skill_id = ?', $id);
			$select->where('deleteflag = 0'); //未删除
			$Data = $db->fetchRow($select);
			$view->assign('skillData', $Data);

			$view->display('renter/skilledit.tpl');
		}
		else
		{
			$skill_code = $this->_getParam('skillcode');
			$skill_name = $this->_getParam('skillname');
			$factory_id = $this->_getParam('factoryid');
            $fakecalling = $this->_getParam('fakecalling'); 
			if ($skill_code && $skill_name)
			{
				$up_ary = array(
						'skill_code' => $skill_code,
						'skill_name' => $skill_name,
                        'fakecalling' => $fakecalling
					);
				
				$where = $db->quoteInto('skill_id = ?', $id);
				$db->update($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_SKILL, $up_ary, $where);
			}

            $urlArray = array(
                array('title' => "查看列表", 'url' => "/qnskillrenter/list")
            );
            $this->msgUrl("编辑技能组成功!<br/>技能编号:" . $skill_code . " <br/>技能名:" . $skill_name, $urlArray);
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


		$where = $db->quoteInto('skill_id = ?', $id);
		$db->update($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_SKILL, $up_ary, $where);
		header('location: ' . $config['site_url'] . '/qnskillrenter/list');
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
