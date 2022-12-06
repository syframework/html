<?php
namespace Sy\Test\Form;

use Sy\Component\Html\Form\Container;
use Sy\Component\Html\Form\Element;
use Sy\Test\TestCase;

class ContainerTest extends TestCase {

	public function testConstructContainer() {
		$c = new Container('container');
		$this->assertComponentRenderEqualsText($c, '<container></container>');
		$c = new Container('container');
		$c->addElement(new Element('hello'));
		$this->assertComponentRenderEqualsText($c, '<container><hello></hello></container>');
	}

}