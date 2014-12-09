<?php
class Departement {
	private $dep_num;
	private $dep_nom;
	private $vil_num;
	public function __construct($valeurs = array()) {
		if (! empty ( $valeurs )) {
			$this->affecte ( $valeurs );
		}
	}
	public function affecte($donnees) {
		foreach ( $donnees as $attribut => $valeurs ) {
			switch ($attribut) {
				case 'dep_num' :
					$this->setDepNum ( $valeurs );
					break;
				case 'dep_nom' :
					$this->setDepNom ( $valeurs );
					break;
				case 'vil_num' :
					$this->setVilNum ( $valeurs );
					break;
			}
		}
	}
	
	// GETTER - SETTER
	public function getVilNum() {
		return $this->vil_num;
	}
	public function setVilNum($vil_num) {
		$this->vil_num = $vil_num;
	}
	public function setDepNum($dep_num) {
		$this->dep_num = $dep_num;
	}
	public function setDepNom($dep_nom) {
		$this->dep_nom = $dep_nom;
	}
	public function getDepNom() {
		return $this->dep_nom;
	}
	public function getDepNum() {
		return $this->dep_num;
	}
}