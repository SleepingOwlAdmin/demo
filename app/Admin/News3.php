<?php

use App\Model\News3;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(News3::class, function (ModelConfiguration $model) {
    $model->setTitle('News v3')->setAlias('news/v3');

    // Display
    $model->onDisplay(function () {

        $display = AdminDisplay::tabbed();

        $display->setTabs(function() {

            $tabs = [];

            $columns = [
                AdminColumn::link('title')->setLabel('Title'),
                AdminColumn::datetime('date')->setLabel('Date')->setFormat('d.m.Y')->setWidth('150px'),
                AdminColumn::custom()->setLabel('Published')->setCallback(function ($instance) {
                    return $instance->published ? '<i class="fa fa-check"></i>' : '<i class="fa fa-minus"></i>';
                })->setWidth('50px')->setHtmlAttribute('class', 'text-center'),
            ];

            $main = AdminDisplay::table()->paginate(20, 'news');
            $main->setColumns($columns);

            $tabs[] = AdminDisplay::tab($main)->setLabel('Main')->setActive();

            $withScope = AdminDisplay::table();

            $withScope->getScopes()->push('last');

            $withScope->setColumns($columns);

            $tabs[] = AdminDisplay::tab($withScope)->setLabel('With Scope');

            $otherColumns = AdminDisplay::table();
            $otherColumns->setApply(function ($query) {
                $query->orderBy('title', 'asc');
            });

            $otherColumns->setColumns([
                AdminColumn::link('title')->setLabel('Title'),
                AdminColumn::custom()->setLabel('Title Length')->setCallback(function ($instance) {
                    return strlen($instance->title);
                })->setWidth('50px')->setHtmlAttribute('class', 'text-center'),
            ]);

            $tabs[] = AdminDisplay::tab($otherColumns)->setLabel('Other Columns and Order');

            return $tabs;
        });

        return $display;
    });

    // Create And Edit
    $model->onCreateAndEdit(function() {
        $form = AdminForm::panel()
            ->addBody([
                AdminFormElement::text('title', 'Title')->required(),
                AdminFormElement::date('date', 'Date')->required()->setFormat('d.m.Y'),
                AdminFormElement::checkbox('published', 'Published'),
            ])->addBody([
                AdminFormElement::ckeditor('text', 'Text'),
            ]);

        $form->getButtons()
            ->setSaveButtonText('Save news')
            ->hideSaveAndCloseButton();

        return $form;
    });
});
