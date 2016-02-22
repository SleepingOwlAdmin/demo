<?php

use App\Model\Company;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(Company::class, function (ModelConfiguration $model) {
    $model->setTitle('Companies');

    // Display
    $model->onDisplay(function () {
        $display = AdminDisplay::table()->setColumns([
            AdminColumn::link('title')->setLabel('Title')->setWidth('400px'),
            AdminColumn::text('address')->setLabel('Address')->setAttribute('class', 'text-muted'),
        ]);

        $display->paginate(15);

        return $display;
    });

    // Create And Edit
    $model->onCreateAndEdit(function() {
        return AdminForm::panel()->setItems([
            [
                AdminFormElement::hidden('contact_id'),
                AdminFormElement::text('title', 'Title')->required()->unique(),
                AdminFormElement::text('address', 'Address'),
                AdminFormElement::text('phone', 'Phone')
            ]
        ]);
    });
})
    ->addMenuLink(Company::class, 'Content')
    ->setIcon('bank');