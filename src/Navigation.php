<?php
namespace Sy\Component\Html;

use Sy\Component\Html\Element;

class Navigation extends Element {

	public function __construct() {
		parent::__construct('ul');
	}

	/**
	 * Add an item in the navigation list
	 *
	 * @param string $title Item title
	 * @param string $link Item link
	 * @return Navigation\Item
	 */
	public function addItem($title, $link = null, array $attributes = array()) {
		$item = new Navigation\Item($title, $link, $attributes);
		return $this->addElement($item);
	}

}