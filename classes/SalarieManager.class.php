<?php
class SalarieManager {
	public function __construct($db) {
		$this->db = $db;
	}
	
	// $salarie, c'est un objet de type etudiant qu'on va lui passer
	// $id, c'est l'id de la personne ajoutée, qui va servir à faire le lien.
	public function add($salarie, $idPersonne) {
		$requete = $this->db->prepare ( 'INSERT INTO SALARIE (per_num, sal_telprof, fon_num ) VALUES (:per_num, :sal_telprof, :fon_num);' );
		$requete->bindValue ( ':per_num', $idPersonne );
		$requete->bindValue ( ':sal_telprof', $salarie->getSalTelProf () );
		$requete->bindValue ( ':fon_num', $salarie->getFonNum () );
		
		$retour = $requete->execute ();
		return $retour;
	}
	public function getAllSalarie() {
		$listeSalaries = array (); // tableau d'objet
		
		$sql = 'SELECT per_num, sal_telprof, fon_num FROM SALARIE ORDER BY per_num';
		$requete = $this->db->prepare ( $sql );
		$requete->execute ();
		
		while ( $salarie = $requete->fetch ( PDO::FETCH_OBJ ) ) {
			$listeSalaries [] = new Salarie ( $salarie );
		}
		$requete->closeCursor ();
		return $listeSalaries;
	}
	public function getSalarie($per_num) {
		$sql = 'select * from salarie s,personne p,fonction f
		where s.per_num=p.per_num and s.fon_num=f.fon_num';
		$requete = $this->db->prepare ( $sql );
		$requete->execute ();
		$donnees = $requete->fetch ( PDO::FETCH_ASSOC );
		$requete->closeCursor ();
		return new Salarie ( $donnees );
	}
}