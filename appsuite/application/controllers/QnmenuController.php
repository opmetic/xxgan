<?php
/** Zend_Controller_Action */

class QnmenuController extends Zend_Controller_Action_Qn
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
        $select->where('deleteflag = 0'); //未删除 
		$select->order("factory_id");
		$listData = $db->fetchAll($select);
		$view->assign('list', $listData);
		$view->assign('id', $id);

    	$view->display('menuadd.tpl');
    }

	public function adddoAction()
    {
		$view = Zend_Registry::get('view');
    	$user = Zend_Registry::get('user');
		$db = Zend_Registry::get('dbAdapter');
		$config = Zend_Registry::get('config');

		$menuname = $this->_getParam('menuname');
		$factoryid = $this->_getParam('factoryid');
		$menucode = $this->_getParam('menucode');
		$menuparent = $this->_getParam('menuparent', 0);
		$menukey = $this->_getParam('menukey');

		if ($menuname && $menucode)
		{
			$in_ary = array(
					'menu_name' => $menuname,
					'factory_id' => $factoryid,
					'menu_key' => $menucode,
					'menu_parent' => $menuparent,
					'menu_url' => $menukey
				);

				$db->insert(TABLE_QNSOFT_MENU, $in_ary);
		}
        $this->msg("新增目录成功", "/qnmenu/add");
		//header('location: ' . $config['site_url'] . '/qnmenu/list');
    }

	public function listAction()
	{
		$view = Zend_Registry::get('view');
    	$user = Zend_Registry::get('user');
		$db = Zend_Registry::get('dbAdapter');
		$config = Zend_Registry::get('config');

        $select = $db->select();
        $select->from(TABLE_QNSOFT_MENU . ' as m', '*');
        $select->where('m.deleteflag = 0'); //未删除
        $select->join(TABLE_QNSOFT_FACTORY . ' as f', 'm.factory_id = f.factory_id', 'factory_name');//多表联合查询
        $select->order("factory_id");
        $listData = $db->fetchAll($select);

        $TmpListData = array();
        $maxLevel = 1;// 最大分级数
        foreach($listData as $cell)
        {
            $cell['level'] = 1;
            $TmpListData[$cell['menu_id']] = $cell;
        }

        $TmpListData2 = array();
        foreach($TmpListData as $cell)
        {
            if ($cell['menu_parent'] > 0)
            {
                //非一级目录
                $level = 2;
                $index = $cell['menu_parent'];
                while($TmpListData[$index]['menu_parent'] > 0)
                {
                    $level++;
                    $index = $TmpListData[$index]['menu_parent'];
                }
                $cell['level'] = $level;

                if ( $maxLevel < $level) //处理最大分组数
                {
                    $maxLevel = $level;
                }

                $TmpListData2[$cell['menu_id']] = $cell;
            }
            else
            {
                $TmpListData2[$cell['menu_id']] = $cell;
            }
        }

        $jsonListData = array();


        while($maxLevel > 0)
        {
            foreach($TmpListData2 as $cell)
            {
                
                if ($cell['level'] == $maxLevel)
                {
                    if ($cell['level'] == 1)
                    {
                        //根目录
                        $jsonCell = array(
                                    "id" => $cell['menu_url'],
                                    "text" => $cell['menu_name'],
                                    "children" => $cell['children']    
                                    );

                        $jsonListData[] = $cell;
                    }
                    else
                    {
                        $jsonCell = array(
                                    "id" => $cell['menu_url'],
                                    "text" => $cell['menu_name'],
                                    "children" => $cell['children']    
                                    );
                        $TmpListData2[$cell['menu_parent']]['children'][] = $cell;
                    }
                }
            }
            $maxLevel--;
        }
        $listData = array();

        foreach($jsonListData as $node)
        {
            $this->getMenuList($listData, $node, 1);
        }
        
		$view->assign('list', $listData);
    	$view->display('menulist.tpl');
	}
    
    public function getMenuList(&$listData, $oldListRese, $level)
    {
        if ($level == 1)
        {    
            $oldList = $oldListRese;
            $tmp = $oldListRese;
            $tmp['children'] = '';
            $listData[] =  $tmp;
            if (isset($oldList['children']) && $oldList['children'] )
            {    
                  $this->getMenuList($listData, $oldList['children'], $level+1);
            }
        }
        else
        {
            foreach($oldListRese as $oldList)
            {
                $tmp = $oldList;
                $tmp['children'] = '';
                for($i = 1; $i < $level; $i++)
                {
                    $tmp['menu_name'] = '--' . $tmp['menu_name'];  
                }
                $listData[] =  $tmp;
                if (isset($oldList['children']) && $oldList['children'] )
                {
                      $this->getMenuList($listData, $oldList['children'], $level+1);
                }
            }
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
			//目录信息
			$select = $db->select();
			$select->from(TABLE_QNSOFT_MENU . ' as m', '*');
			$select->where('m.menu_id = ?', $id);
			$select->where('m.deleteflag = 0'); //未删除
			$select->join(TABLE_QNSOFT_FACTORY . ' as f', 'm.factory_id = f.factory_id', 'factory_name');//多表联合查询
			$select->order("factory_id");
			$Data = $db->fetchRow($select);
			$view->assign('Data', $Data);

			//父目录目录信息
			$select = $db->select();
			$select->from(TABLE_QNSOFT_MENU, '*');
			$select->where('factory_id = ?', $Data['factory_id']);
			$select->where('deleteflag = 0'); //未删除
			$parentData = $db->fetchAll($select);

			$view->assign('parentData', $parentData);


			$view->display('menuedit.tpl');
		}
		else
		{
			$menuname = $this->_getParam('menuname');
			$menucode = $this->_getParam('menucode');
			$menuparent = $this->_getParam('menuparent');
			$menukey = $this->_getParam('menukey');

            $select = $db->select();
            $select->from(TABLE_QNSOFT_MENU, '*');
            $select->where('deleteflag = 0'); //未删除
            $listDataTmp = $db->fetchAll($select);
            $listData = array();
            foreach($listDataTmp as $node)
            {
                $listData[$node['menu_id']] = $node;
            }
            
            //判断是否有回环
            if ($menuparent == $id)
            {
                $urlArray = array(
                    array('title' => "返回列表", 'url' => "/qnmenu/list")
                );
                $this->msgUrl("您的修改有错误，存在环路!", $urlArray);  
                exit(0);
            }
            $testparent = $menuparent;
            while($listData[$testparent]['menu_parent'] != 0)
            {   
                if ($listData[$testparent]['menu_id'] == $id ||
                    $listData[$testparent]['menu_parent'] == $id)
                {
                    $urlArray = array(
                        array('title' => "返回列表", 'url' => "/qnmenu/list")
                    );
                    $this->msgUrl("您的修改有错误，存在环路!", $urlArray);  
                    exit(0);
                }
                
                $testparent = $listData[$testparent]['menu_parent'];  //向上推一级 
            }
            
			$up_ary = array(
					'menu_name' => $menuname,
					'menu_key' => $menucode,
					'menu_parent' => $menuparent,
					'menu_url' => $menukey
				);


			$where = $db->quoteInto('menu_id = ?', $id);
			$db->update(TABLE_QNSOFT_MENU, $up_ary, $where);

			header('location: ' . $config['site_url'] . '/qnmenu/list');
		}
	}

	public function delAction()
	{
		$config = Zend_Registry::get('config');
		$id =  $this->_getParam('id');
		$db = Zend_Registry::get('dbAdapter');

		$select = $db->select();
		$select->from(TABLE_QNSOFT_MENU . ' as m', '*');
		$select->where('m.menu_parent = ?', $id);
		$select->where('m.deleteflag = 0'); //未删除
		$Data = $db->fetchAll($select);
		if ($Data)
		{
			echo"<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />";
			echo "此目录包含子目录，不允许直接删除!";
			echo "<a href=\"" . $config['site_url'] . '/qnmenu/list">返回</a>';
		}
		else
		{
			$up_ary = array(
						'deleteflag' => 1
					);
			$where = $db->quoteInto('menu_id = ?', $id);

			$db->update(TABLE_QNSOFT_MENU, $up_ary, $where);
			header('location: ' . $config['site_url'] . '/qnmenu/list');
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
    
	public function jlistAction()
	{
		$user = Zend_Registry::get('user');
		$db = Zend_Registry::get('dbAdapter');
		$config = Zend_Registry::get('config');
		$factoryid = $this->_getParam('factoryid');

		if ($factoryid > 0)
		{
			$select = $db->select();
			$select->from(TABLE_QNSOFT_MENU, '*');
			$select->where("factory_id = ?" , $factoryid);
            $select->where('deleteflag = 0'); //未删除
			$listData = $db->fetchAll($select);
			$json = Zend_Json::encode($listData);
			echo $json;
		}
	}

    public function jsonlistAction()
	{
		$user = Zend_Registry::get('user');
		$db = Zend_Registry::get('dbAdapter');
		$config = Zend_Registry::get('config');

		$factoryid = $this->_getParam('factoryid');
		if ($factoryid > 0 && $factoryid > 0)
		{
			$select = $db->select();
			$select->from(TABLE_QNSOFT_MENU, '*');
			$select->where("factory_id = ?" , $factoryid);
			$select->where('deleteflag = 0'); //未删除
			$listData = $db->fetchAll($select);

			$TmpListData = array();
			$maxLevel = 1;// 最大分级数
			foreach($listData as $cell)
			{
				$cell['level'] = 1;
				$TmpListData[$cell['menu_id']] = $cell;
			}

			$TmpListData2 = array();
			foreach($TmpListData as $cell)
			{
				if ($cell['menu_parent'] > 0)
				{
					//非一级目录
					$level = 2;
					$index = $cell['menu_parent'];
					while($TmpListData[$index]['menu_parent'] > 0)
					{
						$level++;
						$index = $TmpListData[$index]['menu_parent'];
					}
					$cell['level'] = $level;

					if ( $maxLevel < $level) //处理最大分组数
					{
						$maxLevel = $level;
					}

					$TmpListData2[$cell['menu_id']] = $cell;
				}
				else
				{
					$TmpListData2[$cell['menu_id']] = $cell;
				}
			}

			$jsonListData = array();


			while($maxLevel > 0)
			{
				foreach($TmpListData2 as $cell)
				{
					
					if ($cell['level'] == $maxLevel)
					{
						if ($cell['level'] == 1)
						{
							//根目录
							$jsonCell = array(
										"id" => $cell['menu_url'],
										"text" => $cell['menu_name'],
										"children" => $cell['children']	
										);

							$jsonListData[] = $jsonCell;
						}
						else
						{
							$jsonCell = array(
										"id" => $cell['menu_url'],
										"text" => $cell['menu_name'],
										"children" => $cell['children']	
										);
							$TmpListData2[$cell['menu_parent']]['children'][] = $jsonCell;
						}
					}
				}
				$maxLevel--;
			}
			//print_r($jsonListData);exit(0);
			$json = Zend_Json::encode($jsonListData);
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
