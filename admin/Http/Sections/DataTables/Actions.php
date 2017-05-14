<?php
namespace Admin\Http\Sections\DataTables;

use AdminForm;
use AdminColumn;
use AdminDisplay;
use AdminFormElement;
use AdminColumnEditable;
use SleepingOwl\Admin\Form\FormElements;


use App\Model\DataTables\NewsActions;

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

class Actions extends Section implements Initializable
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
    protected $title = 'DataTables Actions';
    /**
     * @var string
     */
    protected $alias = 'Actions';


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

        $tableActions = AdminDisplay::datatablesAsync()->setName('actions')->setModelClass(NewsActions::class)
            ->setColumns([
                AdminColumn::checkbox(),
                AdminColumn::custom('№',function( )use (&$i) {return ++$i;}),
                AdminColumnEditable::text('title', 'Title'),
                AdminColumnEditable::text('text', 'Text'),
                AdminColumn::datetime('date', 'Date')->setFormat('d.m.Y')->setWidth('150px'),
                AdminColumnEditable::checkbox('published', 'Published'),
            ])

            ->setActions([
                AdminColumn::action('export', 'Export')->setAction(route('admin.news.export')),
            ]);
        $tableActions ->getActions()->setPlacement('panel.heading.actions');


        $tabs->appendTab(
            new  FormElements([
                '<div class="alert bg-info">
                        <p>
                        Для корректной работы Actions необходим столбец checkbox
                        </p>
                        <pre>                        
    ->setColumns([
       AdminColumn::checkbox()
             </pre> 
             <p>
               Создание выпадающего списка действий 
             </p>
              <pre>
      
    ->setActions([
       AdminColumn::action(\'export\', \'Export\')->setAction(route(\'admin.news.export\')),
     ])
                        </pre>  
                        <p>Для переноса Actions можно использовать setPlacement</p>
                        <pre>
    $tableActions ->getActions()->setPlacement(\'panel.heading.actions\');
                        </pre>
                        
                        </div>
                        ',

                $tableActions
            ])
            ,'Actions'

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
