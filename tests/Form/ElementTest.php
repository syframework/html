<?php
namespace Sy\Test\Form;

use Sy\Component\Html\Form\Element;
use Sy\Test\TestCase;

class ElementTest extends TestCase {

	public function testConstructElement() {
		$e = new Element('input');
		$this->assertComponentRenderEqualsText($e, '<input />');

		$e = new Element('textarea', 'hello world');
		$this->assertComponentRenderEqualsText($e, '<textarea>hello world</textarea>');

		$e = new Element('textarea', 'hello world', ['name' => 'foo', 'class' => 'bar']);
		$this->assertComponentRenderEqualsText($e, '<textarea name="foo" class="bar">hello world</textarea>');

		$e = new Element('textarea', 'hello world', ['name' => 'foo', 'class' => 'bar'], ['label' => 'Message']);
		$this->assertComponentRenderEqualsText($e, '<label>Message</label><textarea name="foo" class="bar">hello world</textarea>');
	}

	public function testSetAttributeName() {
		$e = new Element('input', attributes: ['name' => 'foo']);
		$this->assertComponentRenderEqualsText($e, '<input name="foo" />');

		$e = new Element('input', attributes: ['name' => 'foo.bar.baz']);
		$this->assertComponentRenderEqualsText($e, '<input name="foo_bar_baz" />');

		$e = new Element('input', attributes: ['name' => 'foo bar baz']);
		$this->assertComponentRenderEqualsText($e, '<input name="foo_bar_baz" />');

		$e = new Element('input', attributes: ['name' => 'foo[bar]']);
		$this->assertComponentRenderEqualsText($e, '<input name="foo[bar]" />');

		$e = new Element('input', attributes: ['name' => 'foo[bar][baz]']);
		$this->assertComponentRenderEqualsText($e, '<input name="foo[bar][baz]" />');

		$e = new Element('input', attributes: ['name' => 'foo[]']);
		$this->assertComponentRenderEqualsText($e, '<input name="foo[]" />');

		$e = new Element('input', attributes: ['name' => 'foo[bar][]']);
		$this->assertComponentRenderEqualsText($e, '<input name="foo[bar][]" />');
	}

	public function testLabelPosition() {
		$e = new Element('input', options: ['label' => 'foo']);
		$this->assertComponentRenderEqualsText($e, '<label>foo</label><input />');

		$e = new Element('input', options: ['label' => 'foo', 'label-position' => 'before']);
		$this->assertComponentRenderEqualsText($e, '<label>foo</label><input />');

		$e = new Element('input', options: ['label' => 'foo', 'label-position' => 'after']);
		$this->assertComponentRenderEqualsText($e, '<input /><label>foo</label>');

		$e = new Element('input', options: ['label' => 'foo', 'label-position' => 'wrap-before']);
		$this->assertComponentRenderEqualsText($e, '<label>foo<input /></label>');

		$e = new Element('input', options: ['label' => 'foo', 'label-position' => 'wrap-after']);
		$this->assertComponentRenderEqualsText($e, '<label><input />foo</label>');
	}

	public function testLabelClass() {
		$e = new Element('input', options: ['label' => 'foo', 'label-class' => 'well']);
		$this->assertComponentRenderEqualsText($e, '<label class="well">foo</label><input />');
	}

	public function testErrorPosition() {
		$e = new Element('input', options: ['error' => 'foo']);
		$this->assertComponentRenderEqualsText($e, '<span class="error">foo</span><input />');

		$e = new Element('input', options: ['error' => 'foo', 'error-position' => 'before']);
		$this->assertComponentRenderEqualsText($e, '<span class="error">foo</span><input />');

		$e = new Element('input', options: ['error' => 'foo', 'error-position' => 'after']);
		$this->assertComponentRenderEqualsText($e, '<input /><span class="error">foo</span>');
	}

	public function testSetError() {
		$e = new Element('input');
		$e->setError('hello world');
		$this->assertComponentRenderEqualsText($e, '<span class="error">hello world</span><input />');
	}

	public function testErrorClass() {
		$e = new Element('input', options: ['error' => 'foo', 'error-class' => 'well']);
		$this->assertComponentRenderEqualsText($e, '<span class="well">foo</span><input />');
	}

	public function testIsRequired() {
		$e = new Element('input');
		$this->assertFalse($e->isRequired());

		$e = new Element('input', attributes: ['required' => true]);
		$this->assertTrue($e->isRequired());

		$e = new Element('input', options: ['required' => true]);
		$this->assertTrue($e->isRequired());
	}

}