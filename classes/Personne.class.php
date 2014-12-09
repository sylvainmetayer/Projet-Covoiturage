<?php
class Personne {
	private $per_num;
	private $per_nom;
	private $per_prenom;
	private $per_tel;
	private $per_mail;
	private $per_login;
	private $per_pwd;
	public function __construct($valeurs = array()) {
		if (! empty ( $valeurs )) {
			$this->affecte ( $valeurs );
		}
	}
	public function affecte($donnees) {
		// var_dump($donnees);
		foreach ( $donnees as $attribut => $valeurs ) {
			switch ($attribut) {
				case 'per_num' :
					$this->setPerNum ( $valeurs );
					break;
				case 'per_nom' :
					$this->setNomPersonne ( $valeurs );
					break;
				case 'per_prenom' :
					$this->setPrenomPersonne ( $valeurs );
					break;
				case 'per_tel' :
					$this->setPerTel ( $valeurs );
					break;
				case 'per_mail' :
					$this->setPerMail ( $valeurs );
					break;
				case 'per_login' :
					$this->setPerLogin ( $valeurs );
					break;
				case 'per_pwd' :
					$this->setPerPwd ( $valeurs );
					break;
			}
		}
	}
	public function setNomPersonne($per_nom) {
		$this->per_nom = $per_nom;
	}
	public function setPrenomPersonne($per_prenom) {
		$this->per_prenom = $per_prenom;
	}
	public function setPerNum($per_num) {
		$this->per_num = $per_num;
	}
	public function setPerTel($per_tel) {
		$this->per_tel = $per_tel;
	}
	public function setPerMail($per_mail) {
		$this->per_mail = $per_mail;
	}
	public function setPerLogin($per_login) {
		$this->per_login = $per_login;
	}
	public function setPerPwd($per_pwd) {
		$this->per_pwd = $per_pwd;
	}
	public function getNomPersonne() {
		return $this->per_nom;
	}
	public function getPrenomPersonne() {
		return $this->per_prenom;
	}
	public function getPerNum() {
		return $this->per_num;
	}
	public function getPerTel() {
		return $this->per_tel;
	}
	public function getPerMail() {
		return $this->per_mail;
	}
	public function getPerLogin() {
		return $this->per_login;
	}
	public function getPerPwd() {
		return $this->per_pwd;
	}
}