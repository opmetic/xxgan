<?php
/** 
 * Zend_Controller_Action 
 * 技能组管理
 */

class QnbuttonexrenterController extends Zend_Controller_Action_Qn
{    
	public function init()
    {
    	Zend_Controller_Action_Qn::init();
    }
    
    /**
    * put your comment there...
    * 
    */
    public function listaAction()
    {
        $per_page_num = 100; //每页100
        
        $view = Zend_Registry::get('view');
        $user = Zend_Registry::get('user');
        $db = Zend_Registry::get('dbAdapter');
        $config = Zend_Registry::get('config');
        
        $page =  $this->_getParam('page', 1);//分页
        $select = $db->select();
        $select->from($config['factory_enterprisecode'] .'_' . TABLE_QNSOFT_BUTTON . ' as b', 'count(*)');
        $select->join($config['factory_enterprisecode'] .'_' . TABLE_QNSOFT_SKILL . ' as s', 'b.button_group = s.skill_code', '');//多表联合查询

        $select->where('b.deleteflag = 0'); //未删除

        $sum = $db->fetchOne($select);
        
        $select = $db->select();

        $select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_BUTTON . ' as b', '*');
        $select->join($config['factory_enterprisecode'] .'_' . TABLE_QNSOFT_SKILL . ' as s', 'b.button_group = s.skill_code', array('s.skill_code', 's.skill_name'));//多表联合查询

        $select->where('b.deleteflag = 0'); //未删除
        $select->limitPage($page, $per_page_num);
        
        $listData = $db->fetchAll($select);
        $view->assign('list', $listData);
        
        //分页 
        $page_arr = array(
            'url_start' => $config['site_url'] . '/qnbuttonexrenter/lista/',
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
        
        $view->display('renter/buttonexlista.tpl');
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
		
		$select = $db->select();
		$select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_SKILL . ' as p', '*');
		$select->where('p.deleteflag = 0'); //未删除
		$listData = $db->fetchAll($select);
		$view->assign('list', $listData);
    	
    	$view->display('renter/buttonexadd.tpl');
    }

	public function adddoAction()
    {
		$view = Zend_Registry::get('view');
    	$user = Zend_Registry::get('user');
		$db = Zend_Registry::get('dbAdapter');
		$config = Zend_Registry::get('config');

		$button_name = $this->_getParam('button_name');
		$button_info = $this->_getParam('button_info');
        $button_group = $this->_getParam('button_group');
        
		if ($button_name && $button_info)
		{
			$in_ary = array(
					'button_name' => $button_name,
					'button_info' => $button_info,
					'button_group' => $button_group
				);

				$db->insert($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_BUTTON, $in_ary);
                $this->msg("新增按键成功", "/qnbuttonexrenter/add"); 
		}
        else
        {
            $this->msg("新增按键失败，值不能为空", "/qnbuttonexrenter/add");    
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
			$select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_BUTTON, '*');
			$select->where('button_id = ?', $id);
			$select->where('deleteflag = 0'); //未删除
			$Data = $db->fetchRow($select);
			$view->assign('buttonData', $Data);
			
			$select = $db->select();
			$select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_SKILL . ' as p', '*');
			$select->where('p.deleteflag = 0'); //未删除
			$listData = $db->fetchAll($select);
			$view->assign('list', $listData);

			$view->display('renter/buttonexedit.tpl');
		}
		else
		{
		    $button_name = $this->_getParam('button_name');
            $button_info = $this->_getParam('button_info');
            $button_group = $this->_getParam('button_group');
            
			if ($button_name && $button_info)
			{
				$up_ary = array(
						'button_name' => $button_name,
						'button_info' => $button_info,
                        'button_group' => $button_group
					);
				
				$where = $db->quoteInto('button_id = ?', $id);
				$db->update($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_BUTTON, $up_ary, $where);
			}

            $urlArray = array(
                array('title' => "查看列表", 'url' => "/qnbuttonexrenter/lista")
            );
            $this->msgUrl("编辑按钮成功!", $urlArray);
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


		$where = $db->quoteInto('button_id = ?', $id);
		$db->update($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_BUTTON, $up_ary, $where);
		header('location: ' . $config['site_url'] . '/qnbuttonexrenter/lista');
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
            echo 'var c_area = ' . $json;
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
