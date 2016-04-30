<?php

class FormElementTest extends TestCase
{

    /**
     * @var \SleepingOwl\Admin\Form\FormElement
     */
    private $element;


    public function setUp()
    {
        parent::setUp();

        $this->element = $this->getMockForAbstractClass(\SleepingOwl\Admin\Form\FormElement::class);
    }


    public function test_adds_validation_rule()
    {
        $this->assertEmpty($this->element->getValidationRules());

        $rule = 'some_rule';
        $this->element->addValidationRule($rule);
        $this->assertEquals([$rule], $this->element->getValidationRules());
    }

    public function test_initializable()
    {
        \KodiCMS\Assets\Facades\Meta::shouldReceive('loadPackage')->once();
        $this->element->initialize();
    }

    public function test_sets_validation_rules_as_array()
    {
        $rules = [
            'rule|one',
            'rule|two',
        ];

        $rulesParsed = [
            ['rule', 'one'],
            ['rule', 'two'],
        ];

        $this->assertEmpty($this->element->getValidationRules());
        $this->element->setValidationRules($rules);
        $this->assertEquals($rulesParsed, $this->element->getValidationRules());
    }


    public function test_sets_validation_rules_as_arguments()
    {
        $rulesParsed = [
            ['rule', 'one'],
            ['rule', 'two'],
        ];

        $this->assertEmpty($this->element->getValidationRules());
        $this->element->setValidationRules('rule|one', 'rule|two');
        $this->assertEquals($rulesParsed, $this->element->getValidationRules());
    }


    public function test_gets_view()
    {
        $this->assertNotEmpty($this->element->getView());
    }


    public function test_gets_and_sets_model()
    {
        $this->assertEmpty($this->element->getModel());

        $model = Mockery::mock(\Illuminate\Database\Eloquent\Model::class);
        $this->element->setModel($model);
        $this->assertEquals($model, $this->element->getModel());
    }


    public function test_is_arrayable()
    {
        $this->assertTrue(is_array($this->element->toArray()));
    }


    public function test_converts_into_string()
    {
        $template = Mockery::mock(\SleepingOwl\Admin\Contracts\TemplateInterface::class);
        $template->shouldReceive('view->render');
        $this->app->instance('sleeping_owl.template', $template);

        $this->assertEquals('', $this->element->__toString());
    }
}