<?php
/** 
 * Zend_Controller_Action 
 * 分机管理
 */

class BbController extends Zend_Controller_Action_Qn
{    
    public function init()
    {
        Zend_Controller_Action_Qn::init();
    }
    
    public function indexAction()
    {
    	echo "addphoneeee<p/>";
    	echo "addphone<p/>";
    	echo "adduseraaa  88214439 - 88214598<p/>";
    	echo "adduserbbb<p/>";
    	echo "adduserccc<p/>";
    	echo "adduserddd<p/>";
    	echo "addscript<p/>";
    	echo "deluser<p/>";
    }
    
    
    public function addphoneeeeAction()
    {
        echo "helloworld";
        $view = Zend_Registry::get('view');
        $user = Zend_Registry::get('user');
        $db = Zend_Registry::get('dbAdapter');
        $config = Zend_Registry::get('config');
   //9788114801    9788114900
        $j = 0;
        $model = 4201; 
        for ($i = 4801 ; $i <= 4900; $i++)
        { 
            $phone_num = "978811" . (int)$i;
            $select = $db->select();
            $select->from(TABLE_QNSOFT_PHONE, '*');
            $select->where('phone_num = ?', $phone_num); //未删除 

            $Data = array();
            $Data = $db->fetchRow($select);
            if ($Data)
            {
                 echo '分机号' .  $phone_num . '已存在' . '<p/>';
            }
            else
            {
                $j ++;  
                 echo '新增分机' .  $phone_num . '   模块号' . $model . '<p/>';
                 $in_ary = array(
                    'phone_num' => $phone_num,
                    'basemodel' => $model,
                    'factory_id' => 26
                );
                try{
                    $db->insert(TABLE_QNSOFT_PHONE, $in_ary);
                    $model ++;
                }
                catch (Exception $e) { 
                }
            }
        }
         echo "end " . $j;  
    }
    
