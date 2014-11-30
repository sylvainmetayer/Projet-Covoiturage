<?php
class ProposeManager{
	private $db;
	
	public function __construct($db) {
		$this->db=$db;
	}
	
	public function add($propose) {
		$requete = $this->db->prepare (
		'INSERT INTO PROPOSE (par_num, per_num, pro_date, pro_time, pro_place, pro_sens) VALUES (:par_num, :per_num , :pro_date, :pro_time, :pro_place, :pro_sens);');
		$requete->bindValue(':par_num', $propose->getParNum());
		$requete->bindValue(':per_num', $propose->getPerNum());
		$requete->bindValue(':pro_date', ($propose->getDate()));
		$requete->bindValue(':pro_time', $propose->getTime());
		$requete->bindValue(':pro_place', $propose->getPlace());
		$requete->bindValue(':pro_sens', $propose->getSens());
		
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

}