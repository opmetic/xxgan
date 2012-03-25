<?php
/** 
 * 用户角色
 * Zend_Controller_Action 
 */

class QnroleController extends Zend_Controller_Action_Qn
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
    	
        $select = $db->select();
        $select->from(TABLE_QNSOFT_FACTORY, '*');
        $select->order("factory_id");
        $select->where('deleteflag = 0'); //未删除 
        $listData = $db->fetchAll($select);
        $view->assign('list', $listData);
        
    	$view->display('roleadd.tpl');
    }

	public function adddoAction()
    {
		$view = Zend_Registry::get('view');
    	$user = Zend_Registry::get('user');
		$db = Zend_Registry::get('dbAdapter');
		$config = Zend_Registry::get('config');

		$role_name = $this->_getParam('name');
		$factory_id = $this->_getParam('factoryid');
		$role_dsc = $this->_getParam('dsc');
		if ($role_name)
		{
			$in_ary = array(
					'role_name' => $role_name,
					'factory_id' => $factory_id,
					'role_dsc' => $role_dsc,
					'Deleteflag' => 0
				);
                try
                {
				    $db->insert(TABLE_QNSOFT_ROLE, $in_ary);
                }  
                catch(Exception $e){
                    $_POST['errmsg'] = '您输入有错误，请重新输入';
                    $view->assign('post', $_POST);  
                    $view->display('roleadd.tpl'); 
                    exit(0); 
                };
		}
        else
        {
            $_POST['errmsg'] = '您输入有错误,角色名为必填项，请重新输入';
            $view->assign('post', $_POST);  
            $view->display('roleadd.tpl'); 
            exit(0); 
        }
		//header('location: ' . $config['site_url'] . '/qnfactory/list');
        $this->msg("新增角色成功", "/qnrole/add");
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
        $select->from(TABLE_QNSOFT_ROLE, 'count(*)');
        $select->where('deleteflag = 0'); //未删除
        $sum = $db->fetchOne($select);
              
        $select = $db->select();
        $select->from(TABLE_QNSOFT_ROLE . ' as p', '*');
        $select->where('p.deleteflag = 0'); //未删除
        $select->join(TABLE_QNSOFT_FACTORY . ' as f', 'p.factory_id = f.factory_id', 'factory_name');//多表联合查询
        $select->order("factory_id");
        $select->limitPage($page, $per_page_num);
        $listData = $db->fetchAll($select);
        $view->assign('list', $listData);
        
        //分页 
        $page_arr = array(
            'url_start' => $config['site_url'] . '/qnrole/list/',
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
        
        $view->display('rolelist.tpl');
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
			$select->where('deleteflag = 0'); //未删除

			$Data = $db->fetchAll($select);
			$view->assign('factoryData', $Data);

			//角色信息
			$select = $db->select();
			$select->from(TABLE_QNSOFT_ROLE, '*');
			$select->where('role_id = ?', $id);
			$select->where('deleteflag = 0'); //未删除

			$roleData = $db->fetchRow($select);

			$view->assign('roleData', $roleData);

			$view->display('roleedit.tpl');
		}
		else
		{
			$role_name = $this->_getParam('name');
            $factory_id = $this->_getParam('factoryid');
            $role_dsc = $this->_getParam('dsc');

            $up_ary = array(
                'role_name' => $role_name,
                'factory_id' => $factory_id,
                'role_dsc' => $role_dsc,
                'Deleteflag' => 0
            );
            try
            {
                $where = $db->quoteInto('role_id = ?', $id);     
                $db->update(TABLE_QNSOFT_ROLE, $up_ary, $where);    
            }  
            catch(Exception $e){
                $_POST['errmsg'] = '您输入有错误，请重新输入';
                $view->assign('post', $_POST);  
                $view->display('roleedit.tpl'); 
                exit(0); 
            };
            
			header('location: ' . $config['site_url'] . '/qnrole/list');
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
        $where = $db->quoteInto('role_id = ?', $id);     
        $db->update(TABLE_QNSOFT_ROLE, $up_ary, $where);    
                
        header('location: ' . $config['site_url'] . '/qnrole/list');
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
