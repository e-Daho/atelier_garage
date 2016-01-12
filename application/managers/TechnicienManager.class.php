<?php
class TechnicienManager
{
	private $_db;

	const ACTION_REUSSIE = 1;
	const ACTION_ECHOUEE = 0;

	public function __construct($db){$this->setDb($db);}
	
	public function setDb($db){$this->_db = $db;}

	public function add(Technicien $technicien)
	{
		$q = $this->_db->prepare('INSERT INTO technicien SET numero = :numero, nom = :nom, prenom = :prenom');

		$q->bindValue(':numero',$technicien->numero(),PDO::PARAM_INT);
		$q->bindValue(':nom',$technicien->nom(),PDO::PARAM_STR);
		$q->bindValue(':prenom',$technicien->prenom(),PDO::PARAM_STR);
		
		$q->execute();
		
		return self::ACTION_REUSSIE;
	}

	public function count()
	{
		return $this->_db->query('SELECT COUNT(*) FROM technicien')->fetchColumn();
	}

	public function delete(Technicien $technicien)
	{
		$q = $this->_db->prepare('DELETE FROM technicien WHERE numero = :numero');
		$q->execute([':numero' => $technicien->numero()]);
		return self::ACTION_REUSSIE;
	}

	public function exists(Technicien $technicien)
	{    
		$q = $this->_db->prepare('SELECT COUNT(*) FROM technicien WHERE numero = :numero');
		$q->execute([':numero' => $technicien->numero()]);
    
		return (bool) $q->fetchColumn();
	}

  
	public function get($numero)
	{
		$q = $this->_db->prepare('SELECT numero, nom, prenom FROM technicien WHERE numero = :numero');	
		$q->execute([':numero' => $numero]);

		$technicien = $q->fetch(PDO::FETCH_ASSOC);
		
		return new Technicien($technicien);
	}
	
  
	public function update(Technicien $technicien)
	{
		if($this->exists($technicien))
		{
			$q = $this->_db->prepare('UPDATE technicien SET nom = :nom, prenom = :prenom WHERE numero = :numero');
		    
			$q->bindValue(':nom',$technicien->nom(),PDO::PARAM_STR);
			$q->bindValue(':prenom',$technicien->prenom(),PDO::PARAM_STR);
			$q->bindValue(':numero',$technicien->numero(),PDO::PARAM_INT);
		    
			$q->execute();
			return self::ACTION_REUSSIE;
		}
		else
		{
			return self::ACTION_ECHOUEE;
		}
	}
}
