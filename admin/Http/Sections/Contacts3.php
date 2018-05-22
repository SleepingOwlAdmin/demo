<?php

namespace Admin\Http\Sections;

use AdminColumn;
use AdminDisplay;
use AdminDisplayFilter;
use AdminForm;
use AdminFormElement;
use AdminSection;
use App\Model\Company;
use App\Model\Contact;
use App\Model\Country;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Form\FormElements;
use SleepingOwl\Admin\Section;

/**
 * Class Contacts3
 *
 * @property \App\Model\Contact3 $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Contacts3 extends Section
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
    protected $title = 'Contacts v.3';

    /**
     * @var string
     */
    protected $alias;

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        $display = AdminDisplay::datatablesAsync();
        $display->with('country', 'companies');
        $display->setFilters(
            AdminDisplayFilter::related('country_id')->setModel(Country::class),
            AdminDisplayFilter::related('companies.title')->setOperator(\SleepingOwl\Admin\Display\Filter\FilterBase::CONTAINS)
        );

        $display->setColumns([
            $photoColumn = AdminColumn::image('photo', 'Photo'),
            $fullNameColumn = AdminColumn::link('fullName', 'Name'),
            $birthdayColumn = AdminColumn::datetime('birthday', 'Birthday')->setFormat('d.m.Y'),
            $countyTitleColumn = AdminColumn::text('country.title', 'Country')->append(AdminColumn::filter('country_id')),
            $companyTitleColumn = AdminColumn::lists('companies.title', 'Companies')->append(AdminColumn::filter('companies.title')),
        ]);

        $photoColumn->getHeader()->setHtmlAttribute('class', 'bg-success text-center');
        $fullNameColumn->getHeader()->setHtmlAttribute('class', 'bg-primary');
        $birthdayColumn->getHeader()->setHtmlAttribute('class', 'bg-orange');
        $countyTitleColumn->getHeader()->setHtmlAttribute('class', 'bg-maroon');
        $companyTitleColumn->getHeader()->setHtmlAttribute('class', 'bg-purple');

        // Change Control Column
        $display->getColumns()->getControlColumn()->getHeader()->setTitle('Control')->setHtmlAttribute('class', 'bg-black');

        $display->paginate(10);

        return $display;
    }

    /**
     * @param int $id
     *
     * @return FormInterface
     */
    public function onEdit($id)
    {
        $display = AdminDisplay::tabbed();

        $display->setTabs(function() use ($id) {
            $tabs = [];

            $form = AdminForm::panel();
//
            $form->addHeader(AdminFormElement::columns()
                 ->addColumn([
                     AdminFormElement::text('firstName', 'First Name')->required()
                 ], 3)->addColumn([
                    AdminFormElement::text('lastName', 'Last Name')->required()
                ], 3)->addColumn([
                    AdminFormElement::date('birthday', 'Birthday')->setFormat('d.m.Y')->required()
                ])
            );
//
            $form->addBody([
                AdminFormElement::text('phone', 'Phone'),
                AdminFormElement::columns()
                    ->addColumn([
                        AdminFormElement::select('country_id', 'Country', Country::class)->setDisplay('title')
                    ], 4)->addColumn([
                        AdminFormElement::textarea('address', 'Address')
                    ])
            ]);

            $form->addBody([
                AdminFormElement::textarea('comment', 'Comment'),
            ]);

            $form->addFooter([
                AdminFormElement::image('photo', 'Photo'),
            ]);

            if (! is_null($id)) {
                $instance = Contact::find($id);

                if (! is_null($instance->country_id)) {
                    if (! is_null($country = AdminSection::getModel(Country::class)->fireEdit($instance->country_id))) {
                        $tabs[] = AdminDisplay::tab(
                            new FormElements([$country])
                        )->setLabel('Form from Related Model (Country)');
                    }
                }
            }
            $companies = AdminSection::getModel(Company::class)->fireDisplay();
            $companies->getScopes()->push(['withContact', $id]);
            $companies->setParameter('contact_id', $id);

            $form->addBody([
                AdminFormElement::columns()->addColumn([
                    $companies
                ])
            ]);

            $tabs[] = AdminDisplay::tab($form, 'Main Form')->setActive(true)->setIcon('<i class="fa fa-credit-card"></i>');


            return $tabs;
        });


        return $display;
    }

    /**
     * @return FormInterface
     */
    public function onCreate()
    {
        return $this->onEdit(null);
    }
}
