<?php
namespace Admin\Http\Sections;

use AdminForm;
use AdminColumn;
use AdminDisplay;
use AdminFormElement;
use AdminColumnEditable;
use SleepingOwl\Admin\Form\FormElements;

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
class NewsJs extends Contacts5
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
    protected $title = 'Javascript Examples';
    /**
     * @var string
     */
    protected $alias = 'javascript';


    /**
     * Initialize class.
     */

    public function initialize()
    {
        $page = \AdminNavigation::getPages()->findById('javascript');

        $page->addPage(
            $this->makePage(300)
        );

    }

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        $table = AdminDisplay::datatablesAsync()->setName('somename')->setModelClass(\App\Model\NewsJS::class)
            ->setColumns([
                AdminColumnEditable::text('title', 'Title'),
                AdminColumn::datetime('date', 'Date')->setFormat('d.m.Y')->setWidth('150px'),
                AdminColumnEditable::checkbox('published', 'Published'),
            ])
            ->paginate(10);


        $tabs = AdminDisplay::tabbed();

        $tabs->setElements([

                AdminDisplay::tab(
                    new  FormElements([
                        '<div class="alert bg-info">
                           <p>а</p>                           
                        </div>
                        ',

                        $table
                    ])
                )->setLabel('Sweet Alert Messages'),


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
