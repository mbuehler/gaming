<?php

/**
 * Weapon test case.
 */
class WeaponTest extends PHPUnit_Framework_TestCase {

	private $Weapon;


	protected function setUp() {
		parent::setUp ();
	}

	protected function tearDown() {
		$this->Weapon = null;
		parent::tearDown ();
	}

	public function __construct() {}

	public function test__construct() {
		$name     = 'Short Sword';
    $weight   = 80;
    $damage   = '1d6';
    $modifier = '+1';
		$this->Weapon = new Weapon($name,$weight,$damage,$modifier);
		$this->assertEquals($name,    $this->Weapon->getName());
		$this->assertEquals($weight,  $this->Weapon->getWeight());
		$this->assertEquals($damage,  $this->Weapon->getDamage());
		$this->assertEquals($modifier,$this->Weapon->getModifier());
	}

}