<?php
/** 
 * 用户角色
 * Zend_Controller_Action 
 */

class QnauthrenterController extends Zend_Controller_Action_Qn
{    
	public function init()
    {
    	Zend_Controller_Action_Qn::init();
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
        
    	$id =  $this->_getParam('id');  //角色ID
		$submit = $this->_getParam('submit');
		
        //角色ID
        $select = $db->select();
        $select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_ROLE . ' as p', '*');
        $select->where('p.deleteflag = 0'); //未删除
        $select->where('p.role_id = ?', $id); 
        $select->join(TABLE_QNSOFT_FACTORY . ' as f', 'p.factory_id = f.factory_id', 'factory_name');//多表联合查询
        $select->order("factory_id");

        $roleData = $db->fetchRow($select);
        $view->assign('roleData', $roleData);   
            
		if (!$submit)
		{
			//分机信息
			$select = $db->select();
			$select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_RESOURCE, '*');
			$select->where('factory_id = ?', $roleData['factory_id']);
			$select->where('deleteflag = 0'); //未删除

			$resourceData = $db->fetchAll($select);
            $resourceArray = array();

            foreach($resourceData as $resourceNode)
            {
                $sql = $db->select();
                $sql->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_AUTH, '*');
                $sql->where('role_id = ?', $id);
                $sql->where('resource_id = ?', $resourceNode['resource_id']);
                $sql->where('deleteflag = 0'); //未删除 

                $authData = $db->fetchAll($sql); 
                if ($authData)
                {
                    //有这个权限
                    $resourceNode['checked'] = 'checked';
                }
                else
                {
                    //没有这个权限
                    $resourceNode['checked'] = ''; 
                }
                $resourceArray[$resourceNode['resource_type']][] = $resourceNode;
            }

			$view->assign('resourceArray', $resourceArray);
            $view->assign('resource_type_array', $resource_type);
                      
			$view->display('renter/authedit.tpl');
		}
		else
		{
            $resourcelist = $this->_getParam('resource_list');

            //清完所有资源分配
            $up_ary = array(
                    'deleteflag' => 1
                );
            $db->update($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_AUTH, $up_ary, "role_id = " . $roleData['role_id']);

            foreach($resourcelist as $node)
            {
                //判断关系是否存在
                $select = $db->select();
                $select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_AUTH, 'role_id');
                $select->where('role_id = ?', $roleData['role_id']);
                $select->where('resource_id = ?', $node);
                $temp = $db->fetchAll($select);
                        
                if ($temp)
                {
                    //存在
                    $up_ary = array(
                        'deleteflag' => 0
                    );
                    $db->update($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_AUTH, $up_ary, "role_id = " . $roleData['role_id'] . " and resource_id = " . $node);
                }
                else
                {
                    //新增
                    $select = $db->select();
                    $select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_RESOURCE, '*');
                    $select->where('resource_id = ?', $node);

                    $resourceData = $db->fetchRow($select);
                    
                    $in_ary = array(
                        'role_id' =>  $roleData['role_id'],
                        'role_name' => $roleData['role_name'],
                        'resource_id' => $resourceData['resource_id'],
                        'resource_name' => $resourceData['resource_name'],
                        'deleteflag' => 0
                    );
                    $db->insert($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_AUTH, $in_ary); 
                }
            }

            $urlArray = array(
                array('title' => "查看列表", 'url' => "/qnrolerenter/list")
            );
            $this->msgUrl("编辑成功", $urlArray);  
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
