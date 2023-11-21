<?php
namespace Sy\Component\Html;

use Sy\Component\WebComponent;

class Page extends WebComponent {

	/**
	 * @var bool
	 */
	private $debug;

	/**
	 * @var string
	 */
	private $doctype;

	/**
	 * @var string
	 */
	private $charset;

	/**
	 * @var array
	 */
	private $base;

	/**
	 * @var array
	 */
	private $meta;

	/**
	 * @var array
	 */
	private $links;

	/**
	 * @var array
	 */
	private $htmlAttributes;

	/**
	 * @var array
	 */
	private $bodyAttributes;

	/**
	 * @var array
	 */
	private $jsonLd;

	public function __construct() {
		$this->phpInfo();
		$this->logFile();
		$this->timeStart('Web page');
		parent::__construct();
		$this->setTemplateFile(__DIR__ . '/Page/templates/Page.tpl', 'php');
		$this->debug   = false;
		$this->doctype = 'html5';
		$this->charset = 'utf-8';
		$this->base    = array();
		$this->meta    = array();
		$this->links   = array();
		$this->htmlAttributes = array();
		$this->bodyAttributes = array();
		$this->jsonLd = array();
		$this->setBody('');
		$this->mounted(function () {
			$this->renderAll();
			$this->timeStop('Web page');
			if ($this->debug) {
				$this->setComponent('DEBUG_BAR', new Page\DebugBar($this->charset));
			}
		});
	}

	/**
	 * Activate the web debug toolbar
	 */
	public function enableDebugBar() {
		$this->debug = true;
	}

	/**
	 * Set html tag attribute
	 *
	 * @param string $name attribute name
	 * @param string $value attribute value
	 */
	public function setHtmlAttribute($name, $value) {
		$this->htmlAttributes[$name] = $value;
	}

	/**
	 * Set html tag attributes
	 *
	 * @param array $attributes
	 */
	public function setHtmlAttributes(array $attributes) {
		foreach ($attributes as $name => $value) {
			$this->setHtmlAttribute($name, $value);
		}
	}

	/**
	 * Set the doctype declaration
	 *
	 * @param string $type [html4.01|xhtml1.0|xhtml1.1]-[strict|transitional|frameset]
	 */
	public function setDoctype($type = 'html5') {
		$this->doctype = $type;

		$doctype = array(
			'html4.01-strict'       => 'PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"',
			'html4.01-transitional' => 'PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"',
			'html4.01-frameset'     => 'PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd"',
			'xhtml1.0-strict'       => 'PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"',
			'xhtml1.0-transitional' => 'PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"',
			'xhtml1.0-frameset'     => 'PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd"',
			'xhtml1.1'              => 'PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"',
			'html5'                 => '',
		);

		// Default doctype
		if (!array_key_exists($type, $doctype)) return;

		$this->setVar('DOCTYPE', $doctype[$type]);

		// xmlns attribute required for xhtml document
		if (strpos($type, 'xhtml') === 0)
			$this->setHtmlAttribute('xmlns', 'http://www.w3.org/1999/xhtml');
	}

	/**
	 * Add a meta tag
	 *
	 * @param array $meta
	 */
	public function addMeta(array $meta, $key = null) {
		$element = new Element('meta');
		$element->setAttributes($meta);
		if (is_null($key)) {
			$this->meta[] = $element;
		} else {
			$this->meta[$key] = $element;
		}
	}

	/**
	 * Add multiple meta tag with the same attribute name
	 *
	 * @param string $attribute
	 * @param string $name
	 * @param array $contents
	 */
	public function addMetas($attribute, $name, array $contents) {
		foreach ($contents as $content) {
			$element = new Element('meta');
			$element->setAttributes(array($attribute => $name, 'content' => $content));
			$key = $attribute . '-' . strtolower($name);
			if (!is_array($this->meta[$key])) {
				$this->meta[$key] = [];
			}
			$this->meta[$key][] = $element;
		}
	}

	/**
	 * Set a meta tag
	 *
	 * @param string $name
	 * @param mixed $content string or array
	 * @param bool $httpEquiv
	 */
	public function setMeta($name, $content, $httpEquiv = false) {
		if ($httpEquiv) {
			$attr = 'http-equiv';
		} else {
			if (substr($name, 0, 3) === 'og:') {
				$attr = 'property';
			} else {
				$attr = 'name';
			}
		}
		if (is_array($content)) {
			$this->addMetas($attr, $name, $content);
		} else {
			$this->addMeta(array($attr => $name, 'content' => $content), $attr . '-' . strtolower($name));
		}
	}

