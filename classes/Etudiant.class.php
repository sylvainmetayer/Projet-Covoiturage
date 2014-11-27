<?php
class Etudiant{
	private per_num;
	private dep_num;
	private div_num;
	
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
				case 'per_num' : $this->setPerNum($valeurs); break;
				case 'dep_num' : $this->setNomPersonne($valeurs); break;
				case 'div_num' : $this->setNomPersonne($valeurs); break;
			}
		}
	}
	
	//GETTER - SETTER 
	public function setPerNum($per_num)
	{
		$this->$per_num = $per_num;
	}
	
	public function setDivNum($div_num)
	{
		$this->$div_num = $div_num;
	}
	
	public function setDepNum($dep_num)
	{
		$this->$dep_num = $dep_num;
	}
	
	public function getPerNum()
	{
		return $this->$per_num ;
	}
	
	public function getDivNum()
	{
		return $this->$div_num ;
	}
	
	public function getDepNum()
	{
		return $this->$dep_num ;
	}
	
	
}