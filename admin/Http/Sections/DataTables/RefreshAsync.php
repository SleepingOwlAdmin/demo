<?php
namespace Admin\Http\Sections\DataTables;

use AdminForm;
use AdminColumn;
use AdminDisplay;
use AdminFormElement;
use AdminColumnEditable;
use SleepingOwl\Admin\Form\FormElements;


use App\Model\DataTables\NewsRefreshAsync;

use SleepingOwl\Admin\Section;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;

/**
 * Class TabsBadges
 *
 * @property \App\Model\Contact5 $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */

class RefreshAsync extends Section implements Initializable
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
    protected $title = 'Refresh & Toolbar';
    /**
     * @var string
     */
    protected $alias = 'RefreshDataTablesAsync';


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

        $tabs = AdminDisplay::tabbed();

        $tableRefresh = AdminDisplay::datatablesAsync()->setName('refresh')->setModelClass(NewsRefreshAsync::class)
            ->setColumns([
                AdminColumn::custom('№',function( )use (&$i) {return ++$i;}),
                AdminColumnEditable::text('title', 'Title'),
                AdminColumnEditable::text('text', 'Text'),
                AdminColumn::datetime('date', 'Date')->setFormat('d.m.Y')->setWidth('150px'),
                AdminColumnEditable::checkbox('published', 'Published'),
            ])
            ->paginate(10);

        $tableRefresh ->getActions()->setView(view('admin::datatables.toolbar'))->setPlacement('panel.heading.actions');


        $tabs->appendTab(
            new  FormElements([
                '<div class="alert bg-info">
                  <p>Для принудительного обновления таблицы  DataTables Async без обновления страницы с помощью JavaScript используте метод draw() </p>
                  <pre>
                           
   $(\'.datatables\').DataTable().api().draw();
                  </pre>   
                  <p>Вы можете размещать любые свои кнопки над таблицей.</p>
                  <pre>
                           
   $table->getActions()->setView(view(\'admin::datatables.toolbar\'))->setPlacement(\'panel.heading.actions\');
                  </pre>   
                  <p>Где view(\'admin::datatables.toolbar\') представление admin\resources\view\datatables\toolbar.blade.php</p>
                </div>
                        ',

                $tableRefresh
            ])
            ,'Refresh DataTable And ToolBar'

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

    }
    /**
     * @return FormInterface
     */
    public function onCreate()
    {
        return $this->onEdit(null);
    }
}
