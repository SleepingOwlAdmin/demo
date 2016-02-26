<?php

use App\User;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(User::class, function (ModelConfiguration $model) {
    $model->setTitle('Users');

    // Display
    $model->onDisplay(function () {
        return AdminDisplay::table()
            ->setAttribute('class', 'table-primary')
            ->setColumns([
                AdminColumn::link('name')->setLabel('Username'),
                AdminColumn::email('email')->setLabel('Email')->setWidth('150px'),
                AdminColumn::lists('roles.name')->setLabel('Roles')->setWidth('200px'),
            ])->paginate(20);
    });

    // Create And Edit
    $model->onCreateAndEdit(function() {
        return AdminForm::form()->setItems([
            AdminFormElement::text('name', 'Username')->required()
        ]);
    });

    $model->disableDeleting();
})
    ->addMenuLink(User::class)
    ->setIcon('group');
