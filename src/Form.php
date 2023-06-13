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
		$this->setAttributes($attributes);
		$this->setOption('error-class', 'error');
		$this->setOption('success-class', 'success');
		$this->added(function () {
			$this->initialize();
			$this->formId = $this->getFormActionTrigger();
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
	 * Extract the value by walking the array using given array path.
	 *
	 * Given an array path, returns the value of the last element.
	 * Example: $array['a']['b']['c'] = 'val' will return 'val' with path 'a[b][c]'.
	 *
	 * @param  array $array Array to walk
	 * @param  string $path Array notation path of the part to extract
	 * @return mixed
	 */
	public static function getValueByPath(array $array, $path) {
		if (empty($array)) return null;
		$path = trim($path);
		if ($path === '') return null;

		$keys = array_filter(array_map(function($v) {
			return rtrim($v, ']');
		}, explode('[', $path)), 'strlen');

		$tmp = &$array;

		foreach ($keys as $key) {
			$tmp = &$tmp[$key];
		}
		return $tmp;
	}

	/**
	 * Return an id used for catching form submit action
	 *
	 * @return string
	 */
	protected function getFormActionTrigger() {
		return md5($this->getObjectValue($this));
	}

	private function getPropertyValue($property) {
		$type  = gettype($property);
		switch ($type) {
			case 'NULL':
			case 'unknown type':
			case 'resource':
				return $type;

			case 'object':
				return $this->getObjectValue($property);

			case 'array':
				return implode(array_map(array($this, 'getPropertyValue'), $property));

			default:
				return $property;
		}
	}

	private function getObjectValue($object) {
		$class = new \ReflectionClass($object);
		return $class->getName() . implode(array_map(function (\ReflectionProperty $property) use ($object) {
			return $this->getPropertyValue($property->getValue($object));
		}, $class->getProperties()));
	}

}