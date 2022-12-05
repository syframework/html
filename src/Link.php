<?php
namespace Sy\Component\Html;

class Link extends Element {

	/**
	 * @param string|\Sy\Component $content
	 * @param string|null $url
	 * @param array $attributes
	 */
	public function __construct($content, $url = null, $attributes = array()) {
		parent::__construct('a', $content, $attributes);
		if (!is_null($url)) {
			$this->setAttribute('href', $url);
		}
	}

}