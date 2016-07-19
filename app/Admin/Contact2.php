<?php

use App\Model\Company;
use App\Model\Country;
use App\Model\Contact2;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(Contact2::class, function (ModelConfiguration $model) {
    $model->setTitle('Contacts v.2')->setAlias('contacts2');

    $model->setMessageOndelete('<i class="fa fa-comment-o fa-lg"></i> Контакт успешно удален');

    // Display
    $model->onDisplay(function () {
        $display = AdminDisplay::table();
        $display->with('country', 'companies');
        $display->setFilters([
            AdminDisplayFilter::related('country_id')->setModel(Country::class),
            AdminDisplayFilter::field('country.title')->setOperator(\SleepingOwl\Admin\Display\Filter\FilterBase::CONTAINS)
        ]);

        $display->setColumns([
            AdminColumn::image('photo')->setLabel('Photo')
                ->setWidth('100px'),
            AdminColumn::link('fullName')->setLabel('Name')
                ->setWidth('200px'),
            AdminColumn::datetime('birthday')->setLabel('Birthday')->setFormat('d.m.Y')
                ->setWidth('150px')
                ->setHtmlAttribute('class', 'text-center'),
            AdminColumn::text('country.title')->setLabel('Country')->append(AdminColumn::filter('country_id')),
            AdminColumn::lists('companies.title')->setLabel('Companies'),
        ]);

        return $display;
    });

    // Create And Edit
    $model->onCreateAndEdit(function($id = null) {
        $form = AdminForm::panel();

        $form->addHeader([
                AdminFormElement::columns()
                    ->addColumn([
                        AdminFormElement::text('firstName', 'First Name')->required()
                    ], 3)->addColumn([
                        AdminFormElement::text('lastName', 'Last Name')->required()->addValidationMessage('required', 'You need to set last name')
                    ], 3)->addColumn([
                        AdminFormElement::date('birthday', 'Birthday')->setFormat('d.m.Y')->required()
                    ])
        ]);

        $companies = AdminSection::getModel(Company::class)->fireDisplay();

        $companies->getScopes()->push(['withContact', $id]);
        $companies->setParameter('contact_id', $id);
        $companies->getColumns()->disableControls();

        $tabs = AdminDisplay::tabbed([
            'Contacts' => new \SleepingOwl\Admin\Form\FormElements([
                AdminFormElement::text('phone', 'Phone'),
                AdminFormElement::columns()
                    ->addColumn([
                        AdminFormElement::select('country_id', 'Country')->setModelForOptions(new Country)->setDisplay('title')
                    ], 4)->addColumn([
                        AdminFormElement::textarea('address', 'Address')
                    ])
            ]),
            'Comment' => new \SleepingOwl\Admin\Form\FormElements([
                AdminFormElement::wysiwyg('comment', 'Comment', 'simplemde')->disableFilter(),
            ]),
            'Companies' => new \SleepingOwl\Admin\Form\FormElements([
                AdminFormElement::multiselect('companies', 'Companies')->setModelForOptions(new Company)->setDisplay('title'),
                $companies
            ]),
        ]);

        $form->addElement($tabs);

        $form->addBody(AdminFormElement::image('photo', 'Photo'));

        $form->getButtons()
            ->setSaveButtonText('Save contact')
            ->hideCancelButton();

        return $form;
    });
});
