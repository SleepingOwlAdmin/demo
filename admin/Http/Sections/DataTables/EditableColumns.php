<?php
namespace Admin\Http\Sections\DataTables;

use AdminForm;
use AdminColumn;
use AdminDisplay;
use AdminFormElement;
use AdminColumnEditable;
use SleepingOwl\Admin\Form\FormElements;


use App\Model\Country;

use App\Model\DataTables\NewsEditableColumns;

use SleepingOwl\Admin\Section;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;

use SleepingOwl\Admin\Form\Buttons\Cancel;

/**
 * Class TabsBadges
 *
 * @property \App\Model\Contact5 $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */

class EditableColumns extends Section implements Initializable
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
    protected $title = 'Editable Columns';
    /**
     * @var string
     */
    protected $alias = 'EditableColumns';


    /**
     * Initialize class.
     */

    public function initialize()
    {
        $page = \AdminNavigation::getPages()->findById('datatables');

        $page->addPage(
            $this->makePage(300)
        );

    }

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        $tableEditable = AdminDisplay::datatablesAsync()->setName('editable')->setModelClass(NewsEditableColumns::class)
            ->setColumns([
                AdminColumn::custom('№',function( )use (&$i) {return ++$i;}),
                AdminColumnEditable::text('title', 'Title'),
                AdminColumnEditable::text('text', 'Text'),
                AdminColumnEditable::datetime('date', 'Date')->setWidth('200px'),
                AdminColumnEditable::checkbox('published', 'Published'),
            ])
            ->paginate(10);


        $tabs = AdminDisplay::tabbed();

        $tabs->appendTab(
                    new  FormElements([
                        '<div class="alert bg-info">
                           <p>На данный момент существует 4 типа колонок с возможностью редактирования:</p>
                           <p>AdminColumnEditable::text(\'fielName\', \'Label\'),</p>                       
                           <p>AdminColumnEditable::checkbox(\'fielName\', \'Label\'),</p>
                           <p>AdminColumnEditable::datetime(\'fielName\', \'Label\'),</p>
                           <p>AdminColumnEditable::select(\'fielName\')</p>
                           <p>      ->setModelForOptions(new SourseModel)</p>
                           <p>      ->setLabel(\'label\')</p>
                           <p>      ->setDisplay(\'title\')</p>
                               
                               
                        </div>
                        ',

                        $tableEditable
                    ]),
              'Editable Columns'

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


        $form =AdminForm::form()->setElements([
            AdminFormElement::text('title', 'Title'),
            AdminFormElement::text('text', 'Text'),
            AdminFormElement::datetime('date', 'Date'),
            AdminFormElement::checkbox('published', 'Published'),
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
