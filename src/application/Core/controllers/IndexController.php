<?php 

/**
 * @author Formateur
 * @desc Controlleur par défaut 
 *
 */
class Core_IndexController extends Zend_Controller_Action
{
	public function indexAction()
	{
		
	}
	
	public function testAction()
	{
	
	}
	
	public function signinAction()
	{
		$acl = Zend_Registry::get('Zend_Acl');
		
		if($acl->isAllowed()){
			echo 'IP Non BANNI';
		} else {
			echo 'IP BANNI';
		}
		
		$this->_helper->layout()->setLayout('signin');
		$form = new Core_Form_Auth();
		
		if ($this->getRequest()->isPost()) {
			if ($form->isValid($this->getRequest()->getPost())) {
				$login = $form->getValue('login');
				$password = $form->getValue('password');
				
				$adapter = new Zend_Auth_Adapter_DbTable();
				$adapter->setTableName('user')
						->setIdentityColumn('user_login')
						->setCredentialColumn('user_password')
						->setIdentity($login)
						->setCredential($password);
				
				$auth = Zend_Auth::getInstance();
				
				$authResult = $auth->authenticate($adapter);
				if($authResult->isValid()) {
					$storage = $auth->getStorage();
					
					$mapper = new Core_Model_Mapper_User();
					$user = $mapper->authenticate($adapter->getResultRowObject(null, 'user_password'));
					
					$storage->write($user);			
				}
								
				if ($authResult->getCode() == Zend_Auth_Result::SUCCESS) {
					$this->_redirect('/');
				}
			}
		}
		
		$this->view->form = $form;
	}
	
	public function logoutAction()
	{
		$auth = Zend_Auth::getInstance();
		$auth->clearIdentity();
		$this->_redirect('/');
		
	}
	
	public function clearcacheAction()
	{
		$cache = Zend_Controller_Front::getInstance()
				->getParam('bootstrap')
				->getResource('cachemanager')
				->getCache('data1');
		
		$cache->clean(Zend_Cache::CLEANING_MODE_ALL);
		$this->redirect("/");
	}
}