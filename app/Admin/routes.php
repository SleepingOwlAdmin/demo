<?php

Route::get('', ['as' => 'admin.dashboard', function () {
	$content = 'Define your dashboard here.';
	return AdminSection::view($content, 'Dashboard');
}]);

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