<?php

class Dice{

	public $sided  = 0;
	public $num    = 0;
	public $total  = 0;
	public $modval = 0;
	public $mod    = NULL;
	public $log    = '';
	public $error  = '';

	private $base_error    = "Error Rolling Dice";
	private $invalid_sides = ": Invalid Sided Die";

	function Dice() { }

	function roll($die) {
		$this->log = '';
		$this->error = '';

		$total = 0;

	  $die = $this->checkPositiveModifier ( $die );

	  $die = $this->checkNegativeModifier ( $die );

		$dice = explode("d",$die);

		if(is_numeric($dice[0])) {
			$this->num = $dice[0];
			if(is_numeric($dice[1])) {
				$this->sided = $dice[1];
			} else {
				return $this->throwError($this->invalid_sides);
			}
		} else {
			return $this->throwError();
		}

		for($i=0; $i<$this->num; $i++) {
			$roll = rand(1,$this->sided);
			$this->log .= "Roll ".($i+1).": $roll ";

			if($this->mod == "+") {
				$total += $roll+$this->modval;
				$this->log .= "+".$this->modval;
			} elseif ($this->mod == "-") {
				if($this->modval < $roll) {
					$total += ($roll - $this->modval);
					$this->log .= "-".$this->modval;
				} else {
					$this->log .= "modifier dropped to zero";
				}
			} else {
	  		$total += $roll;
			}
			$this->log .= "\n";
	  }
	  $this->log .= "Total: $total\n\n";
	  $this->total = $total;

	  return ($this->error) ? $this->error : $total; }

	private function checkNegativeModifier($die) {
		$minus = explode("-",$die);
		  if(sizeof($minus)>1) {
		  	$this->mod = "-";
		  	$this->modval = $minus[1];
		  	$die = $minus[0];
		  }
		  return $die;
	}

	private function checkPositiveModifier($die) {
		$plus = explode("+",$die);
		  if(sizeof($plus)>1) {
		  	$this->mod = "+";
		  	$this->modval = $plus[1];
		  	$die = $plus[0];
		  }
		  return $die;
	}

	private function throwError($msg='') {
		$this->error = $this->base_error.$msg;
		$this->log .= $this->error;
	  return $this->error;	}

}