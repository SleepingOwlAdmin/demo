<?php

use App\Model\Country;
use App\Model\Contact4;
use SleepingOwl\Admin\Column;
use SleepingOwl\Admin\Filter\Filter;
use SleepingOwl\Admin\Model\ModelConfiguration;
use SleepingOwl\Admin\Column\Filter\ColumnFilter;

AdminSection::registerModel(Contact4::class, function (ModelConfiguration $model) {
    $model->setTitle('Contacts v.4')->setAlias('contacts4');

    // Display
    $model->onDisplay(function () {
        $display = AdminDisplay::datatables()->setAttribute('class', 'table-primary');
        $display->setWith('country', 'companies');
        $display->setFilters([
            Filter::related('country_id')->setModel(Country::class)
        ]);
        $display->setOrder([[1, 'asc']]);

        $display->setColumns([
            Column::image('photo')->setLabel('Photo')
                ->setWidth('100px'),
            Column::link('fullName')->setLabel('Name')
                ->setWidth('200px'),
            Column::string('height')->setLabel('Height'),
            Column::datetime('birthday')->setLabel('Birthday')->setFormat('d.m.Y')
                ->setWidth('150px')
                ->setAttribute('class', 'text-center'),
            Column::string('country.title')->setLabel('Country')->append(Column::filter('country_id')),
            Column::lists('companies.title')->setLabel('Companies')
        ]);

        $display->setColumnFilters([
            null,
            ColumnFilter::text()->setPlaceholder('Full Name'),
            ColumnFilter::range()->setFrom(
                ColumnFilter::text()->setPlaceholder('From')
            )->setTo(
                ColumnFilter::text()->setPlaceholder('To')
            ),
            ColumnFilter::range()->setFrom(
                ColumnFilter::date()->setPlaceholder('From Date')->setFormat('d.m.Y')
            )->setTo(
                ColumnFilter::date()->setPlaceholder('To Date')->setFormat('d.m.Y')
            ),
            ColumnFilter::select()->setPlaceholder('Country')->setModel(new Country)->setDisplay('title'),
            ColumnFilter::text()->setPlaceholder('Companies'),
        ]);

        return $display;
    });

})
    ->addMenuLink(Contact4::class)
    ->setIcon('credit-card');
