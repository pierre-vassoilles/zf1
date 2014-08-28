<?php
class Core_SoapController extends Zend_Controller_Action
{
	
	private $demoSvc;
	private $cache;
	
	public function init()
	{
		$this->demoSvc = new Core_Service_Demo();
	
		$this->cache = Zend_Controller_Front::getInstance()
		->getParam('bootstrap')
		->getResource('cachemanager')
		->getCache('data1');
	
	}
	
	public function indexAction()
	{
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		
		if(!is_null($this->getRequest()->getParam('wsdl'))){
			//Génération du WSDL
			$wsdl = new Zend_Soap_AutoDiscover();
			$wsdl->setClass('Core_Service_Demo');
			// wsdl->handle() : gère la requête et la réponse au client
			$wsdl->handle();		
		} else {
			//Traitement de la requête
			$soap = new Zend_Soap_Server('http://' . $_SERVER['HTTP_HOST'] . '/ws?wsdl');
			$soap->setClass('Core_Service_Demo');
			$soap->handle();
		}
	}
	
	public function clientAction()
	{
		$demoSvc = new Zend_Soap_Client('http://' . $_SERVER['HTTP_HOST'] . '/ws?wsdl');

		$this->view->toto = $demoSvc->test('toto');
	}
	
	
	
	
}