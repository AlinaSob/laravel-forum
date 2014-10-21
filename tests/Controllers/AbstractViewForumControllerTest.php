<?php namespace Atrakeur\Forum\Controllers;

use \Atrakeur\Forum\ForumBaseTest;

class AbstractViewForumControllerTest extends ForumBaseTest {

	protected function getPackageProviders()
	{
		return array('\Atrakeur\Forum\ForumServiceProvider');
	}

	public function testGetIndex()
	{
		$categoriesMock = $this->createCategoriesMock();
		$topicsMock = $this->createTopicsMock();
		$messagesMock = $this->createMessagesMock();

		$categoryMock = new \stdClass();
		$categoryMock->url = 'url';
		$categoryMock->title = 'title';
		$categoryMock->subtitle = 'title';
		$categoryMock->subcategories = array();
		$categoriesMock->shouldReceive('getByParent')->andReturn(array($categoryMock));

		$controller = $this->createViewController($categoriesMock, $topicsMock, $messagesMock);

		\App::instance('\Atrakeur\Forum\Repositories\CategoriesRepository', $categoriesMock);
		\App::instance('\Atrakeur\Forum\Models\ForumTopic', $topicsMock);
		\App::instance('\Atrakeur\Forum\Controllers\AbstractViewForumController', $controller);

		\Route:: get('testRoute', '\Atrakeur\Forum\Controllers\AbstractViewForumController@getIndex');
		$this->call('GET', 'testRoute');
	}

	public function testGetCategoryInvalid()
	{
		$categoriesMock = $this->createCategoriesMock();
		$topicsMock = $this->createTopicsMock();
		$messagesMock = $this->createMessagesMock();

		$categoriesMock->shouldReceive('getById')->once()->with(31415, array('parentCategory', 'subCategories', 'topics'))->andReturn(null);

		$controller = $this->createViewController($categoriesMock, $topicsMock, $messagesMock);

		\App::instance('\Atrakeur\Forum\Repositories\CategoriesRepository', $categoriesMock);
		\App::instance('\Atrakeur\Forum\Models\ForumTopic', $topicsMock);
		\App::instance('\Atrakeur\Forum\Controllers\AbstractViewForumController', $controller);

		$this->setExpectedException('\Symfony\Component\HttpKernel\Exception\NotFoundHttpException');
		\Route:: get('testRoute/{categoryId}/{categoryUrl}', '\Atrakeur\Forum\Controllers\AbstractViewForumController@getCategory');
		$this->call('GET', 'testRoute/31415/FalseTestName');
	}

	public function testGetCategory()
	{
		$categoriesMock = $this->createCategoriesMock();
		$topicsMock = $this->createTopicsMock();
		$messagesMock = $this->createMessagesMock();

		$categoryMock = new \stdClass();
		$categoryMock->url = 'url';
		$categoryMock->postUrl = 'url';
		$categoryMock->title = 'title';
		$categoryMock->canPost = false;
		$categoryMock->subtitle = 'title';
		$categoryMock->subCategories = array();
		$categoryMock->topics = array();
		$categoryMock->parentCategory = null;
		$categoriesMock->shouldReceive('getById')->once()->with(1, array('parentCategory', 'subCategories', 'topics'))->andReturn($categoryMock);

		$controller = $this->createViewController($categoriesMock, $topicsMock, $messagesMock);

		\App::instance('\Atrakeur\Forum\Repositories\CategoriesRepository', $categoriesMock);
		\App::instance('\Atrakeur\Forum\Models\ForumTopic', $topicsMock);
		\App::instance('\Atrakeur\Forum\Controllers\AbstractViewForumController', $controller);

		\Route:: get('testRoute/{categoryId}/{categoryUrl}', '\Atrakeur\Forum\Controllers\AbstractViewForumController@getCategory');
		$this->call('GET', 'testRoute/1/title');
	}

	public function tearDown()
	{
		\Mockery::close();
	}

}
