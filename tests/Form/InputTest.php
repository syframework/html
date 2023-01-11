<?php
namespace Sy\Test\Form;

use Sy\Component\Html\Form\Input;
use Sy\Test\TestCase;

class InputTest extends TestCase {

	public function testConstruct() {
		$c = new Input('foo');
		$this->assertComponentRenderEqualsText($c, '<input type="foo" />');
		$c = new Input('image', ['class' => 'foo', 'id' => 'img1']);
		$this->assertComponentRenderEqualsText($c, '<input class="foo" id="img1" type="image" />');
		$c = new Input('image', ['class' => 'foo'], ['label' => 'My image']);
		$this->assertComponentRenderEqualsText($c, '<label>My image</label><input class="foo" type="image" />');
	}

}