    public function addphoneAction()
    {
        echo "helloworld";
        $view = Zend_Registry::get('view');
        $user = Zend_Registry::get('user');
        $db = Zend_Registry::get('dbAdapter');
        $config = Zend_Registry::get('config');

        $j = 0;
        for ($i = 4001 ; $i <= 4200; $i++)
        {   
            
            $select = $db->select();
            $select->from(TABLE_QNSOFT_PHONE, '*');
            $select->where('phone_num = ?', "978811" . (int)$i); //未删除 

            $Data = array();
            $Data = $db->fetchRow($select);
            if ($Data)
            {
                 echo $i . '已存在' . '<p/>';
            }
            else
            {
                $j ++;
                 echo "978811" . (int)$i . '<p/>';
                 $in_ary = array(
                    'phone_num' => "978811" . (int)$i,
                    'factory_id' => 26
                );
                try{
                    $db->insert(TABLE_QNSOFT_PHONE, $in_ary);
                }
                catch (Exception $e) { 
                }
            }
        }
         echo "end " . $j;  
    }
// 
    public function adduseraaaAction()
    {
        echo "adduser<p/>" ;
        $view = Zend_Registry::get('view');
        $user = Zend_Registry::get('user');
        $db = Zend_Registry::get('dbAdapter');
        $config = Zend_Registry::get('config');
        $factory_id = $config['factory_id'];
        
        //88214439 - 88214598
        $j = 0;
        for ($i = 4439 ; $i <= 4598; $i++)
        {   
            $workid = "8821" . (int)$i;
            
            $select = $db->select();
            $select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USER, '*');
            $select->where('workid = ?', $workid);
            $select->where('deleteflag = 0'); //未删除
            $Data = $db->fetchRow($select);
            if ($Data)
            {
                echo "用户 " . $workid . '已存在<p/>';
             //   $up_ary = array(
            //       'skill_id' => 27
              //  );
	//
	        //    $where = 'user_id = ' . $Data['uid'] ;
	         //   $db->update($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USERSKILLGROUP, $up_ary, $where);
            }
            else
            {
                $j++;
                echo "新增用户 " . $workid . '<p/>';  
                $in_ary = array(
                    'username' => $workid,
                    'workid' => $workid,
                    'role' => 2, //普通坐席
                    'nickname' => $workid,
                    'factory_id' => 26, //四川
                    'agentid' => 0,
                    'plain' =>$workid,
                    'pwdplaintext' => "1",
                    'password' => strtoupper(md5("1")),
                    'plain_pwd' => "123456",  
                    'plain_pwdmd5' => strtoupper(md5("123456")),
                    'fakecalling' => "",
                    'basemodelid' => "",
                    'autoanswer' => 1,
                    'agentautoenteridle' => 1,
                    'basemodelid' => 0
                    );

                $db->insert($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USER, $in_ary); 
                
                //用户信息
                $select = $db->select();
                $select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USER, '*');
                $select->where('workid = ?', $workid);
                $select->where('factory_id = ?', $factory_id);
                $select->where('deleteflag = 0'); //未删除
                $userData = $db->fetchRow($select);
                
                
                //技能
                $in_ary = array(
                                    'user_id' => $userData['uid'],
                                    'user_name' => $userData['nickname'],
                                    'skill_id' => 23, //23  酒店前台 
                                    'factory_id' => $factory_id
                                );

                $db->insert($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USERSKILLGROUP, $in_ary);
            } 
        }
         echo "end " . $j;  
    }
    
    public function adduserbbbAction()
    {
        echo "adduser<p/>" ;
        $view = Zend_Registry::get('view');
        $user = Zend_Registry::get('user');
        $db = Zend_Registry::get('dbAdapter');
        $config = Zend_Registry::get('config');
        $factory_id = $config['factory_id'];
        
		//214369-214418
        $j = 0;
        for ($i = 4369 ; $i <= 4418; $i++)
        {   
            $workid = "8821" . (int)$i;
            
            $select = $db->select();
            $select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USER, '*');
            $select->where('workid = ?', $workid);
            $select->where('deleteflag = 0'); //未删除
            $Data = $db->fetchRow($select);
            if ($Data)
            {
                echo "用户 " . $workid . '已存在<p/>';
            }
            else
            {
                $j++;
                echo "新增用户 " . $workid . '<p/>';  
                $in_ary = array(
                    'username' => $workid,
                    'workid' => $workid,
                    'role' => 2,
                    'nickname' => $workid,
                    'factory_id' => 26,
                    'agentid' => 0,
                    'plain' =>$workid,
                    'pwdplaintext' => "648765",
                    'password' => strtoupper(md5("648765")),
                    'plain_pwd' => "123456",  
                    'plain_pwdmd5' => strtoupper(md5("123456")),
                    'fakecalling' => "",
                    'basemodelid' => ""
                    );

                $db->insert($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USER, $in_ary); 
                
                //用户信息
                $select = $db->select();
                $select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USER, '*');
                $select->where('workid = ?', $workid);
                $select->where('factory_id = ?', $factory_id);
                $select->where('deleteflag = 0'); //未删除
                $userData = $db->fetchRow($select);
                
                
                //技能
                $in_ary = array(
                                    'user_id' => $userData['uid'],
                                    'user_name' => $userData['nickname'],
                                    'skill_id' => 24, //12 	0571118114 	26 	酒店中台
                                    'factory_id' => $factory_id
                                );

                $db->insert($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USERSKILLGROUP, $in_ary);
            } 
        }
         echo "end " . $j;  
    }
     public function addusercccAction()
    {
        echo "adduser<p/>" ;
        $view = Zend_Registry::get('view');
        $user = Zend_Registry::get('user');
        $db = Zend_Registry::get('dbAdapter');
        $config = Zend_Registry::get('config');
        $factory_id = $config['factory_id'];
        
        $j = 0;
        for ($i = 4000 ; $i <= 4275; $i++)
        {   
            $workid = "8821" . (int)$i;
            
            $select = $db->select();
            $select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USER, '*');
            $select->where('workid = ?', $workid);
            $select->where('deleteflag = 0'); //未删除
            $Data = $db->fetchRow($select);
            if ($Data)
            {
                echo "用户 " . $workid . '已存在<p/>';
            }
            else
            {
                $j++;
                echo "新增用户 " . $workid . '<p/>';  
                $in_ary = array(
                    'username' => $workid,
                    'workid' => $workid,
                    'role' => 2,
                    'nickname' => $workid,
                    'factory_id' => 26,
                    'agentid' => 0,
                    'plain' =>$workid,
                    'pwdplaintext' => "648765",
                    'password' => strtoupper(md5("648765")),
                    'plain_pwd' => "Hj8966y33",  
                    'plain_pwdmd5' => strtoupper(md5("Hj8966y33")),
                    'fakecalling' => "",
                    'basemodelid' => ""
                    );

                $db->insert($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USER, $in_ary); 
                
                //用户信息
                $select = $db->select();
                $select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USER, '*');
                $select->where('workid = ?', $workid);
                $select->where('factory_id = ?', $factory_id);
                $select->where('deleteflag = 0'); //未删除
                $userData = $db->fetchRow($select);
                
                
                //技能
                $in_ary = array(
                                    'user_id' => $userData['uid'],
                                    'user_name' => $userData['nickname'],
                                    'skill_id' => 23,
                                    'factory_id' => $factory_id
                                );

                $db->insert($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USERSKILLGROUP, $in_ary);
            } 
        }
         echo "end " . $j;  
    }
    public function adduserdddAction()
    {
        echo "adduser<p/>" ;
        $view = Zend_Registry::get('view');
        $user = Zend_Registry::get('user');
        $db = Zend_Registry::get('dbAdapter');
        $config = Zend_Registry::get('config');
        $factory_id = $config['factory_id'];
        
        $j = 0;
        for ($i = 4276 ; $i <= 4368; $i++)
        {   
            $workid = "8821" . (int)$i;
            
            $select = $db->select();
            $select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USER, '*');
            $select->where('workid = ?', $workid);
            $select->where('deleteflag = 0'); //未删除
            $Data = $db->fetchRow($select);
            if ($Data)
            {
                echo "用户 " . $workid . '已存在<p/>';
            }
            else
            {
                $j++;
                echo "新增用户 " . $workid . '<p/>';  
                $in_ary = array(
                    'username' => $workid,
                    'workid' => $workid,
                    'role' => 2,
                    'nickname' => $workid,
                    'factory_id' => 26,
                    'agentid' => 0,
                    'plain' =>$workid,
                    'pwdplaintext' => "648765",
                    'password' => strtoupper(md5("648765")),
                    'plain_pwd' => "Hj8966y33",  
                    'plain_pwdmd5' => strtoupper(md5("Hj8966y33")),
                    'fakecalling' => "",
                    'basemodelid' => ""
                    );

                $db->insert($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USER, $in_ary); 
                
                //用户信息
                $select = $db->select();
                $select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USER, '*');
                $select->where('workid = ?', $workid);
                $select->where('factory_id = ?', $factory_id);
                $select->where('deleteflag = 0'); //未删除
                $userData = $db->fetchRow($select);
                
                
                //技能
                $in_ary = array(
                                    'user_id' => $userData['uid'],
                                    'user_name' => $userData['nickname'],
                                    'skill_id' => 24,
                                    'factory_id' => $factory_id
                                );

                $db->insert($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USERSKILLGROUP, $in_ary);
            } 
        }
         echo "end " . $j;  
    }
    
    public function addscriptAction()
    {
        $view = Zend_Registry::get('view');
        $user = Zend_Registry::get('user');
        $db = Zend_Registry::get('dbAdapter');
        $config = Zend_Registry::get('config');
             //脚本
        $select = $db->select();
        $select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_SCRIPTDB . ' as s', '*');
        $select->where('s.user_id = ?', 34);
        $select->where('s.scriptdb_key = ?', "appsuiteinitial");
        $select->where('s.deleteflag = 0'); //未删除
        $appsuiteinitial = $db->fetchRow($select); 
        print_r($appsuiteinitial);  
        $select = $db->select();
        $select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_SCRIPTDB . ' as s', '*');
        $select->where('s.user_id = ?', 34);
        $select->where('s.scriptdb_key = ?', "onanswersuccess");
        $select->where('s.deleteflag = 0'); //未删除
        $onanswersuccess = $db->fetchRow($select); 
        print_r($onanswersuccess);  
        $select = $db->select();
        $select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_SCRIPTDB . ' as s', '*');
        $select->where('s.user_id = ?', 34);
        $select->where('s.scriptdb_key = ?', "SL");
        $select->where('s.deleteflag = 0'); //未删除
        $SL = $db->fetchRow($select); 
        print_r($SL);  
        
        
        echo "开始>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>" ;
        //用户
        $select = $db->select();
        $select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USER, '*');
        $select->where('utype = 2');
        $select->where('deleteflag = 0'); //未删除
        $Data = $db->fetchAll($select);   

        foreach ($Data as $u)
        {
            echo "<p/>" . $u['uid'];
            $select = $db->select();
            $select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_SCRIPTDB . ' as s', '*');
            $select->where('s.user_id = ?', $u['uid']);
            $select->where('s.scriptdb_key = "appsuiteinitial"'); 
            $select->where('s.deleteflag = 0'); //未删除
            $scriptDataTmp1 = $db->fetchRow($select); 
            if ($appsuiteinitial && !$scriptDataTmp1)
            {
                $in_ary = array(
                    'scriptdb_name' => "appsuiteinitial",
                    'user_id' => $u['uid'],
                    'scriptdb_key' => "appsuiteinitial",   
                    'scriptdb_info' => $appsuiteinitial['scriptdb_info'],
                    'scriptdb_dsc' => "",
                    'flag' => 0,
                    'deleteflag' => 0
                );

                $db->insert($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_SCRIPTDB, $in_ary);    
            }
            
            $select = $db->select();
            $select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_SCRIPTDB . ' as s', '*');
            $select->where('s.user_id = ?', $u['uid']);
            $select->where('s.scriptdb_key = "onanswersuccess"'); 
            $select->where('s.deleteflag = 0'); //未删除
            $scriptDataTmp2 = $db->fetchRow($select); 
            if ($onanswersuccess && !$scriptDataTmp2)
            {    
                  $in_ary = array(
                    'scriptdb_name' => "onanswersuccess",
                    'user_id' => $u['uid'],
                    'scriptdb_key' => "onanswersuccess",   
                    'scriptdb_info' => $onanswersuccess['scriptdb_info'],
                    'scriptdb_dsc' => "",
                    'flag' => 0,
                    'deleteflag' => 0
                );


                $db->insert($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_SCRIPTDB, $in_ary);  
            }
            
            $select = $db->select();
            $select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_SCRIPTDB . ' as s', '*');
            $select->where('s.user_id = ?', $u['uid']);
            $select->where('s.scriptdb_key = "SL"'); 
            $select->where('s.deleteflag = 0'); //未删除
            $scriptDataTmp3 = $db->fetchRow($select); 
            if ($SL && !$scriptDataTmp3)
            {
            $in_ary = array(
                    'scriptdb_name' => "AL",
                    'user_id' => $u['uid'],
                    'scriptdb_key' => "SL",   
                    'scriptdb_info' => $SL['scriptdb_info'],
                    'scriptdb_dsc' => "",
                    'flag' => 0,
                    'deleteflag' => 0
                );

                $db->insert($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_SCRIPTDB, $in_ary);  
            }               
        }
   
    }
    
    public function addmodelAction()
    {
        $view = Zend_Registry::get('view');
        $user = Zend_Registry::get('user');
        $db = Zend_Registry::get('dbAdapter');
        $config = Zend_Registry::get('config');
        
        $j = 0;
        $model = 3401;
        for ($i = 4001 ; $i <= 4200; $i++)
        {   
            
            $select = $db->select();
            $phone_num = "978811" . (int)$i;
            
            $up_ary = array(
                    'basemodel' => $model
                );

            $where = 'phone_num = ' . $phone_num . ' and deleteflag = 0';
            $db->update(TABLE_QNSOFT_PHONE, $up_ary, $where);
            echo "<p/>" . ($i - 4000) . ": " . $phone_num . "  > " .  $model;
            $model++;
            
        }
        echo "end " . $j;  
            
        
    }
    
    public function deluserAction()
    {
        echo "deluser<p/>" ;
        $view = Zend_Registry::get('view');
        $user = Zend_Registry::get('user');
        $db = Zend_Registry::get('dbAdapter');
        $config = Zend_Registry::get('config');
        $factory_id = $config['factory_id'];
        
        $j = 0;
        for ($i = 4369 ; $i <= 4418; $i++)
        {   
            $workid = "8821" . (int)$i;
            
            $select = $db->select();
            $select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USER, '*');
            $select->where('workid = ?', $workid);
            $select->where('deleteflag = 0'); //未删除
            $Data = $db->fetchRow($select);
            if ($Data)
            {
            	$j++;
                echo "用户 " . $workid . '已存在<p/>';
            	$db->delete($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USER, 'workid = ' . $workid);
            	
            	$db->delete($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USERSKILLGROUP, 'user_id = ' . $Data['uid']);
            }
            else
            {
            	echo "用户 " . $workid . '不存在<p/>';
            } 
        }
         echo "end " . $j;  
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
