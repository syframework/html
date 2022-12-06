<?php
namespace Sy\Test;

use Sy\Component\Html\Link;
use Sy\Component\Html\Element;
use Sy\Component;

class LinkTest extends TestCase {

	public function testLinkCreation() {
		$a = new Link('hello');
		$this->assertComponentRenderEqualsText($a, '<a>hello</a>');
		$a = new Link('hello', '#');
		$this->assertComponentRenderEqualsText($a, '<a href="#">hello</a>');
		$a = new Link('hello', '#', ['class' => 'foo']);
		$this->assertComponentRenderEqualsText($a, '<a class="foo" href="#">hello</a>');
		$a = new Link(new Element('span', 'hello'));
		$this->assertComponentRenderEqualsText($a, '<a><span>hello</span></a>');
	}

}