<?php

use Mockery as m;

class NamedFormElementTest extends TestCase
{

    /**
     * @var \SleepingOwl\Admin\Form\Element\NamedFormElement
     */
    private $element;

    private $path = 'cat.cat1.cat2';

    public function setUp()
    {
        parent::setUp();

        $this->element = $this->getMockForAbstractClass(
            \SleepingOwl\Admin\Form\Element\NamedFormElement::class,
            [$this->path]
        );
    }

    /**
     * @covers SleepingOwl\Admin\Form\Element\NamedFormElement::setLabel
     */
    public function test_sets_and_gets_label()
    {
        $this->assertNull($this->element->getLabel());

        $label = 'label';
        $this->element->setLabel($label);
        $this->assertEquals($label, $this->element->getLabel());
    }

    /**
     * @covers SleepingOwl\Admin\Form\Element\NamedFormElement::setPath
     * @covers SleepingOwl\Admin\Form\Element\NamedFormElement::getPath
     */
    public function test_sets_and_gets_path()
    {
        $this->assertEquals($this->path, $this->element->getPath());

        $path = 'other-path';
        $this->element->setPath($path);
        $this->assertEquals($path, $this->element->getPath());
    }

    /**
     * @covers SleepingOwl\Admin\Form\Element\NamedFormElement::setDefaultValue
     * @covers SleepingOwl\Admin\Form\Element\NamedFormElement::getDefaultValue
     */
    public function test_sets_and_gets_default_value()
    {
        $this->assertNull($this->element->getDefaultValue());

        $defaultValue = 'value';
        $this->element->setDefaultValue($defaultValue);
        $this->assertEquals($defaultValue, $this->element->getDefaultValue());
    }

    /**
     * @covers SleepingOwl\Admin\Form\Element\NamedFormElement::setName
     * @covers SleepingOwl\Admin\Form\Element\NamedFormElement::getName
     */
    public function test_sets_and_gets_name()
    {
        $this->assertEquals('cat[cat1][cat2]', $this->element->getName());

        $name = 'some-name';
        $this->element->setName($name);
        $this->assertEquals($name, $this->element->getName());
    }

    /**
     * @covers SleepingOwl\Admin\Form\Element\NamedFormElement::setAttribute
     * @covers SleepingOwl\Admin\Form\Element\NamedFormElement::getAttribute
     */
    public function test_sets_and_gets_attribute()
    {
        $this->assertEquals('cat2', $this->element->getAttribute());

        $attribute = 'some-attribute';
        $this->element->setAttribute($attribute);
        $this->assertEquals($attribute, $this->element->getAttribute());
    }

    /**
     * @covers SleepingOwl\Admin\Form\Element\NamedFormElement::setHelpText
     * @covers SleepingOwl\Admin\Form\Element\NamedFormElement::getHelpText
     */
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

        $helpText = m::mock(\Illuminate\Contracts\Support\Htmlable::class);
        $helpText->shouldReceive('toHtml')->once();

