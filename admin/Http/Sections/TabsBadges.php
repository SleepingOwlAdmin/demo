<?php
namespace Admin\Http\Sections;

use AdminForm;
use AdminColumn;
use AdminDisplay;
use AdminFormElement;
use AdminColumnEditable;
use KodiComponents\Navigation\Badge;
use SleepingOwl\Admin\Form\FormElements;


use App\Model\NewsTabsBadges;
use App\Model\Country;

use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;

/**
 * Class TabsBadges
 *
 * @property \App\Model\Contact5 $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class TabsBadges extends Contacts5
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
    protected $title = 'Tabs Badges';
    /**
     * @var string
     */
    protected $alias = 'tabs-badges';


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

        $columns = [
            AdminColumn::link('title', 'Title'),
            AdminColumn::datetime('date', 'Date')->setFormat('d.m.Y')->setWidth('150px'),
            AdminColumnEditable::checkbox('published', 'Published'),
        ];


        $table =  AdminDisplay::table()->setModelClass(NewsTabsBadges::class)->setApply(function($query) {
            $query->orderBy('date', 'desc');
        })->paginate(10)->setColumns($columns);

        $tablePublushed =  AdminDisplay::table()->setApply(function($query) {
            $query->orderBy('date', 'desc');
        })->paginate(10)->getScopes()->set('published') ->setColumns($columns);

        $tableUnpublushed =  AdminDisplay::table()->setApply(function($query) {
            $query->orderBy('date', 'desc');
        })->paginate(10)->getScopes()->set('unpublished') ->setColumns($columns);


        $tabs = AdminDisplay::tabbed();

        $tabs->setElements([

                AdminDisplay::tab(
                    new  FormElements([
                        '<div class="alert bg-info">
                           <p>В <B>AdminDisplay::tab()</B> можно вызвать <B>setBadge</B> или передать в конструктор <B><em>Badge|string|Closure</em></B></p>                           
                           <p>То есть либо передать готовое значения для таба, либо передать callback который вычислит это значение, либо сам Badge. </p>  
                        </div>
                        ',

                        $table
                    ])
                )->setLabel('All News')->setBadge(NewsTabsBadges::count()),

                AdminDisplay::tab($tablePublushed)
                     ->setIcon('<i class="glyphicon glyphicon-send"></i>')
                     ->setLabel('Published News')
                     ->setBadge(function(){
                        return NewsTabsBadges::published()->count();
                    }),

                AdminDisplay::tab($tableUnpublushed)
                     ->setLabel('Unpublished News')
                     ->seticon('<i class="glyphicon glyphicon-alert"></i>')
                     ->setBadge(function(){
                 return NewsTabsBadges::where('published', 0)->count();
                }),
                AdminDisplay::tab($tableUnpublushed)
                    ->setLabel('Last')
                    ->setBadge(new Badge()),
        ]);

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
                ],3)
                ->addColumn([
                    AdminFormElement::select('country_id', 'Country', Country::class)->setDisplay('title')
                ], 12)
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
