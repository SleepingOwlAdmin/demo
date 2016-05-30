<?php

Route::get('', ['as' => 'admin.dashboard', 'uses' => '\App\Http\Controllers\HomeController@dashboard']);

Route::get('/information', ['as' => 'admin.information', function () {
	$content = 'Define your information here.';
	return AdminSection::view($content, 'Information');
}]);

Route::post('/news/export.json', ['as' => 'admin.news.export', function () {
	$response = new \Illuminate\Http\JsonResponse([
		'title' => 'Congratulation! You exported news.',
		'news' => App\Model\News5::whereIn('id', Request::get('id', []))->get()
	]);

	$response->setJsonOptions(JSON_PRETTY_PRINT);

	return $response;
}]);