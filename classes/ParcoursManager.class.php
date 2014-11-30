<?php
class ParcoursManager{
		private $db;
	
	public function __construct($db)
	{
		$this->db = $db;
	}

	// A TESTER
	public function add($parcours)
	{
		// Il manque une fonction qui recherche le numero de la ville passée en parametre
		// pour verifier qu'elle n'existe pas déjà.
		// Il faudra la faire deux fois, dans le sens vil_num1->vil_num2 et dans le sens vil_num2->vil_num1
		//Fonction faite, voir plus bas
		
		//on regarde le premier sens
		$sens1 = getVilNum1et2VerifParcours( $parcours->getVil_num1() , $parcours->getVil_num2() );
		//on regarde l'autre sens
		$sens2 = getVilNum1et2VerifParcours( $parcours->getVil_num2() , $parcours->getVil_num1() );
		
		//si $sens1 et $sens2 sont different de null, ça veut dire que le parcours existe déjà, et qu'il ne faut pas l'ajouter à nouveau
		if ( $sens1 != null and $sens2 != null) 
		{
			return null; 
			//on quitte sans ajouter de parcours
		}
		
		$requete = $this->db->prepare(
		'INSERT INTO parcours (par_km, vil_num1, vil_num2) VALUES (:km, :vil_num1, :vil_num2);');
		//var_dump($parcours->getParKm());
		$requete->bindValue(':km',$parcours->getParKm());
		$requete->bindValue(':vil_num1',$parcours->getVil_num1());
		$requete->bindValue(':vil_num2',$parcours->getVil_num2());
		
		$retour = $requete->execute();
		//var_dump($retour);
		return $retour;
	}

	// A TESTER
	public function getVilNum1et2VerifParcours($vil_num1, $vil_num2) 
	{
		//On selectionne tous les parcours ayant pour départ vil_num1 et arrivée vil_num2
		$sql = "SELECT par_num, par_km, vil_num1, vil_num2 FROM parcours WHERE vil_num1=:vil_num1 AND vil_num2=:vil_num2";
		$requete = $this->db->prepare($sql);
		$requete->bindValue(":vil_num1", $vil_num1);
		$requete->bindValue(":vil_num2", $vil_num2);
		
		$requete->execute();
		
		$resultat = $requete->fetch(PDO::FETCH_OBJ);
		
		if ($resultat != null) //Le parcours existe déjà
		{
			return $resultat;
			// Il s'agit d'un objet !!
		}
		else
		{
			return null;
			//Le parcours n'a pas été trouvé, il n'existe donc pas
		}
	}
	
	// A FAIRE
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
	
	// A TESTER
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