<?php

use App\Model\Contact;
use App\Model\Country;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(Contact::class, function (ModelConfiguration $model) {
    $model->setTitle('Contacts')->enableAccessCheck();

    $model->onDisplay(function () {
        $display = AdminDisplay::table();

        $display->setAttribute('class', 'table-info table-hover');

        $display->setWith('country', 'companies');
        $display->setFilters([
            AdminFilter::related('country_id')->setModel(Country::class)
        ]);

        $display->setColumns([
            AdminColumn::image('photo')
                ->setLabel('Photo<br/><small>(image)</small>')
                ->setWidth('100px'),
            AdminColumn::text('fullName')
                ->setLabel('Name<br/><small>(string with accessor)</small>')
                ->setWidth('200px'),
            AdminColumn::datetime('birthday')
                ->setLabel('Birthday<br/><small>(datetime)</small>')
                ->setWidth('150px')
                ->setAttribute('class', 'text-center')
                ->setFormat('d.m.Y'),
            AdminColumn::text('country.title')
                ->setLabel('Country<br/><small>(string from related model)</small>')
                 ->append(
                     AdminColumn::filter('country_id')
                ),
            AdminColumn::count('companies')
                ->setLabel('Companies<br/><small>(count)</small>')
                ->setAttribute('class', 'text-center')
                ->setWidth('50px'),
            AdminColumn::lists('companies.title')->setLabel('Companies<br/><small>(lists)</small>'),
            AdminColumn::custom()->setLabel('Has Photo?<br/><small>(custom)</small>')->setCallback(function ($instance) {
                return $instance->photo ? '<i class="fa fa-check"></i>' : '<i class="fa fa-minus"></i>';
            })
                ->setAttribute('class', 'text-center')
                ->setWidth('50px'),
        ]);

        return $display;
    });
})->addMenuLink(Contact::class)->setIcon('user');
