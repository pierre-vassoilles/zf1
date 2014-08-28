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
			//G�n�ration du WSDL
			$wsdl = new Zend_Soap_AutoDiscover();
			$wsdl->setClass('Core_Service_Demo');
			// wsdl->handle() : g�re la requ�te et la r�ponse au client
			$wsdl->handle();		
		} else {
			//Traitement de la requ�te
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