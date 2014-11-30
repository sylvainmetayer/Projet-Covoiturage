<?php
class Division{
	private $div_num;
	private $div_nom;
	
	public function __construct ($valeurs = array())
	{
		if (!empty($valeurs))
		{
			$this->affecte($valeurs);
		}
	}
	
	public function affecte($donnees)
	{
		foreach ($donnees as $attribut => $valeurs)
		{
			switch ($attribut)
			{
				case 'div_num' : $this->setDivNum($valeurs); break;
				case 'div_nom' : $this->setDivNom($valeurs); break;
			}
		}
	}
	
	public function setDivNum($div_num)
	{
		$this->div_num = $div_num;
	}
	
	public function setDivNom($div_nom)
	{
		$this->div_nom = $div_nom;
	}
	
	public function getDivNom()
	{
		return $this->div_nom;
	}
	
	public function getDivNum()
	{
		return $this->div_num;
	}
}