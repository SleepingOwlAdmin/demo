<?php

use App\Model\Country;
use App\Model\Company;
use App\Model\Contact;
use App\Model\Contact3;
use SleepingOwl\Admin\Filter\Filter;
use SleepingOwl\Admin\Column;
use SleepingOwl\Admin\FormItems\FormItem;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(Contact3::class, function (ModelConfiguration $model) {
    $model->setTitle('Contacts v.3')->setAlias('contacts3');

    // Display
    $model->onDisplay(function () {
        $display = AdminDisplay::table();
        $display->setWith('country', 'companies');
        $display->setFilters([
            Filter::related('country_id')->setModel(Country::class)
        ]);

        $display->setColumns([
            Column::image('photo')->setLabel('Photo'),
            Column::link('fullName')->setLabel('Name'),
            Column::datetime('birthday')->setLabel('Birthday')->setFormat('d.m.Y'),
            Column::string('country.title')->setLabel('Country')->append(Column::filter('country_id')),
            Column::lists('companies.title')->setLabel('Companies'),
        ]);

        return $display;
    });

    // Create And Edit
    $model->onCreateAndEdit(function($id = null) {
        $display = AdminDisplay::tabbed();

        $display->setTabs(function() use ($id) {
            $tabs = [];

            $form = AdminForm::form();
            $form->setItems(
                FormItem::columns()
                    ->addColumn(function() {
                        return [
                            FormItem::text('firstName', 'First Name')->required(),
                            FormItem::text('lastName', 'Last Name')->required(),
                            FormItem::text('phone', 'Phone'),
                            FormItem::text('address', 'Address'),
                        ];
                    })->addColumn(function() {
                        return [
                            FormItem::image('photo', 'Photo'),
                            FormItem::date('birthday', 'Birthday')->setFormat('d.m.Y'),
                        ];
                    })->addColumn(function() {
                        return [
                            FormItem::select('country_id', 'Country')->setModelForOptions(new Country)->setDisplay('title'),
                            FormItem::wysiwyg('comment', 'Comment')->setEditor('ckeditor'),
                        ];
                    })
            );

            $tabs[] = AdminDisplay::tab($form)->setLabel('Main Form')->setActive(true);

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

                $tabs[] = AdminDisplay::tab($companies)->setLabel('Display from Related Model (Companies)');
            }
            return $tabs;
        });


        return $display;
    });
})
    ->addMenuLink(Contact3::class)
    ->setIcon('credit-card');
