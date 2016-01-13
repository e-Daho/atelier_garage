<?php
class Facture_InterventionManager
{
	private $_db;

	const ACTION_REUSSIE = 1;
	const ACTION_ECHOUEE = 0;

	public function __construct($db){$this->setDb($db);}
	
	public function setDb($db){$this->_db = $db;}

	public function add(Facture_Intervention $fi)
	{
		$q = $this->_db->prepare('
			INSERT INTO facture_intervention 
			SET idFacture = :idFacture, idIntervention = :idIntervention
		');

		$q->bindValue(':idFacture',$fi->idFacture(),PDO::PARAM_INT);
		$q->bindValue(':idIntervention',$fi->idIntervention(),PDO::PARAM_INT);	
		
		$q->execute();
		
		return self::ACTION_REUSSIE;
	}

	public function count()
	{
		return $this->_db->query('SELECT COUNT(*) FROM facture')->fetchColumn();
	}

	public function delete(Facture_Intervention $fi)
	{
		$q = $this->_db->prepare('
			DELETE FROM facture_intervention 
			WHERE idFacture = :idFacture AND idIntervention = :idIntervention');
		
		$q->bindValue(':idFacture',$fi->idFacture(),PDO::PARAM_INT);
		$q->bindValue(':idIntervention',$fi->idIntervention(),PDO::PARAM_INT);
		
		$q->execute();
		
		return self::ACTION_REUSSIE;
	}

	public function exists(Facture_Intervention $fi)
	{    
		$q = $this->_db->prepare('
			SELECT COUNT(*) 
			FROM facture_intervention 
			WHERE idFacture = :idFacture AND idIntervention = :idIntervention
		');
		
		$q->bindValue(':idFacture',$fi->idFacture(),PDO::PARAM_INT);
		$q->bindValue(':idIntervention',$fi->idIntervention(),PDO::PARAM_INT);

		$q->execute();
    
		return (bool) $q->fetchColumn();
	}
	
	public function get($idFacture, $idIntervention)
	{
		$q = $this->_db->prepare('
			SELECT idFacture, idIntervention
			FROM facture_intervention 
			WHERE idFacture = :idFacture AND idIntervention = :idIntervention
		');

		$q->bindValue(':idFacture',$fi->idFacture(),PDO::PARAM_INT);
		$q->bindValue(':idIntervention',$fi->idIntervention(),PDO::PARAM_INT);

		$facture = $q->fetch(PDO::FETCH_ASSOC);
		
		return empty($facture) ? null : new Facture_Intervention($idFacture, $idIntervention);
	}
	
  
	public function getList($idFacture)
		$factures_details = [];
		
		$q = $this->_db->prepare('
			SELECT idFacture, prixTotal, idIntervention, nom, prix
			FROM (
				SELECT idFacture, prixTotal, idIntervention
				FROM facture INNER JOIN facture_intervention
				WHERE idFacture LIKE :idFacture
			) T 
			INNER JOIN intervention
		');

    		$q->bindParam(':idFacture', $idFacture, PDO::PARAM_INT);
		
			$q->execute();
	    
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			$factures_details[] = new Facture_Detail($donnees); 
		}
		return $factures;
	}

  
	public function update(Facture_Intervention $facture)
	{
		if($this->exists($facture))
		{
			$q = $this->_db->prepare('UPDATE facture SET prixTotal = :prixTotal WHERE idFacture = :idFacture');
		    
			$q->bindValue(':idFacture',$facture->idFacture(),PDO::PARAM_INT);
			$q->bindValue(':prixTotal',$facture->prixTotal(),PDO::PARAM_INT);
			
		    
			$q->execute();
			return self::ACTION_REUSSIE;
		}
		else
		{
			return self::ACTION_ECHOUEE;
		}
	}
}
