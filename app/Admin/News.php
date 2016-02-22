<?php

use App\Model\News;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(News::class, function (ModelConfiguration $model) {
    $model->setTitle('News');

    // Display
    $model->onDisplay(function () {
        return AdminDisplay::table()->setApply(function($query) {
            $query->orderBy('date', 'desc');
        })->setColumns([
            AdminColumn::link('title')->setLabel('Title'),
            AdminColumn::datetime('date')->setLabel('Date')->setFormat('d.m.Y')->setWidth('150px'),
            AdminColumn::custom()->setLabel('Published')->setCallback(function ($instance) {
                return $instance->published ? '<i class="fa fa-check"></i>' : '<i class="fa fa-minus"></i>';
            })->setWidth('50px')->setAttribute('class', 'text-center'),
        ])->paginate(5);
    });

    // Create And Edit
    $model->onCreateAndEdit(function() {
        $form = AdminForm::form()->setItems([
            AdminFormElement::text('title', 'Title')->required(),
            AdminFormElement::date('date', 'Date')->required()->setFormat('d.m.Y'),
            AdminFormElement::checkbox('published', 'Published'),
            AdminFormElement::ckeditor('text', 'Text'),
        ]);

        $form->setSaveButtonText('Save news');
        $form->hideSaveAndCloseButton();

        return $form;
    });
})
    ->addMenuLink(News::class, 'Content')
    ->setIcon('newspaper-o');
