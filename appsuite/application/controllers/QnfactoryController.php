<?php
/** Zend_Controller_Action */

class QnfactoryController extends Zend_Controller_Action_Qn
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
		$config = Zend_Registry::get('config');
    	
    	$view->display('factorladd.tpl');
    }

	public function adddoAction()
    {
		$view = Zend_Registry::get('view');
    	$user = Zend_Registry::get('user');
		$db = Zend_Registry::get('dbAdapter');
		$config = Zend_Registry::get('config');

		$factory_name = $this->_getParam('name');
		$enterprisecode = $this->_getParam('enterprisecode');
		$factory_code = $this->_getParam('code');
		$factory_pwd = $this->_getParam('pwd');
		$factory_userdefined = $this->_getParam('userdefined');
		if ($factory_name && $enterprisecode)
		{
			$in_ary = array(
					'factory_name' => $factory_name,
					'factory_enterprisecode' => $enterprisecode,
					'factory_code' => $factory_code,
					'factory_pwd' => $factory_pwd,
					'factory_userdefined' => $factory_userdefined
				);
                try
                {
				    $db->insert(TABLE_QNSOFT_FACTORY, $in_ary);
                }  catch(Exception $e){
                    $_POST['errmsg'] = '您输入的公司编号已存在，请重新输入';
                    $view->assign('post', $_POST);  
                    $view->display('factorladd.tpl'); 
                    exit(0); 
                };
		}
		//header('location: ' . $config['site_url'] . '/qnfactory/list');
        $this->msg("新增公司成功", "/qnfactory/add");
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
        $select->from(TABLE_QNSOFT_FACTORY, 'count(*)');
        $select->where('deleteflag = 0'); //未删除
        $sum = $db->fetchOne($select);
        
		$select = $db->select();
		$select->from(TABLE_QNSOFT_FACTORY, '*');
		$select->where('deleteflag = 0'); //未删除
		$select->order("factory_id");
        $select->limitPage($page, $per_page_num);
		$listData = $db->fetchAll($select);
		$view->assign('list', $listData);
        
        //分页 
        $page_arr = array(
            'url_start' => $config['site_url'] . '/qnfactory/list/',
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
        
    	$view->display('factorllist.tpl');
	}

	/**
	 * 查看
	 */
	public function showAction()
	{
		$view = Zend_Registry::get('view');
    	$user = Zend_Registry::get('user');
		$db = Zend_Registry::get('dbAdapter');
		$config = Zend_Registry::get('config');
    	$id =  $this->_getParam('id');
		
		if ($id > 0)
		{
			//公司信息
			$select = $db->select();
			$select->from(TABLE_QNSOFT_FACTORY, '*');
			$select->where('factory_id = ?', $id);
			$select->where('deleteflag = 0'); //未删除

			$Data = $db->fetchRow($select);
			$view->assign('factoryData', $Data);

			//分机信息
			$select = $db->select();
			$select->from(TABLE_QNSOFT_PHONE, '*');
			$select->where('factory_id = ?', $id);
            $select->where('deleteflag = 0'); //未删除 

			$phoneData = $db->fetchAll($select);
			$view->assign('phoneData', $phoneData);


			$view->display('factorlview.tpl');
		}
		else
		{
			
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
			//公司信息
			$select = $db->select();
			$select->from(TABLE_QNSOFT_FACTORY, '*');
			$select->where('factory_id = ?', $id);
			$select->where('deleteflag = 0'); //未删除

			$Data = $db->fetchRow($select);
			$view->assign('factoryData', $Data);

			//分机信息
			$select = $db->select();
			$select->from(TABLE_QNSOFT_PHONE, '*');
			$select->where('factory_id = ?', $id);
			$select->where('deleteflag = 0'); //未删除

			$phoneData = $db->fetchAll($select);
			$view->assign('phoneData', $phoneData);

			$view->display('factorledit.tpl');
		}
		else
		{
			$factory_name = $this->_getParam('name');
			$factory_code = $this->_getParam('code');
			$factory_pwd = $this->_getParam('pwd');
			$factory_userdefined = $this->_getParam('userdefined');

			$up_ary = array(
					'factory_name' => $factory_name,
					'factory_code' => $factory_code,
					'factory_pwd' => $factory_pwd,
					'factory_userdefined' => $factory_userdefined
				);

			$where = $db->quoteInto('factory_id = ?', $id);
			$db->update(TABLE_QNSOFT_FACTORY, $up_ary, $where);

			header('location: ' . $config['site_url'] . '/qnfactory/show/id/' . $id);
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
		$where = $db->quoteInto('factory_id = ?', $id);

		$db->update(TABLE_QNSOFT_FACTORY, $up_ary, $where);
		header('location: ' . $config['site_url'] . '/qnfactory/list');
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
