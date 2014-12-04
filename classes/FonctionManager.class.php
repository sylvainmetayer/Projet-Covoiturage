<?php
class FonctionManager{
	public function __construct($db)
	{
		$this->db = $db;
	}

	// A TESTER
	public function add($fonction)
	{
		$requete = $this->db->prepare(
		'INSERT INTO FONCTION (fon_libelle) VALUES (:fon_libelle);');
		
		$requete->bindValue(':fon_libelle',$fonction->getFonLibelle());
		
		$retour = $requete->execute();
		return $retour;
	}
	
	// A TESTER
	public function getAllFonctions()
	{
		$listeFonction = array(); //tableau d'objet
		
		$sql = 'SELECT fon_libelle, fon_num FROM FONCTION';
		$requete = $this->db->prepare($sql);
		$requete->execute();
		while ($fon_libelle = $requete->fetch(PDO::FETCH_OBJ))
		{
			$listeFonction[] = new fonction ($fon_libelle);
		}
		return $listeFonction;
		$requete->closeCursor();
	}
	
	// Pour obtenir une fonction en particulier
	// A TESTER
	public function getDetailsFonction($idFonction) 
	{
		$sql = 'SELECT fon_num, fon_libelle FROM FONCTION WHERE fon_num='.$idFonction.'';
		$requete = $this->db->prepare($sql);
		$requete->execute();
		$resultat = $requete->fetch(PDO::FETCH_OBJ);
		$requete->closeCursor();
		if ($resultat != null)
		{
			return new Fonction($resultat);
			// on retourne un objet Fonction
		}
		else
		{
			//Fonction demandée non trouvée
			return null;
		}
	}
}
?>	