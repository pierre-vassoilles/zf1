<?php 

class Core_Plugin_Auth extends Zend_Controller_Plugin_Abstract
{
	
	public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request)
	{
		//DMZ
		$exceptions = array (
			"Core::soap::index",
		);
		$resource = $request->getModuleName() . '::' . $request->getControllerName() . '::' . $request->getActionName();
		
		if (!Zend_Auth::getInstance()->hasIdentity() && !in_array($resource, $exceptions)) {
			$request->setModuleName('Core')
					->setControllerName('index')
					->setActionName('signin')
					->setDispatched(true);
		}
	}
}