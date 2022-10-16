<?php
namespace Sy\Component\Html;

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
	 */
	public function __construct($tagName) {
		parent::__construct();
		$this->setTemplateFile(__DIR__ . '/templates/Element.tpl', 'php');
		$this->tagName = trim($tagName);
		$this->attributes = array();
		$this->content = array();
		$this->parent = null;
	}

	/**
	 * Get the element attribute
	 *
	 * @param string $name Attribute name
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
	 * @param array $content Element content
	 */
	public function setContent(array $content) {
		$this->content = $content;
	}

	/**
	 * Add an element
	 *
	 * @param Element $element
	 * @return Element
	 */
	public function addElement(Element $element) {
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
				'END_TAG'  => in_array($this->tagName, $this->voidElements) ? ' /' : '></' . $this->tagName
			));
			foreach ($this->attributes as $name => $value) {
				$this->setBlock('BLOCK_ATTRIBUTES', array(
					'NAME'  => $name,
					'VALUE' => $value
				));
			}
			foreach ($this->getFormattedContent() as $element) {
				$this->setBlock('BLOCK_CONTENT', array('ELEMENT' => $element));
			}
		});
		return parent::render();
	}

	private function getFormattedContent() {
		$content = $this->getContent();
		if (empty($content)) return $content;
		if (count($content) > 1) {
			$content = array_map(function($value) {
				return is_string($value) ? $value . "\n" : $value;
			}, $content);
			array_unshift($content, "\n");
		}
		if (count($content) == 1 and current($content) instanceof Element)
			array_unshift($content, "\n");
		return $content;
	}

}