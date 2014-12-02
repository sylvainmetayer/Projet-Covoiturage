<?php
class PersonneManager {
	private $db;
	public function __construct($db) {
		$this->db = $db;
	}
	
	// Cette fonction va ajouter une personne, puis retourner l'id de la personne ajouté, ce qui permettra de faire l'ajout de l'étudiant/salarié
	// A TESTER
	public function add($personne) {
		$requete = $this->db->prepare ( 'INSERT INTO personne (per_nom, per_prenom, per_tel, per_mail, per_login, per_pwd) VALUES (:nom, :prenom, :tel, :mail, :login, :pwd);' );
		
		$requete->bindValue ( ':nom', $personne->getNomPersonne () );
		$requete->bindValue ( ':prenom', $personne->getPrenomPersonne () );
		$requete->bindValue ( ':tel', $personne->getPerTel () );
		$requete->bindValue ( ':mail', $personne->getPerMail () );
		$requete->bindValue ( ':login', $personne->getPerLogin () );
		$requete->bindValue ( ':pwd', $personne->getPerPwd () );
		
		$retour = $requete->execute ();
		return $this->db->lastInsertId ();
		// Pour ajouter par la suite un etudiant/salarié
	}
	
	// A TESTER
	public function getAllPersonnes() {
		$listePersonne = array ();
		
		$sql = 'SELECT per_num, per_nom, per_prenom FROM personne ';
		$requete = $this->db->prepare ( $sql );
		$requete->execute ();
		while ( $personne_donnees = $requete->fetch ( PDO::FETCH_OBJ ) ) {
			$listePersonne [] = new Personne ( $personne_donnees );
		}
		return $listePersonne;
		$requete->closeCursor ();
	}
	
	// A TESTER
	public function modifierPersonne($personne) {
		$requete = $this->db->prepare ( 'UPDATE personne SET per_prenom= \':prenom\', per_nom\':nom\', 
		per_tel=\':tel\', per_mail=\':mail\', 
		per_pwd=\':pwd\', per_login=\':login\' 
		WHERE per_num = :per_num' );
		
		$requete->bindValue ( ':nom', $personne->getNomPersonne () );
		$requete->bindValue ( ':prenom', $personne->getPrenomPersonne () );
		$requete->bindValue ( ':tel', $personne->getPerTel () );
		$requete->bindValue ( ':mail', $personne->getPerMail () );
		$requete->bindValue ( ':login', $personne->getPerLogin () );
		$requete->bindValue ( ':pwd', $personne->getPerPwd () );
		// POUR GERER LE TYPE DE PERSONNE
		// Reprendre comme l'ajout d'une personne, c'est à dire diviser en deux requete, une pour la personne, et une pour l'étudiant/salarié
		$requete->bindValue ( ':per_num', $personne->getPerNum () ); // permet de modifier la bonne personne
		
		$retour = $requete->execute ();
		return $personne->getPerNum (); // pour récupérer l'id de l'étudiant/salarié à modifier
	}
	
	// A TESTER
	public function supprimerPersonne($personne) {
		$requete = $this->db->prepare ( 'DELETE FROM personne WHERE per_num = :per_num' );
		
		$requete->bindValue ( ':per_num', $personne->getPerNum () );
		
		$retour = $requete->execute ();
		return $retour;
	}
	
	// Incomplet
	// CF EN BAS
	public function getDetailsEtudiant($personne) {
		// Inutile, car une seule ligne de retourné ? $listePersonne = array();
		$sql = 'SELECT per_num, per_nom, per_prenom, per_mail, per_tel, vil_nom FROM personne p 
		INNER JOIN etudiant e ON e.per_num=p.per_num
		INNER JOIN departement d ON d.dep_num=e.dep_num
		INNER JOIN ville v ON v.vil_num=d.vil_num
		WHERE per_num=:per_num';
		
		$requete = $this->db->prepare ( $sql );
		
		$requete->bindValue ( ':per_num', $personne->getPerNum () );
		
		$requete->execute ();
		
		// Pas besoin de while, puisque que l'on sait qu'il n'y a qu'une seule ligne de retourné
		$personne_donnees = $requete->fetch ( PDO::FETCH_OBJ );
		// PROBLEME
		$listePersonne = new Personne ( $personne_donnees );
		// Manque le fait de mettre la ville !
		$personne_donnees->closeCursor ();
		return $listePersonne;
	}
	
	// Incomplet
	// A mettre dans SALARIE
	public function getDetailsSalarie($personne) {
		$sql = 'SELECT per_num, per_nom, per_prenom, per_mail, per_tel, sal_telpro, fon_libelle FROM personne p 
		INNER JOIN salarie s ON s.per_num=s.per_num
		INNER JOIN fonction f ON f.fon_num=s.fon_num
		WHERE per_num=:per_num';
		
		$requete = $this->db->prepare ( $sql );
		
		$requete->bindValue ( ':per_num', $personne->getPerNum () );
		
		$requete->execute ();
		
		// Pas besoin de while, puisque que l'on sait qu'il n'y a qu'une seule ligne de retourné
		$personne_donnees = $requete->fetch ( PDO::FETCH_OBJ );
		
		$listePersonne = new Personne ( $personne_donnees );
		// Manque le fait de mettre le telephone pro et la fonction !
		$listePersonne->closeCursor ();
		return $listePersonne;
	}
}