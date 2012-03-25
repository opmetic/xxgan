<?php

/**
* soap
*
*/
class SoapModel
{
	/**
	 * 初始化
	 * @var object
	 */
	private $db = null;

	/**
	 * 构造函数
	 */	
	function __construct()
	{
		$this->db = $db = Zend_Registry::get('dbAdapter');
	}
	
	public function get10086Flow($ip, &$result)
	{             
		try {                
			$soap = new SoapClient('./soap/encoding/qn.wsdl', array('location' => 'http://' . $ip . ':60000'));

			$soapResult = $soap->getFlow(array());
			$result = (array)$soapResult;
		} catch (Exception $e) {
		    $result = null;
		    return false;
		}
		return true;
	}
	
	public function set10086Flow($ip, $newflow, &$result)
	{             
		try {                
			$soap = new SoapClient('./soap/encoding/qn.wsdl', array('location' => 'http://' . $ip . ':60000'));
	
			$soapResult = $soap->setFlow(array('newFlow' => $newflow));
			$result = (array)$soapResult;
		} catch (Exception $e) {
		    $result = null;
		    return false;
		}
		return true;
	}
	
	
	
	public function getFlowByTag($ip, $tag, &$result)
	{             
		
		try {                
			$soap = new SoapClient('./soap/encoding/qn.wsdl', array('location' => 'http://' . $ip . ':60000'));
			$soapResult = $soap->getFlowByTag(array('tag' => $tag));
			$result = (array)$soapResult;
		} catch (Exception $e) {
		    $result = null;
		    return false;
		}
		return true;
	}
	
	public function setFlowByTag($ip, $tag, $newTagFlow, &$result)
	{             
		try {                
			$soap = new SoapClient('./soap/encoding/qn.wsdl', array('location' => 'http://' . $ip . ':60000'));
	
			$soapResult = $soap->setFlowByTag(array('tag' => $tag, 'newTagFlow' => $newTagFlow));
			$result = (array)$soapResult;
		} catch (Exception $e) {
		    $result = null;
		    return false;
		}
		return true;
	}	
	
	
	
	
	
	
	public function get12580Flow($ip, &$result)
	{             
		try {                
			$soap = new SoapClient('./soap/encoding/qn.wsdl', array('location' => 'http://' . $ip . ':60000'));
	
			$soapResult = $soap->getFlow(array());
			$result = (array)$soapResult;
		} catch (Exception $e) {
		    $result = null;
		    return false;
		}
		return true;
	}
	
	public function set12580Flow($ip, $newflow, &$result)
	{             
		try {                
			$soap = new SoapClient('./soap/encoding/qn.wsdl', array('location' => 'http://' . $ip . ':60000'));
	
			$soapResult = $soap->setFlow(array('newFlow' => $newflow));
			$result = (array)$soapResult;
		} catch (Exception $e) {
		    $result = null;
		    return false;
		}
		return true;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	public function aaa()
	{
				$client = new SoapClient(NULL, 
        array( 
        "location" => "http://10.10.142.94:60000", 
        "uri"      => "urn:xmethods-delayed-quotes", 
        "style"    => SOAP_RPC, 
        "use"      => SOAP_ENCODED 
           )); 

print_r($client->__call( 
        /* SOAP Method Name */ 
        "getFlow", 
        /* Parameters */ 
        array( 
        ), 
        /* Options */ 
        array( 
            /* SOAP Method Namespace */ 
            "uri" => "urn:xmethods-delayed-quotes", 
            /* SOAPAction HTTP Header for SOAP Method */ 
            "soapaction" => "urn:xmethods-delayed-quotes#getQuote" 
        )). "\n"); 
exit;
	}
}
?>