<?php
namespace Sy\Test\Form;

use Sy\Component\Html\Form\Fieldset;
use Sy\Test\TestCase;

class FieldsetTest extends TestCase {

	public function testConstruct() {
		$f = new Fieldset();
		$this->assertComponentRenderEqualsText($f, '<fieldset></fieldset>');

		$f = new Fieldset('foo');
		$this->assertComponentRenderEqualsText($f, '<fieldset><legend>foo</legend></fieldset>');

		$f = new Fieldset('foo', ['id' => 'fs1']);
		$this->assertComponentRenderEqualsText($f, '<fieldset id="fs1"><legend>foo</legend></fieldset>');
	}

	public function testGetLegend() {
		$f = new Fieldset('foo');
		$this->assertComponentRenderEqualsText($f->getLegend(), '<legend>foo</legend>');

		$f = new Fieldset('foo');
		$f->getLegend()->setAttribute('class', 'bar');
		$this->assertComponentRenderEqualsText($f->getLegend(), '<legend class="bar">foo</legend>');
	}

}