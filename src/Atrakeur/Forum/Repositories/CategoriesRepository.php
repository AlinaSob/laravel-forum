<?php namespace Atrakeur\Forum\Repositories;

use \Atrakeur\Forum\Models\ForumCategory;

class CategoriesRepository extends AbstractBaseRepository {

	public function __construct(ForumCategory $model)
	{
		$this->model = $model;
	}

	public function getById($id, array $with = array())
	{
		if (!is_numeric($id))
		{
			throw new \InvalidArgumentException();
		}

		return $this->getFirstBy('id', $id, $with);
	}

	public function getByParent($parent, array $with = array())
	{
		if (is_array($parent) && isset($parent['id'])) 
		{
			$parent = $parent['id'];
		}

		if ($parent != null && !is_numeric($parent))
		{
			throw new \InvalidArgumentException();
		}

		return $this->getManyBy('parent_category', $parent, $with);
	}

}