	/**
	 * Add a link tag
	 *
	 * @param array $link
	 */
	public function addLink(array $link) {
		$this->links[] = $link;
	}

	/**
	 * Set base element
	 *
	 * @param string $href
	 * @param string $target
	 */
	public function setBase($href = '', $target = '') {
		$this->base = array_filter(['href' => $href, 'target' => $target]);
	}

	/**
	 * Set the document charset
	 *
	 * @param string $charset Charset encoding string
	 */
	public function setCharset($charset) {
		$this->charset = $charset;
	}

	/**
	 * Set the page description
	 *
	 * @param string $description
	 */
	public function setDescription($description) {
		$this->setMeta('Description', $description);
	}

	/**
	 * Set the page title
	 *
	 * @param string $title
	 */
	public function setTitle($title) {
		$this->setVar('TITLE', $title);
	}

	/**
	 * Set the page favicon
	 *
	 * @param string $href
	 * @param string $type
	 * @param string $rel
	 */
	public function setFavicon($href, $type = 'image/x-icon', $rel = 'shortcut icon') {
		$this->setVar('FAVICON_HREF', $href);
		$this->setVar('FAVICON_TYPE', $type);
		$this->setVar('FAVICON_REL', $rel);
	}

	/**
	 * Set body tag attribute
	 *
	 * @param string $name attribute name
	 * @param string $value attribute value
	 */
	public function setBodyAttribute($name, $value) {
		$this->bodyAttributes[$name] = $value;
	}

	/**
	 * Set the body tag attributes
	 *
	 * @param array $attributes
	 */
	public function setBodyAttributes(array $attributes) {
		foreach ($attributes as $name => $value) {
			$this->setBodyAttribute($name, $value);
		}
	}

	/**
	 * Add JSON-LD
	 *
	 * @param array $jsonLd
	 */
	public function addJsonLd(array $jsonLd) {
		$this->jsonLd[] = $jsonLd;
	}

	/**
	 * Set JSON-LD
	 *
	 * @param array $jsonLd
	 */
	public function setJsonLd(array $jsonLd) {
		$this->jsonLd = $jsonLd;
	}

	/**
	 * Set the head content
	 *
	 * @param string|\Sy\Component $content
	 */
	public function setHead($content) {
		$this->setVar('HEAD', $content);
	}

	/**
	 * Add a head content
	 *
	 * @param string|\Sy\Component $content
	 */
	public function addHead($content) {
		$this->setVar('HEAD', $content, true);
	}

	/**
	 * Set the body content
	 *
	 * @param string|\Sy\Component $content
	 */
	public function setBody($content) {
		$this->setVar('BODY', $content);
	}

	/**
	 * Add a body content
	 *
	 * @param string|\Sy\Component $content
	 */
	public function addBody($content) {
		$this->setVar('BODY', $content, true);
	}

	private function phpInfo() {
		$debugger = \Sy\Debug\Debugger::getInstance();
		if (!$debugger->phpInfoActive()) return;
		if (is_null($this->get('phpinfo'))) return;
		phpinfo(INFO_GENERAL | INFO_CREDITS | INFO_CONFIGURATION | INFO_MODULES | INFO_ENVIRONMENT | INFO_LICENSE);
		exit();
	}

	private function logFile() {
		$debugger = \Sy\Debug\Debugger::getInstance();
		if (!$debugger->fileLogActive()) return;
		if (is_null($this->get('sy_debug_log_file'))) return;
		$loggers = $debugger->getLoggers();
		if (!is_null($this->get('sy_debug_log_clear'))) {
			$loggers['file']->clearLogs();
			exit();
		}
		echo '<pre>' . htmlentities($loggers['file']->getLogs(), ENT_QUOTES, $this->charset) . '</pre>';
		exit();
	}

	private function renderAll() {
		$this->renderAttributes($this->htmlAttributes, 'HTML_ATTR');
		$this->renderAttributes($this->bodyAttributes, 'BODY_ATTR');
		$this->renderBase();
		$this->renderMetas();
		$this->renderLinks();
		$this->renderCssLinks();
		$this->renderJsLinks();
		$this->setVar('CSS_CODE', $this->getCssCode());
		$this->renderJsCode();
		$this->renderJsonLd();
	}

	private function renderAttributes(array $attributes, $block) {
		foreach ($attributes as $name => $value) {
			$this->setVar('NAME', $name);
			$this->setVar('VALUE', $value);
			$this->setBlock($block);
		}
	}

	private function renderBase() {
		if (empty($this->base)) return;
		$this->setComponent('BASE', new Element('base', null, $this->base));
	}

