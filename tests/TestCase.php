<?php
namespace Sy\Test;

use Sy\Component;

class TestCase extends \PHPUnit\Framework\TestCase {

	public function assertFileContentEqualsComponentRender(string $filename, Component $component) {
		$minify = function ($code) {
			$code = str_replace(array("\t", "\r", "\n"), '', $code);
			$code = preg_replace('/\s+/', ' ', $code);
			$code = str_replace(array('> <'), '', $code);
			return trim($code);
		};
		$this->assertEquals($minify(file_get_contents($filename)), $minify($component->render()));
	}

	public function assertComponentRenderEqualsText(Component $component, string $text) {
		$minify = function ($code) {
			$code = str_replace(array("\t", "\r", "\n"), '', $code);
			$code = preg_replace('/\s+/', ' ', $code);
			$code = str_replace(array('> <'), '', $code);
			return trim($code);
		};
		$this->assertEquals($minify($text), $minify($component->render()));
	}

}