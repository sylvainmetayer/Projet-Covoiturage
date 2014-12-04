<?php
class DepartementManager{

	private $db;
	
	public function __construct($db)
	{
		$this->db = $db;
	}

	// A TESTER
	public function add($departement)
	{
		$requete = $this->db->prepare(
		'INSERT INTO DEPARTEMENT (dep_nom) VALUES (:dep_nom);');
		
		$requete->bindValue(':div_nom',$division->getDepNom());
		
		$retour = $requete->execute();
		return $retour;
	}
	
	// A TESTER
	public function getAllDepartements()
	{
		$listeDepartement = array(); //tableau d'objet
		
		$sql = 'SELECT dep_num, dep_nom FROM DEPARTEMENT';
		$requete = $this->db->prepare($sql);
		$requete->execute();
		while ($dep_nom = $requete->fetch(PDO::FETCH_OBJ))
		{
			$listeDepartement[] = new departement ($dep_nom);
		}
		return $listeDepartement;
		$requete->closeCursor();
	}
	
	// Pour obtenir un departement en particulier
	// A TESTER
	public function getDetailsDepartement($idDepartement) 
	{
		$sql = 'SELECT dep_num, dep_nom, vil_num FROM DEPARTEMENT WHERE dep_num='.$idDepartement.'';
		$requete = $this->db->prepare($sql);
		$requete->execute();
		$resultat = $requete->fetch(PDO::FETCH_OBJ);
		$requete->closeCursor();
		if ($resultat != null)
		{
			return new Departement($resultat);
			// on retourne un objet !!
		}
		else
		{
			//Departement demandé non trouvée
			return null;
		}
	}
}
?>