<?php
namespace Sy\Test\Form;

use Sy\Component\Html\Form\FieldContainer;
use Sy\Test\TestCase;

class FieldContainerTest extends TestCase {

	public function testConstructFieldContainer() {
		$f = new FieldContainer('fieldset');
		$this->assertComponentRenderEqualsText($f, '<fieldset></fieldset>');
		$f = new FieldContainer('fieldset');
		$f->addButton('hello');
		$this->assertComponentRenderEqualsText($f, '<fieldset><button>hello</button></fieldset>');
	}

}