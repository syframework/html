<?php
namespace Sy\Test\Form;

use Sy\Component\Html\Form\OptionContainer;
use Sy\Test\TestCase;

class OptionContainerTest extends TestCase {

	public function testConstruct() {
		$s = new OptionContainer('select');
		$this->assertComponentRenderEqualsText($s, '<select></select>');
		$s = new OptionContainer('select');
		$s->addOption('hello', 'foo');
		$s->addOption('world');
		$this->assertComponentRenderEqualsText($s, '
			<select>
				<option value="foo">hello</option>
				<option>world</option>
			</select>
		');
	}

}