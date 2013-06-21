<?php

require_once 'classes/dice.class.php';
require_once 'PHPUnit/Framework/TestCase.php';

class DiceTest extends PHPUnit_Framework_TestCase {

	private $dice;

	protected function setUp() {
		parent::setUp ();
		$this->dice = new Dice(/* parameters */);
	}

	protected function tearDown() {
		$this->dice = null;
		parent::tearDown ();
	}

	public function __construct() {}

	public function test__construct() {
		$this->dice = new Dice();
		$this->assertEquals(0,$this->dice->sided);
		$this->assertEquals(0,$this->dice->num);
		$this->assertNull($this->dice->mod);
	  $this->assertEquals(0,$this->dice->modval);
	}

	public function testBasicRoll() {
		$roll = $this->dice->roll('3d6');
		$this->assertGreaterThan(2,$roll, 'Roll of 3d6 should never be below 3');
		$this->assertLessThan(19,$roll, 'Roll of 3d6 should never exceed 18');
		echo $this->dice->log;
	}

	public function testPositiveModifierRoll() {
		$roll = $this->dice->roll('3d6+1');
		$this->assertGreaterThan(5,$roll, 'Roll of 3d6+1 should never be less that 6');
		$this->assertLessThan(22,$roll, 'Roll of 3d6+1 should never exceed 21');
		echo $this->dice->log;
	}

	public function testNegativeModifierRoll() {
		$roll = $this->dice->roll('3d6-1');
		$this->assertGreaterThan(-1,$roll,'Roll of 3d6-1 should never be less that 0');
		$this->assertLessThan(16,$roll, 'Roll of 3d6+1 should never exceed 15');
		echo $this->dice->log;
	}

	public function testNegativeModifierGreaterThanDieValueResultsInZero() {
		$roll = $this->dice->roll('2d4-4');
		$this->assertEquals(0,$roll, 'Roll of2d4-4 should always result in 0');
		echo $this->dice->log;
	}

	public function testBadDieValueResultsInError() {
		$error = $this->dice->roll('twentytwentwen');
		$this->assertEquals('Error Rolling Dice',$error);
	}

	public function testBadDieSideValueResultsInError() {
		$error = $this->dice->roll('1dfoo');
		$this->assertEquals('Error Rolling Dice: Invalid Sided Die',$error);
	}
}

