<?php
namespace Sy\Test\Form;

use Sy\Component\Html\Form\FieldContainer;
use Sy\Test\TestCase;

class FieldContainerTest extends TestCase {

	public function testConstructFieldContainer() {
		$f = new FieldContainer('fieldcontainer');
		$this->assertComponentRenderEqualsText($f, '<fieldcontainer></fieldcontainer>');

		$f = new FieldContainer('fieldcontainer', 'hello world');
		$this->assertComponentRenderEqualsText($f, '<fieldcontainer>hello world</fieldcontainer>');

		$f = new FieldContainer('fieldcontainer', 'hello world', ['id' => 'fs1']);
		$this->assertComponentRenderEqualsText($f, '<fieldcontainer id="fs1">hello world</fieldcontainer>');
	}

	public function testAddDiv() {
		$f = new FieldContainer('fieldcontainer');
		$div = $f->addDiv();
		$this->assertComponentRenderEqualsText($f, '<fieldcontainer><div></div></fieldcontainer>');
		$this->assertComponentRenderEqualsText($div, '<div></div>');

		$f = new FieldContainer('fieldcontainer', 'hello world');
		$div = $f->addDiv(['class' => 'row']);
		$this->assertComponentRenderEqualsText($f, '<fieldcontainer>hello world<div class="row"></div></fieldcontainer>');
		$this->assertComponentRenderEqualsText($div, '<div class="row"></div>');

		$f = new FieldContainer('fieldcontainer', 'hello world');
		$div = $f->addDiv(['class' => 'row']);
		$div->addButton('hello');
		$this->assertComponentRenderEqualsText($f, '<fieldcontainer>hello world<div class="row"><button>hello</button></div></fieldcontainer>');
		$this->assertComponentRenderEqualsText($div, '<div class="row"><button>hello</button></div>');
	}

	public function testAddButton() {
		$f = new FieldContainer('fieldcontainer');
		$f->addButton('hello');
		$this->assertComponentRenderEqualsText($f, '<fieldcontainer><button>hello</button></fieldcontainer>');

		$f = new FieldContainer('fieldcontainer');
		$f->addButton('hello', ['id' => 'btn1']);
		$this->assertComponentRenderEqualsText($f, '<fieldcontainer><button id="btn1">hello</button></fieldcontainer>');
	}

	public function testAddSpan() {
		$f = new FieldContainer('fieldcontainer');
		$span = $f->addSpan();
		$this->assertComponentRenderEqualsText($f, '<fieldcontainer><span></span></fieldcontainer>');
		$this->assertComponentRenderEqualsText($span, '<span></span>');

		$f = new FieldContainer('fieldcontainer');
		$span = $f->addSpan(['class' => 'foo']);
		$this->assertComponentRenderEqualsText($f, '<fieldcontainer><span class="foo"></span></fieldcontainer>');
		$this->assertComponentRenderEqualsText($span, '<span class="foo"></span>');

		$f = new FieldContainer('fieldcontainer');
		$span = $f->addSpan(['class' => 'foo']);
		$span->addContent('hello world');
		$this->assertComponentRenderEqualsText($f, '<fieldcontainer><span class="foo">hello world</span></fieldcontainer>');
		$this->assertComponentRenderEqualsText($span, '<span class="foo">hello world</span>');
	}

	public function testAddFieldset() {
		$f = new FieldContainer('fieldcontainer');
		$fs = $f->addFieldset();
		$this->assertComponentRenderEqualsText($f, '<fieldcontainer><fieldset></fieldset></fieldcontainer>');
		$this->assertComponentRenderEqualsText($fs, '<fieldset></fieldset>');

		$f = new FieldContainer('fieldcontainer');
		$fs = $f->addFieldset('I am legend');
		$this->assertComponentRenderEqualsText($f, '<fieldcontainer><fieldset><legend>I am legend</legend></fieldset></fieldcontainer>');
		$this->assertComponentRenderEqualsText($fs, '<fieldset><legend>I am legend</legend></fieldset>');

		$f = new FieldContainer('fieldcontainer');
		$fs = $f->addFieldset('I am legend', ['class' => 'foo']);
		$fs->addButton('hello');
		$this->assertComponentRenderEqualsText($f, '<fieldcontainer><fieldset class="foo"><legend>I am legend</legend><button>hello</button></fieldset></fieldcontainer>');
		$this->assertComponentRenderEqualsText($fs, '<fieldset class="foo"><legend>I am legend</legend><button>hello</button></fieldset>');
	}

	public function testAddLabel() {
		$f = new FieldContainer('fieldcontainer');
		$label = $f->addLabel('hello');
		$this->assertComponentRenderEqualsText($f, '<fieldcontainer><label>hello</label></fieldcontainer>');
		$this->assertComponentRenderEqualsText($label, '<label>hello</label>');

		$f = new FieldContainer('fieldcontainer');
		$label = $f->addLabel('hello', ['class' => 'foo']);
		$this->assertComponentRenderEqualsText($f, '<fieldcontainer><label class="foo">hello</label></fieldcontainer>');
		$this->assertComponentRenderEqualsText($label, '<label class="foo">hello</label>');
	}

}