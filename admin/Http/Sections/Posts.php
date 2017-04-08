<?php

namespace Admin\Http\Sections;

use AdminColumn;
use AdminDisplay;
use AdminForm;
use AdminFormElement;

use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;

use SleepingOwl\Admin\Section;
use SleepingOwl\Admin\Contracts\Initializable;


/**
 * Class Posts
 *
 * @property \App\Model\Post $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Posts extends Section implements Initializable
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
    protected $title;

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
        return AdminDisplay::table()->setColumns([
            AdminColumn::link('title', 'Title'),
            AdminColumn::text('contact.country.title', 'Country'),
            AdminColumn::text('contact.FullName', 'Full Name'),
        ])->paginate(5);
    }

    /**
     * @param int $id
     *
     * @return FormInterface
     */
    public function onEdit($id)
    {
        return AdminForm::panel()->addBody([
            AdminFormElement::text('title', 'Title')->required(),
            AdminFormElement::wysiwyg('text', 'Text', 'simplemde')->required()->setFilteredValueToField('text_html'),
            AdminFormElement::select('country_id')->setLabel('Страна')
                ->setModelForOptions(\App\Model\Country::class)
                ->setHtmlAttribute('placeholder', 'Выберите страну')
                ->setDisplay('title')
                ->required(),
            AdminFormElement::dependentselect('contact_id', 'Контакт', ['country_id'])
                ->setModelForOptions(\App\Model\Contact::class)
                ->setHtmlAttribute('placeholder', 'Выберите контакт')
                ->setDisplay('FullName')
                ->setLoadOptionsQueryPreparer(function($item, $query) {
                    return $query->where('country_id', $item->getDependValue('country_id'));
                }),
        ]);
    }

    /**
     * @return FormInterface
     */
    public function onCreate()
    {
        return $this->onEdit(null);
    }
}
