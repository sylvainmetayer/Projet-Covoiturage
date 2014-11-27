<?php
class Parcours{
	private $par_num; //Primary Key
	private $par_km;
	private $vil_num1;
	private $vil_num2;
	
	public function __construct ($valeurs = array())
	{
		if (!empty($valeurs))
		{
			$this->affecte($valeurs);
		}
	}
	
	public function affecte($donnees)
	{
		//print_r($donnees);
		foreach ($donnees as $attribut => $valeurs)
		{
			switch ($attribut)
			{
				case 'par_num' : $this->setParNum($valeurs); break;
				case 'par_km' : $this->setParKm($valeurs); break;
				case 'vil_num1' : $this->setVil_num1($valeurs); break;
				case 'vil_num2' : $this->setVil_num2($valeurs); break;
			}
		}
	}
	
	public function setParNum($par_num)
	{
		$this->par_num=$par_num;
	}
	
	public function setParKm($par_km)
	{
		$this->par_km=$par_km;
	}
	
	public function setVil_num1($vil_num1)
	{
		$this->vil_num1 = $vil_num1;
	}
	
	public function setVil_num2($vil_num2)
	{
		$this->vil_num2 = $vil_num2;
	}
	
	public function getParNum()
	{
		return $this->par_num;
	}
	
	public function getParKm()
	{
		return $this->par_km;
	}
	
	public function getVil_num1()
	{
		return $this->vil_num1;
	}
	
	public function getVil_num2()
	{
		return $this->vil_num2;
	}
}