<?php
namespace Sy\Component\Html\Form;

class Element extends \Sy\Component\Html\Element {

	/**
	 * @var array
	 */
	private $options;

	/**
	 * Form element constructor
	 *
	 * @param string $tagName Element tag name
	 * @param string|\Sy\Component $content Element content
	 * @param array $attributes Element attributes
	 * @param array $options Element options
	 */
	public function __construct($tagName = '', $content = null, array $attributes = array(), array $options = array()) {
		parent::__construct($tagName, $content, $attributes);
		$this->setTemplateFile(__DIR__ . '/templates/Element.tpl', 'php');
		$options['label-position'] = isset($options['label-position']) ? $options['label-position'] : 'before';
		$options['error-position'] = isset($options['error-position']) ? $options['error-position'] : 'before';
		$options['error-class'] = isset($options['error-class']) ? $options['error-class'] : 'error';
		$this->setOptions($options);

		$this->mount(function() {
			$this->setVar('ID', $this->getAttribute('id'));
			$this->setVars(array_filter($this->options, 'is_string'));
		});
	}

	/**
	 * Set the element attribute
	 *
	 * @param string $name attribute name
	 * @param string $value attribute value
	 */
	public function setAttribute($name, $value) {
		if ($name == 'name') {
			$this->setName($value);
		} else {
			parent::setAttribute($name, $value);
		}
	}

	/**
	 * Set error message
	 *
	 * @param string $error
	 */
	public function setError($error) {
		$this->setOption('error', $error);
	}

	/**
	 * Set the element options
	 *
	 * @param array $options
	 */
	public function setOptions(array $options) {
		foreach ($options as $name => $value) {
			$this->setOption($name, $value);
		}
	}

	/**
	 * Set the element option
	 *
	 * @param string $name option name
	 * @param mixed $value option value
	 */
	public function setOption($name, $value) {
		$name = strtoupper(str_replace('-', '_', $name));
		$this->options[$name] = $value;
	}

	/**
	 * Get the element option
	 *
	 * @param  string $name
	 * @return mixed
	 */
	public function getOption($name) {
		$name = strtoupper(str_replace('-', '_', $name));
		return isset($this->options[$name]) ? $this->options[$name] : null;
	}

	/**
	 * Set the element name attribute
	 *
	 * @param string $name
	 */
	public function setName($name) {
		$begin = strstr($name, '[', true);
		if (!$begin) {
			parent::setAttribute('name', str_replace(array('.', ' '), '_', $name));
			return;
		}
		$new_begin = str_replace(array('.', ' '), '_', $begin);
		$end = strstr($name, '[');
		$new_end = str_replace('[]', '', $end);
		if ($end and substr_compare($end, '[]', -2) == 0) {
			$new_end .= '[]';
		}
		parent::setAttribute('name', $new_begin . $new_end);
	}

	/**
	 * Return if the element is required or not
	 *
	 * @return bool
	 */
	public function isRequired() {
		if (!is_null($this->getAttribute('required'))) return true;
		if (!is_null($this->getOption('required'))) {
			return $this->getOption('required');
		} else {
			return false;
		}
	}

	/**
	 * Add a validator
	 *
	 * @param callable $name
	 */
	public function addValidator($name) {
		$validators = $this->getOption('validator');
		if (is_null($validators)) $validators = array();
		if (!is_array($validators)) $validators = array($validators);
		$validators[] = $name;
		$this->setOption('validator', $validators);
	}

}