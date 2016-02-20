<?php

use KodiCMS\Users\Model\User;
use KodiCMS\Users\Model\UserRole;
use SleepingOwl\Admin\Filter\Filter;
use SleepingOwl\Admin\Column;
use SleepingOwl\Admin\Filter\FilterBase;
use SleepingOwl\Admin\FormItems\FormItem;
use SleepingOwl\Admin\Display\DisplayTabbed;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(User::class, function (ModelConfiguration $model) {
        $model->setTitle('User')
            ->onDisplay(function () {
                $display = AdminDisplay::tabbed();

                $display->setTabs(function (DisplayTabbed $tabbed) {

                    $tabbed->appendDisplay(
                        AdminDisplay::table()
                            ->setFilters([
                                Filter::field('name')
                                    ->setOperator(FilterBase::BEGINS_WITH)
                                    ->setValue('ad')
                            ])
                            ->setColumns([
                                Column::link('name')->setLabel('name'),
                                Column::lists('roles.name')->setLabel('Roles')->setWidth('300px'),
                                Column::email('email')->setLabel('E-mail')->setWidth('200px'),
                            ]), 'First Tab');

                    $tabbed->appendDisplay(AdminDisplay::table()->setColumns([
                        Column::link('username')->setLabel('Username'),
                    ]), 'Second Tab');
                });

                return $display;
            })->onCreateAndEdit(function () {
                $form = AdminForm::form();
                $form->setItems(
                    FormItem::columns()->addColumn(function() {
                        return [
                            FormItem::wysiwyg('name', 'Username', 'ace')->required(),
                            FormItem::text('email', 'E-mail')->required()->addValidationRule('email'),
                            FormItem::timestamp('created_at', 'Date creation'),
                            FormItem::multiselect('roles', 'Roles')->setModelForOptions(new UserRole)->setDisplay('name'),
                        ];
                    })
                );

                return $form;
            });
    })
    ->addMenuLink(User::class)
    ->setIcon('users');
