<?php
/** 
 * Zend_Controller_Action 
 * 分机管理
 */

class CcController extends Zend_Controller_Action_Qn
{    
    public function init()
    {
        Zend_Controller_Action_Qn::init();
    }
    
    public function indexAction()
    {
         echo '公众机票前台(粤) 员工 116595-116824 :adduseraaa<p/>' ;
         echo '公众机票前台(粤) 班长 116825-116844 :adduserbbb<p/>' ;
         echo '酒店前台（广东本省） 员工 216508-216737 :adduserccc<p/>' ;
         echo '酒店前台（广东本省）  班长 216738-216757 :adduserddd<p/>' ;
         echo '广东VIP队列 员工 616000-616019 :addusereee<p/>' ;
         echo '广东VIP队列 班长 616020-616024 :adduserfff<p/>' ;
  		 echo '房态管控（广东深劳）  216757-216766 :adduserggg<p/>' ;
    }
    
    public function addphoneeeeAction()
    {
        echo "helloworld";
        $view = Zend_Registry::get('view');
        $user = Zend_Registry::get('user');
        $db = Zend_Registry::get('dbAdapter');
        $config = Zend_Registry::get('config');

        $j = 0;
        $model = 2401; 
        for ($i = 6000 ; $i <= 6099; $i++)
        { 
            $phone_num = "978813" . (int)$i;
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
                 echo '新增分机' .  $phone_num . '<p/>';
                 $in_ary = array(
                    'phone_num' => $phone_num,
                    'basemodel' => $model,
                    'factory_id' => 27
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
        $model = 2501; 
        for ($i = 6100 ; $i <= 6149; $i++)
        { 
            $phone_num = "978813" . (int)$i;
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
                 echo '新增分机' .  $phone_num . '<p/>';
                 $in_ary = array(
                    'phone_num' => $phone_num,
                    'basemodel' => $model,
                    'factory_id' => 27
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

	//公众机票前台(粤) 员工 116595-116824 :adduseraaa
    public function adduseraaaAction()
    {
        echo "adduser<p/>" ;
        $view = Zend_Registry::get('view');
        $user = Zend_Registry::get('user');
        $db = Zend_Registry::get('dbAdapter');
        $config = Zend_Registry::get('config');
        $factory_id = $config['factory_id'];
        
        //88116595 - 88116824
        $j = 0;   
        for ($i = 6595 ; $i <= 6824; $i++)
        {   
            $workid = "8811" . (int)$i;
            
            $select = $db->select();
            $select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USER, '*');
            $select->where('workid = ?', $workid);
            $select->where('deleteflag = 0'); //未删除
            $Data = $db->fetchRow($select);
            if ($Data)
            {
                echo "用户 " . $workid . '已存在<p/>';
                $db->delete($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USER, 'workid = ' . $workid);
            	$db->delete($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USERSKILLGROUP, 'user_id = ' . $Data['uid']);
                //更改用户技能
                
                //$up_ary = array(
                //    'skill_id' => 39
                //);
	
	            //$where = 'user_id = ' . $Data['uid'] ;
	            //$db->update($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USERSKILLGROUP, $up_ary, $where);
            }
           // else
           // {
                $j++;
                echo "新增用户 " . $workid . '<p/>';  
                $in_ary = array(
                    'username' => $workid,
                    'workid' => $workid,
                    'role' => 2, //普通坐席
                    'nickname' => $workid,
                    'factory_id' => 27, //广州
                    'agentid' => 0,
                    'plain' =>$workid,
                    'pwdplaintext' => "863713",
                    'password' => strtoupper(md5("863713")),
                    'plain_pwd' => "Hj8966y",  
                    'plain_pwdmd5' => strtoupper(md5("Hj8966y")),
                    'fakecalling' => "",
                    'basemodelid' => "",
                    'initialready' => 1,
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
                                    'skill_id' => 40,// 公众机票前台(粤)
                                    'factory_id' => $factory_id
                                );

                $db->insert($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USERSKILLGROUP, $in_ary);
          // } 
        }
         echo "end " . $j;  
    }
    
    
    //公众机票前台(粤) 班长 116825-116844
    public function adduserbbbAction()
    {
        echo "adduser<p/>" ;
        $view = Zend_Registry::get('view');
        $user = Zend_Registry::get('user');
        $db = Zend_Registry::get('dbAdapter');
        $config = Zend_Registry::get('config');
        $factory_id = $config['factory_id'];
        
        //116825-116844
        $j = 0;   
        for ($i = 6825 ; $i <= 6844; $i++)
        {   
            $workid = "8811" . (int)$i;
            
            $select = $db->select();
            $select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USER, '*');
            $select->where('workid = ?', $workid);
            $select->where('deleteflag = 0'); //未删除
            $Data = $db->fetchRow($select);
            if ($Data)
            {
                echo "用户 " . $workid . '已存在<p/>';
                $db->delete($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USER, 'workid = ' . $workid);
            	$db->delete($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USERSKILLGROUP, 'user_id = ' . $Data['uid']);
                //更改用户技能
                
                //$up_ary = array(
                //    'skill_id' => 39
                //);
	
	            //$where = 'user_id = ' . $Data['uid'] ;
	            //$db->update($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USERSKILLGROUP, $up_ary, $where);
            }
           // else
           // {
                $j++;
                echo "新增用户 " . $workid . '<p/>';  
                $in_ary = array(
                    'username' => $workid,
                    'workid' => $workid,
                    'role' => 1, //班长坐席
                    'nickname' => $workid,
                    'factory_id' => 27, //广州
                    'agentid' => 0,
                    'plain' =>$workid,
                    'pwdplaintext' => "863713",
                    'password' => strtoupper(md5("863713")),
                    'plain_pwd' => "Hj8966y",  
                    'plain_pwdmd5' => strtoupper(md5("Hj8966y")),
                    'fakecalling' => "",
                    'basemodelid' => "",
                    'initialready' => 1,
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
                                    'skill_id' => 40,// 公众机票前台(粤)
                                    'factory_id' => $factory_id
                                );

                $db->insert($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USERSKILLGROUP, $in_ary);
          //  } 
        }
         echo "end " . $j;  
    }

	//酒店前台（广东本省） 员工 216508-216737 :adduserccc
    public function addusercccAction()
    {
        echo "adduser<p/>" ;
        $view = Zend_Registry::get('view');
        $user = Zend_Registry::get('user');
        $db = Zend_Registry::get('dbAdapter');
        $config = Zend_Registry::get('config');
        $factory_id = $config['factory_id'];
        
        //216508-216737
        $j = 0;   
        for ($i = 6508 ; $i <= 6737; $i++)
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
                $db->delete($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USER, 'workid = ' . $workid);
            	$db->delete($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USERSKILLGROUP, 'user_id = ' . $Data['uid']);
                //更改用户技能
                
                //$up_ary = array(
                //    'skill_id' => 39
                //);
	
	            //$where = 'user_id = ' . $Data['uid'] ;
	            //$db->update($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USERSKILLGROUP, $up_ary, $where);
            }
           // else
           // {
                $j++;
                echo "新增用户 " . $workid . '<p/>';  
                $in_ary = array(
                    'username' => $workid,
                    'workid' => $workid,
                    'role' => 2, //普通坐席
                    'nickname' => $workid,
                    'factory_id' => 27, //广州
                    'agentid' => 0,
                    'plain' =>$workid,
                    'pwdplaintext' => "782956",
                    'password' => strtoupper(md5("782956")),
                    'plain_pwd' => "Hj8966y",  
                    'plain_pwdmd5' => strtoupper(md5("Hj8966y")),
                    'fakecalling' => "",
                    'basemodelid' => "",
                    'initialready' => 1,
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
                                    'skill_id' => 41,// 酒店前台(粤)
                                    'factory_id' => $factory_id
                                );

                $db->insert($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USERSKILLGROUP, $in_ary);
         //   } 
        }
         echo "end " . $j;  
    }    
    
    //酒店前台（广东本省）有问题  班长 216738-216757 :adduserddd
    public function adduserdddAction()
    {
        echo "adduser<p/>" ;
        $view = Zend_Registry::get('view');
        $user = Zend_Registry::get('user');
        $db = Zend_Registry::get('dbAdapter');
        $config = Zend_Registry::get('config');
        $factory_id = $config['factory_id'];
        
        //216738-216757
        $j = 0;   
        for ($i = 6738 ; $i <= 6757; $i++)
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
                $db->delete($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USER, 'workid = ' . $workid);
            	$db->delete($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USERSKILLGROUP, 'user_id = ' . $Data['uid']);
                //更改用户技能
                
                //$up_ary = array(
                //    'skill_id' => 39
                //);
	
	            //$where = 'user_id = ' . $Data['uid'] ;
	            //$db->update($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USERSKILLGROUP, $up_ary, $where);
            }
           // else
           // {
                $j++;
                echo "新增用户 " . $workid . '<p/>';  
                $in_ary = array(
                    'username' => $workid,
                    'workid' => $workid,
                    'role' => 1, //班长坐席
                    'nickname' => $workid,
                    'factory_id' => 27, //广州
                    'agentid' => 0,
                    'plain' =>$workid,
                    'pwdplaintext' => "782956",
                    'password' => strtoupper(md5("782956")),
                    'plain_pwd' => "Hj8966y",  
                    'plain_pwdmd5' => strtoupper(md5("Hj8966y")),
                    'fakecalling' => "",
                    'basemodelid' => "",
                    'initialready' => 1,
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
                                    'skill_id' => 41,// 酒店前台(粤)
                                    'factory_id' => $factory_id
                                );

                $db->insert($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USERSKILLGROUP, $in_ary);
           // } 
        }
         echo "end " . $j;  
    }    
    
    //广东VIP队列 员工 616000-616019 :addusereee
    public function addusereeeAction()
    {
        echo "adduser<p/>" ;
        $view = Zend_Registry::get('view');
        $user = Zend_Registry::get('user');
        $db = Zend_Registry::get('dbAdapter');
        $config = Zend_Registry::get('config');
        $factory_id = $config['factory_id'];
        
        //616000-616019
        $j = 0;   
        for ($i = 6000 ; $i <= 6019; $i++)
        {   
            $workid = "8861" . (int)$i;
            
            $select = $db->select();
            $select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USER, '*');
            $select->where('workid = ?', $workid);
            $select->where('deleteflag = 0'); //未删除
            $Data = $db->fetchRow($select);
            if ($Data)
            {
                echo "用户 " . $workid . '已存在<p/>';
                $db->delete($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USER, 'workid = ' . $workid);
            	$db->delete($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USERSKILLGROUP, 'user_id = ' . $Data['uid']);
                //更改用户技能
                
                //$up_ary = array(
                //    'skill_id' => 39
                //);
	
	            //$where = 'user_id = ' . $Data['uid'] ;
	            //$db->update($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USERSKILLGROUP, $up_ary, $where);
            }
           // else
           // {
                $j++;
                echo "新增用户 " . $workid . '<p/>';  
                $in_ary = array(
                    'username' => $workid,
                    'workid' => $workid,
                    'role' => 2, //普通坐席
                    'nickname' => $workid,
                    'factory_id' => 27, //广州
                    'agentid' => 0,
                    'plain' =>$workid,
                    'pwdplaintext' => "936713",
                    'password' => strtoupper(md5("936713")),
                    'plain_pwd' => "Hj8966y",  
                    'plain_pwdmd5' => strtoupper(md5("Hj8966y")),
                    'fakecalling' => "",
                    'basemodelid' => "",
                    'initialready' => 1,
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
                                    'skill_id' => 42,// 广东VIP队列
                                    'factory_id' => $factory_id
                                );

                $db->insert($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USERSKILLGROUP, $in_ary);
          //  } 
        }
         echo "end " . $j;  
    }    
    
    
    //广东VIP队列 班长 616020-616024 :adduserfff
    public function adduserfffAction()
    {
        echo "adduser<p/>" ;
        $view = Zend_Registry::get('view');
        $user = Zend_Registry::get('user');
        $db = Zend_Registry::get('dbAdapter');
        $config = Zend_Registry::get('config');
        $factory_id = $config['factory_id'];
        
        //616020-616024
        $j = 0;   
        for ($i = 6020 ; $i <= 6024; $i++)
        {   
            $workid = "8861" . (int)$i;
            
            $select = $db->select();
            $select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USER, '*');
            $select->where('workid = ?', $workid);
            $select->where('deleteflag = 0'); //未删除
            $Data = $db->fetchRow($select);
            if ($Data)
            {
                echo "用户 " . $workid . '已存在<p/>';
                $db->delete($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USER, 'workid = ' . $workid);
            	$db->delete($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USERSKILLGROUP, 'user_id = ' . $Data['uid']);
                //更改用户技能
                
                //$up_ary = array(
                //    'skill_id' => 39
                //);
	
	            //$where = 'user_id = ' . $Data['uid'] ;
	            //$db->update($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USERSKILLGROUP, $up_ary, $where);
            }
           // else
           // {
                $j++;
                echo "新增用户 " . $workid . '<p/>';  
                $in_ary = array(
                    'username' => $workid,
                    'workid' => $workid,
                    'role' => 1, //班长坐席
                    'nickname' => $workid,
                    'factory_id' => 27, //广州
                    'agentid' => 0,
                    'plain' =>$workid,
                    'pwdplaintext' => "936713",
                    'password' => strtoupper(md5("936713")),
                    'plain_pwd' => "Hj8966y",  
                    'plain_pwdmd5' => strtoupper(md5("Hj8966y")),
                    'fakecalling' => "",
                    'basemodelid' => "",
                    'initialready' => 1,
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
                                    'skill_id' => 42,// 广东VIP队列
                                    'factory_id' => $factory_id
                                );

                $db->insert($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_USERSKILLGROUP, $in_ary);
           // } 
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
        $select->where('s.user_id = ?', 2188);
        $select->where('s.scriptdb_key = ?', "appsuiteinitial");
        $select->where('s.deleteflag = 0'); //未删除
        $appsuiteinitial = $db->fetchRow($select); 
        print_r($appsuiteinitial);  
        $select = $db->select();
        $select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_SCRIPTDB . ' as s', '*');
        $select->where('s.user_id = ?', 2188);
        $select->where('s.scriptdb_key = ?', "onanswersuccess");
        $select->where('s.deleteflag = 0'); //未删除
        $onanswersuccess = $db->fetchRow($select); 
        print_r($onanswersuccess);  
        $select = $db->select();
        $select->from($config['factory_enterprisecode'] . '_' . TABLE_QNSOFT_SCRIPTDB . ' as s', '*');
        $select->where('s.user_id = ?', 2188);
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
