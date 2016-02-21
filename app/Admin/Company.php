<?php

use App\Model\Company;
use SleepingOwl\Admin\Column;
use SleepingOwl\Admin\FormItems\FormItem;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(Company::class, function (ModelConfiguration $model) {
    $model->setTitle('Companies');

    // Display
    $model->onDisplay(function () {
        $display = AdminDisplay::table()->setColumns([
            Column::link('title')->setLabel('Title')->setWidth('400px'),
            Column::string('address')->setLabel('Address')->setAttribute('class', 'text-muted'),
        ]);

        $display->paginate(15);

        return $display;
    });

    // Create And Edit
    $model->onCreateAndEdit(function() {
        return AdminForm::form()->setItems([
            FormItem::hidden('contact_id'),
            FormItem::text('title', 'Title')->required()->unique(),
            FormItem::text('address', 'Address'),
            FormItem::text('phone', 'Phone'),
        ]);
    });
})
    ->addMenuLink(Company::class, 'Content')
    ->setIcon('bank');