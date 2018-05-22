<?php

namespace Admin\Http\Sections\Forms;

use AdminColumn;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Section;

/**
 * Class Form
 *
 * @property \App\Model\Form $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Forms extends Section implements Initializable
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
    protected $title = 'All Form Items';

    /**
     * @var string
     */
    protected $alias;

    /**
     * Initialize class.
     */
    public function initialize()
    {
        $page = \AdminNavigation::getPages()->findById('forms-examples');

        $page->addPage(
            $this->makePage(0)
        );

    }

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        $display = AdminDisplay::table();

        $display->paginate(50);

        $display->setColumns([
            AdminColumn::text('id', '#')->setWidth('30px'),
            AdminColumn::link('title', 'String'),
            AdminColumn::datetime('created_at', 'Created At')->setFormat('d.m.Y H:i:s')
                ->setWidth('150px')
                ->setHtmlAttribute('class', 'text-center')
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
        $form = AdminForm::panel()
            ->addBody([
                AdminFormElement::text('title', 'Title')->required(),
                AdminFormElement::textaddon('textaddon', 'TextAddon')
                    ->setAddon('$')
                    ->placeAfter(),
                AdminFormElement::checkbox('checkbox', 'Checkbox'),
                AdminFormElement::date('date', 'Date'),
                AdminFormElement::time('time', 'Time'),
                AdminFormElement::timestamp('timestamp', 'Timestamp')->setFormat('d.m.Y g:i A'),
            ])
            ->addBody([
             AdminFormElement::select('select', 'Select', [
                 1 => 'First',
                 2 => 'Second',
                 3 => 'Third'
             ])->nullable()->required(),
            ])
            ->addBody([
//                AdminFormElement::dependentselect('city_id', 'City', ['select'])->setModelForOptions(\App\Model\Country::class)
//                    ->setDisplay("title")
//                    ->required(),

                AdminFormElement::image('image', 'Image'),
                AdminFormElement::images('images', 'Images'),
            ])
            ->addBody([
                AdminFormElement::textarea('textarea', 'Textarea'),
                AdminFormElement::wysiwyg('ckeditor', 'Ckeditor'),
            ]);

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
