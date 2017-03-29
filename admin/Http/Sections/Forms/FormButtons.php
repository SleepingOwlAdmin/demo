<?php

namespace Admin\Http\Sections\Forms;

use AdminColumn;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use SleepingOwl\Admin\Form\FormElements;

use App\Model\Forms\Form;

use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Section;


use SleepingOwl\Admin\Form\Buttons\Save;



/**
 * Class Form
 *
 * @property \App\Model\Form $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class FormButtons extends Section implements Initializable
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
    protected $title = 'Form Buttons';

    /**
     * @var string
     */
    protected $alias ='form_buttons';

    /**
     * Initialize class.
     */
    public function initialize()
    {
        $page = \AdminNavigation::getPages()->findById('forms-examples');

        $page->addPage(
            $this->makePage(0,'New')
        );
    }

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {

     ;
            return $this->fireEdit( Form::first()->id );
    }

    /**
     * @param int $id
     *
     * @return FormInterface
     */
    public function onEdit($id)
    {

        $tabs = AdminDisplay::tabbed();

        $form = AdminForm::panel()
            ->addBody([
                AdminFormElement::text('title', 'Title')->required(),
        ]);

        $form->getButtons();

        $tabs->appendTab(
            new  FormElements([
                '<div class="alert bg-info">
                    <h4><B>Default AdminForm Buttons </B> </h4>
                    <p>У каждой формы по умолчанию задан набор кнопок, который представлен в виде массива</p>
                    <pre>
   buttons = [
        \'delete\' => new Delete(),
        \'save\'   => (new Save())->setGroupElements([
            \'save_and_create\' => new SaveAndCreate(),
            \'save_and_close\'  => new SaveAndClose(),
        ]),
        \'cancel\' => new Cancel(),
   ];
                    </pre>
                </div>',
                $form
            ])
            ,
            //Название таба
            'Default Buttons'
        );




        $form2 = AdminForm::panel()->setModelClass(Form::class)
            ->setElements([
                AdminFormElement::text('title', 'Title')->required(),
            ]);

        $form2->getButtons()->setButtons([
            'delete' => null,

            'save'   => (new Save())-> setText('Сохранить'),
        ]);

        $tabs->appendTab(
            new  FormElements([
                '<div class="alert bg-info">
                    <h4><B>Default AdminForm Buttons </B> </h4>
                    <p>Мы можем заменить или убрать какую-либо кнопку передав ассоциативный массив в метод setButtons</p>
                    <pre>
  $form->getButtons()->setButtons ([
        \'delete\' => null,
        \'save\' => new Save()::setText(\'Сохранить\'),
       
   ]);
                    </pre>
                    <p>Будут изменены только перечисленные в массиве кнопки</p>
                </div>',
                $form2
            ])
            ,
            //Название таба
            'Replace Form Buttons'
        );

        $tabs->appendTab(
            $form
            ,
            //Название таба
            'Clear Form Buttons'
        );

        $tabs->appendTab(
            $form
            ,
            //Название таба
            'Add Form Buttons'
        );

        $tabs->appendTab(
            $form
            ,
            //Название таба
            'Form Buttons HTML Attributes'
        );

        $tabs->appendTab(
            $form
            ,
            //Название таба
            'Form Buttons Placement'
        );

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
