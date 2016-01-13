<?php
class RepareManager
{
	private $_db;

	const ACTION_REUSSIE = 1;
	const ACTION_ECHOUEE = 0;

	public function __construct($db){$this->setDb($db);}
	
	public function setDb($db){$this->_db = $db;}

	# prend une repare en argument, retourne 1
	public function add(Repare $repare)
	{
		$q = $this->_db->prepare('INSERT INTO repare SET technicien = :technicien, voiture = :voiture, idFacture = :idFacture, dateDebut= :dateDebut, dateFin = :dateFin');

		$q->bindValue(':technicien',$repare->technicien(),PDO::PARAM_INT);
		$q->bindValue(':voiture',$repare->voiture(),PDO::PARAM_STR);
		$q->bindValue(':idFacture',$repare->idFacture(),PDO::PARAM_INT);
		$q->bindValue(':dateDebut',$repare->dateDebut(),PDO::PARAM_STR);
		$q->bindValue(':dateFin',$repare->dateFin(),PDO::PARAM_STR);
		
		$q->execute();
		
		return self::ACTION_REUSSIE;
	}
	
	# retourne le nombre de repares en bdd (int)
	public function count()
	{
		return $this->_db->query('SELECT COUNT(*) FROM repare')->fetchColumn();
	}
	
	# prend une repare en argument, retourne 1 si l'action est réussie
	public function delete(Repare $repare)
	{
		$q = $this->_db->prepare('DELETE FROM repare WHERE (technicien = :technicien AND voiture = :voiture)');
		
		$q->bindValue(':technicien',$repare->technicien(),PDO::PARAM_INT);
		$q->bindValue(':voiture',$repare->voiture(),PDO::PARAM_STR);
		
		$q->execute();
		
		return self::ACTION_REUSSIE;
	}

	# prend une repare en argument, retourne un booléen
	public function exists(Repare $repare)
	{    
		$q = $this->_db->prepare('SELECT COUNT(*) FROM repare WHERE (technicien = :technicien AND voiture = :voiture)');
		
		$q->bindValue(':technicien',$repare->technicien(),PDO::PARAM_INT);
		$q->bindValue(':voiture',$repare->voiture(),PDO::PARAM_STR);
		
		$q->execute();
    
		return (bool) $q->fetchColumn();
	}

  	# prend un technicien et une voiture en argument, retourne une repare si elle existe
	public function get($technicien, $voiture)
	{
		$q = $this->_db->prepare('SELECT technicien, voiture, idFacture, dateDebut, dateFin FROM repare WHERE (technicien = :technicien AND voiture = :voiture)');
			
		$q->bindValue(':technicien',$technicien,PDO::PARAM_INT);
		$q->bindValue(':voiture',$voiture,PDO::PARAM_STR);
		
		$q->execute();

		$repare = $q->fetch(PDO::FETCH_ASSOC);
		
		return empty($repare) ? null : new Repare($repare);
	}
  
	# retourne untableau de repares
	/*public function getList($technicien, $voiture, $idFacture, $dateDebut, $dateFin, $date_arrivee, $proprietaire, $reparateur)
	{
		$repares = [];
		
		$bonus = ($reparateur == '%') ? 'OR (re.technicien IS NULL)' : '';
		
		$q = $this->_db->prepare('
			SELECT vo.technicien, vo.voiture, vo.idFacture, vo.dateDebut, vo.dateFin, vo.date_arrivee, vo.proprietaire, IFNULL(re.technicien,\'done\')
			FROM repare vo LEFT JOIN repare re ON vo.technicien = re.repare
			WHERE vo.technicien LIKE :technicien
			AND vo.voiture LIKE :voiture
			AND vo.idFacture LIKE :idFacture 
			AND vo.dateDebut LIKE :dateDebut 
			AND vo.dateFin LIKE :dateFin 
			AND vo.date_arrivee LIKE :date_arrivee  
			AND vo.proprietaire LIKE :proprietaire
			AND ((re.technicien LIKE :technicien) '.$bonus.')
			ORDER BY date_arrivee DESC
');


    		$q->bindParam(':technicien', $technicien, PDO::PARAM_STR);
    		$q->bindParam(':voiture', $voiture, PDO::PARAM_STR);
		$q->bindParam(':idFacture', $idFacture, PDO::PARAM_STR);
		$q->bindParam(':dateDebut', $dateDebut, PDO::PARAM_INT);
		$q->bindParam(':dateFin', $dateFin, PDO::PARAM_STR); 
		$q->bindParam(':date_arrivee', $date_arrivee,PDO::PARAM_INT);
		$q->bindParam(':proprietaire', $proprietaire, PDO::PARAM_INT);  
		$q->bindParam(':technicien', $reparateur, PDO::PARAM_INT);   
		$q->execute();
	    
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			$repares[] = new Repare($donnees); 
		}
		return $repares;
	}*/
	
  	# prend une repare en argument, retourne 1 si l'action est réussie, 0 sinon
	public function update(Repare $repare)
	{
		if($this->exists($repare))
		{
			$q = $this->_db->prepare('UPDATE repare SET idFacture = :idFacture, dateDebut= :dateDebut, dateFin = :dateFin WHERE (technicien = :technicien AND voiture = :voiture)');
		    
			$q->bindValue(':idFacture',$repare->idFacture(),PDO::PARAM_INT);
			$q->bindValue(':dateDebut',$repare->dateDebut(),PDO::PARAM_STR);
			$q->bindValue(':dateFin',$repare->dateFin(),PDO::PARAM_STR);
			$q->bindValue(':voiture',$repare->voiture(),PDO::PARAM_STR);
			$q->bindValue(':technicien',$repare->technicien(),PDO::PARAM_INT);
			
			$q->execute();
			
			return self::ACTION_REUSSIE;
		}
		else
		{
			return self::ACTION_ECHOUEE;
		}
	}
}
