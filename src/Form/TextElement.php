<?php
namespace Sy\Component\Html\Form;

require_once __DIR__ . '/Validator.php';

class TextElement extends Element implements ValidableElement {

	/**
	 * Set the element attribute
	 *
	 * @param string $name attribute name
	 * @param string $value attribute value
	 */
	public function setAttribute($name, $value) {
		if (\strtolower($name) === 'value' and !is_null($value))
			$value = str_replace ('"', '&quot;', $value);
		parent::setAttribute($name, $value);
	}

	public function isValid($value) {
		if ($this->isRequired()) {
			if (!isset($value) or $value === '') return false;
			if (is_array($value)) {
				$value = array_filter($value);
				if (empty($value)) return false;
			}
		} else {
			if (is_array($value)) $value = array_filter($value);
			if (empty($value)) return true;
		}
		$validators = $this->getOption('validator');
		if (is_null($validators)) return true;
		if (!is_array($validators)) $validators = array($validators);
		if (is_callable($validators)) $validators = array($validators);
		foreach ($validators as $v) {
			if (!is_callable($v)) continue;
			if (!call_user_func($v, $value, $this)) return false;
		}
		return true;
	}

}