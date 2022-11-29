<?php
namespace Sy\Component\Html;

abstract class Form extends Form\FieldContainer {

	/**
	 * @var string
	 */
	private $formId;

	/**
	 * @var bool
	 */
	private $initialized;

	/**
	 * @var bool
	 */
	private static $isSubmit = false;

	/**
	 * Form inputs must be added in this method
	 */
	abstract public function init();

	/**
	 * Form submit action must be implemented in this method
	 */
	abstract public function submitAction();

	/**
	 * @param array $attributes The form attributes
	 */
	public function __construct(array $attributes = array()) {
		parent::__construct();
		$this->initialized = false;
		$this->setTemplateFile(__DIR__ . '/Form/templates/Form.tpl', 'php');
		$this->formId = $this->getFormActionTrigger();
		$this->setAttributes($attributes);
		$this->setOption('error-class', 'error');
		$this->setOption('success-class', 'success');
		$this->added(function () {
			$this->initialize();
			if (($this->request('sy-form-action-trigger') === $this->formId) and !self::$isSubmit) {
				self::$isSubmit = true;
				$info = $this->getDebugTrace();
				$info['type'] = 'Form submit';
				$message = 'Call method ' . get_class($this) . '::submitAction';
				$this->log($message, $info);
				$this->submitAction();
			}
		});
		$this->mount(function () {
			$this->setVar('ACTION_TRIGGER', $this->formId);
			if (is_null($this->getAttribute('action'))) {
				$this->setAttribute('action', isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '');
			}
			if (is_null($this->getAttribute('method'))) {
				$this->setAttribute('method', 'post');
			}
		});
	}

	/**
	 * Initialize the form
	 *
	 * @param callable|null $preInit Closure executed before init
	 * @param callable|null $postInit Closure executed after init
	 */
	public function initialize($preInit = null, $postInit = null) {
		if ($this->initialized) return;
		if (is_callable($preInit)) $preInit();
		$this->init();
		if (is_callable($postInit)) $postInit();
		$this->initialized = true;
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
	 * @param  array $values
	 * @throws Form\Exception
	 */
	public function validate(array $values) {
		if (!$this->isValid($values)) {
			throw new Form\Exception();
		}
	}

	/**
	 * Return an id used for catching form submit action
	 *
	 * @return string
	 */
	protected function getFormActionTrigger() {
		return md5(get_class($this));
	}

}