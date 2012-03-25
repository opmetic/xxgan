<?php
/** 
 * 用户角色
 * Zend_Controller_Action 
 */

class QnresourceController extends Zend_Controller_Action_Qn
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
        global $resource_type;   //资源类型
        
    	$view = Zend_Registry::get('view');
    	$user = Zend_Registry::get('user');
        $db = Zend_Registry::get('dbAdapter');
		$config = Zend_Registry::get('config');
    	
        $select = $db->select();
        $select->from(TABLE_QNSOFT_FACTORY, '*');
        $select->order("factory_id");
        $select->where('deleteflag = 0'); //未删除 
        $listData = $db->fetchAll($select);
        $view->assign('list', $listData);
        $view->assign('resource_type_array', $resource_type); 

    	$view->display('resourceadd.tpl');
    }

	public function adddoAction()
    {
        global $resource_type;   //资源类型
        
		$view = Zend_Registry::get('view');
    	$user = Zend_Registry::get('user');
		$db = Zend_Registry::get('dbAdapter');
		$config = Zend_Registry::get('config');

         $select = $db->select();
        $select->from(TABLE_QNSOFT_FACTORY, '*');
        $select->order("factory_id");
        $select->where('deleteflag = 0'); //未删除 
        $listData = $db->fetchAll($select);
        $view->assign('list', $listData);
        $view->assign('resource_type_array', $resource_type); 
        
		$resource_name = $this->_getParam('resource_name');
		$factoryid = $this->_getParam('factoryid');
		$resource_type = $this->_getParam('resource_type');
		$resource_dsc = $this->_getParam('resource_dsc');
        
		if ($resource_name)
		{
            $select = $db->select();
            $select->from(TABLE_QNSOFT_RESOURCE, '*');
            $select->where('resource_name = ?', $resource_name);
            $select->where('factory_id = ?', $factoryid);  
            $select->where('deleteflag = 0'); //未删除 
            $tmp = $db->fetchRow($select);
            if ($tmp)
            {
                $_POST['errmsg'] = '您输入的资源名已存在，请重新输入';
                $view->assign('post', $_POST); 
                $view->assign('id', $factoryid); 
                
                $view->display('resourceadd.tpl'); 
                exit(0); 
            }
            
			$in_ary = array(
					'resource_name' => $resource_name,
					'resource_type' => $resource_type,
					'factory_id' => $factoryid,
					'resource_dsc' => $resource_dsc
				);
            try
            {
				$db->insert(TABLE_QNSOFT_RESOURCE, $in_ary);
            } 
            catch(Exception $e){
                $_POST['errmsg'] = '您输入的信息不正确，请重新输入';
                $view->assign('post', $_POST);  
                $view->display('resourceadd.tpl'); 
                exit(0); 
            };
		}
        else
        {
            $_POST['errmsg'] = '您输入的信息不正确，请重新输入';
            $view->assign('post', $_POST);  
            $view->display('resourceadd.tpl'); 
            exit(0); 
        }
		//header('location: ' . $config['site_url'] . '/qnfactory/list');
        $this->msg("新增资源成功", "/qnresource/add");
    }

	public function listAction()
	{
        global $resource_type; //资源类型 
        $per_page_num = 15; //每页15
        
	    $view = Zend_Registry::get('view');
        $user = Zend_Registry::get('user');
        $db = Zend_Registry::get('dbAdapter');
        $config = Zend_Registry::get('config');
        
        $page =  $this->_getParam('page', 1);//分页
        $sourceTypeQuery =  $this->_getParam('sourcetype', 'all');//查找条件

          
        $selectSum = $db->select();     
        $select = $db->select();
        $selectSum->from(TABLE_QNSOFT_RESOURCE, 'count(*)'); 
        $select->from(TABLE_QNSOFT_RESOURCE . ' as p', '*');
        if ($sourceTypeQuery != 'all')       //有查找条件
        {
            $selectSum->where('resource_type = ?', $sourceTypeQuery);
            $select->where('p.resource_type = ?', $sourceTypeQuery);
        }
        $selectSum->where('deleteflag = 0'); //未删除
        $select->where('p.deleteflag = 0'); //未删除
        $select->join(TABLE_QNSOFT_FACTORY . ' as f', 'p.factory_id = f.factory_id', 'factory_name');//多表联合查询
        $select->order("factory_id");
        $select->limitPage($page, $per_page_num);
        $sum = $db->fetchOne($selectSum);
        $listDataTmp = $db->fetchAll($select);
        
        //分页 
        $page_arr = array(
            'url_start' => $config['site_url'] . '/qnresource/list/',
            'cur_page' => $page, 
            'total_item' => $sum, //总记录条数
            'per_page_num' => $per_page_num,  //每页记录数
            'url_arr' => array('sourcetype'=> $sourceTypeQuery),
            'cur_item_str' => '',   //当前页多少条，如果为空表示不要此项 
        );
        $pager_class = new pager_str($page_arr);

        $page_str = $pager_class->page_str; //分页内容
        $page = $pager_class->get_cur_page(); //得到当前页码
        $view->assign('page_str', $page_str);
        //分页　end

        
        $listData = array();
        foreach($listDataTmp as $node)
        {
            $node['type_txt'] = $resource_type[$node['resource_type']];
            $listData[] = $node;
        }

        
        $view->assign('sourcetype', $sourceTypeQuery); 
        $view->assign('list', $listData);
        $view->assign('resource_type_array', $resource_type); 

    	$view->display('resourcelist.tpl');
	}

	/**
	 * 编辑
	 */
	public function editAction()
	{
        global $resource_type;   //资源类型
         
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
			$select->where('deleteflag = 0'); //未删除

			$Data = $db->fetchAll($select);
			$view->assign('factoryData', $Data);

			//资源信息
			$select = $db->select();
			$select->from(TABLE_QNSOFT_RESOURCE, '*');
			$select->where('resource_id = ?', $id);
			$select->where('deleteflag = 0'); //未删除

			$resourceData = $db->fetchRow($select);
			$view->assign('resourceData', $resourceData);
            $view->assign('resource_type_array', $resource_type);

			$view->display('resourceedit.tpl');
		}
		else
		{
		    $resource_name = $this->_getParam('resource_name');
            $factoryid = $this->_getParam('factoryid');
            $resource_type = $this->_getParam('resource_type');
            $resource_dsc = $this->_getParam('resource_dsc');

			$up_ary = array(
				   'resource_name' => $resource_name,
                    'resource_type' => $resource_type,
                    'factory_id' => $factoryid,
                    'resource_dsc' => $resource_dsc
				);

			$where = $db->quoteInto('resource_id = ?', $id);
			$db->update(TABLE_QNSOFT_RESOURCE, $up_ary, $where);

			header('location: ' . $config['site_url'] . '/qnresource/list');
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
		$where = $db->quoteInto('resource_id = ?', $id);

		$db->update(TABLE_QNSOFT_RESOURCE, $up_ary, $where);
		header('location: ' . $config['site_url'] . '/qnresource/list');
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
