<?php

namespace Admin\Http\Sections;

use AdminColumn;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use AdminSection;
use App\Model\Contact;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Section;

/**
 * Class Countries
 *
 * @property \App\Model\Country $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Countries extends Section implements Initializable
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
    protected $title = 'Countries (orderable)';

    /**
     * @var string
     */
    protected $alias;

    /**
     * Initialize class.
     */
    public function initialize()
    {
       $this->addToNavigation()->setIcon('fa fa-globe');
    }

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        $display = AdminDisplay::table();

        $display->setHtmlAttribute('class', 'table-bordered table-success table-hover');

        $display->setApply(function ($query) {
            $query->orderBy('order', 'asc');
        });

        $display->setColumns([
            AdminColumn::text('id', '#')->setWidth('30px'),
            AdminColumn::link('title', 'Title'),
            AdminColumn::count('contacts', 'Contacts')
                ->setWidth('100px')
                ->setHtmlAttribute('class', 'text-center')
                ->append(
                   AdminColumn::filter('country_id')->setModel(new Contact())
                ),
            AdminColumn::order()
               ->setLabel('Order')
               ->setHtmlAttribute('class', 'text-center')
               ->setWidth('100px'),
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
        $display = AdminDisplay::tabbed();
        $display->setTabs(function () use ($id) {
            $tabs = [];

            $form = AdminForm::form();
            $form->setElements([
                AdminFormElement::text('title', 'Title')->required()->unique(),
            ]);

            $tabs[] = AdminDisplay::tab($form)->setLabel("Main Edit")
                ->setActive(true)
                ->setIcon('<i class="fa fa-money"></i>');

            if(!is_null($id)){
                $contacts = AdminSection::getModel(Contact::class)->fireDisplay(['scopes' => ['withBusiness', $id]]);

                $tabs[] = AdminDisplay::tab($contacts)
                    ->setLabel("Contacts")
                    ->setIcon('<i class="fa fa-credit-card"></i>');
            }
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
