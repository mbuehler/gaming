<?php

class Item {
  private $name;
  private $weight;
  
  public function getWeight() { return $this->weight; }
  public function getName()   { return $this->name;   }
  
  public function Item($name, $weight) {
  	$this->name   = $name;
  	$this->weight = $weight;
  }
}