<?php
class Core_JsonController extends Zend_Controller_Action
{

	private $cache;
	
	public function init()
	{
	
		$this->cache = Zend_Controller_Front::getInstance()
		->getParam('bootstrap')
		->getResource('cachemanager')
		->getCache('data1');
	
	}
	
	public function serverAction()
	{
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		
		$server = new Zend_Json_Server();
		$server->setClass("Core_Service_Blog");
		
		//Autodécouverte du serviceMap (équivalement Json-RPC du WSDL de Soap)
		if($this->getRequest()->isGet()) {
			$server->setTarget('/json')->setEnvelope(Zend_Json_Server_Smd::ENV_JSONRPC_2);
			$smd = $server->getServiceMap();
			
			$this->getResponse()->setHeader('Content-type', 'application/json');
			echo $smd;
			return;
		}
		
		$server->handle();
	}
	
	public function clientAction()
	{

	}
	
	
	
	
}