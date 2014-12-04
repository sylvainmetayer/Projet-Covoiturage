<?php
class EtudiantManager
{
	private $db;
	
	public function __construct($db)
	{
		$this->db = $db;
	}

	//$etudiant, c'est un objet de type etudiant qu'on va lui passer
	//$id, c'est l'id de la personne ajoutée, qui va servir à faire le lien.
	// A TESTER, PAS GARANTI QUE CA MARCHE
	public function add($etudiant, $idPersonne)
	{
		//var_dump($etudiant);
		$requete = $this->db->prepare(
		'INSERT INTO ETUDIANT (per_num, dep_num, div_num ) VALUES (:per_num, :dep_num, :div_num);');
		//(SELECT per_num FROM personne WHERE per_num = pdo.lastInsertId()), :dep, :div);');
		$requete->bindValue(':per_num',$idPersonne);
		$requete->bindValue(':dep_num',$etudiant->getDepNum());
		$requete->bindValue(':div_num',$etudiant->getDivNum());
		//var_dump($requete);
		$retour = $requete->execute();
		return $retour;
	}	
	
	// A TESTER
	public function getAllEtudiant() 
	{
		$listeEtudiants = array(); //tableau d'objet
		
		$sql='SELECT per_num, dep_num, div_num FROM ETUDIANT ORDER BY per_num';
		$requete=$this->db->prepare($sql);
		$requete->execute();
		
		while($etudiant=$requete->fetch(PDO::FETCH_OBJ))
		{
			$listeEtudiants[]=new Etudiant($etudiant);
		}
		$requete->closeCursor();
		return $listeEtudiants;
	}
	
	public function getNbEtudiants()
	{
	
		$sql = 'select * from etudiant';
		$requete = $this->db->prepare($sql);
		$requete->execute();
		while ($etudiants = $requete->fetch(PDO::FETCH_OBJ))
		{
			$sql=$sql+1;
		}
		$requete->closeCursor();
		return $sql;
	}
	
	public function getEtudiant($per_num){
		$sql = 'select * from etudiant e, division di,departement de, personne p,ville v
		where de.dep_num=e.dep_num and e.div_num=di.div_num and e.per_num=p.per_num and de.vil_num=v.vil_num';
		$requete = $this->db->prepare($sql);
		$requete->execute();
		$donnees= $requete->fetch(PDO::FETCH_ASSOC);
		$etudiant=new Etudiant($donnees);
		$requete->closeCursor();
		return $etudiant;
	}
	
	// A TESTER
	//per_num, dep_num, div_num
	public function modifierEtudiant($etudiant, $idPersonne) {
		$requete = $this->db->prepare ( 'UPDATE etudiant SET div_num=\':div_num\', dep_num=\':dep_num\'
		WHERE per_num = :per_num' );
	
		$requete->bindValue ( ':div_num', $etudiant->getDivNum());
		$requete->bindValue ( ':dep_num', $etudiant->getDepNum() );
		$requete->bindValue ( ':per_num', $idPersonne ); // permet de modifier la bonne personne
	
		$retour = $requete->execute ();
		return $retour;
	}
}