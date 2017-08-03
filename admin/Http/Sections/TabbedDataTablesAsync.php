<?php

namespace Admin\Http\Sections;

use AdminForm;
use AdminColumn;
use AdminDisplay;
use AdminFormElement;
use AdminColumnFilter;
use SleepingOwl\Admin\Form\FormElements;

use App\Model\Country;
use App\Model\Contact6;

use SleepingOwl\Admin\Section;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;


/**
 * Class Contacts6
 *
 * @property \App\Model\Contact5 $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class TabbedDataTablesAsync extends Section implements Initializable
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
    protected $title = 'Tabbed DataTables Async';
    /**
     * @var string
     */
    protected $alias;

    /**
     * Initialize class.
     */

    public function initialize()
    {
        $page = \AdminNavigation::getPages()->findById('tabs-examples');

        $page->addPage(
            $this->makePage(300)
        );

    }

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        $table = AdminDisplay::datatablesAsync()->setName('somename')->setModelClass(Contact6::class)
            ->setColumns([
                AdminColumn::text('id', 'ID')->setHtmlAttribute('class', 'reorder')->setWidth('100px'),
                AdminColumn::image('photo', 'Photo')->setWidth('100px'),
                AdminColumn::link('fullName', 'Name')->setWidth('200px'),
                AdminColumn::text('address', 'Address')->setWidth('200px'),
                AdminColumn::datetime('birthday',
                    'Birthday')->setFormat('d.m.Y')->setWidth('150px')->setHtmlAttribute('class', 'text-center'),
            ]);



        $table->setColumnFilters([
            null,
            null,
            AdminColumnFilter::select()->setModel(new Contact6)->setDisplay('address')->setPlaceholder('Имя не выбрано'),

        ]);
        $table->getColumnFilters()->setPlacement('table.header');


        $table2 = AdminDisplay::datatablesAsync()->setName('meganame')->setModelClass(Contact6::class)
            ->setColumns([
                AdminColumn::text('id', '#')->setWidth('200px'),
                AdminColumn::link('fullName', 'Name')->setWidth('200px'),
                AdminColumn::datetime('birthday',
                    'Birthday')->setFormat('d.m.Y')->setWidth('150px')->setHtmlAttribute('class', 'text-center'),
            ]);



        $table3 = AdminDisplay::datatablesAsync()->setName('dupername')->setModelClass(Contact6::class)
            ->setColumns([
                AdminColumn::image('photo', 'Photo')->setWidth('100px'),
                AdminColumn::datetime('birthday',
                    'Birthday')->setFormat('d.m.Y')->setWidth('150px')->setHtmlAttribute('class', 'text-center'),
            ]);
        $table3 ->getActions()->setView(view('admin::datatables.toolbar'))->setPlacement('panel.heading.actions');
        $table4 = AdminDisplay::datatablesAsync()->setName('fastname')->setModelClass(Contact6::class)
            ->setColumns([
                AdminColumn::image('photo', 'Photo')->setWidth('100px'),
                AdminColumn::link('fullName', 'Name')->setWidth('200px')
            ]);

        $tabs = AdminDisplay::tabbed();

        $columns = AdminFormElement::columns()
            ->addElement([$table2])
            ->addColumn([$table3])
            ->addColumn([$table4]);


        $tabs->appendTab(
            new  FormElements([
                '<div class="alert bg-info">
                    <h4> Использование <B>DataTablesAsync</B> в <B>Tabs</B></h4>
                    <p>У каждой формы в табе должен быть уникальный <b>name</b> проставленный методом <b>setName</b> у таблицы</p>
                    <h5>AdminDisplay::datatablesAsync()->setName("somename")</h5>  
                </div>',
                $table
            ])
            ,
            //Название таба
            'Data Table Async in Tab'
        );
        $tabs->appendTab(
            $columns
            ,
            //Название таба
            'Data Table Async in columns in Tab'
        );

        return $tabs;

    }

    /**
     * @param int $id
     *
     * @return FormInterface
     */
    public function onEdit($id)
    {
        $formPrimary = AdminForm::form()->addElement(
            AdminFormElement::columns()
                ->addColumn([
                    AdminFormElement::text('firstName', 'First Name')->required()
                ], 3)
                ->addColumn([
                    AdminFormElement::text('lastName', 'Last Name')->required()->addValidationMessage('required',
                        'You need to set last name')
                ], 3)
                ->addColumn([
                    AdminFormElement::date('birthday', 'Birthday')->setFormat('d.m.Y')->required()
                ])
                ->addColumn([
                    AdminFormElement::select('country_id', 'Country', Country::class)->setDisplay('title')
                ], 4)
        );
        $formHTML    = AdminForm::form()->addElement(
            new \SleepingOwl\Admin\Form\FormElements([
                AdminFormElement::textarea('address', 'Address')->required('so sad but this field is empty')
            ])
        );
        $formVisual  = AdminForm::form()->addElement(
            new \SleepingOwl\Admin\Form\FormElements([
                AdminFormElement::wysiwyg('address', 'Address')->required('so sad but this field is empty.')
            ])
        );


        $tabs = AdminDisplay::tabbed();

        $tabs->appendTab($formPrimary, 'Primary');

        $tabs->appendTab($formHTML, 'HTML Adress Redactor');

        $tabs->appendTab($formVisual, 'Visual Adress Redactor');


        return $tabs;
    }

    /**
     * @return FormInterface
     */
    public function onCreate()
    {
        return $this->onEdit(null);
    }
}
