<?php

namespace Admin\Http\Sections;

use AdminColumn;
use AdminDisplay;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;

/**
 * Class News5
 *
 * @property \App\Model\News5 $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class News5 extends News4
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
    protected $title = 'News v5';

    /**
     * @var string
     */
    protected $alias = 'news/v5';

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        $display = AdminDisplay::table()->setActions(
            AdminColumn::action('export', 'Export')
                ->setAction(route('admin.news.export'))
                ->setIcon('fa fa-share')
        )->setColumns([
            AdminColumn::checkbox(),
            AdminColumn::link('title', 'Title'),
            AdminColumn::datetime('date', 'Date')->setFormat('d.m.Y')->setWidth('150px'),
            AdminColumn::custom('Published', function ($instance) {
                return $instance->published ? '<i class="fa fa-check"></i>' : '<i class="fa fa-minus"></i>';
            })->setWidth('50px')->setHtmlAttribute('class', 'text-center'),
        ]);

        $display->getActions()->setPlacement('panel.buttons')->setHtmlAttribute('class', 'pull-right');

        return $display;
    }
}
