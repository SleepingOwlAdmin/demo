<?php

use App\Model\News5;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(News5::class, function (ModelConfiguration $model) {
    $model->setTitle('News v5')->setAlias('news/v5');

    // Display
    $model->onDisplay(function () {
        $display = AdminDisplay::table()->setActions([
                AdminColumn::action('export', 'Export')->setIcon('fa fa-share')->setAction(route('admin.news.export')),
            ])->setColumns([
                AdminColumn::checkbox(),
                AdminColumn::link('title')->setLabel('Title'),
                AdminColumn::datetime('date')->setLabel('Date')->setFormat('d.m.Y')->setWidth('150px'),
                AdminColumn::custom()->setLabel('Published')->setCallback(function ($instance) {
                    return $instance->published ? '<i class="fa fa-check"></i>' : '<i class="fa fa-minus"></i>';
                })->setWidth('50px')->setAttribute('class', 'text-center'),
            ]);

        $display->getActions()->setPlacement('panel.buttons')->setAttribute('class', 'pull-right');

        return $display;
    });

    // Create And Edit
    $model->onCreateAndEdit(function () {
        return AdminForm::form()->setItems([
            AdminFormElement::text('title', 'Title')->required(),
            AdminFormElement::date('date', 'Date')->required()->setFormat('d.m.Y'),
            AdminFormElement::checkbox('published', 'Published'),
            AdminFormElement::ckeditor('text', 'Text'),
        ]);
    });
});
