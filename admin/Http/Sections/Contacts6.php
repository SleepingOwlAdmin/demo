<?php
namespace Admin\Http\Sections;

use AdminForm;
use AdminColumn;
use AdminDisplay;
use AdminFormElement;
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
class Contacts6 extends Section implements Initializable
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
        $table = AdminDisplay::datatablesAsync()->setModelClass(Contact6::class)
            ->setColumns([
                AdminColumn::image('photo', 'Photo')->setWidth('100px'),
                AdminColumn::link('fullName', 'Name')->setWidth('200px'),
                AdminColumn::datetime('birthday', 'Birthday')->setFormat('d.m.Y')->setWidth('150px')->setHtmlAttribute('class', 'text-center'),
            ]);

        $tabs = AdminDisplay::tabbed();

        $columns = AdminFormElement::columns()
            ->addElement([$table])
            ->addColumn([$table]);


        $tabs->appendTab(
            new  FormElements([
                '<p class="alert bg-info">Использование <B>DataTablesAsync</B> в <B>Tabs</B> </p>',
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
                    AdminFormElement::text('lastName', 'Last Name')->required()->addValidationMessage('required', 'You need to set last name')
                ], 3)
                ->addColumn([
                    AdminFormElement::date('birthday', 'Birthday')->setFormat('d.m.Y')->required()
                ])
                 ->addColumn([
                        AdminFormElement::select('country_id', 'Country', Country::class)->setDisplay('title')
                ], 4)
        );
        $formHTML = AdminForm::form()->addElement(
            new \SleepingOwl\Admin\Form\FormElements([
                AdminFormElement::textarea('address', 'Address')->required('so sad but this field is empty')
            ])
        );     
        $formVisual = AdminForm::form()->addElement(
            new \SleepingOwl\Admin\Form\FormElements([
                AdminFormElement::wysiwyg('address', 'Address')->required('so sad but this field is empty.')
            ])
        );     
             
             
        $tabs = AdminDisplay::tabbed();

        $tabs->appendTab($formPrimary,  'Primary');
     
        $tabs->appendTab($formHTML,     'HTML Adress Redactor');

        $tabs->appendTab($formVisual,   'Visual Adress Redactor');
             
             
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
