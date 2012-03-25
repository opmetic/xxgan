<?php
/** Zend_Controller_Action */
class TestController extends Zend_Controller_Action
{
	function indexAction()
	{
		$vcid = $this->_getParam('vcid');
		$skillcode = $this->_getParam('skillcode');
		echo $vcid . '  ' . $skillcode . '<p/>';
		echo "<a href=\"javascript:parent.makeOutCall('13888888888');\">makecall</a>";
	}
}

?>