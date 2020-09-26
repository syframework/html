<?php
namespace Sy\Component\Html;

abstract class Form extends Form\FieldContainer {

	private static $isSubmit = false;

	private $formId;

	public function __construct(array $attributes = array()) {
		parent::__construct();
		$this->setTemplateFile(__DIR__ . '/Form/templates/Form.tpl', 'php');
		$this->formId = $this->getFormActionTrigger();
		$this->setAttributes($attributes);
		$this->setOption('error-class', 'error');
		$this->setOption('success-class', 'success');
		$this->init();
		if (($this->request('sy-form-action-trigger') === $this->formId) and !self::$isSubmit) {
			self::$isSubmit = true;
			$info = $this->getDebugTrace();
			$info['type'] = 'Form submit';
			$message = 'Call method ' . get_class($this) . '::submitAction';
			$this->log($message, $info);
			$this->submitAction();
		}
	}

	public function __toString() {
		$this->setVar('ACTION_TRIGGER', $this->formId);
		if (is_null($this->getAttribute('action'))) {
			$this->setAttribute('action', isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '');
		}
		if (is_null($this->getAttribute('method'))) {
			$this->setAttribute('method', 'post');
		}
		return parent::__toString();
	}

	/**
	 * Set success message
	 *
	 * @param string $success
	 */
	public function setSuccess($success) {
		$this->setOption('success', $success);
	}

	/**
	 * Process form validation
	 *
	 * @param array $values
	 * @throws Form\Exception
	 */
	public function validate(array $values) {
		if (!$this->isValid($values)) {
			throw new Form\Exception;
		}
	}

	abstract public function init();

	abstract public function submitAction();

	protected function getFormActionTrigger() {
		return md5(get_class($this));
	}

}

namespace Sy\Component\Html\Form;

class Exception extends \Exception {}