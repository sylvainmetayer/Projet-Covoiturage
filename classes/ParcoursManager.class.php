<?php
class ParcoursManager{
		private $db;
	
	public function __construct($db)
	{
		$this->db = $db;
	}

	
	public function add($parcours)
	{
		$requete = $this->db->prepare(
		'INSERT INTO parcours (par_km, vil_num1, vil_num2) VALUES (:km, :vil_num1, :vil_num2);');
		//var_dump($parcours->getParKm());
		$requete->bindValue(':km',$parcours->getParKm());
		$requete->bindValue(':vil_num1',$parcours->getVil_num1());
		$requete->bindValue(':vil_num2',$parcours->getVil_num2());
		
		//GERER LES CLES ETRANGERES
		$retour = $requete->execute();
		//var_dump($retour);
		return $retour;
	}
	
	//INCOMPLET
	public function getAllParcours()
	{
		$listeParcours = array(); //tableau d'objet
		
		$sql = 'SELECT par_num, vil_num1, vil_num2, par_km FROM parcours';
		$requete = $this->db->prepare($sql);
		$requete->execute();
		//truc multiple à gérer
		while ($nom_vil = $requete->fetch(PDO::FETCH_OBJ))
		{
			$listeParcours[] = new parcours($nom_vil);
		}
		return $listeParcours;
		$requete->closeCursor();
	}
	
	public function getNbParcours()
	{
		$sql = 'SELECT * FROM PARCOURS';
		$requete = $this->db->prepare($sql);
		$requete->execute();
		while ($nb_parcours = $requete->fetch(PDO::FETCH_OBJ))
		{
			$sql = $sql +1;
		}
		$requete->closeCursor();
		return $sql;
	}
}