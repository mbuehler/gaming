<?php

require_once 'classes/enemy.class.php';
require_once 'PHPUnit/Framework/TestCase.php';

class EnemyTest extends PHPUnit_Framework_TestCase {

	private $enemy;

	protected function setUp() {
		parent::setUp ();
		$attacks[0] = '1d6';
		$this->enemy = new Enemy('Orc','LE','M',10,'1d1+5',7,8,$attacks,'C');
	}

	protected function tearDown() {
		$this->enemy = null;
		parent::tearDown ();
	}

	public function __construct() {
	}

	private function ae($a1,$a2,$msg='') {
		$this->assertEquals($a1,$a2,$msg);
	}

	public function testGetEnchantments() {
		$this->assertEquals(array(),$this->enemy->getEnchantments());
	}

	public function testDamage() {
		$this->enemy->damage(2);
		echo $this->enemy->getLog();
		$this->ae('ALIVE',$this->enemy->getStatus());
		$this->ae(4,$this->enemy->getHp());
		$this->enemy->damage(4);
		echo $this->enemy->getLog();
		$this->ae(0,$this->enemy->getHp());
		$this->ae('DEAD',$this->enemy->getStatus());
	}

	public function testHeal() {
		$this->enemy->heal(99);
		echo $this->enemy->getLog();
		$this->ae(6,$this->enemy->getHp());
		$this->ae('ALIVE',$this->enemy->getStatus());
		$this->enemy->damage(6);
		echo $this->enemy->getLog();
		$this->enemy->heal(6);
		echo $this->enemy->getLog();
		$this->ae(0,$this->enemy->getHp());
		$this->ae('DEAD',$this->enemy->getStatus());
	}

	public function testResurrect() {
		$this->enemy->resurrect();
		echo $this->enemy->getLog();
		$this->enemy->damage(99);
		echo $this->enemy->getLog();
		$this->ae('DEAD',$this->enemy->getStatus());
		$this->enemy->resurrect();
		echo $this->enemy->getLog();
		$this->ae(1,$this->enemy->getHp());
		$this->ae('ALIVE',$this->enemy->getStatus());
	}

}


