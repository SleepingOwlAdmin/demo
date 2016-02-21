<?php

use App\Model\News;
use SleepingOwl\Admin\Column;
use SleepingOwl\Admin\FormItems\FormItem;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(News::class, function (ModelConfiguration $model) {
    $model->setTitle('News');

    // Display
    $model->onDisplay(function () {
        return AdminDisplay::table()->setApply(function($query) {
            $query->orderBy('date', 'desc');
        })->setColumns([
            Column::link('title')->setLabel('Title'),
            Column::datetime('date')->setLabel('Date')->setFormat('d.m.Y')->setWidth('150px'),
            Column::custom()->setLabel('Published')->setCallback(function ($instance) {
                return $instance->published ? '<i class="fa fa-check"></i>' : '<i class="fa fa-minus"></i>';
            })->setWidth('50px')->setAttribute('class', 'text-center'),
        ])->paginate(5);
    });

    // Create And Edit
    $model->onCreateAndEdit(function() {
        return AdminForm::form()->setItems([
            FormItem::text('title', 'Title')->required(),
            FormItem::date('date', 'Date')->required()->setFormat('d.m.Y'),
            FormItem::checkbox('published', 'Published'),
            FormItem::ckeditor('text', 'Text'),
        ]);
    });
})
    ->addMenuLink(News::class, 'Content')
    ->setIcon('newspaper-o');
