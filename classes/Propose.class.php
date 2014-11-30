<?php
class Propose{
	private $par_num;
	private $pro_num;
	private $pro_date;
	private $pro_time;
	private $pro_place;
	private $pro_sens;
	
	public function __construct($valeurs) {
		if (!empty($valeurs))
			$this->affecte($valeurs);
	}
	
	public function affecte($donnees) {
		foreach ($donnees as $attribut => $valeur) {
			switch($attribut) {
				case 'par_num':
					$this->setParNum($valeur);
					break;
				case 'pro_num':
					$this->setPerNum($valeur);
					break;
				case 'pro_date':
					$this->setDate($valeur);
					break;
				case 'pro_time':
					$this->setTime($valeur);
					break;
				case 'pro_place':
					$this->setPlace($valeur);
					break;
				case 'pro_sens':
					$this->setSens($valeur);
					break;
			}
		}
	}
	
	public function getParNum() {
		return $this->par_num;
	}
	
	public function setParNum($num) {
		$this->par_num = $num;
	}
	
	public function getPerNum() {
		return $this->per_num;
	}
	
	public function setPerNum($num) {
		$this->per_num = $num;
	}
	
	public function getDate() {
		return $this->date;
	}
	
	public function setDate($date) {
			$this->date = $date;
	}
	
	public function getTime() {
		return $this->time;
	}
	
	public function setTime($time) {
		$this->time = $time;
	}
	
	public function getPlace() {
		return $this->place;
	}
	
	public function setPlace($place) {
			$this->place = $place;
	}

	public function getSens() {
		return $this->sens;
	}
	
	public function setSens($sens) {
		$this->sens = $sens;
	}
}