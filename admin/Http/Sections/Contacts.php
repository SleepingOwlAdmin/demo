<?php

namespace Admin\Http\Sections;

use AdminColumn;
use AdminDisplay;
use AdminDisplayFilter;
use AdminForm;
use AdminFormElement;
use App\Model\Country;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;

/**
 * Class Contacts
 *
 * @property \App\Model\Contact $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Contacts extends Section
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
    protected $alias;

    public function getTitle()
    {
        return 'Contacts';
    }

    /**
     * @return DisplayInterface
     */
    public function onDisplay($scopes = [])
    {
        $display = AdminDisplay::datatablesAsync()->setDisplaySearch(true)->paginate(10);

        $display->setHtmlAttribute('class', 'table-info table-hover');

        $display->with('country', 'companies', 'author');
        $display->setFilters(
            AdminDisplayFilter::related('country_id')->setModel(Country::class)
        );

        $display->setColumns([
            $photo = AdminColumn::image('photo', 'Photo<br/><small>(image)</small>')
                ->setHtmlAttribute('class', 'hidden-sm hidden-xs foobar')
                ->setWidth('100px'),

            AdminColumn::link('fullName', 'Name<br/><small>(string with accessor)</small>')
                ->setWidth('200px'),

            AdminColumn::datetime('birthday', 'Birthday<br/><small>(datetime)</small>')
                ->setWidth('150px')
                ->setHtmlAttribute('class', 'text-center')
                ->setFormat('d.m.Y'),

            $country = AdminColumn::text('country.title', 'Country<br/><small>(string from related model)</small>')
                ->setHtmlAttribute('class', 'hidden-sm hidden-xs hidden-md')
                ->append(
                    AdminColumn::filter('country_id')
                ),

            AdminColumn::relatedLink('author.name', 'Author'),

            $companiesCount = AdminColumn::count('companies', 'Companies<br/><small>(count)</small>', 'country.title')
                ->setHtmlAttribute('class', 'text-center hidden-sm hidden-xs')
                ->setWidth('50px'),

            $companies = AdminColumn::lists('companies.title', 'Companies<br/><small>(lists)</small>', 'created_at')
                ->setHtmlAttribute('class', 'hidden-sm hidden-xs hidden-md'),

            AdminColumn::custom('Has Photo?<br/><small>(custom)</small>', function ($instance) {
                return $instance->photo ? '<i class="fa fa-check"></i>' : '<i class="fa fa-minus"></i>';
            })->setHtmlAttribute('class', 'text-center')->setWidth('50px'),
        ]);

        $photo->getHeader()->setHtmlAttribute('class', 'hidden-sm hidden-xs');
        $country->getHeader()->setHtmlAttribute('class', 'hidden-sm hidden-xs hidden-md');
        $companies->getHeader()->setHtmlAttribute('class', 'hidden-sm hidden-xs hidden-md');
        $companiesCount->getHeader()->setHtmlAttribute('class', 'hidden-sm hidden-xs');

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

        $form->setItems(
            AdminFormElement::columns()
            ->addColumn(function() {
                return [
                    AdminFormElement::text('firstName', 'First Name')->required('Please, type first name'),
                    AdminFormElement::text('lastName', 'Last Name')->required(),
                    AdminFormElement::text('phone', 'Phone'),
                    AdminFormElement::text('address', 'Address'),
                ];
            })->addColumn(function() {
                return [
                    AdminFormElement::image('photo', 'Photo'),
                    AdminFormElement::date('birthday', 'Birthday')->setFormat('d.m.Y'),
                    AdminFormElement::hidden('user_id')->setDefaultValue(auth()->user()->id),
                ];
            })
        );

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
