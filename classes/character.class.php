<?php

require_once "../classes/item.class.php";
require_once "../classes/weapon.class.php";
require_once "../classes/armor.class.php";

class Character {

	// Info variables
	private $name;
	private $status = 'ALIVE';
	private $log;

	// Battle Stats
	private $maxhp;
	private $hp;
	private $ac;

	// Abilities
	private $str;
	private $int;
	private $wis;
	private $dex;
	private $con;
	private $cha;
	private $com;

	// Enchantments
	private $enchantments = array();

	// Equipment
	private $weapons       = array();
	private $armor         = array();
	private $equippeditems = array();
	private $inventory     = array();

	function Character($name,$hp) {
		$this->name  = $name;
		$this->maxhp = $hp;
		$this->hp    = $hp;
	}

	public function getName()          { return $this->name;          }
	public function getLog()           { return $this->log;           }
	public function getHp()            { return $this->hp;            }
	public function getStatus()        { return $this->status;        }
	public function getEnchantments()  { return $this->enchantments;  }
	public function getWeapons()       { return $this->weapons;       }
	public function getArmor()         { return $this->armor;         }
	public function getEquippedItems() { return $this->equippeditems; }
	public function getInventory()     { return $this->inventory;     }

	public function equip($item) {
		switch(get_class($item)) {
			case 'Weapon' :
				$this->inventory = $this->removeItem($this->inventory, $item);
				array_push($this->weapons, $item);
				break;
			case 'Armor' :
				$this->inventory = $this->removeItem($this->inventory, $item);
				array_push($this->armor, $item);
				break;
			default:
				$this->inventory = $this->removeItem($this->inventory, $item);
				array_push($this->equippeditems, $item);
				break;
		}
		$this->log = "Equipped ".$item->getName()."\n";
	}

	public function unEquip($item) {
		switch(get_class($item)) {
			case 'Weapon' :
				$this->weapons = $this->removeItem($this->weapons, $item);
				array_push($this->inventory, $item);
				break;
			case 'Armor' :
				$this->armor = $this->removeItem($this->armor, $item);
				array_push($this->inventory, $item);
				break;
			default:
				$this->equippeditems = $this->removeItem($this->equippeditems, $item);
				array_push($this->inventory, $item);
				break;
		}
		$this->log = "Unequipped ".$item->getName()."\n";
	}

	public function get($item) {
		$currentEncumbrance = $this->getEncumbrance();
		$itemWeight         = $item->getWeight();
		$maxEncumbrance     = $this->getMaxEncumbrance();
		$canCarryItem       = ($currentEncumbrance + $itemWeight) <= $maxEncumbrance;
	  if($canCarryItem) {
    	array_push($this->inventory,$item);
    	$this->log = "Now carrying ".$item->getName()."\n";
    } else {
    	$this->log = "Can't carry this much weight\n";
    }
	}

	public function getEncumbrance() {
		$encumbrance = 0;
		foreach($this->inventory     as $item) { $encumbrance =+ $item->getWeight(); }
	  foreach($this->weapons       as $item) { $encumbrance =+ $item->getWeight(); }
	  foreach($this->armor         as $item) { $encumbrance =+ $item->getWeight(); }
	  foreach($this->equippeditems as $item) { $encumbrance =+ $item->getWeight(); }
	  return $encumbrance;	}

	public function getMaxEncumbrance() {
		return 2000;	}

	public function damage($pts) {
		$this->hp -= $pts;
		$this->log = "Character Sustained $pts Damage\n";
		if($this->hp < 1) {
			$this->status = 'DEAD';
			$this->log .= "Character Killed\n";
		}
	}

	public function heal($pts) {
		if($this->status != 'DEAD') {
			$this->hp = ( ($this->hp + $pts) > $this->maxhp ) ? $this->maxhp : $this->hp + $pts;
			$this->log = "Character Healed to ".$this->hp."/".$this->maxhp."\n";
		} else {
			$this->log = "Character Must Be Resurrected Before Healing\n";
		}
	}

	public function resurrect() {
		if($this->status == 'DEAD') {
			$this->hp = 1;
			$this->status = 'ALIVE';
			$this->log = "Character Has Been Resurrected\n";
		} else {
			$this->log = "Character Wasn't Dead\n";
		}
	}

	private function removeItem() {
    $args = func_get_args();
    $arr = $args[0];
    $values = array_slice($args,1);

    foreach($arr as $k=>$v) {
      if(in_array($v, $values))
        unset($arr[$k]);
    }
    return $arr; }

}