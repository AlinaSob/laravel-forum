<?php namespace Atrakeur\Forum\Repositories;

use \Atrakeur\Forum\ForumBaseTest;
use \Atrakeur\Forum\Repositories\CategoriesRepository;

class CategoriesRepositoryTest extends ForumBaseTest {

	protected function getPackageProviders()
	{
		return array('\Atrakeur\Forum\ForumServiceProvider');
	}

	protected function getCategoryModelMock($id, $with, $return)
	{
		$modelMock = \Mockery::mock('\Atrakeur\Forum\Models\ForumCategory');

		$modelMock->shouldReceive('where')->with('parent_category', '=', $id)->once()->andReturn($modelMock);
		$modelMock->shouldReceive('with')->with($with)->once()->andReturn($modelMock);
		$modelMock->shouldReceive('get')->once()->andReturn($modelMock);
		$modelMock->shouldReceive('toArray')->once()->andReturn($return);

		return $modelMock;
	}

	public function testGetByParentNull()
	{
		//mock the ForumCategory model
		$modelMock = $this->getCategoryModelMock(null, array(), array());

		$repository = new CategoriesRepository($modelMock);
		$this->assertEquals(array(), $repository->getByParent(null));
	}

	public function testGetByParentInteger()
	{
		//mock the ForumCategory model
		$modelMock = $this->getCategoryModelMock(1, array(), array());

		$repository = new CategoriesRepository($modelMock);
		$this->assertEquals(array(), $repository->getByParent(1));
	}

	public function testGetByParentArray()
	{
		//mock the ForumCategory model
		$modelMock = $this->getCategoryModelMock(1, array(), array());

		$repository = new CategoriesRepository($modelMock);
		$this->assertEquals(array(), $repository->getByParent(array('id' => 1)));
	}

}
