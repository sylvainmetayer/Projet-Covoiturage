<?php
class Ville{
	private $vil_nom;
	private $vil_num; //Primary Key
	
	public function __construct ($valeurs = array())
	{
		if (!empty($valeurs))
		{
			$this->affecte($valeurs);
		}
	}
	
	// POUR CLEMENT : METTRE LES NOMS DE VARIABLES PAREIL QUE SUR LES NOMS SUR LA BD !!!
	public function affecte($donnees)
	{
		foreach ($donnees as $attribut => $valeurs)
		{
			switch ($attribut)
			{
				case 'vil_nom' : $this->setNomVille($valeurs); break;
				case 'vil_num' : $this->setNumVille($valeurs); break;
			}
		}
	}
	
	public function setNomVille($vil_nom)
	{
		$this->vil_nom = $vil_nom;
	}
	
	public function setNumVille($vil_num)
	{
		$this->vil_num = $vil_num;
	}
	
	public function getVilleNom() 
	{ 
		return $this->vil_nom;
	}
	
	public function getNumVille()
	{
		return $this->vil_num;
	}
}