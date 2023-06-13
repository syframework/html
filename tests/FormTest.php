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

	private $array;

	private $integer;

	private $object;

	private $bool;

	public function __construct(string $name, array $array = [], int $integer = 0, $object = null, $bool = false) {
		parent::__construct();
		$this->name    = $name;
		$this->array   = $array;
		$this->integer = $integer;
		$this->object  = $object;
		$this->bool    = $bool;
	}

	public function init() {
		$this->addTextInput(['value' => 'foo']);
	}

	public function submitAction() {
		echo 'Submit action';
	}

}

class Foo {
	private $name;

	private $array;

	private $integer;

	private $object;

	private $bool;

	public function __construct(string $name, array $array = [], int $integer = 0, $object = null, $bool = false) {
		$this->name    = $name;
		$this->array   = $array;
		$this->integer = $integer;
		$this->object  = $object;
		$this->bool    = $bool;
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
		$d = new AForm('a', [1]);

		$this->assertEquals(strval($a), strval($c));
		$this->assertNotEquals(strval($b), strval($c));
		$this->assertNotEquals(strval($a), strval($d));
	}

}