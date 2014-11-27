<?php
class FonctionManager{
	public function __construct($db)
	{
		$this->db = $db;
	}

	public function add($fonction)
	{
		$requete = $this->db->prepare(
		'INSERT INTO FONCTION (fon_libelle) VALUES (:fon_libelle);');
		
		$requete->bindValue(':fon_libelle',$fonction->getFonLibelle());
		
		$retour = $requete->execute();
		return $retour;
	}
	
	public function getAllFonctions()
	{
		$listeFonction = array(); //tableau d'objet
		
		$sql = 'SELECT fon_libelle, fon_num FROM FONCTION';
		$requete = $this->db->prepare($sql);
		$requete->execute();
		while ($fon_libelle = $requete->fetch(PDO::FETCH_OBJ))
		{
			$listeFonction[] = new fonction ($fon_libelle);
		}
		return $listeFonction;
		$requete->closeCursor();
	}
}
?>	