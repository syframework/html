<?php
namespace Sy\Test\Form;

use Sy\Component\Html\Form\Element;
use Sy\Test\TestCase;

class ElementTest extends TestCase {

	public function testConstructElement() {
		$e = new Element('input');
		$this->assertComponentRenderEqualsText($e, '<input />');
	}

}