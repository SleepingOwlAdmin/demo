<?php

use App\Model\News4;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(News4::class, function (ModelConfiguration $model) {
    $model->setTitle('News v4')->setAlias('news/v4');

    // Display
    $model->onDisplay(function () {
        $display = AdminDisplay::table()
            ->setFilters([
                AdminDisplayFilter::scope('last')->setTitle('Latest News'),
                AdminDisplayFilter::field('published')->setTitle(function ($value) {
                    return $value ? 'Published' : 'Not Published';
                }),
                AdminDisplayFilter::custom('limit')->setTitle(function ($value) {
                    return 'Limit: '.$value;
                })->setCallback(function ($query, $value) {
                    $query->limit($value);
                })
            ])
            ->setColumns([
                AdminColumn::link('title')->setLabel('Title'),
                AdminColumn::datetime('date')->setLabel('Date')->setFormat('d.m.Y')->setWidth('150px'),
                AdminColumn::custom()->setLabel('Published')->setCallback(function ($instance) {
                    return $instance->published ? '<i class="fa fa-check"></i>' : '<i class="fa fa-minus"></i>';
                })->setWidth('50px')->setAttribute('class', 'text-center'),
            ]);

        return $display;
    });

    // Create And Edit
    $model->onCreateAndEdit(function() {
        return AdminForm::form()->setItems([
            AdminFormElement::text('title', 'Title')->required(),
            AdminFormElement::date('date', 'Date')->required()->setFormat('d.m.Y'),
            AdminFormElement::checkbox('published', 'Published'),
            AdminFormElement::ckeditor('text', 'Text'),
        ]);
    });
});
