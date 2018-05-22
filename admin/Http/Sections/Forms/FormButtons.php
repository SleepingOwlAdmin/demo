<?php

namespace Admin\Http\Sections\Forms;

use AdminColumn;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use SleepingOwl\Admin\Form\FormElements;

use App\Model\Forms\FormButton;

use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Section;


use SleepingOwl\Admin\Form\Buttons\Save;
use SleepingOwl\Admin\Form\Buttons\SaveAndCreate;
use SleepingOwl\Admin\Form\Buttons\SaveAndClose;
use SleepingOwl\Admin\Form\Buttons\Delete;
use SleepingOwl\Admin\Form\Buttons\Cancel;


use AdminFormButton;


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


        $tabs = AdminDisplay::tabbed();

        $tabs->appendTab(
            new  FormElements([
                '<div class="alert bg-info">
                    <h4><B>Default AdminForm Buttons </B> </h4>
                    <p>У каждой формы по умолчанию задан набор кнопок, который представлен в виде массива</p>
                    <pre>
   $this->buttons = [
        \'delete\' => new Delete(),
        \'save\'   => (new Save())->setGroupElements([
            \'save_and_create\' => new SaveAndCreate(),
            \'save_and_close\'  => new SaveAndClose(),
        ]),
        \'cancel\' => new Cancel(),
   ];
                    </pre>
                </div>',

                $this->fireEdit(FormButton::First()->id)
            ])
            ,
            //Название таба
            'Default Buttons'
        );







        $form2 = $this->fireEdit( FormButton::first()->id );


        $form2->getButtons()->replaceButtons([
            'delete' => null,
            'save'   => AdminFormButton::save()->setGroupElements([
                'save_and_create' => (new SaveAndCreate())->setText('Сохранить и создать'),
                'save_and_close'  => new SaveAndClose(),
            ])->setText('Сохранить'),

            'cancel'  => AdminFormButton::cancel()->setText('Отменить'),
        ]);


        $tabs->appendTab(
            new  FormElements([
                '<div class="alert bg-info">
                    <h4><B>Default AdminForm Buttons </B> </h4>
                    <p>Мы можем заменить или убрать какую-либо кнопку передав ассоциативный массив в метод setButtons</p>
                    <pre>
  
    $form->getButtons()->replaceButtons([
            \'delete\' => null, // Убираем кнопку Delete
            \'save\'   => (new Save())->setGroupElements([
                \'save_and_create\' => new SaveAndCreate()->setText(\'Сохранить и создать\'),
                \'save_and_close\'  => new SaveAndClose(),
            ])->setText(\'Сохранить\'),

            \'cancel\'  => (new Cancel())->setText(\'Отменить\'),
        ]);
   или 
   $form->getButtons()->replaceButtons([
            \'delete\' => null, // Убираем кнопку Delete
            \'save\'   =>  AdminFormButton::save()->setGroupElements([
                \'save_and_create\' => (new SaveAndCreate())->setText(\'Сохранить и создать\'),
                \'save_and_close\'  => AdminFormButton::saveAndClose(),
            ])->setText(\'Сохранить\'),

            \'cancel\'  => AdminFormButton::cancel(->setText(\'Отменить\'),
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


        $form3 = $this->fireEdit( FormButton::first()->id );

        $form3->getButtons()->setButtons([]);

        $tabs->appendTab(
            new  FormElements([
            '<div class="alert bg-info">
                    <h4><B>Clear All  AdminForm Buttons </B> </h4>
                    <p>Мы можем удалить все кнопки передав пустой массив в setButtons:</p>
                    <pre>
  $form->getButtons()->setButtons ([]);
                    </pre>                                    
                </div>',
            $form3
        ])
            ,
            //Название таба
            'Clear Form Buttons'
        );


        $form4 = $this->fireEdit( FormButton::first()->id );

        $form4->getButtons()->setButtons([
            'cancel' => new Cancel(),
            'save'   => (new Save())->setGroupElements([
                'save_and_create' => new SaveAndCreate(),
                'save_and_close'  => new SaveAndClose(),
            ]),

            'delete' => new Delete(),
            'call_to_grandma' => (new Save())->setText('Позвонить бабушке'),
            'write'   => (new Save())->setGroupElements([
                'write_will' => AdminFormButton::save()->setText('Написать завещание'),
                'write_order'  => AdminFormButton::save()->setText('Оформить заказ'),
                'write_mail'  => AdminFormButton::save()->setText('Отправить письмо'),
            ])->setText('Написать'),
        ]);


        $tabs->appendTab(
            new  FormElements([
                    '<div class="alert bg-info">
                    <h4><B>Clear All  AdminForm Buttons </B> </h4>
                    <p>Передав свой массив, мы можем изменить порядок кнопок или добавить новые setButtons:</p>
                    <pre>
   $form4->getButtons()->setButtons([
            \'cancel\' => new Cancel(),
            \'save\'   => (new Save())->setGroupElements([
                \'save_and_create\' => new SaveAndCreate(),
                \'save_and_close\'  => new SaveAndClose(),
            ]),

            \'delete\' => new Delete(),
            \'call_to_grandma\' => (new Save())->setText(\'Позвонить бабушке\'),
            \'write\'   => (new Save())->setGroupElements([
                \'write_will\' => AdminFormButton::save()->setText(\'Написать завещание\'),
                \'write_order\'  => AdminFormButton::save()->setText(\'Оформить заказ\'),
                \'write_mail\'  => AdminFormButton::save()->setText(\'Отправить письмо\'),
            ])->setText(\'Написать\'),
    ]);
                </pre>                       
                <p>Вы можете создать свой класс Кнопки со своей логикой или унаследовать его от существующего.</p>
                </div>',
                    $form4
            ])
            ,
            //Название таба
            'Add Form Buttons'
        );



        $form5 = $this->fireEdit( FormButton::first()->id );

        $form5->getButtons()->setButtons([
            'cancel' => (new Cancel())->getHtmlAttribute('style','border:5px solid green'),
            'save'   => (new Save())->setGroupElements([
                'save_and_create' => new SaveAndCreate(),
                'save_and_close'  => new SaveAndClose(),
            ]),

            'delete' => new Delete(),
        ]);

        $tabs->appendTab(
            new  FormElements([
                '<div class="alert bg-info">
                    <h4><B> AdminForm Buttons Placement</B> </h4>
                    <p>Можно добавлять кнопоки используя метод setPlacement</p>
                    <p>В этот метод мы передаем ассоциативный массив с указанием места установки дополнительных кнопок.</p>
                    <pre>
 $form5->getButtons()
    ->setPlacements([
        \'after\' => [\'title\', \'date\'],
        \'before\' => [\'title\']
]);
                </pre>                       
                </div>',
                $form5
            ])
            ,
            //Название таба
            'Form Buttons Placement'
        );





        $form6 = $this->fireEdit( FormButton::first()->id );

        $form6->getButtons()->replaceButtons ([
            'save'   => (new Save())->setText('Сохранить')->setHtmlAttributes(['style'=>'border:3px solid purple; background: violet;', 'data-custom'=>'mydata']),

            'delete'   => (new Delete())->setText('Не удалять')->setHtmlAttribute('style','border:3px solid purple; background: orange;'),
        ])->setHtmlAttributes(['class'=>'pull-right','style'=>'background: #d9edf7;']);
        

        $tabs->appendTab(
            new  FormElements([
                '<div class="alert bg-info">
                    <h4><B>Default AdminForm Buttons </B> </h4>
                    <p>Для каждой кнопки или группы кнопок можно поменять или задать HTML атрибуты</p>
                    <pre>
      $form6->getButtons()->replaceButtons ([
            \'save\'   => (new Save())->setText(\'Сохранить\')->setHtmlAttributes([\'style\'=>\'border:3px solid purple; background: violet;\', \'data-custom\'=>\'mydata\']),

            \'delete\'   => (new Delete())->setText(\'Не удалять\')->setHtmlAttribute(\'style\',\'border:3px solid purple; background: violet;\'),
        ])->setHtmlAttributes([\'class\'=>\'pull-right\',\'style\'=>\'background: grey\']);
                    </pre>
                    <p>Будут изменены только перечисленные в массиве кнопки</p>                   
                 
                </div>',
                $form6
            ])
            ,
            //Название таба
            'Form Buttons HTML Attributes'
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
        return AdminForm::panel()
            ->addBody([
                AdminFormElement::text('title', 'Title')->required(),
                AdminFormElement::date('date', 'Date'),
        ]);
    }

    /**
     * @return FormInterface
     */
    public function onCreate()
    {
        return $this->onEdit(null);
    }
}
