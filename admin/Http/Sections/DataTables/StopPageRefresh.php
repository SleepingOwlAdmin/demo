<?php
namespace Admin\Http\Sections\DataTables;

use Meta;
use AdminColumn;
use AdminDisplay;
use AdminColumnEditable;
use SleepingOwl\Admin\Form\FormElements;

use App\Model\DataTables\CountryStopPageRefresh;
use App\Model\Contact;

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

class StopPageRefresh extends Section implements Initializable
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
    protected $title = 'Stop Page Refresh';
    /**
     * @var string
     */
    protected $alias = 'StopPageRefresh';


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

        Meta::loadPackage(['stopRefresh']);


        $tabs = AdminDisplay::tabbed();


        $tableRefresh = AdminDisplay::datatablesAsync()->setName('stop')->setModelClass(CountryStopPageRefresh::class)->setColumns([
            AdminColumn::text('id', '#')->setWidth('30px'),
            AdminColumn::link('title', 'Title'),
            AdminColumn::order()
                ->setLabel('Order')
                ->setHtmlAttribute('class', 'text-center')
                ->setWidth('100px'),
        ]);

        $tableRefresh->setApply(function ($query) {
            $query->orderBy('order', 'asc');
        });

        $tabs->appendTab(
            new  FormElements([
                '
                <div class="alert bg-info">
                  <p>Убираем обновление Страницы при Сортировке и удалении записей. </p>
                </div>
                ',

                $tableRefresh
            ])
            ,'Stop Refresh Page'

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
