<?php
class ProposeManager{
	private $db;
	
	public function __construct($db) {
		$this->db=$db;
	}
	
	//OK
	public function add($propose) {
		
		$myDateTime = DateTime::createFromFormat('d-m-Y', $propose->getDate());
		var_dump($myDateTime);
		$requete = $this->db->prepare (
		'INSERT INTO PROPOSE (par_num, per_num, pro_date, pro_time, pro_place, pro_sens) 
				VALUES (:par_num, :per_num , :pro_date, :pro_time, :pro_place, :pro_sens);');
		$requete->bindValue(':par_num', $propose->getParNum());
		$requete->bindValue(':per_num', $propose->getPerNum());
		$requete->bindValue(':pro_date', ($myDateTime->date));
		$requete->bindValue(':pro_time', $propose->getTime());
		$requete->bindValue(':pro_place', $propose->getPlace());
		$requete->bindValue(':pro_sens', $propose->getSens());

		var_dump($requete);
		
		$retour=$requete->execute();
		return $retour;
	}
	
	// A TESTER - Vraiment utile ?
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
	
}