<?php

namespace Admin\Http\Sections;

use AdminColumn;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;

/**
 * Class News3
 *
 * @property \App\Model\News3 $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class News3 extends Section
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
    protected $title = 'News v3';

    /**
     * @var string
     */
    protected $alias = 'news/v3';

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        $display = AdminDisplay::tabbed();

        $display->setTabs(function() {

            $tabs = [];

            $columns = [
                AdminColumn::link('title', 'Title'),
                AdminColumn::datetime('date', 'Date')->setFormat('d.m.Y')->setWidth('150px'),
                AdminColumn::custom('Published', function ($instance) {
                    return $instance->published ? '<i class="fa fa-check"></i>' : '<i class="fa fa-minus"></i>';
                })->setWidth('50px')->setHtmlAttribute('class', 'text-center'),
            ];

            $main = AdminDisplay::table()->paginate(20, 'news');
            $main->setColumns($columns);

            $tabs[] = AdminDisplay::tab($main, 'Main')->setActive();

            $withScope = AdminDisplay::table();

            $withScope->getScopes()->push('last');

            $withScope->setColumns($columns);

            $tabs[] = AdminDisplay::tab($withScope, 'With Scope');

            $otherColumns = AdminDisplay::table();
            $otherColumns->setApply(function ($query) {
                $query->orderBy('title', 'asc');
            });

            $otherColumns->setColumns([
                AdminColumn::link('title', 'Title'),
                AdminColumn::custom('Title Length', function ($instance) {
                    return strlen($instance->title);
                })->setWidth('50px')->setHtmlAttribute('class', 'text-center'),
            ]);

            $tabs[] = AdminDisplay::tab($otherColumns, 'Other Columns and Order');

            return $tabs;
        });

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
                AdminFormElement::date('date', 'Date')->required()->setFormat('d.m.Y'),
                AdminFormElement::checkbox('published', 'Published'),
            ])
            ->addBody([
                AdminFormElement::wysiwyg('text', 'Text', 'tinymce'),
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
