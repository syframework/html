<?php
namespace Sy\Component\Html\Form;

class Checkbox extends Input implements FillableElement, ValidableElement {

	/**
	 * Input type checkbox element
	 *
	 * @param array $attributes Checkbox attributes
	 * @param array $options Checkbox options
	 */
	public function __construct(array $attributes = array(), array $options = array()) {
		parent::__construct('checkbox', $attributes, $options);
		$this->setOption('label-position', 'after');
		$this->setOption('error-position', 'after');
	}

	/**
	 * {@inheritDoc}
	 */
	public function fill($value) {
		if (is_null($value)) return;
		if (is_array($value)) {
			if (in_array($this->getAttribute('value'), $value, true))
				$this->setAttribute('checked', 'checked');
		}
		if ($this->getAttribute('value') == $value)
			$this->setAttribute('checked', 'checked');
	}

	/**
	 * {@inheritDoc}
	 */
	public function isValid($value) {
		if ($this->isRequired()) {
			if (is_array($value)) {
				if (!in_array($this->getAttribute('value'), $value)) {
					return false;
				}
			} elseif ((string)$this->getAttribute('value') !== (string)$value) {
				return false;
			}
		}
		return true;
	}

}