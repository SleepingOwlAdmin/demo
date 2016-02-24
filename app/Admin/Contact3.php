<?php

use App\Model\Country;
use App\Model\Company;
use App\Model\Contact;
use App\Model\Contact3;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(Contact3::class, function (ModelConfiguration $model) {
    $model->setTitle('Contacts v.3')->setAlias('contacts/v3');

    // Display
    $model->onDisplay(function () {
        $display = AdminDisplay::table();
        $display->setWith('country', 'companies');
        $display->setFilters([
            AdminFilter::related('country_id')->setModel(Country::class)
        ]);

        $display->setColumns([
            $photoColumn = AdminColumn::image('photo')->setLabel('Photo'),
            $fullNameColumn = AdminColumn::link('fullName')->setLabel('Name'),
            $birthdayColumn = AdminColumn::datetime('birthday')->setLabel('Birthday')->setFormat('d.m.Y'),
            $countyTitleColumn = AdminColumn::text('country.title')->setLabel('Country')->append(AdminColumn::filter('country_id')),
            $companyTitleColumn = AdminColumn::lists('companies.title')->setLabel('Companies'),
        ]);

        $photoColumn->getHeader()->setAttribute('class', 'bg-success');
        $fullNameColumn->getHeader()->setAttribute('class', 'bg-primary');
        $birthdayColumn->getHeader()->setAttribute('class', 'bg-orange');
        $countyTitleColumn->getHeader()->setAttribute('class', 'bg-maroon');
        $companyTitleColumn->getHeader()->setAttribute('class', 'bg-purple');

        // Change Control Column
        $display->getControlColumn()->getHeader()->setTitle('Control')->setAttribute('class', 'bg-black');

        return $display;
    });

    // Create And Edit
    $model->onCreateAndEdit(function($id = null) {
        $display = AdminDisplay::tabbed();

        $display->setTabs(function() use ($id) {
            $tabs = [];

            $form = AdminForm::form();
            $form->setItems(
                AdminFormElement::columns()
                    ->addColumn(function() {
                        return [
                            AdminFormElement::text('firstName', 'First Name')->required(),
                            AdminFormElement::text('lastName', 'Last Name')->required(),
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
                            AdminFormElement::textarea('comment', 'Comment'),
                        ];
                    })
            );

            $tabs[] = AdminDisplay::tab($form)->setLabel('Main Form')->setActive(true)->setIcon('<i class="fa fa-credit-card"></i>');

            if (! is_null($id)) {
                $instance = Contact::find($id);

                if (! is_null($instance->country_id)) {
                    if (! is_null($country = AdminSection::getModel(Country::class)->fireFullEdit($instance->country_id))) {
                        $tabs[] = AdminDisplay::tab($country)->setLabel('Form from Related Model (Country)');
                    }
                }

                $companies = AdminSection::getModel(Company::class)->fireDisplay();

                $companies->appendScope(['withContact', $id]);
                $companies->setParameter('contact_id', $id);

                $tabs[] = AdminDisplay::tab($companies)->setLabel('Display from Related Model (Companies)')->setIcon('<i class="fa fa-university"></i>');
            }

            return $tabs;
        });


        return $display;
    });
})
    ->addMenuLink(Contact3::class)
    ->setIcon('credit-card');
