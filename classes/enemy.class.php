<?php

require_once "classes/dice.class.php";

class Enemy {

	private $race;
	private $align;
	private $size;
	private $move;
	private $hd;
	private $ac;
	private $initiative;
	private $attacks; // array of damages
	private $treasure;

	private $status = 'ALIVE';
	private $log;

	private $hp;
	private $maxhp;

	// Enchantments
	private $enchantments = array();

	public function Enemy($race,$align,$size,$move,$hd,$ac,$initiative,$attacks,$treasure) {
    $dice = new Dice();
		$this->hp = $this->maxhp = $dice->roll($hd);

		$this->race       = $race;
		$this->align      = $align;
		$this->size       = $size;
		$this->move       = $move;
		$this->hd         = $hd;
		$this->ac         = $ac;
		$this->initiative = $initiative;
		$this->attacks    = $attacks;
		$this->treasure   = $treasure;
	}

	public function getHp()           { return $this->hp;           }
	public function getStatus()       { return $this->status;       }
  public function getLog()          { return $this->log;          }
  public function getEnchantments() { return $this->enchantments; }
  public function getAttacks()      { return $this->attacks;      }
  public function getRace()         { return $this->race;         }

	public function damage($pts) {
		$this->hp -= $pts;
		$this->log = $this->race." Sustained $pts Damage\n";
		if($this->hp < 1) {
			$this->status = 'DEAD';
			$this->log .= $this->race." Killed\n";
		}
	}

	public function heal($pts) {
		if($this->status != 'DEAD') {
			$this->hp = ( ($this->hp + $pts) > $this->maxhp ) ? $this->maxhp : $this->hp + $pts;
			$this->log = $this->race." Healed to ".$this->hp."/".$this->maxhp."\n";
		} else {
			$this->log = $this->race." Must Be Resurrected Before Healing\n";
		}
	}

  public function resurrect() {
		if($this->status == 'DEAD') {
			$this->hp = 1;
			$this->status = 'ALIVE';
			$this->log = $this->race." Has Been Resurrected\n";
		} else {
			$this->log = $this->race." Wasn't Dead\n";
		}
	}
}

?>