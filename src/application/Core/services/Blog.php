<?php 

class Core_Service_Blog
{
	
	
	/**
	 * 
	 * @param string $asArray
	 * @return multitype:Core_Model_Categorie |multitype:Ambigous <the, string>
	 */
	public function fetchCategories($asArray = false)
	{
		$mapper = new Core_Model_Mapper_Categorie();
		$result = $mapper->fetchAll();
		if (false === $asArray) {
			return $result;
		} else {
			$resultArray = array();
			foreach($result as $categorie) {
				$resultArray[$categorie->getId()] = $categorie->getNom();
			}
			return $resultArray;
		}
		
	}
	
	 /**
	  * 
	  * @param string $asArray
	  * @return multitype:Core_Model_Author |multitype:Ambigous <the, string>
	  */
	public function fetchAuthors($asArray = false)
	{
		$mapper = new Core_Model_Mapper_Author();
		$result = $mapper->fetchAll();
		if (false === $asArray) {
			return $result;
		} else {
			$resultArray = array();
			foreach($result as $author) {
				$resultArray[$author->getId()] = $author->getName();
			}
			return $resultArray;
		}
	
	}
	
	 /**
	  * 
	  * @param number $id
	  * @throws InvalidArgumentException
	  * @return Core_Model_Categorie
	  */
	public function findCategorie($id)
	{
		if (0 === (int) $id) {
			throw new InvalidArgumentException('id doit être un entier supérieur à 1');
		}
		
		$mapper = new Core_Model_Mapper_Categorie();
		return $mapper->find($id);
	}
	
	/**
	 * Fetches last articles (ordered by date)
	 * @param number $count number of fetched articles
	 */
	public function fetchLastArticles($count = 5)
	{
		$count = (int) $count;
		
		if (0 === $count) {
			throw new InvalidArgumentException('count doit être un entier supérieur à 1');
		}

		$mapper = new Core_Model_Mapper_Article;
		$articles = $mapper->fetchAll(null,'article_id DESC', $count);

		return $articles;
		
	}
	
	/**
	 * @param number $articleId
	 * @throws InvalidArgumentException
	 * @return Core_Model_Article
	 */
	public function fetchArticleById($articleId)
	{
		if (0 === (int) $articleId) {
			throw new InvalidArgumentException('articleId doit être un entier supérieur à 1');
		}
		
		$mapper = new Core_Model_Mapper_Article;
		$article = $mapper->find($articleId);
		
		return $article;
		
	}
	
	/**
	 * 
	 * @param number $id
	 * @throws InvalidArgumentException
	 * @return multitype:Core_Model_Article
	 */
	public function fetchArticlesByCategory($id)
	{
		if (0 === (int) $id) {
			throw new InvalidArgumentException('id doit être un entier supérieur à 1');
		}
		
		$mapper = new Core_Model_Mapper_Article;
		$where = array(Core_Model_Mapper_Article::COL_CATEGORIE_ID . ' = ?' => $id);
		$articles = $mapper->fetchAll($where,'article_id DESC');
		
		return $articles;
		
		
	}
	
	/**
	 * 
	 * @param Core_Model_Article $article
	 */
	public function saveArticle(Core_Model_Article $article)
	{
		$mapper = new Core_Model_Mapper_Article;
		$mapper->save($article);
	}
	
	/**
	 * 
	 * @param string $comment
	 * @param number $article
	 * @param number $user
	 * @throws InvalidArgumentException
	 * @throws Exception
	 * @return boolean
	 */
	public function saveComment($comment, $article, $user)
	{
		if(0 === (int) $article){
			throw new InvalidArgumentException('Article inconnu');
		}
		if(0 === (int) $user){
			throw new InvalidArgumentException('User inconnu');
		}
		
		$comment = htmlentities(strip_tags($comment));
		
		$db = Zend_Controller_Front::getInstance()
			->getParam('bootstrap')
			->getResource('multidb')
			->getDb('db1');
		
		$sql = "INSERT INTO article_comment (article_id, user_id, comment_content, comment_datetime)
				VALUES (?, ?, ?, NOW())";

		try {
			return (bool) $db->query($sql, array($article, $user, $comment));
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	/**
	 * 
	 * @param number $article
	 * @throws InvalidArgumentException
	 * @throws Exception
	 */
	public function readComments($article)
	{
		if(0 === (int) $article){
			throw new InvalidArgumentException('Article inconnu');
		}
		
		$db = Zend_Controller_Front::getInstance()
		->getParam('bootstrap')
		->getResource('multidb')
		->getDb('db1');
		
		$sql = "SELECT ac.*, u.user_login FROM article_comment ac, user u
				WHERE article_id = ?
					AND ac.user_id = u.user_id
				ORDER BY comment_datetime ASC";
		
		try {				
			return $db->fetchAll($sql, $article);
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	/**
	 * Removes a comment with his ID
	 * @param integer $commentId
	 */
	public function removeComment($commentId)
	{
		if(0 === (int) $commentId){
			throw new InvalidArgumentException('Commentaire inconnu');
		}
		
		$db = Zend_Controller_Front::getInstance()
				->getParam('bootstrap')
				->getResource('multidb')
				->getDb('db1');
		
		$sql = "DELETE FROM article_comment WHERE comment_id = ?";
		
		try {
			return $db->query($sql, $commentId);
		} catch (Exception $e) {
			throw $e;
		}
	}
}