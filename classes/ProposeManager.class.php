<?php
class ProposeManager {
	private $db;
	public function __construct($db) {
		$this->db = $db;
	}
	
	// OK
	public function add($propose) {
		$myDateTime = DateTime::createFromFormat ( 'd-m-Y', $propose->getDate () );
		// $dateString = $myDateTime->date;
		// var_dump($myDateTime);
		$requete = $this->db->prepare ( 'INSERT INTO PROPOSE (par_num, per_num, pro_date, pro_time, pro_place, pro_sens) 
				VALUES (:par_num, :per_num , :pro_date, :pro_time, :pro_place, :pro_sens);' );
		$requete->bindValue ( ':par_num', $propose->getParNum () );
		$requete->bindValue ( ':per_num', $propose->getPerNum () );
		$requete->bindValue ( ':pro_date', ($myDateTime->format ( 'd-m-Y' )) );
		$requete->bindValue ( ':pro_time', $propose->getTime () );
		$requete->bindValue ( ':pro_place', $propose->getPlace () );
		$requete->bindValue ( ':pro_sens', $propose->getSens () );
		
		// var_dump($requete);
		
		$retour = $requete->execute ();
		return $retour;
	}
	public function getAllPropose() {
		$listePropose = array ();
		
		$sql = 'SELECT par_num, per_num, pro_date, pro_time, pro_place, pro_sens FROM PROPOSE ORDER BY par_num';
		$requete = $this->db->prepare ( $sql );
		$requete->execute ();
		
		while ( $propose = $requete->fetch ( PDO::FETCH_OBJ ) ) {
			$listePropose [] = new Propose ( $propose );
		}
		
		$requete->closeCursor ();
		return $listePropose;
	}
	
	// Retourne true si la date est correcte (c'est a dire superieure ou egal a la date du jour)
	// sinon false (date inferieure a la date du jour
	// La fonction de controle de date ne marche pas.
	public function CtrlDate($date) {
		// date à tester
		$date = new DateTime ( $date );
		$date = $date->format ( 'Y-m-d' );
		$now = new DateTime (); // Date du jour
		$now = $now->format ( 'Y-m-d' );
		
		// var_dump($now<=$date);
		
		// Controle que la date propose est egale ou supérieure à la date du jour
		if ($now <= $date) {
			// Correct, la date du jour est inferieure ou egale a la date propose
			return true;
		} else {
			// la date proposée est inferieure a la date du jour
			return false;
		}
	}
	public function getAllDeparts() {
		$listeDeparts = array ();
		
		$sql = 'SELECT vil_num, vil_nom FROM Ville v, Propose pr, Parcours pa 
				Where pr.pro_sens = 0
				And pr.par_num = pa.par_num
				And pa.vil_num1 = v.vil_num
				ORDER BY vil_num';
		$requete = $this->db->prepare ( $sql );
		$requete->execute ();
		
		while ( $depart = $requete->fetch ( PDO::FETCH_OBJ ) ) {
			$listeDeparts [] = new Ville ( $depart );
		}
		
		$requete->closeCursor ();
		
		$sql = 'SELECT vil_num, vil_nom FROM Ville v, Propose pr, Parcours pa
				Where pr.pro_sens = 1
				And pr.par_num = pa.par_num
				And pa.vil_num2 = v.vil_num
				ORDER BY vil_num';
		$requete = $this->db->prepare ( $sql );
		$requete->execute ();
		
		while ( $depart = $requete->fetch ( PDO::FETCH_OBJ ) ) {
			$listeDeparts [] = new Ville ( $depart );
		}
		
		$requete->closeCursor ();
		
		return $listeDeparts;
	}
	public function getAllArrive($depart) {
		$listeArrive = array ();
		
		$sql = 'SELECT vil_num, vil_nom FROM Ville v, Propose pr, Parcours pa
				Where pr.pro_sens = 0
				And pr.par_num = pa.par_num
				And pa.vil_num2 = v.vil_num
				And pa.vil_num1 = :vil_num1
				ORDER BY vil_num';
		$requete = $this->db->prepare ( $sql );
		$requete->bindValue ( ":vil_num1", $depart );
		$requete->execute ();
		
		while ( $arrive = $requete->fetch ( PDO::FETCH_OBJ ) ) {
			$listeArrive [] = new Ville ( $arrive );
		}
		
		$requete->closeCursor ();
		
		$sql = 'SELECT vil_num, vil_nom FROM Ville v, Propose pr, Parcours pa
				Where pr.pro_sens = 1
				And pr.par_num = pa.par_num
				And pa.vil_num1 = v.vil_num
				And pa.vil_num2 = :vil_num2
				ORDER BY vil_num';
		$requete = $this->db->prepare ( $sql );
		$requete->bindValue ( ":vil_num2", $depart );
		$requete->execute ();
		
		while ( $arrive = $requete->fetch ( PDO::FETCH_OBJ ) ) {
			$listeArrive [] = new Ville ( $arrive );
		}
		
		$requete->closeCursor ();
		
		return $listeArrive;
	}
	public function getDetailsTrajet($vil_num1, $vil_num2, $date, $precision, $heure) {
		$listeTrajet = array ();
		
		$sql = "SELECT DISTINCT pr.par_num, pr.per_num, pr.pro_date, pr.pro_time, pr.pro_place, pr.pro_sens 
				FROM Ville v, Propose pr, Parcours pa, Personne pe
				Where pa.vil_num1 = :vil_num1
				And pa.vil_num2 = :vil_num2
				And pr.pro_date between ':pro_date' - :precision and ':pro_date' + :precision
				And pr.pro_time >= :pro_time
				ORDER BY par_num";
		$requete = $this->db->prepare ( $sql );
		
		$requete->bindValue ( ":vil_num1", $vil_num1 );
		$requete->bindValue ( ":vil_num2", $vil_num2 );
		$requete->bindValue ( ":pro_date", $date );
		$requete->bindValue ( ":pro_time", $heure );
		$requete->bindValue ( ":precision", $precision );
		
		$requete->execute ();
		
		while ( $trajet = $requete->fetch ( PDO::FETCH_OBJ ) ) {
			$listeTrajet [] = new Propose ( $trajet );
		}
		
		$requete->closeCursor ();
		
		return $listeTrajet;
	}
}
