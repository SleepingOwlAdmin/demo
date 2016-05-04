<?php

use Mockery as m;

class AdminTest extends TestCase
{
    /**
     * @var Admin
     */
    private $admin;

    public function setUp()
    {
        parent::setUp();

        $this->admin = new SleepingOwl\Admin\Admin();
    }

    /**
     * @covers SleepingOwl\Admin\Admin::registerModel
     * @covers SleepingOwl\Admin\Admin::getModels
     */
    public function registers_models()
    {
        $this->admin->registerModel('TestModel', function () { });
        $this->assertEquals(1, count($this->admin->getModels()));

        $this->admin->registerModel('TestModel', function () { });
        $this->assertEquals(1, count($this->admin->getModels()));

        $this->admin->registerModel('OtherModel', function () { });
        $this->assertEquals(2, count($this->admin->getModels()));
    }

    /**
     * @covers SleepingOwl\Admin\Admin::modelAliases
     * @covers SleepingOwl\Admin\Admin::getModels
     */
    public function test_returns_form_aliases()
    {
        $this->admin->registerModel('TestModel', function () { });
        $aliases = $this->admin->modelAliases();
        $this->assertEquals('test_models', $aliases['TestModel']);
    }

    /**
     * @covers SleepingOwl\Admin\Admin::getModel
     */
    public function test_gets_model()
    {
        $this->markTestIncomplete('Function needs refactoring or clarification.');

        $model = $this->admin->getModel();
    }

    /**
     * @covers SleepingOwl\Admin\Admin::hasModel
     */
    public function test_checks_if_has_model()
    {
        $this->admin->registerModel('TestModel', function () { });
        $this->assertTrue($this->admin->hasModel('TestModel'));
        $this->assertFalse($this->admin->hasModel('AbsentModel'));
    }

    /**
     * @covers SleepingOwl\Admin\Admin::template
     */
    public function test_returns_template()
    {
        $this->assertInstanceOf(\SleepingOwl\Admin\Contracts\TemplateInterface::class,
            $this->admin->template());
    }

    /**
     * @covers SleepingOwl\Admin\Admin::addMenuPage
     */
    public function test_adds_menu_page()
    {
        $navigation = m::mock(\SleepingOwl\Admin\Navigation::class);
        $this->app->instance('sleeping_owl.navigation', $navigation);
        $navigation->shouldReceive('addPage->setPriority')->once();

        $this->admin->addMenuPage();
    }

    /**
     * @covers SleepingOwl\Admin\Admin::view
     */
    public function test_renders_view()
    {
        $arguments = ['content', 'title'];
        $controllerClass = \SleepingOwl\Admin\Http\Controllers\AdminController::class;

        $controller = m::mock($controllerClass);
        $this->app->instance($controllerClass, $controller);
        $controller->shouldReceive('renderContent')
                   ->withArgs($arguments)
                   ->once();

        $this->admin->view($arguments[0], $arguments[1]);
    }
}