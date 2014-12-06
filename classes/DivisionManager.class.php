<?php
class DivisionManager {
	public function __construct($db) {
		$this->db = $db;
	}
	public function add($division) {
		$requete = $this->db->prepare ( 'INSERT INTO DIVISION (div_nom) VALUES (:div_nom);' );
		
		$requete->bindValue ( ':div_num', $division > getDivNom () );
		
		$retour = $requete->execute ();
		return $retour;
	}
	public function getAllDivisions() {
		$listeDivision = array (); // tableau d'objet
		
		$sql = 'SELECT div_num, div_nom FROM DIVISION';
		$requete = $this->db->prepare ( $sql );
		$requete->execute ();
		while ( $div_nom = $requete->fetch ( PDO::FETCH_OBJ ) ) {
			$listeDivision [] = new division ( $div_nom );
		}
		return $listeDivision;
		$requete->closeCursor ();
	}
	
	// Pour obtenir une division en particulier
	public function getDetailsDivision($idDivision) {
		$sql = 'SELECT div_num, div_nom FROM DIVISION WHERE div_num=' . $idDivision . '';
		$requete = $this->db->prepare ( $sql );
		$requete->execute ();
		$resultat = $requete->fetch ( PDO::FETCH_OBJ );
		$requete->closeCursor ();
		if ($resultat != null) {
			return new Division ( $resultat );
			// on retourne un objet Division
		} else {
			// Division demandée non trouvée
			return null;
		}
	}
}