<?php
namespace Sy\Component\Html;

use Sy\Component\Html\Element;
use Sy\Component\Html\Navigation\Item;

/**
 * Navigation component is basically a list of item.
 * Each item can be a link or a navigation component.
 *
 * Example:
 * $nav = new Navigation([
 *     'Menu1' => 'url1',
 *     'Menu2' => 'url2',
 *     'Menu3' => [
 *         'Menu3.1' => 'url3.1',
 *         'Menu3.2' => 'url3.2',
 *         'Menu3.3' => 'url3.3',
 *     ],
 * ]);
 */
class Navigation extends Element {

	/**
	 * @var Link|null
	 */
	private $activeLink;

	/**
	 * @param (string|\Sy\Component|null)[] $data
	 * @param string|null $active The active url
	 * @param array $attributes Navigation attributes
	 * @param array $itemAttributes Items attributes
	 * @param array $linkAttributes Links attributes
	 * @param array $itemWithSubNavAttributes Items containing a sub navigation list attributes
	 * @param array $linkWithSubNavAttributes Links before a sub navigation list attributes
	 * @param array $subNavAttributes Sub navigation attributes
	 * @param array $subNavItemAttributes Sub navigation items attributes
	 * @param array $subNavLinkAttributes Sub navigation links attributes
	 */
	public function __construct(
		array $items = array(),
		$active = null,
		array $attributes = array(),
		array $itemAttributes = array(),
		array $linkAttributes = array(),
		array $itemWithSubNavAttributes = array(),
		array $linkWithSubNavAttributes = array(),
		array $subNavAttributes = array(),
		array $subNavItemAttributes = array(),
		array $subNavLinkAttributes = array()
	) {
		parent::__construct('ul');
		$this->setAttributes($attributes);
		$this->activeLink = null;
		if (empty($items)) return;
		foreach ($items as $label => $item) {
			if ($item instanceof Item) {
				$this->addElement($item);
			} elseif ($item instanceof Link) {
				$this->addItem($item);
			} elseif (is_array($item)) {
				$nav = new Navigation(
					$item,
					$active,
					$subNavAttributes,
					$subNavItemAttributes,
					$subNavLinkAttributes,
					$itemWithSubNavAttributes,
					$linkWithSubNavAttributes,
					$subNavAttributes,
					$subNavItemAttributes,
					$subNavLinkAttributes
				);
				if (!is_null($nav->getActiveLink())) {
					$this->setActiveLink($nav->getActiveLink());
				}
				$this->addItem(
					new Link($label, '#', $linkWithSubNavAttributes),
					null,
					$itemWithSubNavAttributes
				)->addElement($nav);
			} elseif (is_null($item)) {
				$this->addItem($label, null, $itemAttributes);
			} else {
				$link = new Link($label, $item, $linkAttributes);
				if (!is_null($active) and $active === $item) {
					$this->setActiveLink($link);
				}
				$this->addItem($link, null, $itemAttributes);
			}
		}
	}

	/**
	 * Add an item in the navigation list
	 *
	 * @param  string|\Sy\Component $content Item content
	 * @param  string|null $url Item link url
	 * @return Item
	 */
	public function addItem($title, $url = null, array $attributes = array()) {
		return $this->addElement(new Item($title, $url, $attributes));
	}

	/**
	 * @return Link|null
	 */
	public function getActiveLink() {
		return $this->activeLink;
	}

	/**
	 * @param Link|null $link
	 */
	public function setActiveLink($link = null) {
		$this->activeLink = $link;
	}

}