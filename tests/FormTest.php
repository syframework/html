<?php
namespace Sy\Test;

use Sy\Component\Html\Form;

class MyForm extends Form {

	public function init() {
		$this->addTextInput(['value' => 'foo']);
	}

	public function submitAction() {
		echo 'MyForm submit action';
	}

	protected function getFormActionTrigger() {
		return 'foo';
	}

}

class AForm extends Form {

	private $name;

	public function __construct(string $name) {
		parent::__construct();
		$this->name = $name;
	}

	public function init() {
		$this->addTextInput(['value' => 'foo']);
	}

	public function submitAction() {
		echo 'Submit action';
	}

}

class FormTest extends TestCase {

	public function testFormCreation() {
		$form = new MyForm();
		$this->assertComponentRenderEqualsText($form, '
			<form action="" method="post">
				<input name="sy-form-action-trigger" value="foo" type="hidden" />
				<input value="foo" type="text" />
			</form>
		');
	}

	public function testFormId() {
		$a = new AForm('a');
		$b = new AForm('b');
		$c = new AForm('a');

		$this->assertEquals(strval($a), strval($c));
		$this->assertNotEquals(strval($b), strval($c));
	}

}