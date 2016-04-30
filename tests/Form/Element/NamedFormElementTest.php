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


    public function test_sets_and_gets_help_text()
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


    /*
     * TODO Add tests. 
     */
}