<?php
class Salarie{
	private $per_num;
	private $sal_telprof;
	private $fon_num;
	
	public function __construct ($valeurs = array())
	{
		if (!empty($valeurs))
		{
			$this->affecte($valeurs);
		}
	}
	
	public function affecte($donnees)
	{
		foreach ($donnees as $attribut => $valeurs)
		{
			switch ($attribut)
			{
				case 'per_num' : $this->setPerNum($valeurs); break;
				case 'sal_telprof' : $this->setSal_TelProf($valeurs); break;
				case 'fon_num' : $this->setFonNum($valeurs); break;
			}
		}
	}
	
	//GETTER - SETTER 
	public function setPerNum($per_num)
	{
		$this->per_num = $per_num;
	}
	
	public function setSal_TelProf($sal_telprof)
	{
		$this->sal_telprof = $sal_telprof;
	}
	
	public function setFonNum($fon_num)
	{
		$this->fon_num = $fon_num;
	}
	
	public function getPerNum()
	{
		return $this->per_num ;
	}
	
	public function getSal_TelProf()
	{
		return $this->sal_telprof ;
	}
	
	public function getFonNum()
	{
		return $this->fon_num ;
	}
	
	
}