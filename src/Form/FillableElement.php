<?php
namespace Sy\Component\Html\Form;

interface FillableElement {

	/**
	 * Fill the element with a value
	 *
	 * @param mixed $value
	 */
	public function fill($value);

}