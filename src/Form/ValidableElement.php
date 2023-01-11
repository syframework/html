<?php
namespace Sy\Component\Html\Form;

interface ValidableElement {

	/**
	 * Check if element is valid with this value
	 *
	 * @param  mixed $value
	 * @return bool
	 */
	public function isValid($value);

}