<?php

class NamedFormElementTest extends TestCase
{

    /**
     * @var \SleepingOwl\Admin\Form\Element\NamedFormElement
     */
    private $element;

    private $path = 'cat.cat1.cat2';


    public function setUp()
    {
        $this->element = $this->getMockForAbstractClass(\SleepingOwl\Admin\Form\Element\NamedFormElement::class,
            [$this->path]);
    }


    public function test_sets_and_gets_label()
    {
        $this->assertNull($this->element->getLabel());

        $label = 'label';
        $this->element->setLabel($label);
        $this->assertEquals($label, $this->element->getLabel());
    }


    public function test_sets_and_gets_path()
    {
        $this->assertEquals($this->path, $this->element->getPath());

        $path = 'other-path';
        $this->element->setPath($path);
        $this->assertEquals($path, $this->element->getPath());
    }


    public function test_sets_and_gets_default_value()
    {
        $this->assertNull($this->element->getDefaultValue());

        $defaultValue = 'value';
        $this->element->setDefaultValue($defaultValue);
        $this->assertEquals($defaultValue, $this->element->getDefaultValue());
    }


    public function test_sets_and_gets_name()
    {
        $this->assertEquals('cat[cat1][cat2]', $this->element->getName());

        $name = 'some-name';
        $this->element->setName($name);
        $this->assertEquals($name, $this->element->getName());
    }


    public function test_sets_and_gets_attribute()
    {
        $this->assertEquals('cat2', $this->element->getAttribute());

        $attribute = 'some-attribute';
        $this->element->setAttribute($attribute);
        $this->assertEquals($attribute, $this->element->getAttribute());
    }


    public function test_sets_and_gets_help_text()
    {
        $this->assertEmpty($this->element->getHelpText());

        $helpText = 'help text';
        $this->element->setHelpText($helpText);
        $this->assertEquals($helpText, $this->element->getHelpText());
    }


    public function test_sets_and_gets_help_text_as_htmlable()
    {
        $this->assertEmpty($this->element->getHelpText());

        $helpText = Mockery::mock(\Illuminate\Contracts\Support\Htmlable::class);
        $helpText->shouldReceive('toHtml')->once();

        $this->element->setHelpText($helpText);
        $this->element->getHelpText();
    }


    public function test_sets_and_gets_readonly()
    {
        $this->assertFalse($this->element->isReadonly());
        $this->element->setReadonly(true);
        $this->assertTrue($this->element->isReadonly());
    }


    public function test_adds_validation_rule_without_message()
    {
        $this->element->addValidationRule('rule:second');
        $expectedRule = ['cat.cat1.cat2' => ['rule:second']];

        $this->assertEquals($expectedRule,
            $this->element->getValidationRules());
    }


    public function test_adds_validation_rule_with_message()
    {
        $this->element->addValidationRule('rule:second', 'message');

        $expectedRule = ['cat.cat1.cat2' => ['rule:second']];
        $this->assertEquals($expectedRule,
            $this->element->getValidationRules());

        $expectedMessage = ['cat[cat1][cat2].rule' => 'message'];
        $this->assertEquals($expectedMessage,
            $this->element->getValidationMessages());
    }


    public function test_adds_validation_messages()
    {
        $this->assertEmpty($this->element->getValidationMessages());

        $this->element->addValidationMessage('rule', 'message');

        $expectedMessage = ['cat[cat1][cat2].rule' => 'message'];
        $this->assertEquals($expectedMessage,
            $this->element->getValidationMessages());
    }


    public function test_sets_validation_messages()
    {
        $messages = ['rule' => 'message'];
        $this->element->setValidationMessages($messages);

        $expectedMessage = ['cat[cat1][cat2].rule' => 'message'];
        $this->assertEquals($expectedMessage,
            $this->element->getValidationMessages());
    }

    public function test_gets_value(){
        dd($this->element->getValue());
    }

    /*
     * TODO Add tests. 
     */
}