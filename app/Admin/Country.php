<?php

use App\Model\Contact;
use App\Model\Country;
use SleepingOwl\Admin\Column;
use SleepingOwl\Admin\FormItems\FormItem;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(Country::class, function (ModelConfiguration $model) {
    $model->setTitle('Countries (orderable)');

    $model->onDisplay(function() {
        $display = AdminDisplay::table();

        $display->setAttribute('class', 'table-bordered table-success table-hover');

        $display->setApply(function ($query) {
            $query->orderBy('order', 'asc');
        });

        $display->setColumns([
            Column::string('id')
                ->setLabel('#')
                ->setWidth('30px'),
            Column::link('title')->setLabel('Title'),
            Column::count('contacts')
                ->setLabel('Contacts')
                ->setWidth('100px')
                ->setAttribute('class', 'text-center')
                ->append(
                    Column::filter('country_id')->setModel(new Contact)
                ),
            Column::order()
                ->setLabel('Order')
                ->setAttribute('class', 'text-center')
                ->setWidth('100px'),
        ]);

        return $display;
    });

    $model->onCreateAndEdit(function($id = null) {
        $form = AdminForm::form();
        $form->setItems([
            FormItem::text('title', 'Title')->required()->unique(),
        ]);
        return $form;
    });
})
    ->addMenuLink(Country::class)
    ->setIcon('globe');
