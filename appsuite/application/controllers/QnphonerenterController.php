<?php
/** 
 * Zend_Controller_Action 
 * 分机管理
 */

class QnphoneController extends Zend_Controller_Action_Qn
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
    	
		$select = $db->select();
		$select->from(TABLE_QNSOFT_FACTORY, '*');
		$select->order("factory_id");
        $select->where('deleteflag = 0'); //未删除 
		$listData = $db->fetchAll($select);
		$view->assign('list', $listData);
		$view->assign('id', $id);
    	$view->display('phoneadd.tpl');
    }

	public function adddoAction()
    {
		$view = Zend_Registry::get('view');
    	$user = Zend_Registry::get('user');
		$db = Zend_Registry::get('dbAdapter');
		$config = Zend_Registry::get('config');

		$phone_num = $this->_getParam('num');
		$factory_id = $this->_getParam('factoryid');
		if ($phone_num)
		{
			$in_ary = array(
/*					'plain_pwd' => $plain_pwd,
					'plain_pwdmd5' => strtoupper(md5($plain_pwd)),
*/
					'phone_num' => $phone_num,
					'factory_id' => $factory_id
				);

				$db->insert(TABLE_QNSOFT_PHONE, $in_ary);
		}
        $this->msg("新增分机成功", "/qnphone/add"); 
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
        $select->from(TABLE_QNSOFT_PHONE, 'count(*)');
        $select->where('deleteflag = 0'); //未删除
        $sum = $db->fetchOne($select);
    	
		$select = $db->select();
		$select->from(TABLE_QNSOFT_PHONE . ' as p', '*');
		$select->where('p.deleteflag = 0'); //未删除
		$select->join(TABLE_QNSOFT_FACTORY . ' as f', 'p.factory_id = f.factory_id', 'factory_name');//多表联合查询
		$select->order("factory_id");
        $select->limitPage($page, $per_page_num);
		$listData = $db->fetchAll($select);
		$view->assign('list', $listData);

        //分页 
        $page_arr = array(
            'url_start' => $config['site_url'] . '/qnphone/list/',
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
        
		$view->display('phonelist.tpl');
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
			$select->from(TABLE_QNSOFT_PHONE, '*');
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
			//分机信息
			$select = $db->select();
			$select->from(TABLE_QNSOFT_PHONE, '*');
			$select->where('phone_id = ?', $id);
			$select->where('deleteflag = 0'); //未删除
			$Data = $db->fetchRow($select);
			$view->assign('phoneData', $Data);
			
			//公司信息
			$select = $db->select();
			$select->from(TABLE_QNSOFT_FACTORY, '*');
			$select->where('deleteflag = 0'); //未删除
			$select->order("factory_id");
			$listData = $db->fetchAll($select);
			$view->assign('list', $listData);

			$view->display('phoneedit.tpl');
		}
		else
		{
			$phone_num = $this->_getParam('num');
			$factory_id = $this->_getParam('factoryid');

			$up_ary = array(
					'phone_num' => $phone_num,
					'factory_id' => $factory_id
				);

			$where = $db->quoteInto('phone_id = ?', $id);
			$db->update(TABLE_QNSOFT_PHONE, $up_ary, $where);

            $urlArray = array(
                array('title' => "查看列表", 'url' => "/qnphone/list")
            );
            $this->msgUrl("编辑分机成功,新分机号为:" . $phone_num, $urlArray);  
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
		$where = $db->quoteInto('phone_id = ?', $id);
		$db->update(TABLE_QNSOFT_PHONE, $up_ary, $where);
		header('location: ' . $config['site_url'] . '/qnphone/list');
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
