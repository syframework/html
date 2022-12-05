<?php
namespace Sy\Component\Html\Navigation;

use Sy\Component\Html\Element;
use Sy\Component\Html\Link;

class Item extends Element {

	/**
	 * @param string|\Sy\Component $content
	 * @param string|null $url
	 * @param array $attributes
	 */
	public function __construct($content, $url = null, array $attributes = array()) {
		parent::__construct('li');
		$this->setAttributes($attributes);
		if (is_null($url)) {
			$this->setContent($content);
		} else {
			$this->addElement(new Link($content, $url));
		}
	}

}