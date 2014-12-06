<?php
class VilleManager {
	private $db;
	public function __construct($db) {
		$this->db = $db;
	}
	public function add($ville) {
		$testVille = $this->VerifVille ( $ville->getVilleNom () );
		
		if ($testVille != null) { // la ville existe déjà
			return null;
			// on quitte sans ajouter de ville
		}
		
		$requete = $this->db->prepare ( 'INSERT INTO ville (vil_nom) VALUES (:ville);' );
		$requete->bindValue ( ':ville', $ville->getVilleNom () );
		
		$retour = $requete->execute ();
		return $retour;
	}
	public function VerifVille($vil_nom) {
		$sql = "SELECT vil_num, vil_nom FROM ville WHERE vil_nom=:vil_nom ";
		$requete = $this->db->prepare ( $sql );
		$requete->bindValue ( ":vil_nom", $vil_nom );
		
		$requete->execute ();
		
		$resultat = $requete->fetch ( PDO::FETCH_OBJ );
		
		if ($resultat != null) // La ville existe déjà
{
			return new Ville ( $resultat );
			// Il s'agit d'un objet Ville
		} else {
			return null;
			// La ville n'a pas été trouvée, elle n'existe donc pas
		}
	}
	public function getAllVille() {
		$listeVille = array (); // tableau d'objet
		
		$sql = 'SELECT vil_num, vil_nom FROM ville';
		$requete = $this->db->prepare ( $sql );
		$requete->execute ();
		while ( $nom_vil = $requete->fetch ( PDO::FETCH_OBJ ) ) {
			$listeVille [] = new ville ( $nom_vil );
		}
		// var_dump($listeVille);
		return $listeVille;
		$requete->closeCursor ();
	}
	public function getNomVille($numVille) {
		$sql = 'SELECT vil_nom FROM VILLE where vil_num=' . $numVille . '';
		// echo $sql;
		$requete = $this->db->prepare ( $sql );
		$requete->execute ();
		
		$resultat = $requete->fetch ( PDO::FETCH_OBJ );
		// var_dump($resultat);
		$requete->closeCursor ();
		return new Ville ( $resultat );
	}
	public function getVilleParId($idVille) {
		$sql = "SELECT vil_num, vil_nom FROM ville WHERE vil_num=:vil_num";
		$requete = $this->db->prepare ( $sql );
		$requete->bindValue ( ':vil_num', $idVille );
		
		$requete->execute ();
		$resultat = $requete->fetch ( PDO::FETCH_OBJ );
		
		if ($resultat != null) {
			return new Ville ( $resultat );
			// On retourne un objet Ville
		} else {
			return null;
		}
		$requete->closeCursor ();
	}
}
?>