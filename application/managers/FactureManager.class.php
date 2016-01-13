<?php
class FactureManager
{
	private $_db;

	const ACTION_REUSSIE = 1;
	const ACTION_ECHOUEE = 0;

	public function __construct($db){$this->setDb($db);}
	
	public function setDb($db){$this->_db = $db;}

	public function add(Facture $facture)
	{
		$q = $this->_db->prepare('INSERT INTO facture SET prixTotal = :prixTotal');

		$q->bindValue(':prixTotal',$facture->prixTotal(),PDO::PARAM_INT);	
		
		$q->execute();
		
		$facture->hydrate([
			'idFacture'=>$this->_db->lastInsertId(), 
			'prixTotal'=>$facture->prixTotal()]);
		
		return self::ACTION_REUSSIE;
	}

	public function count()
	{
		return $this->_db->query('SELECT COUNT(*) FROM facture')->fetchColumn();
	}

	public function delete(Facture $facture)
	{
		$q = $this->_db->prepare('DELETE FROM facture WHERE idFacture = :idFacture');
		
		$q->bindValue(':idFacture',$facture->idFacture(),PDO::PARAM_INT);
		
		$q->execute();
		
		return self::ACTION_REUSSIE;
	}

	public function exists(Facture $facture)
	{    
		$q = $this->_db->prepare('SELECT COUNT(*) FROM facture WHERE idFacture = :idFacture');
		
		$q->bindValue(':idFacture',$facture->idFacture(),PDO::PARAM_INT);

		$q->execute();
    
		return (bool) $q->fetchColumn();
	}
	
	public function get($idFacture)
	{
		$q = $this->_db->prepare('SELECT idFacture, prixTotal FROM facture WHERE idFacture = :idFacture');	
		$q->execute([':idFacture' => $idFacture]);

		$facture = $q->fetch(PDO::FETCH_ASSOC);
		
		return empty($facture) ? null : new Facture($facture);
	}
	
  
	/*public function getList($idFacture, $prixTotal, $date)
	{
		$factures = [];
		
		$q = $this->_db->prepare('SELECT * FROM facture WHERE idFacture LIKE :idFacture AND prixTotal LIKE :prixTotal AND date LIKE :date ORDER BY date');

    		$q->bindParam(':idFacture', $idFacture, PDO::PARAM_STR);
    		$q->bindParam(':prixTotal', $prixTotal, PDO::PARAM_INT);
		$q->bindParam(':date', $date, PDO::PARAM_STR);
		$q->execute();
	    
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			$factures[] = new Facture($donnees); 
		}
		return $factures;
	}*/

  
	public function update(Facture $facture)
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
