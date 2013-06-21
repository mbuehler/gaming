<?php

require_once 'classes/character.class.php';
require_once 'PHPUnit/Framework/TestCase.php';

class CharacterTest extends PHPUnit_Framework_TestCase {

	private $character;

	protected function setUp() {
		parent::setUp ();
		$this->character = new Character('Fred',10);
	}

	protected function tearDown() {
		$this->character = null;
		parent::tearDown ();
	}

	public function __construct() {
	}

	public function ae($a1,$a2,$msg='') {
		$this->assertEquals($a1,$a2,$msg);
	}

	public function testGet() {
		$item = new Item('Flask',10);
		$this->character->get($item);
		echo $this->character->getLog();
		$this->assertTrue( in_array( $item, $this->character->getInventory() ) );
	  $heavyItem = new Item('Rock',2100);
		$this->character->get($heavyItem);
		echo $this->character->getLog();
		$this->assertFalse( in_array( $heavyItem, $this->character->getInventory() ) );
	}

	public function testGetEnchantments() {
		$this->assertEquals(array(),$this->character->getEnchantments());
	}

	public function testEquip() {
		$item = new Item('Flask',10);
		$this->character->get($item);
		$this->character->Equip($item);
		echo $this->character->getLog();
		$this->assertFalse( in_array( $item, $this->character->getInventory() ) );
		$this->assertTrue( in_array( $item, $this->character->getEquippedItems() ) );
	}

	public function testEquipUnequipWeapon() {
		$weapon = new Weapon('Short Sword','100','1d6');
		$this->character->get($weapon);
		$this->character->Equip($weapon);
		echo $this->character->getLog();
		$this->assertTrue( in_array( $weapon, $this->character->getWeapons() ) );
		$this->character->UnEquip($weapon);
		echo $this->character->getLog();
		$this->assertFalse( in_array( $weapon, $this->character->getWeapons() ) );
		$this->assertTrue( in_array( $weapon, $this->character->getInventory() ) );
	}

	public function testEquipUnequipArmor() {
		$armor = new Armor('Chain Mail +1','500','+1');
		$this->character->get($armor);
		$this->character->Equip($armor);
		echo $this->character->getLog();
		$this->assertTrue( in_array( $armor, $this->character->getArmor() ) );
		$this->character->UnEquip($armor);
		echo $this->character->getLog();
		$this->assertFalse( in_array( $armor, $this->character->getArmor() ) );
		$this->assertTrue( in_array( $armor, $this->character->getInventory() ) );
	}

	public function testUnEquip() {
		$item = new Item('Flask',10);
		$this->character->get($item);
		$this->character->Equip($item);
		echo $this->character->getLog();
		$this->assertTrue( in_array( $item, $this->character->getEquippedItems() ) );
		$this->character->Unequip($item);
		echo $this->character->getLog();
		$this->assertFalse( in_array( $item, $this->character->getEquippedItems() ) );
		$this->assertTrue( in_array( $item, $this->character->getInventory() ) );
	}

	public function testGetEquippedWeapon() {
		$weapon = new Weapon('Short Sword','100','1d6');
		$this->character->get($weapon);
		$this->character->Equip($weapon);
		$weapons = $this->character->getWeapons();
		$this->ae('Short Sword',$weapons[0]->getName());
	}

	public function testDamage() {
		$this->character->damage(2);
		echo $this->character->getLog();
		$this->ae('ALIVE',$this->character->getStatus());
		$this->ae(8,$this->character->getHp());
		$this->character->damage(8);
		echo $this->character->getLog();
		$this->ae(0,$this->character->getHp());
		$this->ae('DEAD',$this->character->getStatus());
	}

	public function testHeal() {
		$this->character->heal(99);
		echo $this->character->getLog();
		$this->ae(10,$this->character->getHp());
		$this->ae('ALIVE',$this->character->getStatus());
		$this->character->damage(10);
		echo $this->character->getLog();
		$this->character->heal(10);
		echo $this->character->getLog();
		$this->ae(0,$this->character->getHp());
		$this->ae('DEAD',$this->character->getStatus());
	}

	public function testResurrect() {
		$this->character->resurrect();
		echo $this->character->getLog();
		$this->character->damage(99);
		echo $this->character->getLog();
		$this->ae('DEAD',$this->character->getStatus());
		$this->character->resurrect();
		echo $this->character->getLog();
		$this->ae(1,$this->character->getHp());
		$this->ae('ALIVE',$this->character->getStatus());
	}

}

