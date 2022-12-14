<?php
namespace Sy\Test\Form;

use Sy\Component\Html\Form\Textarea;
use Sy\Test\TestCase;

class TextareaTest extends TestCase {

	public function testConstruct() {
		$t = new Textarea();
		$this->assertComponentRenderEqualsText($t, '<textarea></textarea>');

		$t = new Textarea();
		$t->setContent('hello world');
		$this->assertComponentRenderEqualsText($t, '
			<textarea>
				hello world
			</textarea>
		');

		$t = new Textarea();
		$t->addText('foo');
		$t->addText('bar');
		$this->assertComponentRenderEqualsText($t, '
			<textarea>
				foobar
			</textarea>
		');
	}

}