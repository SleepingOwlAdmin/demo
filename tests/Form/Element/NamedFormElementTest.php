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

        $helpText = m::mock(\Illuminate\Contracts\Support\Htmlable::class);
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

        $this->assertEquals([$this->path => ['rule']],
            $this->element->getValidationRules());
    }

    public function test_gets_validation_rules_with_unique()
    {
        $this->element->addValidationRule('_unique');

        $model = m::mock(\Illuminate\Database\Eloquent\Model::class);
        $model->shouldReceive('getTable')->once()->andReturn('test_table');
        $model->shouldReceive('exists')->andReturn(true);
        $model->shouldReceive('getKey')->andReturn('test_table_id');
        $this->element->setModel($model);

        $rulesExpected = [
            $this->path => ['unique:test_table,cat2,test_table_id'],
        ];

        $this->assertEquals($rulesExpected,
            $this->element->getValidationRules());
    }

    /**
     * @depends test_gets_value
     */
    public function test_is_arrayable()
    {
        $this->element->toArray();
    }

    /**
     * @depends test_gets_value
     */
    public function test_is_savable()
    {
        $this->element->save();
    }

    /*
     * TODO Add tests. 
     */
}