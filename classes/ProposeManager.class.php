<?php
class ProposeManager{
	private $db;
	
	public function __construct($db) {
		$this->db=$db;
	}
	
	//OK
	public function add($propose) {
		
		$myDateTime = DateTime::createFromFormat('d-m-Y', $propose->getDate());
		//$dateString = $myDateTime->date;
		//var_dump($myDateTime);
		$requete = $this->db->prepare (
		'INSERT INTO PROPOSE (par_num, per_num, pro_date, pro_time, pro_place, pro_sens) 
				VALUES (:par_num, :per_num , :pro_date, :pro_time, :pro_place, :pro_sens);');
		$requete->bindValue(':par_num', $propose->getParNum());
		$requete->bindValue(':per_num', $propose->getPerNum());
		$requete->bindValue(':pro_date', ($myDateTime->format('d-m-Y')));
		$requete->bindValue(':pro_time', $propose->getTime());
		$requete->bindValue(':pro_place', $propose->getPlace());
		$requete->bindValue(':pro_sens', $propose->getSens());

		//var_dump($requete);
		
		$retour=$requete->execute();
		return $retour;
	}
	
	public function getAllPropose() {
		$listePropose = array();
		
		$sql='SELECT par_num, per_num, pro_date, pro_time, pro_place, pro_sens FROM PROPOSE ORDER BY par_num';
		$requete=$this->db->prepare($sql);
		$requete->execute();
		
		while($propose=$requete->fetch(PDO::FETCH_OBJ)) 
		{
			$listePropose[]=new Propose($propose);
		}
		
		$requete->closeCursor();
		return $listePropose;
	}
	
	//Retourne true si la date est correcte (c'est a dire superieure ou egal a la date  du jour)
	// sinon false (date inferieure a la date du jour
	//La fonction de controle de date ne marche pas.
	public function CtrlDate($date) {
		// date à tester
		$date = date('Y-m-d'); 
		$now = new DateTime(); //Date du jour 
		$now = $now->format('Y-m-d');
		
		//$date = new DateTime( $date );
		$date = new Date($date);
		$date = $date->format('Y-m-d');
		
		// Controle que la date propose est egale ou supérieure à la date du jour		
		if( $now <= $date ) {
			//Correct, la date du jour est inferieure ou egale a la date propose
			return true;
		}
		else { 
			//la date proposée est inferieure a la date du jour
			return false;	
		}
		
	}
	
}