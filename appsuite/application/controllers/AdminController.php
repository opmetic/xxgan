<?php
/** Zend_Controller_Action */

class AdminController extends Zend_Controller_Action_Qn
{    
	public function init()
    {
    	Zend_Controller_Action_Qn::init();
    }
    
    /**
     * 管理后台
     */
    public function indexAction()
    {
    	$view = Zend_Registry::get('view');
    	$user = Zend_Registry::get('user');
    	
    	$view->display('admin.tpl');
    }
    
    /**
     * 脚本编辑
     */
    public function scriptAction()
    {
    	echo 'script helloworld';
    }

  
    
  
    public  function aboutchannelsoftAction()
    {
    	echo "&nbsp;&nbsp;&nbsp;&nbsp;青牛（北京）技术有限公司（简称青牛软件）是一家位于北京西钓鱼台核心地带的外资高新技术企业，是中国领先的通讯软件产品和服务提供商，致力于融合网络（通讯网、计算机网、有线电视网）技术研究和产品开发，在国内电信增值业务平台和呼叫中心平台市场占有率第一。<p/> 
&nbsp;&nbsp;&nbsp;&nbsp;青牛软件成立于2000年，本着“尊重、务实、睿智、健康”的价值理念稳步发展，目前公司规模达800人，办公面积达5000平方米，在全国拥有完善的营销运营体系。<p/>  
&nbsp;&nbsp;&nbsp;&nbsp;青牛软件具有对通讯网络与计算机网络应用市场长期深刻的理解，拥有自主知识产权的统一服务核心技术，为基础电信运营商、增值业务运营商、内容提供商及大型企事业单位在现有网络上创建、部署、管理运营增值业务和交互式服务提供统一的业务支撑环境，并提供跨平台的多网融合解决方案。 
<p/>&nbsp;&nbsp;&nbsp;&nbsp;基于“内容价值最大化，持续为社会创造价值”的企业使命，经过短短9年的发展，青牛软件的电信增值业务平台和呼叫中心平台已经广泛应用于电信、金融、政府、邮政、传媒等重点行业，同时青牛软件与基础运营商、虚拟运营商、内容提供商、设备供应商、系统集成商以及应用开发商形成了良性互动的合作关系，建立起共同成长的新型产业价值链，不断发掘通信网络价值潜力，持续为社会创造价值。 
<p/>&nbsp;&nbsp;&nbsp;&nbsp;2005年4月，软银亚洲、华登国际和中科招商等国内外著名投资基金向青牛软件注资3150万美元，进一步推动青牛软件的国际化和规模化发展，这是当时中国软件行业最大金额的单笔私募融资。也是国际投资者对青牛价值的高度认可。作为中国市场领先的电信增值业务支撑系统及CTI产品提供商，青牛产品已经在电信、金融、政府、媒体等行业广泛使用，特别是与中国移动、中国联通、中国电信三大基础电信运营商的的成功合作为其发挥技术和产品优势进一步奠定了基础。青牛软件将继续以“聚焦客户的信息获取需求，成为一个国际化的根植于软件技术的解决方案和服务提供商”的企业目标积极拓展国内和国际市场，向国际化软件公司大步迈进。 
<p/>&nbsp;&nbsp;&nbsp;&nbsp;面对未来新的产业格局，青牛执着地相信，把握现在即拥有未来，坚持立足于自主核心技术，发挥整体综合优势，利用系统知识完整、对计算机网络应用市场理解深刻和研发能力强的特点，积极致力于融合网络，秉承服务创造幸福的使命，以无处不在的统一服务惠及每一个普通人的生活！
";
    }
    
    public function aaaAction()
    {
    	try{
          $soap = new SoapClient(null, array('location' => 'http://10.10.10.129:60000', 
												'uri' => 'urn:add',
												'style' => SOAP_DOCUMENT,//'document'SOAP_RPC SOAP_DOCUMENT
                                     			'use' => SOAP_LITERAL,//SOAP_LITERAL SOAP_ENCODED
                                     			'trace' => 1));
        //  $soap = new SoapClient('./soap/add.wsdl', array('location' => 'http://10.10.10.129:60000', 'trace' => 1));		
        //  $soapResult = $soap->__soapCall('add', array(array('num1' => 3, 'num2' => 5)));										
		//	$soapResult = $soap->add( array('num1' => 3, 'num2' => 5));
		$soapResult = $soap->add(array(new SoapParam(3, 'num1'), new SoapParam(4, 'num2')));

          print_r($soapResult);


    	}catch (SoapFault $e)
		{
			echo $e;
		}
		return true;

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
    
/**/
	private function removeCell($table, $id)
	{	
		$db = Zend_Registry::get('dbAdapter');
		$up_ary = array(
				'alive' => 0
			);
		$where = $db->quoteInto('id = ?', $id);
		$db->update($table, $up_ary, $where);
	}
}
?>
