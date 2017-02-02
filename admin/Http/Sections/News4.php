<?php

namespace Admin\Http\Sections;

use AdminColumn;
use AdminDisplay;
use AdminDisplayFilter;
use AdminForm;
use AdminFormElement;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;

/**
 * Class News4
 *
 * @property \App\Model\News4 $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class News4 extends Section
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
    protected $title = 'News v4';

    /**
     * @var string
     */
    protected $alias = 'news/v4';

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        $display = AdminDisplay::table()
            ->setFilters(
                AdminDisplayFilter::scope('last')->setTitle('Latest News'),
                AdminDisplayFilter::field('published')->setTitle(function ($value) {
                   return $value ? 'Published' : 'Not Published';
                }),
                AdminDisplayFilter::custom('limit')->setTitle(function ($value) {
                   return 'Limit: '.$value;
                })->setCallback(function ($query, $value) {
                   $query->limit($value);
                })
            )
            ->setColumns([
                AdminColumn::link('title', 'Title'),
                AdminColumn::datetime('date', 'Date')->setFormat('d.m.Y')->setWidth('150px'),
                AdminColumn::custom('Published', function ($instance) {
                   return $instance->published ? '<i class="fa fa-check"></i>' : '<i class="fa fa-minus"></i>';
                })->setWidth('50px')->setHtmlAttribute('class', 'text-center'),
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
        return AdminForm::form()->setElements([
            AdminFormElement::text('title', 'Title')->required(),
            AdminFormElement::date('date', 'Date')->required()->setFormat('d.m.Y'),
            AdminFormElement::checkbox('published', 'Published'),
            AdminFormElement::wysiwyg('text', 'Text'),
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
