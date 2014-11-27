<?php
class EtudiantManager{
	private $db;
	
	public function __construct($db)
	{
		$this->db = $db;
	}

	//$etudiant, c'est un objet de type etudiant qu'on va lui passer
	public function add($etudiant)
	{
		$requete = $this->db->prepare(
		'INSERT INTO etudiant (per_num, dep_num, div_num ) VALUES (
		:per_num, :dep_num, :div_num;');
		//(SELECT per_num FROM personne WHERE per_num = pdo.lastInsertId()), :dep, :div);');
		$requete->bindValue(':per_num',$etudiant->getPerNum());
		$requete->bindValue(':dep_num',$etudiant->getDepNum());
		$requete->bindValue(':div_num',$etudiant->getDivNum());
		
		$retour = $requete->execute();
		return $retour;
	}	
}