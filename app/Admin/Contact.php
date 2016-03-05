<?php

use App\Model\Contact;
use App\Model\Country;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(Contact::class, function (ModelConfiguration $model) {
    $model->setTitle('Contacts')->enableAccessCheck();

    $model->onDisplay(function () {
        $display = AdminDisplay::table()->paginate(10);

        $display->setAttribute('class', 'table-info table-hover');

        $display->with('country', 'companies', 'author');
        $display->setFilters([
            AdminDisplayFilter::related('country_id')->setModel(Country::class)
        ]);

        $display->setColumns([
            $photo = AdminColumn::image('photo')
                ->setLabel('Photo<br/><small>(image)</small>')
                ->setAttribute('class', 'hidden-sm hidden-xs')
                ->setWidth('100px'),
            AdminColumn::link('fullName')
                ->setLabel('Name<br/><small>(string with accessor)</small>')
                ->setWidth('200px'),
            AdminColumn::datetime('birthday')
                ->setLabel('Birthday<br/><small>(datetime)</small>')
                ->setWidth('150px')
                ->setAttribute('class', 'text-center')
                ->setFormat('d.m.Y'),
            $country = AdminColumn::text('country.title')
                ->setLabel('Country<br/><small>(string from related model)</small>')
                ->setAttribute('class', 'hidden-sm hidden-xs hidden-md')
                ->append(
                    AdminColumn::filter('country_id')
                ),
             AdminColumn::relatedLink('author.name')
                ->setLabel('Author'),
            $companiesCount = AdminColumn::count('companies')
                ->setLabel('Companies<br/><small>(count)</small>')
                ->setAttribute('class', 'text-center hidden-sm hidden-xs')
                ->setWidth('50px'),
            $companies = AdminColumn::lists('companies.title')
                ->setLabel('Companies<br/><small>(lists)</small>')
                ->setAttribute('class', 'hidden-sm hidden-xs hidden-md'),
            AdminColumn::custom()->setLabel('Has Photo?<br/><small>(custom)</small>')->setCallback(function ($instance) {
                return $instance->photo ? '<i class="fa fa-check"></i>' : '<i class="fa fa-minus"></i>';
            })
                ->setAttribute('class', 'text-center')
                ->setWidth('50px'),
        ]);

        $photo->getHeader()->setAttribute('class', 'hidden-sm hidden-xs');
        $country->getHeader()->setAttribute('class', 'hidden-sm hidden-xs hidden-md');
        $companies->getHeader()->setAttribute('class', 'hidden-sm hidden-xs hidden-md');
        $companiesCount->getHeader()->setAttribute('class', 'hidden-sm hidden-xs');

        return $display;
    });

    // Create And Edit
    $model->onCreateAndEdit(function($id = null) {
        $form = AdminForm::panel();

        $form->setItems(
            AdminFormElement::columns()
                ->addColumn(function() {
                    return [
                        AdminFormElement::text('firstName', 'First Name')->required('Please, type first name'),
                        AdminFormElement::text('lastName', 'Last Name')->required(),
                        AdminFormElement::text('phone', 'Phone'),
                        AdminFormElement::text('address', 'Address'),
                    ];
                })->addColumn(function() {
                    return [
                        AdminFormElement::image('photo', 'Photo'),
                        AdminFormElement::date('birthday', 'Birthday')->setFormat('d.m.Y'),
                        AdminFormElement::hidden('user_id')->setDefaultValue(auth()->user()->id),
                    ];
                })
        );

        $form
            ->getButtons()
            ->setSaveButtonText('Save contact')
            ->hideCancelButton();

        return $form;
    });

});
