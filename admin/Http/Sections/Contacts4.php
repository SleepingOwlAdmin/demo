<?php

namespace Admin\Http\Sections;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminDisplayFilter;
use AdminForm;
use AdminFormElement;
use App\Model\Country;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;

/**
 * Class Contacts4
 *
 * @property \App\Model\Contact4 $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Contacts4 extends Section
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
    protected $title = 'Contacts v.4';

    /**
     * @var string
     */
    protected $alias;

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        $display = AdminDisplay::table()->setHtmlAttribute('class', 'table-primary');
        $display->with('country', 'companies');
        $display->setFilters([
            AdminDisplayFilter::related('country_id')->setModel(Country::class)
        ]);

        $display->setColumns([
            AdminColumn::image('photo', 'Photo')->setWidth('100px'),
            AdminColumn::link('fullName', 'Name')
                       ->setWidth('200px')
                       ->setOrderable(false),
            AdminColumn::text('height', 'Height'),
            AdminColumn::datetime('birthday', 'Birthday')->setFormat('d.m.Y')
                       ->setWidth('150px')
                       ->setHtmlAttribute('class', 'text-center'),
            AdminColumn::text('country.title', 'Country')
                       ->append(AdminColumn::filter('country_id')),
            AdminColumn::lists('companies.title', 'Companies')
        ]);

        $display->setColumnFilters([
            null,
            AdminColumnFilter::text()->setPlaceholder('Full Name'),
            AdminColumnFilter::range()->setFrom(
                AdminColumnFilter::text()->setPlaceholder('From')
            )->setTo(
                AdminColumnFilter::text()->setPlaceholder('To')
            ),
            AdminColumnFilter::range()->setFrom(
                AdminColumnFilter::date()->setPlaceholder('From Date')->setFormat('d.m.Y')
            )->setTo(
                AdminColumnFilter::date()->setPlaceholder('To Date')->setFormat('d.m.Y')
            ),
            AdminColumnFilter::select(Country::class, 'title')->setPlaceholder('Country')->multiple(),
            null,
        ]);

        return $display;
    }
}
