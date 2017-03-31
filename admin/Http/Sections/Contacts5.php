<?php
namespace Admin\Http\Sections;

use AdminForm;
use AdminDisplay;
use AdminFormElement;

use Illuminate\Support\Facades\Input;
use SleepingOwl\Admin\Form\FormElements;


use App\Model\Company;
use App\Model\Country;
use App\Model\Contact;

use AdminSection;
use SleepingOwl\Admin\Section;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;

/**
 * Class Contacts5
 *
 * @property \App\Model\Contact5 $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Contacts5 extends Section implements Initializable
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
    protected $title = 'Tabbed Forms ';
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

        $oneForm[] ='<p class="alert bg-info">
                        В данном примере показано использование нескольких независимых форм в табах.
                        <br>
                        При нажатии кнопки Сохранить сохраняется только форма активного Таба.
                    </p>                   
        ';


        foreach (Contact::limit(1)->pluck('id') as $id){
            if (! is_null($id)){
                $oneForm[] = $this->fireEdit($id);
            }
        }

        $severalforms[] ='<p class="alert bg-info">В данном примере показано использование нескольких форм на одной странице полученных методом FireEdit()<BR/> Сохраняеются изменения только одной формы.</p>';

        foreach (Company::limit(5)->pluck('id') as $id){
            if (!is_null($id)){
                $severalforms[] = AdminSection::getModel(Company::class)->fireEdit($id);
            }
        }


        $columns = AdminFormElement::columns();

        foreach (Company::limit(5)->pluck('id') as $id){
            if (!is_null($id)){
                $columns->addColumn([ AdminSection::getModel(Company::class)->fireEdit($id)], 6);
            }
        }


        $tabs = AdminDisplay::tabbed();

        $tabs->appendTab(new FormElements($oneForm),'Forms In Tab');


        $tabs->appendTab(new FormElements($severalforms),'Several Fired Forms In Tab Example');

        $tabs->appendTab(new FormElements([$columns]),'Fired Forms In Columns');

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
