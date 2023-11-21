<?php
namespace Sy\Test;

use Sy\Component\Html\Page;
use Sy\Component\Html\Element;
use Sy\Component\WebComponent;
use Sy\Component;

#region Composition 0
class A extends WebComponent {

	public function __construct() {
		$this->mount(function () {
			$this->setTemplateContent('<div class="a">{B}</div>');
			$this->setVar('B', new B());
			$this->addJsLink('a.js');
			$this->addJsCode('console.log("a")');
			$this->addCssLink('a.css');
			$this->addCssCode('.a {color: red}');
		});
	}

}

class B extends WebComponent {

	public function __construct() {
		$this->mount(function () {
			$this->setTemplateContent('<div class="b">{C}</div>');
			$this->setVar('C', new C());
			$this->addJsLink('b.js');
			$this->addJsCode('console.log("b")');
			$this->addCssLink('b.css');
			$this->addCssCode('.b {color: red}');
		});
	}

}

class C extends WebComponent {

	public function __construct() {
		$this->mount(function () {
			$this->setTemplateContent('<div class="c"></div>');
			$this->addJsLink('c.js');
			$this->addJsCode('console.log("c")');
			$this->addCssLink('c.css');
			$this->addCssCode('.c {color: red}');
		});
	}

}

class P extends Page {

	public function __construct() {
		parent::__construct();
		$this->mount(function () {
			$this->addBody(new A());
			$this->addJsLink('p.js');
			$this->addJsCode('console.log("p")');
			$this->addCssLink('p.css');
			$this->addCssCode('.p {color: red}');

			$this->setTitle('hello world');
			$this->addJsCode('console.log("hello world!")', ['position' => WebComponent::JS_TOP, 'type' => 'text/javascript', 'load' => 'async']);
			$this->addJsCode('console.log("hello world!")', ['load' => 'async']);
			$this->addJsCode('console.log("hello world!2")', ['load' => 'async']);
			$this->addJsLink('a.js');
			$this->addJsLink('b.js');
			$this->addJsLink(['url' => 'https://code.jquery.com/jquery-3.5.1.min.js', 'integrity' => 'sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=']);
			$this->addJsLink('a.js', ['position' => WebComponent::JS_BOTTOM, 'type' => 'module', 'load' => 'async']);
			$this->addJsonLd(array (
				'@context' => 'https://schema.org/',
				'@type' => 'Recipe',
				'name' => 'Party Coffee Cake',
				'author' =>
				array (
					'@type' => 'Person',
					'name' => 'Mary Stone',
				),
				'datePublished' => '2018-03-10',
				'description' => 'This coffee cake is awesome and perfect for parties.',
				'prepTime' => 'PT20M',
			));
			$this->addJsonLd(array (
				'@context' => 'https://schema.org/',
				'@type' => 'Recipe',
				'name' => 'Party Coffee Cake',
				'author' =>
				array (
					'@type' => 'Person',
					'name' => 'Mary Stone',
				),
				'datePublished' => '2018-03-10',
				'description' => 'This coffee cake is awesome and perfect for parties.',
				'prepTime' => 'PT20M',
			));
			$this->setJsonLd([
				array (
					'@context' => 'https://schema.org/',
					'@type' => 'Recipe',
					'name' => 'Party Coffee Cake',
					'author' =>
					array (
						'@type' => 'Person',
						'name' => 'Mary Stone',
					),
					'datePublished' => '2018-03-10',
					'description' => 'This coffee cake is awesome and perfect for parties.',
					'prepTime' => 'PT20M',
				)
			]);
		});
	}

}
#endregion

#region Composition 1
class A1 extends WebComponent {

	public function __construct() {
		$this->setTemplateContent('<div class="a">{B}</div>');
		$this->setVar('B', new B());
		$this->addJsLink('a.js');
		$this->addJsCode('console.log("a")');
		$this->addCssLink('a.css');
		$this->addCssCode('.a {color: red}');
	}

}

class B1 extends WebComponent {

	public function __construct() {
		$this->setTemplateContent('<div class="b">{C}</div>');
		$this->setVar('C', new C());
		$this->addJsLink('b.js');
		$this->addJsCode('console.log("b")');
		$this->addCssLink('b.css');
		$this->addCssCode('.b {color: red}');
	}

}

