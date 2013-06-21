<?php

require_once 'classes/item.class.php';
require_once 'PHPUnit/Framework/TestCase.php';

/**
 * Item test case.
 */
class ItemTest extends PHPUnit_Framework_TestCase {

	private $Item;
	protected function setUp() {
		parent::setUp ();
	}

	protected function tearDown() {
		$this->Item = null;
		parent::tearDown ();
	}

	public function __construct() {}

	public function test__construct() {
		$name   = 'Name';
		$weight = 99;
		$this->Item = new Item($name,$weight);
		$this->assertEquals($name,$this->Item->getName());
		$this->assertEquals($weight,$this->Item->getWeight());
	}

}