<?php
class Fonction{
	private $fon_num;
	private $fon_libelle;
	
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
				case 'fon_libelle' : $this->setFonLibelle($valeurs); break;
				case 'fon_num' : $this->setFonNum($valeurs); break;
			}
		}
	}
	
	//GETTER - SETTER 
	public function getFonNum()
	{
		return $this->fon_num;
	}
	
	public function getFonLibelle()
	{
		return $this->fon_libelle;
	}
	
	public function setFonLibelle($fon_libelle)
	{
		$this->fon_libelle = $fon_libelle;
	}
	
	public function setFonNum($fon_num)
	{
		$this->fon_num = $fon_num;
	}
}