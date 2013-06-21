<?php

require_once "classes/dice.class.php";
require_once "classes/character.class.php";
require_once "classes/enemy.class.php";

class Battle {

	private $round;
	private $pcs;
	private $enemies;
	private $status;
	private $log;

	public function Battle() {
		$this->round = 1;
		$this->status = 'ENGAGED';
		$this->pcs = array();
		$this->enemies = array();
	}

	public function getLog()    { return $this->log;    }
	public function getStatus() { return $this->status; }

	public function addEnemy($enemy) {
		array_push($this->enemies,$enemy);
	}

	public function addPc($pc) {
		array_push($this->pcs,$pc);
	}

	public function doBattle() {
		$dice = new Dice();
		while($this->status == 'ENGAGED') {
			$this->log .= "\nRnd-".$this->round." -------------\n";
			if(!sizeof($this->enemies)) { $this->status = 'VICTORIOUS'; }
			if(!sizeof($this->pcs))     { $this->status = 'DEFEATED';   }
			foreach($this->pcs as $pc) {
				$idx = rand(0,sizeof($this->enemies)-1);
				$weapons = $pc->getWeapons();
				$hp = $dice->roll($weapons[0]->getDamage());
				$enemies = $this->enemies;
				if(isset($this->enemies[$idx])) {
					$enemy = $this->enemies[$idx];
					if(get_class($enemy) == 'Enemy') {
						$enemy->damage($hp);
						if($enemy->getStatus() == 'DEAD') {
							$this->enemies = $this->removeCombatant($this->enemies,$idx);
							if(!sizeof($this->pcs)) { $this->status = 'VICTORIOUS'; }
						}
						$this->log .= $pc->getName()." Hit ".$enemy->getRace()." #$idx For $hp\n".$enemy->getLog()."\n";
					}
				}
			}
			$eidx = 1;
			foreach($this->enemies as $enemy) {
				foreach($enemy->getAttacks() as $attack) {
					$idx = rand(0,sizeof($this->pcs)-1);
					$hp = $dice->roll($attack);
					$pcs = $this->pcs;
					if(isset($this->pcs[$idx])) {
						$pc  = $this->pcs[$idx];
						if(get_class($pc) == 'Character') {
							$pc->damage($hp);
							if($pc->getStatus() == 'DEAD') {
								$this->pcs = $this->removeCombatant($this->pcs,$idx);
								if(!sizeof($this->pcs)) { $this->status = 'DEFEATED'; }
							}
							$this->log .= $enemy->getRace()." #".$eidx." Hit ".$pc->getName()." For $hp\n".$pc->getLog()."\n";
						}
					}
				}
				$eidx++;
			}
			echo $this->getLog();
			$this->log = '';
			$this->round++;
		}
		$this->log .= "Player Characters are ".$this->getStatus()."\n\nEnd of Battle\n\n";
		echo $this->getLog();
	}


  function removeCombatant($arr,$i) {
    unset($arr[$i]);
    return array_values($arr); }

}

?>