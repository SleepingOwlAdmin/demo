<?php

namespace Admin\Http\Sections;

use AdminColumn;
use AdminDisplay;
use AdminDisplayFilter;
use AdminForm;
use AdminFormElement;
use AdminSection;
use App\Model\Company;
use App\Model\Country;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;

/**
 * Class Contacts2
 *
 * @property \App\Model\Contact2 $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Contacts2 extends Section
{
    /**
     * @see http://sleepingowladmin.ru/docs/model_configuration#ограничение-прав-доступа
     *
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Contacts v.2';

    /**
     * @var string
     */
    protected $alias;

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        $display = AdminDisplay::table();
        $display->with('country', 'companies');
        $display->setFilters(
            AdminDisplayFilter::related('country_id')->setModel(Country::class),
            AdminDisplayFilter::field('country.title')->setOperator(\SleepingOwl\Admin\Display\Filter\FilterBase::CONTAINS)
        );

        $display->setColumns([
            AdminColumn::image('photo', 'Photo')->setWidth('100px'),
            AdminColumn::link('fullName', 'Name')->setWidth('200px'),
            AdminColumn::datetime('birthday', 'Birthday')->setFormat('d.m.Y')->setWidth('150px')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::text('country.title', 'Country')->append(AdminColumn::filter('country_id')),
            AdminColumn::lists('companies.title', 'Companies'),
        ]);

        return $display;
    }

    /**
     * @param int $id
     *
     * @return FormInterface
     */
    public function onEdit($id)
    {
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
                        AdminFormElement::select('country_id', 'Country', Country::class)->setDisplay('title')
                    ], 4)->addColumn([
                        AdminFormElement::textarea('address', 'Address')
                    ])
            ]),
            'Comment' => new \SleepingOwl\Admin\Form\FormElements([
                AdminFormElement::wysiwyg('comment', 'Comment', 'simplemde')->disableFilter(),
            ]),
            'Companies' => new \SleepingOwl\Admin\Form\FormElements([
                AdminFormElement::multiselect('companies', 'Companies', Company::class)->setDisplay('title'),
                $companies
            ]),
        ]);

        $form->addElement($tabs);

        $form->addBody(AdminFormElement::image('photo', 'Photo'));

        return $form;
    }

    /**
     * @return FormInterface
     */
    public function onCreate()
    {
        return $this->onEdit(null);
    }
}
