<?php

use App\Model\Contact;
use App\Model\Country;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(Country::class, function (ModelConfiguration $model) {
    $model->setTitle('Countries (orderable)');

    $model->onDisplay(function() {
        $display = AdminDisplay::table();

        $display->setHtmlAttribute('class', 'table-bordered table-success table-hover');

        $display->setApply(function ($query) {
            $query->orderBy('order', 'asc');
        });

        $display->setColumns([
            AdminColumn::text('id')
                ->setLabel('#')
                ->setWidth('30px'),
            AdminColumn::link('title')->setLabel('Title'),
            AdminColumn::count('contacts')
                ->setLabel('Contacts')
                ->setWidth('100px')
                ->setHtmlAttribute('class', 'text-center')
                ->append(
                    AdminColumn::filter('country_id')->setModel(new Contact)
                ),
            AdminColumn::order()
                ->setLabel('Order')
                ->setHtmlAttribute('class', 'text-center')
                ->setWidth('100px'),
        ]);

        return $display;
    });

    $model->onCreateAndEdit(function($id = null) {
        $form = AdminForm::form();
        $form->setItems([
            AdminFormElement::text('title', 'Title')->required()->unique(),
        ]);
        return $form;
    });
})
    ->addMenuPage(Country::class)
    ->setIcon('fa fa-globe');
