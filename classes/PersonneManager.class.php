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
		
		$requete->bindValue ( ':per_num', $personne->getPerNum () ); // permet de modifier la bonne personne
		
		$retour = $requete->execute ();
		return $personne->getPerNum (); // pour r�cup�rer l'id de l'étudiant/salarié à modifier
	}
	
	// A TESTER
	public function supprimerPersonne($personne) {
		// $personne ne contient que le per_num de la personne, on a pas besoin de passer par des getter
		if ($this->isEtudiant ( $personne )) {
			$sqlEtudiant = "DELETE FROM etudiant where per_num=:per_num";
			
			$requete = $this->db->prepare ( $sqlEtudiant );
			
			$requete->bindValue ( ':per_num', $personne );
			
			$requete->execute ();
		}
		if ($this->isSalarie ( $personne )) {
			$sqlSalarie = "DELETE FROM salarie where per_num=:per_num";
			
			$requete = $this->db->prepare ( $sqlSalarie );
			
			$requete->bindValue ( ':per_num', $personne );
			
			$requete->execute ();
		}
		// Une fois l'étudiant/salarie supprimé, il faut delete les parcours ou la personne est.
		$sqlPropose = "DELETE FROM propose WHERE per_num=:per_num";
		
		$requete = $this->db->prepare ( $sqlPropose );
		
		$requete->bindValue ( ':per_num', $personne );
		
		$requete->execute ();
		
		// Finalement, on delete la personne
		
		$sql = "DELETE FROM personne WHERE per_num=:per_num";
		
		$requete = $this->db->prepare ( $sql );
		
		$requete->bindValue ( ':per_num', $personne );
		
		$requete->execute ();
	}
	public function getPersonneParId($idPersonne) {
		$sql = "SELECT per_num, per_nom, per_prenom, per_tel, per_mail, per_login, per_pwd FROM personne WHERE per_num=:per_num";
		$requete = $this->db->prepare ( $sql );
		$requete->bindValue ( ':per_num', $idPersonne );
		
		$requete->execute ();
		$resultat = $requete->fetch ( PDO::FETCH_OBJ );
		
		if ($resultat != null) {
			return new Personne ( $resultat );
			// On retourne un objet Personne
		} else {
			return null;
		}
		$requete->closeCursor ();
	}
	public function getPersonneParLogin($login) {
		$sql = "SELECT per_num, per_nom, per_prenom, per_tel, per_mail, per_login, per_pwd FROM personne WHERE per_login=:login";
		$requete = $this->db->prepare ( $sql );
		$requete->bindValue ( ':login', $login );
		
		$nbLignes = $requete->execute ();
		$resultat = $requete->fetch ( PDO::FETCH_OBJ );
		
		if ($resultat != null) {
			return new Personne ( $resultat );
			// On retourne un objet Personne
		} else {
			return null;
		}
	}
	
	// Pour la connexion
	public function testConnexion($login, $mdp) {
		// $sale = sha1( sha1($mdp) . SEL ); le grain de sel, a voir plus tard.
		$sql = "SELECT per_login FROM personne WHERE per_login=:login AND per_pwd=:mdp";
		
		$requete = $this->db->prepare ( $sql );
		$requete->bindValue ( ':login', $login );
		$requete->bindValue ( ':mdp', (sha1 ( sha1 ( $mdp ) . SEL )) );
		//$requete->bindValue ( ':mdp', $mdp );
		
		$requete->execute ();
		$resultat = $requete->fetch ( PDO::FETCH_OBJ );
		
		if ($resultat != NULL) {
			return true;
		} else {
			return false;
		}
	}
	public function isEtudiant($per_num) {
		$requete = $this->db->prepare ( 'select per_num from etudiant where per_num=' . $per_num );
		$retour = $requete->execute ();
		if ($ligne = $requete->fetch ( PDO::FETCH_ASSOC )) {
			$retour = true;
		} else {
			$retour = false;
		}
		$requete->closeCursor ();
		return $retour;
	}
	public function isSalarie($per_num) {
		$requete = $this->db->prepare ( 'select per_num from salarie where per_num=' . $per_num );
		$retour = $requete->execute ();
		if ($ligne = $requete->fetch ( PDO::FETCH_ASSOC )) {
			$retour = true;
		} else {
			$retour = false;
		}
		$requete->closeCursor ();
		return $retour;
	}
}