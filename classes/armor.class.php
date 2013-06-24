<?php

require_once "../classes/item.class.php";

class Armor extends Item {
	private $ac;
	private $modifier = '';
	
	public function getAc()       { return $this->ac;       }
  public function getModifier() { return $this->modifier; }

	public function Armor($name, $weight, $ac, $modifier='') {
		parent::Item($name,$weight);
		$this->ac       = $ac;
		$this->modifier = $modifier;
	}
	
}