<?php
class VilleManager{

	private $db;
	
	public function __construct($db)
	{
		$this->db = $db;
	}

	public function add($ville)
	{
		$requete = $this->db->prepare(
		'INSERT INTO ville (vil_nom) VALUES (:ville);');
		$requete->bindValue(':ville',$ville->getVilleNom());
		
		$retour = $requete->execute();
		return $retour;
	}
	
	public function getAllVille()
	{
		$listeVille = array(); //tableau d'objet
		
		$sql = 'SELECT vil_num, vil_nom FROM ville';
		$requete = $this->db->prepare($sql);
		$requete->execute();
		while ($nom_vil = $requete->fetch(PDO::FETCH_OBJ))
		{
			$listeVille[] = new ville ($nom_vil);
		}
		//var_dump($listeVille);
		return $listeVille;
		$requete->closeCursor();
	}
	
	// A REFAIRE
	public function getNbVille()
	{
		$sql = 'SELECT * FROM VILLE';
		$requete = $this->db->prepare($sql);
		$requete->execute();
		while ($nom_vil = $requete->fetch(PDO::FETCH_OBJ))
		{
			$sql = $sql +1;
		}
		$requete->closeCursor();
		return $sql;
		
	}
	
	public function getNomVille($numVille)
	{
		$sql = 'SELECT vil_nom FROM VILLE where vil_num='.$numVille.'';
		//echo $sql;
		$requete = $this->db->prepare($sql);
		$requete->execute();
		
		$resultat=$requete->fetch(PDO::FETCH_OBJ);
		//var_dump($resultat);
		$requete->closeCursor();
		return $resultat;
	}
}
?>