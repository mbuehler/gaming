<?php

require_once 'classes/item.class.php';
require_once 'classes/armor.class.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * Armor test case.
 */
class ArmorTest extends PHPUnit_Framework_TestCase {

	private $Armor;

	protected function setUp() {
		parent::setUp ();
	}

	protected function tearDown() {
		$this->Armor = null;
		parent::tearDown ();
	}

	public function __construct() {}

	public function testArmor() {
		$name     = 'Chain Mail';
	  $weight   = 500;
	  $ac       = 6;
  	$modifier = '+1';
		$armor = new Armor($name,$weight,$ac,$modifier);
		$this->assertEquals($name,$armor->getName());
		$this->assertEquals($weight,$armor->getWeight());
		$this->assertEquals($ac,$armor->getAc());
		$this->assertEquals($modifier,$armor->getModifier());
	}

}

