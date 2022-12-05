<?php
namespace Sy\Component\Html;

use Sy\Component;
use Sy\Component\WebComponent;

class Element extends WebComponent {

	/**
	 * @var string
	 */
	private $tagName;

	/**
	 * @var array
	 */
	private $attributes;

	/**
	 * @var array
	 */
	private $content;

	/**
	 * @var array Void element list
	 */
	private $voidElements = array('area', 'base', 'br', 'col', 'embed', 'hr', 'img', 'input', 'keygen', 'link', 'meta', 'param', 'source', 'track', 'wbr');

	/**
	 * Element constructor
	 *
	 * @param string $tagName Element tag name
	 * @param string|Component $content Element content
	 * @param array $attributes Element attributes
	 */
	public function __construct($tagName, $content = null, array $attributes = array()) {
		parent::__construct();
		$this->setTemplateFile(__DIR__ . '/templates/Element.tpl', 'php');
		$this->tagName = trim($tagName);
		$this->attributes = array();
		$this->setAttributes($attributes);
		if (is_null($content)) {
			$this->content = array();
		} else {
			$this->setContent($content);
		}
	}

	/**
	 * Get the element attribute
	 *
	 * @param  string $name Attribute name
	 * @return string
	 */
	public function getAttribute($name) {
		$name = strtolower($name);
		return isset($this->attributes[$name]) ? $this->attributes[$name] : null;
	}

	/**
	 * Get the element attributes
	 *
	 * @return array
	 */
	public function getAttributes() {
		return $this->attributes;
	}

	/**
	 * Set the element attribute
	 *
	 * @param string $name  Attribute name
	 * @param string $value Attribute value
	 */
	public function setAttribute($name, $value) {
		$name = strtolower($name);
		$this->attributes[$name] = $value;
	}

	/**
	 * Set the element attributes
	 *
	 * @param array $attributes Array of element attributes
	 */
	public function setAttributes(array $attributes) {
		foreach ($attributes as $name => $value) {
			$this->setAttribute($name, $value);
		}
	}

	/**
	 * Delete an element attribute
	 *
	 * @param string $name
	 */
	public function unsetAttribute($name) {
		unset($this->attributes[strtolower($name)]);
	}

	/**
	 * Add a class to the element
	 *
	 * @param string $class
	 */
	public function addClass($class) {
		$actual = $this->getAttribute('class');
		$class = is_null($actual) ? $class : $actual . ' ' . $class;
		$this->setAttribute('class', $class);
	}

	/**
	 * Get the element content
	 *
	 * @return array
	 */
	public function getContent() {
		return array_filter($this->content, function($v) {
			return !is_null($v);
		});
	}

	/**
	 * Set the element content
	 *
	 * @param string|Component ...$content Element content
	 */
	public function setContent(...$content) {
		$this->content = array();
		foreach ($content as $c) {
			$this->addContent($c);
		}
	}

	/**
	 * Add an element or text
	 *
	 * @param string|Component $content
	 */
	public function addContent($content) {
		if ($content instanceof Component) {
			$this->addElement($content);
		} else {
			$this->addText($content);
		}
	}

	/**
	 * Add an element
	 *
	 * @param  Component $element
	 * @return Component
	 */
	public function addElement(Component $element) {
		$element->setParent($this);
		$this->content[] = $element;
		return $element;
	}

	/**
	 * Add text in content
	 *
	 * @param string $text
	 */
	public function addText($text) {
		if (empty($text)) return;
		$this->content[] = trim($text);
	}

	/**
	 * Return if the element has a content or not
	 *
	 * @return bool
	 */
	public function isEmpty() {
		$content = $this->getContent();
		return empty($content);
	}

	public function render() {
		$this->mount(function () {
			$this->setVars(array(
				'TAG_NAME' => $this->tagName,
				'END_TAG'  => in_array($this->tagName, $this->voidElements) ? ' /' : '</' . $this->tagName
			));
			foreach ($this->attributes as $name => $value) {
				$this->setBlock('BLOCK_ATTRIBUTES', array(
					'NAME'  => $name,
					'VALUE' => $value
				));
			}
			if (!in_array($this->tagName, $this->voidElements)) {
				$content = $this->getContent();
				$this->setVar('CONTENT', Component::concat('>', ...$content));
			}
		});
		return parent::render();
	}

}