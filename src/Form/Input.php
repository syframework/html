<?php
namespace Sy\Component\Html\Form;

class Input extends Element {

	/**
	 * @var string
	 */
	private $type;

	/**
	 * Input element: image, reset, submit
	 *
	 * @param string $type Input type: text, number, date etc...
	 * @param array $attributes Input attributes
	 * @param array $options Input options
	 */
	public function __construct($type, array $attributes = array(), array $options = array()) {
		parent::__construct('input', null, $attributes, $options);
		$this->type = $type;

		$this->mount(function () {
			$this->setAttribute('type', $this->type);
		});
	}

}