	private function renderMetas() {
		$meta = new Element('meta');
		if ($this->doctype === 'html5') {
			$meta->setAttributes(array('charset' => $this->charset));
		} else {
			$this->setMeta('Content-Type', 'text/html; charset=' . $this->charset, true);
			$meta = $this->meta['http-equiv-content-type'];
			unset($this->meta['http-equiv-content-type']);
		}
		$this->setComponent('META_ELEMENT', $meta);
		$this->setBlock('META');
		foreach ($this->meta as $meta) {
			if (is_array($meta)) {
				foreach ($meta as $m) {
					$this->setComponent('META_ELEMENT', $m);
					$this->setBlock('META');
				}
			} else {
				$this->setComponent('META_ELEMENT', $meta);
				$this->setBlock('META');
			}
		}
	}

	private function renderJsCode() {
		$js = $this->getJsCode(WebComponent::JS_TOP);
		foreach ($js as $type => $js) {
			$this->setVar('TYPE', $type);
			foreach ($js as $load => $code) {
				$this->setVars([
					'LOAD' => $load,
					'CODE' => $code,
				]);
				$this->setBlock('JS_CODE');
			}
		}

		$js = $this->getJsCode(WebComponent::JS_BOTTOM);
		foreach ($js as $type => $js) {
			$this->setVar('TYPE', $type);
			foreach ($js as $load => $code) {
				$this->setVars([
					'LOAD' => $load,
					'CODE' => $code,
				]);
				$this->setBlock('JS_CODE_BOTTOM');
			}
		}
	}

	private function renderJsLinks() {
		$jsLinks = $this->getJsLinks();
		foreach ($jsLinks[WebComponent::JS_TOP] as $jsLink) {
			$url = $jsLink['url'];
			if (is_array($url)) {
				if (!isset($url['url'])) continue;
				$this->setVars(array(
					'JS_LINK'     => $url['url'],
					'INTEGRITY'   => isset($url['integrity']) ? $url['integrity'] : '',
					'CROSSORIGIN' => isset($url['crossorigin']) ? $url['crossorigin'] : 'anonymous',
					'TYPE' => $jsLink['type'],
					'LOAD' => $jsLink['load'],
				));
			} else {
				$this->setVars(array('JS_LINK' => $url, 'INTEGRITY' => '', 'CROSSORIGIN' => '', 'TYPE' => $jsLink['type'], 'LOAD' => $jsLink['load']));
			}
			$this->setBlock('JS_LINKS');
		}
		foreach ($jsLinks[WebComponent::JS_BOTTOM] as $jsLink) {
			$url = $jsLink['url'];
			if (is_array($url)) {
				if (!isset($url['url'])) continue;
				$this->setVars(array(
					'JS_LINK'     => $url['url'],
					'INTEGRITY'   => isset($url['integrity']) ? $url['integrity'] : '',
					'CROSSORIGIN' => isset($url['crossorigin']) ? $url['crossorigin'] : 'anonymous',
					'TYPE' => $jsLink['type'],
					'LOAD' => $jsLink['load'],
				));
			} else {
				$this->setVars(array('JS_LINK' => $url, 'INTEGRITY' => '', 'CROSSORIGIN' => '', 'TYPE' => $jsLink['type'], 'LOAD' => $jsLink['load']));
			}
			$this->setBlock('JS_LINKS_BOTTOM');
		}
	}

	private function renderCssLinks() {
		foreach ($this->getCssLinks() as $media => $links) {
			$this->setVar('MEDIA', $media);
			foreach ($links as $link) {
				if (is_array($link)) {
					if (!isset($link['url'])) continue;
					$this->setVars(array(
						'LINK'        => $link['url'],
						'INTEGRITY'   => isset($link['integrity']) ? $link['integrity'] : '',
						'CROSSORIGIN' => isset($link['crossorigin']) ? $link['crossorigin'] : '',
					));
				} else {
					$this->setVars(array('LINK' => $link, 'INTEGRITY' => '', 'CROSSORIGIN' => ''));
				}
				$this->setBlock('CSS_LINKS');
			}
		}
	}

	private function renderLinks() {
		foreach ($this->links as $link) {
			$l = new Element('link');
			foreach ($link as $name => $value) {
				$l->setAttributes(array($name => $value));
			}
			$this->setComponent('LINK', $l);
			$this->setBlock('LINKS');
		}
	}

	private function renderJsonLd() {
		foreach ($this->jsonLd as $jsonLd) {
			$this->setVar('JSONLD', json_encode($jsonLd, JSON_UNESCAPED_SLASHES));
			$this->setBlock('JSONLD_BLOCK');
		}
	}

}