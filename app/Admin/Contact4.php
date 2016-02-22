<?php

use App\Model\Country;
use App\Model\Contact4;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(Contact4::class, function (ModelConfiguration $model) {
    $model->setTitle('Contacts v.4')->setAlias('contacts4');

    // Display
    $model->onDisplay(function () {
        $display = AdminDisplay::datatables()->setAttribute('class', 'table-primary');
        $display->setWith('country', 'companies');
        $display->setFilters([
            AdminFilter::related('country_id')->setModel(Country::class)
        ]);
        $display->setOrder([[1, 'asc']]);

        $display->setColumns([
           AdminColumn::image('photo')->setLabel('Photo')
                ->setWidth('100px'),
           AdminColumn::link('fullName')->setLabel('Name')
                ->setWidth('200px'),
           AdminColumn::text('height')->setLabel('Height'),
           AdminColumn::datetime('birthday')->setLabel('Birthday')->setFormat('d.m.Y')
                ->setWidth('150px')
                ->setAttribute('class', 'text-center'),
           AdminColumn::text('country.title')->setLabel('Country')->append(AdminColumn::filter('country_id')),
           AdminColumn::lists('companies.title')->setLabel('Companies')
        ]);

        $display->setColumnFilters([
            null,
            AdminColumnFilter::text()->setPlaceholder('Full Name'),
            AdminColumnFilter::range()->setFrom(
                AdminColumnFilter::text()->setPlaceholder('From')
            )->setTo(
                AdminColumnFilter::text()->setPlaceholder('To')
            ),
            AdminColumnFilter::range()->setFrom(
                AdminColumnFilter::date()->setPlaceholder('From Date')->setFormat('d.m.Y')
            )->setTo(
                AdminColumnFilter::date()->setPlaceholder('To Date')->setFormat('d.m.Y')
            ),
            AdminColumnFilter::select()->setPlaceholder('Country')->setModel(new Country)->setDisplay('title'),
            AdminColumnFilter::text()->setPlaceholder('Companies'),
        ]);

        return $display;
    });

})
    ->addMenuLink(Contact4::class)
    ->setIcon('credit-card');
