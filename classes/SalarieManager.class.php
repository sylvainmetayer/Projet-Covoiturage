<?php
class SalarieManager{

	public function __construct($db)
	{
		$this->db = $db;
	}

	//Ne marche probablement pas
	public function add($salarie)
	{
		$requete = $this->db->prepare(
		'INSERT INTO salarie ( per_num, sal_telprof, fon_num ) VALUES (
		(SELECT per_num FROM personne WHERE per_num = pdo.lastInsertId()), :sal_telprof, :fon_num);');
		
		$requete->bindValue(':sal_telprof',$salarie>getSal_TelProf());
		$requete->bindValue(':fon_num',$salarie->getFonNum();
		
		$retour = $requete->execute();
		return $retour;
	}
	
}