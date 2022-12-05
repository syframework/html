<?php

use PHPUnit\Framework\TestCase;
use Sy\Component\Html\Navigation;
use Sy\Component\Html\Link;
use Sy\Component\Html\Navigation\Item;
use Sy\Component;

class NavigationTest extends TestCase {

	public function assertComponentRenderEqualsText(Component $component, string $text) {
		$minify = function ($code) {
			$code = str_replace(array("\t", "\r", "\n"), '', $code);
			$code = preg_replace('/\s+/', ' ', $code);
			$code = str_replace(array('> <'), '', $code);
			return trim($code);
		};
		$this->assertEquals($minify($text), $minify($component->render()));
	}

	public function testSimpleArrayNavigation() {
		$nav = new Navigation([
			'Menu1' => 'url1',
			'Menu2' => '#',
			'Menu3' => '',
			'Menu4' => null,
			new Link('Menu5', 'url5', ['class' => 'foo']),
			new Item('Menu6', 'url6', ['class' => 'foo']),
			new Item(new Link('Menu7', 'url7', ['class' => 'bar']), attributes: ['class' => 'foo']),
		]);
		$this->assertComponentRenderEqualsText($nav, '
			<ul>
				<li><a href="url1">Menu1</a></li>
				<li><a href="#">Menu2</a></li>
				<li><a href="">Menu3</a></li>
				<li>Menu4</li>
				<li><a class="foo" href="url5">Menu5</a></li>
				<li class="foo"><a href="url6">Menu6</a></li>
				<li class="foo"><a class="bar" href="url7">Menu7</a></li>
			</ul>
		');
	}

	public function testNestedArrayNavigation() {
		$nav = new Navigation([
			'Menu1' => 'url1',
			'Menu2' => 'url2',
			'Menu3' => [
				'Menu3.1' => 'url3.1',
				'Menu3.2' => 'url3.2',
				'Menu3.3' => 'url3.3',
			],
		]);
		$this->assertComponentRenderEqualsText($nav, '
			<ul>
				<li><a href="url1">Menu1</a></li>
				<li><a href="url2">Menu2</a></li>
				<li>
					<a href="#">Menu3</a>
					<ul>
						<li><a href="url3.1">Menu3.1</a></li>
						<li><a href="url3.2">Menu3.2</a></li>
						<li><a href="url3.3">Menu3.3</a></li>
					</ul>
				</li>
			</ul>
		');
	}

	public function testNavigationWithAttributes() {
		$nav = new Navigation([
			'Menu1' => 'url1',
			'Menu2' => 'url2',
			'Menu3' => [
				'Menu3.1' => 'url3.1',
				'Menu3.2' => 'url3.2',
				'Menu3.3' => 'url3.3',
			],
		], attributes: [
			'class' => 'ul',
		], itemAttributes: [
			'class' => 'li',
		], linkAttributes: [
			'class' => 'a',
		], itemWithSubNavAttributes: [
			'class' => 'li-with-subnav',
		], linkWithSubNavAttributes: [
			'class' => 'a-with-subnav',
		], subNavAttributes: [
			'class' => 'ul-subnav',
		], subNavItemAttributes: [
			'class' => 'li-subnav',
		], subNavLinkAttributes: [
			'class' => 'a-subnav',
		]);
		$this->assertComponentRenderEqualsText($nav, '
			<ul class="ul">
				<li class="li"><a class="a" href="url1">Menu1</a></li>
				<li class="li"><a class="a" href="url2">Menu2</a></li>
				<li class="li-with-subnav">
					<a class="a-with-subnav" href="#">Menu3</a>
					<ul class="ul-subnav">
						<li class="li-subnav"><a class="a-subnav" href="url3.1">Menu3.1</a></li>
						<li class="li-subnav"><a class="a-subnav" href="url3.2">Menu3.2</a></li>
						<li class="li-subnav"><a class="a-subnav" href="url3.3">Menu3.3</a></li>
					</ul>
				</li>
			</ul>
		');
	}

	public function testActiveLink() {
		$nav = new Navigation([
			'Menu1' => 'url1',
			'Menu2' => 'url2',
			'Menu3' => [
				'Menu3.1' => 'url3.1',
				'Menu3.2' => 'url3.2',
				'Menu3.3' => 'url3.3',
			],
		], active: 'url3.2');
		$this->assertComponentRenderEqualsText($nav->getActiveLink(), '<a href="url3.2">Menu3.2</a>');
		$this->assertComponentRenderEqualsText($nav->getActiveLink()->getParent(), '<li><a href="url3.2">Menu3.2</a></li>');
	}

}