class C1 extends WebComponent {

	public function __construct() {
		$this->setTemplateContent('<div class="c"></div>');
		$this->addJsLink('c.js');
		$this->addJsCode('console.log("c")');
		$this->addCssLink('c.css');
		$this->addCssCode('.c {color: red}');
	}

}

class P1 extends Page {

	public function __construct() {
		parent::__construct();
		$this->addBody(new A());
		$this->addJsLink('p.js');
		$this->addJsCode('console.log("p")');
		$this->addCssLink('p.css');
		$this->addCssCode('.p {color: red}');

		$this->setTitle('hello world');
		$this->addJsCode('console.log("hello world!")', ['position' => WebComponent::JS_TOP, 'type' => 'text/javascript', 'load' => 'async']);
		$this->addJsCode('console.log("hello world!")', ['load' => 'async']);
		$this->addJsCode('console.log("hello world!2")', ['load' => 'async']);
		$this->addJsLink('a.js');
		$this->addJsLink('b.js');
		$this->addJsLink(['url' => 'https://code.jquery.com/jquery-3.5.1.min.js', 'integrity' => 'sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=']);
		$this->addJsLink('a.js', ['position' => WebComponent::JS_BOTTOM, 'type' => 'module', 'load' => 'async']);
	}

}
#endregion

class PageTest extends TestCase {

	public function testPage() {
		$p = new P();
		$this->assertFileContentEqualsComponentRender(__DIR__ . "/result/page.html", $p);
	}

	public function testElement() {
		$div = new Element('div');
		$div->addElement(new Element('hr'));
		$page = new Page();
		$page->addBody($div);
		$this->assertFileContentEqualsComponentRender(__DIR__ . "/result/element.html", $page);
	}

	public function testSetBase() {
		$page = new Page();
		$page->setBase(target: '_parent');
		$this->assertComponentRenderEqualsText($page, '
			<!DOCTYPE html>
			<html>
			<head>
			<base target="_parent" />
			<meta charset="utf-8" /></head>
			<body>
			</body>
			</html>
		');

		$page = new Page();
		$page->setBase(href: 'https://example.com');
		$this->assertComponentRenderEqualsText($page, '
			<!DOCTYPE html>
			<html>
			<head>
			<base href="https://example.com" />
			<meta charset="utf-8" /></head>
			<body>
			</body>
			</html>
		');

		$page = new Page();
		$page->setBase('https://example.com', '_blank');
		$this->assertComponentRenderEqualsText($page, '
			<!DOCTYPE html>
			<html>
			<head>
			<base href="https://example.com" target="_blank" />
			<meta charset="utf-8" /></head>
			<body>
			</body>
			</html>
		');
	}

	public function testAddHead() {
		$page = new Page();
		$page->addHead('<script>console.log("hello world")</script>');
		$this->assertComponentRenderEqualsText($page, '
			<!DOCTYPE html>
			<html>
			<head>
			<meta charset="utf-8" />
			<script>console.log("hello world")</script>
			</head>
			<body>
			</body>
			</html>
		');

		$page = new Page();
		$page->addHead('<script>console.log("hello world")</script>');
		$page->addHead('<script>console.log("foo")</script>');
		$this->assertComponentRenderEqualsText($page, '
			<!DOCTYPE html>
			<html>
			<head>
			<meta charset="utf-8" />
			<script>console.log("hello world")</script><script>console.log("foo")</script>
			</head>
			<body>
			</body>
			</html>
		');
	}

	public function testSetHead() {
		$page = new Page();
		$page->setHead('<script>console.log("foo")</script>');
		$this->assertComponentRenderEqualsText($page, '
			<!DOCTYPE html>
			<html>
			<head>
			<meta charset="utf-8" />
			<script>console.log("foo")</script>
			</head>
			<body>
			</body>
			</html>
		');

		$page = new Page();
		$page->setHead('<script>console.log("foo")</script>');
		$page->setHead('<script>console.log("bar")</script>');
		$this->assertComponentRenderEqualsText($page, '
			<!DOCTYPE html>
			<html>
			<head>
			<meta charset="utf-8" />
			<script>console.log("bar")</script>
			</head>
			<body>
			</body>
			</html>
		');
	}

}