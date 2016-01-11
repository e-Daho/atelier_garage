<?php
class CommuneManager
{
	private $_db;

	const ACTION_REUSSIE = 1;
	const ACTION_ECHOUEE = 0;

	public function __construct($db){$this->setDb($db);}
	
	public function setDb($db){$this->_db = $db;}

	public function add(Commune $commune)
	{
		$q = $this->_db->prepare('INSERT INTO commune SET nom = :nom, nombre = :nombre');

		$q->bindValue(':nom',$commune->nom(),PDO::PARAM_STR);
		$q->bindValue(':nombre',$commune->nombre(),PDO::PARAM_STR);
		$q->execute();
		return self::ACTION_REUSSIE;
	}

	public function count()
	{
		return $this->_db->query('SELECT COUNT(*) FROM commune')->fetchColumn();
	}

	public function delete(Commune $commune)
	{
		$q = $this->_db->prepare('DELETE FROM commune WHERE nom = :nom');
		$q->execute([':nom' => $commune->nom()]);
		return self::ACTION_REUSSIE;
	}

	public function exists(Commune $commune)
	{    
		$q = $this->_db->prepare('SELECT COUNT(*) FROM commune WHERE nom = :nom');
		$q->execute([':nom' => $commune->nom()]);
    
		return (bool) $q->fetchColumn();
	}

  
	public function get($nom)
	{
		$q = $this->_db->prepare('SELECT nom, nombre FROM commune WHERE nom = :nom');	
		$q->execute([':nom' => $nom]);

		$commune = $q->fetch(PDO::FETCH_ASSOC);
		
		return new Commune($commune);
	}
  
	public function getList()
	{
		$communes = [];
		
		$q = $this->_db->prepare('SELECT * FROM commune');
		$q->execute();
	    
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			$communes[] = new Commune($donnees); 
		}
		return $communes;
	}
	
  
	public function update(Commune $commune)
	{
		if($this->exists($commune))
		{
			$q = $this->_db->prepare('UPDATE commune SET nombre = :nombre WHERE nom = :nom');
		    
			$q->bindValue(':nombre',$commune->nombre(),PDO::PARAM_STR);
			$q->bindValue(':nom',$commune->nom(),PDO::PARAM_STR);
		    
			$q->execute();
			return self::ACTION_REUSSIE;
		}
		else
		{
			return self::ACTION_ECHOUEE;
		}
	}
}
