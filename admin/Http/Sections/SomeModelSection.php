<?php

namespace Admin\Http\Sections;

use AdminDisplay;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Form\Buttons\Save;
use SleepingOwl\Admin\Section;

/**
 * Class SomeModelSection
 *
 * @property \App\SomeModel $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class SomeModelSection extends Section implements Initializable {
    /**
     * @see http://sleepingowladmin.ru/docs/model_configuration#ограничение-прав-доступа
     *
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Demo of the bug';

    /**
     * @var string
     */
    protected $alias;

    protected $icon = 'fa fa-bug';

    /**
     * @return DisplayInterface
     */
    public function onDisplay() {
        return $this->fireEdit( 1 );
    }

    /**
     * @param int $id
     *
     * @return FormInterface
     */
    // Generally: I have one section, that bound to one setting-record in database (line 42). It setting has "dependent"
    // model, which displayed IN THE SAME FORM as table. This leads to "Method not allowed exception"

    // By the way, I did a little mistake somewhere, so
    //  a) The save button doesn't work
    //  b) Table has no create button & edit button
    // But it's only in demo and the bug with deleting the FIRST row in table still represented
    public function onEdit( $id ) {
        $section = new SomeAnotherSection( $this->app, 'App\SomeAnotherModel' );
        $form    = \AdminForm::form()->setElements( [
            \AdminFormElement::text( 'name' ),
            $section->fireDisplay()
        ] );
        $form->getButtons()->replaceButtons( [ 'save' => new Save(), 'delete' => null, 'cancel' => null ] );

        $tabs = \AdminDisplay::tabbed();
        $tabs->setTabs( [
            AdminDisplay::tab( $form )->setLabel( 'Tab 1' ),
            AdminDisplay::tab( $form )->setLabel( 'Tab 2' )
        ] );

        return $tabs;
    }

    /**
     * @return FormInterface
     */
    public function onCreate() {
        return $this->onEdit( null );
    }

    /**
     * @return void
     */
    public function onDelete( $id ) {
        // remove if unused
    }

    /**
     * @return void
     */
    public function onRestore( $id ) {
        // remove if unused
    }

    public function initialize() {
        $this->addToNavigation();
    }
}
