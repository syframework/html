<?php

use PHPUnit\Framework\TestCase;
use Sy\Component\Html\Navigation\Item;
use Sy\Component\Html\Link;
use Sy\Component\Html\Element;
use Sy\Component;

class ItemTest extends TestCase {

	public function assertComponentRenderEqualsText(Component $component, string $text) {
		$minify = function ($code) {
			$code = str_replace(array("\t", "\r", "\n"), '', $code);
			$code = preg_replace('/\s+/', ' ', $code);
			$code = str_replace(array('> <'), '', $code);
			return trim($code);
		};
		$this->assertEquals($minify($text), $minify($component->render()));
	}

	public function testConstructItem() {
		$i = new Item('hello');
		$this->assertComponentRenderEqualsText($i, '<li>hello</li>');
		$i = new Item('hello', 'url');
		$this->assertComponentRenderEqualsText($i, '<li><a href="url">hello</a></li>');
		$i = new Item('hello', 'url', ['class' => 'foo']);
		$this->assertComponentRenderEqualsText($i, '<li class="foo"><a href="url">hello</a></li>');
		$i = new Item(new Link('hello', 'url', ['class' => 'foo']));
		$this->assertComponentRenderEqualsText($i, '<li><a class="foo" href="url">hello</a></li>');
		$i = new Item(new Link('hello', 'url', ['class' => 'foo']), null, ['class' => 'bar']);
		$this->assertComponentRenderEqualsText($i, '<li class="bar"><a class="foo" href="url">hello</a></li>');
		$i = new Item(new Element('span', 'hello', ['class' => 'foo']), 'url', ['class' => 'bar']);
		$this->assertComponentRenderEqualsText($i, '<li class="bar"><a href="url"><span class="foo">hello</span></a></li>');
		$i = new Item(new Link(new Element('span', 'hello', ['class' => 'baz']), 'url', ['class' => 'foo']), null, ['class' => 'bar']);
		$this->assertComponentRenderEqualsText($i, '<li class="bar"><a class="foo" href="url"><span class="baz">hello</span></a></li>');
	}

}