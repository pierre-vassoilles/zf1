<?php 

class Core_Plugin_Navigation extends Zend_Controller_Plugin_Abstract
{
	public function routeShutdown(Zend_Controller_Request_Abstract $request)
	{
		$cache = Zend_Controller_Front::getInstance()
				->getParam('bootstrap')
				->getResource('cachemanager')
				->getCache('data1');
		
		$categories = $cache->load('categories_data');
		if($categories === false){
			$blogSvc = new Core_Service_Blog();
			$categories = $blogSvc->fetchCategories();
			$cache->save($categories);
		}
			
		// Cible le conteneur Zend_Navigation principal
		$nav = Zend_Registry::get('Zend_Navigation');
		// Cible le sous conteneur Categories (page)
		$categorieNav = $nav->findById('coreArticleCategories');
		
		foreach($categories as $categorie) {
			// Créée la nouvelle page correspondant à chaque catégorie
			$categoriePage = Zend_Navigation_Page::factory(
					array(
							'type' => 'mvc',
							'module' => 'Core',
							'controller' => 'article',
							'action' => 'categorieview',
							'params' => array('id' => $categorie->getId()),
							'route' => 'coreArticleCategorieview',
							'visible' => true,
							'label' => $categorie->getNom()
					)
			);
			// Injecte la nouvelle page dans le sous conteneur Articles
			$categorieNav->addPage($categoriePage);
		}
		
	}
}