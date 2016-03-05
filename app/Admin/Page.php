<?php

use App\Model\Page;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(Page::class, function (ModelConfiguration $model) {
    $model->setTitle('Pages');

    // Display
    $model->onDisplay(function () {
        return AdminDisplay::tree()->setValue('title');
    });

    // Create And Edit
    $model->onCreateAndEdit(function() {
        return AdminForm::form()->setItems([
            AdminFormElement::text('title', 'Title')->required(),
            AdminFormElement::ckeditor('text', 'Text')
        ]);
    });
})->addMenuPage(Page::class)->setIcon('fa fa-sitemap');
