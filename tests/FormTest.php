<?php
namespace Sy\Test;

use Sy\Component\Html\Form;
use Sy\Component;

class MyForm extends Form {

	public function init() {
		$this->addTextInput(['value' => 'foo']);
	}

	public function submitAction() {
		echo 'MyForm submit action';
	}

}

class FormTest extends TestCase {

	public function testFormCreation() {
		$form = new MyForm();
		$this->assertComponentRenderEqualsText($form, '
			<form action="" method="post">
				<input name="sy-form-action-trigger" value="70f98ae4e1caf15d73b4e6e8b7ada178" type="hidden" />
				<input value="foo" type="text" />
			</form>
		');
	}

}