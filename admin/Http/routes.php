<?php

$router->get('/information', ['as' => 'admin.information', function (\SleepingOwl\Admin\Contracts\Template\TemplateInterface $template) {

    return $template->view(
	    'Define your information here.',
        'Information'
    );

}]);

$router->post('/news/export.json', ['as' => 'admin.news.export', function (\Illuminate\Http\Request $request) {

    $response = new \Illuminate\Http\JsonResponse([
		'title' => 'Congratulation! You exported news.',
		'news' => App\Model\News5::whereIn('id', $request->input('id', []))->get()
	]);

	$response->setJsonOptions(JSON_PRETTY_PRINT);

	return $response;

}]);