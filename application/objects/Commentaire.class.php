<?php
class Commentaire
{
	private $_voiture;
	private $_technicien;
	private $_date;
	private $_texte;

	public function __construct(array $donnees){$this->hydrate($donnees);}
	
	public function hydrate(array $donnees)
	{
		foreach($donnees as $key => $value)
		{
			$method='set'.ucfirst($key);
			if(method_exists($this,$method))
				$this->$method($value);
		}
	}	

	public function voiture(){return $this->_voiture;}
	public function technicien(){return $this->_technicien;}
	public function date(){return $this->_date;}
	public function texte(){return $this->_texte;}

	public function setNumero($voiture){$this->_voiture = $voiture;}
	public function setNom($technicien){$this->_technicien = $technicien;}
	public function setPrenom($date){$this->_date = $date;}
	public function setNombre($texte){$this->_texte = $texte;}
}
?>
