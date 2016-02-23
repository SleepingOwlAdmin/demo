<?php

use App\Model\Company;
use App\Model\Country;
use App\Model\Contact2;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(Contact2::class, function (ModelConfiguration $model) {
    $model->setTitle('Contacts v.2')->setAlias('contacts2');

    // Display
    $model->onDisplay(function () {
        $display = AdminDisplay::table();
        $display->setWith('country', 'companies');
        $display->setFilters([
            AdminFilter::related('country_id')->setModel(Country::class)
        ]);

        $display->setColumns([
            AdminColumn::image('photo')->setLabel('Photo')
                ->setWidth('100px'),
            AdminColumn::link('fullName')->setLabel('Name')
                ->setWidth('200px'),
            AdminColumn::datetime('birthday')->setLabel('Birthday')->setFormat('d.m.Y')
                ->setWidth('150px')
                ->setAttribute('class', 'text-center'),
            AdminColumn::text('country.title')->setLabel('Country')->append(AdminColumn::filter('country_id')),
            AdminColumn::lists('companies.title')->setLabel('Companies'),
        ]);

        return $display;
    });

    // Create And Edit
    $model->onCreateAndEdit(function($id = null) {
        $form = AdminForm::panel();

        $form->setItems(
            AdminFormElement::columns()
                ->addColumn(function() {
                    return [
                        AdminFormElement::text('firstName', 'First Name')
                            ->required('Please, type first name'),

                        AdminFormElement::text('lastName', 'Last Name')
                            ->required()
                            ->addValidationMessage('required', 'You need to set last name'),

                        AdminFormElement::text('phone', 'Phone'),
                        AdminFormElement::text('address', 'Address'),
                    ];
                })->addColumn(function() {
                    return [
                        AdminFormElement::image('photo', 'Photo'),
                        AdminFormElement::date('birthday', 'Birthday')->setFormat('d.m.Y'),
                    ];
                })->addColumn(function() {
                    return [
                        AdminFormElement::select('country_id', 'Country')->setModelForOptions(new Country)->setDisplay('title'),
                        AdminFormElement::multiselect('companies', 'Companies')->setModelForOptions(new Company)->setDisplay('title'),
                        AdminFormElement::textarea('comment', 'Comment'),
                    ];
                })
        );

        $form->setSaveButtonText('Save contact');
        $form->hideCancelButton();

        return $form;
    });

})
    ->addMenuLink(Contact2::class)
    ->setIcon('fax');
