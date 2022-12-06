<?php
namespace Sy\Test;

use Sy\Component\Html\Element;
use Sy\Component;

class ElementTest extends TestCase {

	public function testConstructElement() {
		$e = new Element('div');
		$this->assertComponentRenderEqualsText($e, '<div></div>');
		$e = new Element('div', 'hello');
		$this->assertComponentRenderEqualsText($e, '<div>hello</div>');
		$e = new Element('div', 'hello', ['class' => 'foo']);
		$this->assertComponentRenderEqualsText($e, '<div class="foo">hello</div>');
		$e = new Element('div', new Element('span', 'hello'), ['class' => 'foo']);
		$this->assertComponentRenderEqualsText($e, '<div class="foo"><span>hello</span></div>');
	}

	public function testEmptyElement() {
		$e = new Element('div');
		$this->assertTrue($e->isEmpty());
		$e->addText('hello');
		$this->assertFalse($e->isEmpty());
	}

	public function testVoidElement() {
		$e = new Element('img');
		$this->assertComponentRenderEqualsText($e, '<img />');
		$e->addText('hello');
		$this->assertComponentRenderEqualsText($e, '<img />');
	}

	public function testSetAttribute() {
		$e = new Element('a');
		$e->setAttribute('class', 'foo');
		$this->assertComponentRenderEqualsText($e, '<a class="foo"></a>');

		$e = new Element('a');
		$e->setAttributes([
			'class' => 'foo',
			'href'  => '#',
		]);
		$this->assertComponentRenderEqualsText($e, '<a class="foo" href="#"></a>');
	}

	public function testGetAttribute() {
		$e = new Element('a');
		$e->setAttributes([
			'class' => 'foo',
			'href'  => '#',
		]);
		$this->assertEquals('foo', $e->getAttribute('class'));
		$this->assertEquals([
			'class' => 'foo',
			'href'  => '#',
		], $e->getAttributes());
	}

	public function testUnsetAttribute() {
		$e = new Element('a');
		$e->setAttributes([
			'class' => 'foo',
			'href'  => '#',
		]);
		$e->unsetAttribute('class');
		$this->assertEquals(['href' => '#'], $e->getAttributes());
		$this->assertEquals(null, $e->getAttribute('class'));
	}

	public function testAddClass() {
		$e = new Element('a');
		$e->addClass('foo');
		$this->assertComponentRenderEqualsText($e, '<a class="foo"></a>');

		$e = new Element('a');
		$e->addClass('foo');
		$e->addClass('bar');
		$this->assertComponentRenderEqualsText($e, '<a class="foo bar"></a>');

		$e = new Element('a');
		$e->addClass('foo');
		$e->addClass('bar');
		$e->addClass('baz');
		$this->assertComponentRenderEqualsText($e, '<a class="foo bar baz"></a>');
	}

	public function testAddText() {
		$e = new Element('div');
		$e->addText('hello');
		$this->assertComponentRenderEqualsText($e, '<div>hello</div>');
	}

	public function testAddElement() {
		$e = new Element('div');
		$e->addElement(new Element('span'));
		$this->assertComponentRenderEqualsText($e, '<div><span></span></div>');
	}

	public function testSetContent() {
		$e = new Element('div');
		$e->setContent(
			new Element('span'),
			'hello',
			new Element('a'),
		);
		$this->assertComponentRenderEqualsText($e, '<div><span></span>hello<a></a></div>');

		$e = new Element('div');
		$e->setContent(
			'foo',
			'bar',
			'baz',
		);
		$this->assertComponentRenderEqualsText($e, '
			<div>
				foo
				bar
				baz
			</div>
		');

		$e = new Element('div');
		$e->addElement(new Element('hr'));
		$e->setContent();
		$this->assertEquals([], $e->getContent());
	}

	public function testGetContent() {
		$e = new Element('div');
		$e->setContent('foo', 'bar', 'baz');
		$this->assertEquals(['foo', 'bar', 'baz'], $e->getContent());

		$e = new Element('div');
		$e->setContent('foo', 'bar', 'baz', '');
		$this->assertEquals(['foo', 'bar', 'baz'], $e->getContent());

		$e = new Element('div');
		$e->setContent('foo', 'bar', 'baz', null);
		$this->assertEquals(['foo', 'bar', 'baz'], $e->getContent());
	}

	public function testParent() {
		$a = new Element('div');
		$b = new Element('span', 'hello');
		$a->setContent($b);
		$this->assertComponentRenderEqualsText($b->getParent(), '<div><span>hello</span></div>');
		$a = new Element('div');
		$b = new Element('span', 'hello');
		$a->addContent($b);
		$this->assertComponentRenderEqualsText($b->getParent(), '<div><span>hello</span></div>');
	}

}