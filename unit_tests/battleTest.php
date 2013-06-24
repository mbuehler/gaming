<?php

require_once "../classes/battle.class.php";
/**
 * Battle test case.
 */
class BattleTest extends PHPUnit_Framework_TestCase {

	private $Battle;

	protected function setUp() {
		parent::setUp ();
	}

	protected function tearDown() {
		$this->Battle = null;
		parent::tearDown ();
	}

	public function __construct() {}

	public function test__construct() {

		$battle  = new Battle();
		$battle2 = new Battle();

		$bilbo   = new Character('Bilbo',12);
		$aragorn = new Character('Aragorn',18);

		$shortSword = new Weapon('Short Sword',80,'1d6','');
		$longSword  = new Weapon('Long Sword',100,'1d8','');

		$bilbo->get($shortSword);
		$bilbo->equip($shortSword);
		$aragorn->get($longSword);
		$aragorn->equip($longSword);

		$battle->addPc($bilbo);
		$battle->addPc($aragorn);

		$battle2->addPc($bilbo);

		$attacks[0] = '1d4';
		for($i=0; $i<6; $i++) {
		  $orc = new Enemy('Orc','LE','M',10,'1d4+1',7,8,$attacks,'C');
		  $battle->addEnemy($orc);
		  $battle2->addEnemy($orc);
		  $battle2->addEnemy($orc);
		}

		$battle->doBattle();
		$battle2->doBattle();

	}
}