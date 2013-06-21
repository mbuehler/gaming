<?php

class Weapon extends Item {
	private $damage;
	private $modifier = '';
	
	public function getDamage()   { return $this->damage;   }
	public function getModifier() { return $this->modifier; }
	
	public function Weapon($name, $weight, $damage, $modifier='') {
		parent::__construct($name,$weight);
		$this->damage   = $damage;
		$this->modifier = $modifier;
	}
}