        $this->element->setHelpText($helpText);
        $this->element->getHelpText();
    }

    /**
     * @covers SleepingOwl\Admin\Form\Element\NamedFormElement::isReadonly
     * @covers SleepingOwl\Admin\Form\Element\NamedFormElement::setReadonly
     */
    public function test_sets_and_gets_readonly()
    {
        $this->assertFalse($this->element->isReadonly());
        $this->element->setReadonly(true);
        $this->assertTrue($this->element->isReadonly());
    }

    /**
     * @covers SleepingOwl\Admin\Form\Element\NamedFormElement::addValidationRule
     * @covers SleepingOwl\Admin\Form\Element\NamedFormElement::getValidationRules
     */
    public function test_adds_validation_rule_without_message()
    {
        $this->element->addValidationRule('rule:second');
        $expectedRule = ['cat.cat1.cat2' => ['rule:second']];

        $this->assertEquals(
            $expectedRule,
            $this->element->getValidationRules()
        );
    }

    /**
     * @covers SleepingOwl\Admin\Form\Element\NamedFormElement::getValidationMessages
     */
    public function test_adds_validation_rule_with_message()
    {
        $this->element->addValidationRule('rule:second', 'message');

        $expectedRule = ['cat.cat1.cat2' => ['rule:second']];
        $this->assertEquals(
            $expectedRule,
            $this->element->getValidationRules()
        );

        $expectedMessage = ['cat[cat1][cat2].rule' => 'message'];
        $this->assertEquals(
            $expectedMessage,
            $this->element->getValidationMessages()
        );
    }

    /**
     * @covers SleepingOwl\Admin\Form\Element\NamedFormElement::addValidationMessage
     */
    public function test_adds_validation_messages()
    {
        $this->assertEmpty($this->element->getValidationMessages());

        $this->element->addValidationMessage('rule', 'message');

        $expectedMessage = ['cat[cat1][cat2].rule' => 'message'];
        $this->assertEquals(
            $expectedMessage,
            $this->element->getValidationMessages()
        );
    }

    /**
     * @covers SleepingOwl\Admin\Form\Element\NamedFormElement::setValidationMessages
     */
    public function test_sets_validation_messages()
    {
        $messages = ['rule' => 'message'];
        $this->element->setValidationMessages($messages);

        $expectedMessage = ['cat[cat1][cat2].rule' => 'message'];
        $this->assertEquals(
            $expectedMessage,
            $this->element->getValidationMessages()
        );
    }

    /**
     * @expectedException LogicException
     */
    public function test_gets_value()
    {
        $request = m::mock(\Illuminate\Http\Request::class);
        $request->shouldReceive('all')->once()->andReturn(['input' => 'value']);
        $request->shouldReceive('old')->once()->andReturn(null);
        $request->shouldReceive('setUserResolver');
        Request::swap($request);

        $model = m::mock(\Illuminate\Database\Eloquent\Model::class);
        $model->shouldReceive('getAttribute')
              ->set('cat.cat1.cat2', 'test_value')
              ->once()
              ->andReturn('test_attribute');
        // Required for magic methods to function.
        $model->shouldReceive('setAttribute');

        $this->element->setModel($model);

        $this->markTestIncomplete('Method requires refactoring.');

        $this->element->getValue();
    }

    public function test_gets_validation_rules()
    {
        $this->element->addValidationRule('rule');

        $this->assertEquals(
            [$this->path => ['rule']],
            $this->element->getValidationRules()
        );
    }

    /**
     * @covers SleepingOwl\Admin\Form\Element\NamedFormElement::unique
     */
    public function test_gets_validation_rules_with_unique()
    {
        $this->element->unique();

        $model = m::mock(\Illuminate\Database\Eloquent\Model::class);
        $model->shouldReceive('getTable')->once()->andReturn('test_table');
        $model->shouldReceive('exists')->andReturn(true);
        $model->shouldReceive('getKey')->andReturn('test_table_id');
        $this->element->setModel($model);

        $rulesExpected = [
            $this->path => ['unique:test_table,cat2,test_table_id'],
        ];

        $this->assertEquals(
            $rulesExpected,
            $this->element->getValidationRules()
        );
    }

    /**
     * @covers SleepingOwl\Admin\Form\Element\NamedFormElement::toArray
     */
    //public function test_is_arrayable()
    //{
    //    Request::shouldReceive('old')->once()->andReturn('test');
    //
    //    $model = m::mock(\Illuminate\Database\Eloquent\Model::class);
    //    $this->element->setModel($model);
    //
    //
    //    $this->assertTrue(is_array($this->element->toArray()));
    //}

    /**
     * @covers SleepingOwl\Admin\Form\Element\NamedFormElement::save
     */
    //public function test_is_savable()
    //{
    //    $model = m::mock(\Illuminate\Database\Eloquent\Model::class);
    //    Request::shouldReceive('old')->once()
    //        ->with($this->element->getPath())
    //        ->andReturn('value');
    //
    //    $model->shouldReceive('setAttribute')->with('path', 'value')->once();
    //
    //    $this->element->setPath('path');
    //    $this->element->setModel($model);
    //
    //    $this->element->save();
    //}
}