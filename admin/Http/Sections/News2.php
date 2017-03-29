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
 * Class News2
 *
 * @property \App\Model\News2 $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class News2 extends Section
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
    protected $title = 'News v2';

    /**
     * @var string
     */
    protected $alias = 'news/v2';

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        $display = AdminDisplay::datatables()->setHtmlAttribute('class', 'table-danger');
        $display->setOrder([[1, 'desc']]);

        $display->setColumns([
            AdminColumn::link('title', 'Title'),
            AdminColumn::datetime('date', 'Date')->setFormat('d.m.Y')->setWidth('150px'),
            AdminColumn::custom('Published', function (\App\Model\News2 $model) {
                return $model->published ? '<i class="fa fa-check"></i>' : '<i class="fa fa-minus"></i>';
            })->setWidth('50px')->setHtmlAttribute('class', 'text-center')->setOrderable(false),
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
                AdminFormElement::date('date', 'Date')->required()->setFormat('d.m.Y'),
                AdminFormElement::checkbox('published', 'Published'),
            ])
            ->addBody([
                AdminFormElement::wysiwyg('text', 'Text'),
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
