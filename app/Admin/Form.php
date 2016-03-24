<?php

use App\Model\Form;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(Form::class, function (ModelConfiguration $model) {

    $model->setTitle('Form Items');

    // Display
    $model->onDisplay(function () {

        $display = AdminDisplay::table();

        $display->paginate(50);

        $display->setColumns([

            AdminColumn::text('id')->setLabel('#')
                ->setWidth('30px'),

            AdminColumn::link('title')->setLabel('String'),

            AdminColumn::datetime('created_at')->setLabel('Created At')->setFormat('d.m.Y H:i:s')
                ->setWidth('150px')
                ->setHtmlAttribute('class', 'text-center')
        ]);

        return $display;

    });

    // Create And Edit
    $model->onCreateAndEdit(function($id = null) {

        $form = AdminForm::panel()
            ->addBody([
                AdminFormElement::text('title', 'Title')->required(),
                AdminFormElement::textaddon('textaddon', 'TextAddon')
                    ->setAddon('$')
                    ->placeAfter(),
                AdminFormElement::checkbox('checkbox', 'Checkbox'),
                AdminFormElement::date('date', 'Date'),
                AdminFormElement::time('time', 'Time'),
                AdminFormElement::timestamp('timestamp', 'Timestamp')->setFormat('d.m.Y g:i A'),
            ])
            ->addBody([
                AdminFormElement::select('select', 'Select')
                    ->setOptions([
                        1 => 'First',
                        2 => 'Second',
                        3 => 'Third'
                    ])->nullable(),
            ])
            ->addBody([
                AdminFormElement::image('image', 'Image'),
                AdminFormElement::images('images', 'Images'),
            ])
            ->addBody([
                AdminFormElement::textarea('textarea', 'Textarea'),
                AdminFormElement::wysiwyg('ckeditor', 'Ckeditor'),
            ]);

        return $form;
    });
})
    ->addMenuPage(Form::class, 100);