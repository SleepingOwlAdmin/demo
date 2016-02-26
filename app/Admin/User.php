<?php

use App\Role;
use App\User;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(User::class, function (ModelConfiguration $model) {
    $model->setTitle('Users')->enableAccessCheck();

    // Display
    $model->onDisplay(function () {
        return AdminDisplay::table()
            ->setWith('roles')
            ->setAttribute('class', 'table-primary')
            ->setColumns([
                AdminColumn::link('name')->setLabel('Username'),
                AdminColumn::email('email')->setLabel('Email')->setWidth('150px'),
                AdminColumn::lists('roles.label')->setLabel('Roles')->setWidth('200px'),
            ])->paginate(20);
    });

    // Create And Edit
    $model->onCreateAndEdit(function() {
        return AdminForm::panel()->addBody([
            AdminFormElement::text('name', 'Username')->required(),
            AdminFormElement::text('email', 'E-mail')->required()->addValidationRule('email'),
            AdminFormElement::multiselect('roles', 'Roles')->setModelForOptions(new Role())->setDisplay('name'),
        ]);
    });
})
    ->addMenuLink(User::class, 'Permissions', 1000)
    ->setIcon('group');
