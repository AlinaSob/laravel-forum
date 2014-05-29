<?php
if (!isset($routebase) || !isset($viewController) || !isset($postController)) {
	throw new Exception ('This file can\'t be included outside of ForumServiceProvider@boot!');
}

/*
 *  Defines routes used by Forum controller
 */
\Route:: get($routebase, $viewController.'@getIndex');
\Route:: get($routebase.'{categoryId}-{categoryUrl}', $viewController.'@getCategory');
\Route:: get($routebase.'{categoryId}-{categoryUrl}/{topicId}-{topicUrl}', $viewController.'@getTopic');

\Route:: get($routebase.'{categoryId}-{categoryUrl}/new', $postController.'@getNewTopic');
\Route::post($routebase.'{categoryId}-{categoryUrl}/new', $postController.'@postNewTopic');
