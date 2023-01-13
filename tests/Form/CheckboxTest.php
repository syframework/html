<?php
namespace Sy\Test\Form;

use Sy\Component\Html\Form\Checkbox;
use Sy\Test\TestCase;

class CheckboxTest extends TestCase {

	public function testConstructCheckbox() {
		$c = new Checkbox();
		$this->assertComponentRenderEqualsText($c, '<input type="checkbox" />');

		$c = new Checkbox(attributes: ['class' => 'foo']);
		$this->assertComponentRenderEqualsText($c, '<input class="foo" type="checkbox" />');

		$c = new Checkbox(options: ['label' => 'foo']);
		$this->assertComponentRenderEqualsText($c, '<input type="checkbox" /><label>foo</label>');
	}

	public function testFill() {
		$c = new Checkbox(attributes: ['value' => 'foo']);
		$c->fill('foo');
		$this->assertComponentRenderEqualsText($c, '<input value="foo" checked="checked" type="checkbox" />');

		$c = new Checkbox(attributes: ['value' => 'foo']);
		$c->fill(['foo', 'bar', 'baz']);
		$this->assertComponentRenderEqualsText($c, '<input value="foo" checked="checked" type="checkbox" />');

		$c = new Checkbox(attributes: ['value' => 'foo']);
		$c->fill('bar');
		$this->assertComponentRenderEqualsText($c, '<input value="foo" type="checkbox" />');

		$c = new Checkbox(attributes: ['value' => 'foo']);
		$c->fill(null);
		$this->assertComponentRenderEqualsText($c, '<input value="foo" type="checkbox" />');

		$c = new Checkbox();
		$c->fill('bar');
		$this->assertComponentRenderEqualsText($c, '<input type="checkbox" />');

		$c = new Checkbox();
		$c->fill('');
		$this->assertComponentRenderEqualsText($c, '<input checked="checked" type="checkbox" />');
	}

	public function testIsValid() {
		$c = new Checkbox(attributes: ['value' => 'foo']);
		$this->assertTrue($c->isValid('anything'));

		$c = new Checkbox(attributes: ['value' => 'foo', 'required' => true]);
		$this->assertFalse($c->isValid('anything'));

		$c = new Checkbox(attributes: ['value' => 'foo', 'required' => true]);
		$this->assertTrue($c->isValid('foo'));

		$c = new Checkbox(attributes: ['value' => 'foo', 'required' => true]);
		$this->assertTrue($c->isValid(['foo', 'bar', 'baz']));

		$c = new Checkbox(attributes: ['value' => 'foo', 'required' => true]);
		$this->assertFalse($c->isValid(['bar', 'baz']));
	}

}