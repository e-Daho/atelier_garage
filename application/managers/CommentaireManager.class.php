<?php
class CommentaireManager
{
	private $_db;

	const ACTION_REUSSIE = 1;
	const ACTION_ECHOUEE = 0;

	public function __construct($db){$this->setDb($db);}
	
	public function setDb($db){$this->_db = $db;}

	public function add(Commentaire $commentaire)
	{
		$q = $this->_db->prepare('INSERT INTO commentaire SET voiture = :voiture, technicien = :technicien, date = :date, texte= :texte');

		$q->bindValue(':voiture',$commentaire->voiture(),PDO::PARAM_STR);
		$q->bindValue(':technicien',$commentaire->technicien(),PDO::PARAM_INT);
		$q->bindValue(':date',$commentaire->date()->format('Y-m-d H:i:s'),PDO::PARAM_STR);
		$q->bindValue(':texte',$commentaire->texte(),PDO::PARAM_STR);
		$q->execute();
		return self::ACTION_REUSSIE;
	}

	public function count()
	{
		return $this->_db->query('SELECT COUNT(*) FROM commentaire')->fetchColumn();
	}

	public function delete(Commentaire $commentaire)
	{
		$q = $this->_db->prepare('DELETE FROM commentaire WHERE (voiture = :voiture AND technicien = :technicien AND date = :date)');
		$q->bindValue(':voiture',$commentaire->voiture(),PDO::PARAM_STR);
		$q->bindValue(':technicien',$commentaire->technicien(),PDO::PARAM_INT);
		$q->bindValue(':date',$commentaire->date()->format('Y-m-d H:i:s'),PDO::PARAM_STR);
		$q->execute();
		return self::ACTION_REUSSIE;
	}

	public function exists(Commentaire $commentaire)
	{    
		$q = $this->_db->prepare('SELECT COUNT(*) FROM commentaire WHERE (voiture = :voiture AND technicien = :technicien AND date = :date)');
		$q->bindValue(':voiture',$commentaire->voiture(),PDO::PARAM_STR);
		$q->bindValue(':technicien',$commentaire->technicien(),PDO::PARAM_INT);
		$q->bindValue(':date',$commentaire->date()->format('Y-m-d H:i:s'),PDO::PARAM_STR);
		$q->execute();
    
		return (bool) $q->fetchColumn();
	}
	
  
	/*public function getList($voiture, $technicien, $date)
	{
		$commentaires = [];
		
		$q = $this->_db->prepare('SELECT * FROM commentaire WHERE voiture LIKE :voiture AND technicien LIKE :technicien AND date LIKE :date ORDER BY date');

    		$q->bindParam(':voiture', $voiture, PDO::PARAM_STR);
    		$q->bindParam(':technicien', $technicien, PDO::PARAM_INT);
		$q->bindParam(':date', $date, PDO::PARAM_STR);
		$q->execute();
	    
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			$commentaires[] = new Commentaire($donnees); 
		}
		return $commentaires;
	}*/

  
	public function update(Commentaire $commentaire)
	{
		if($this->exists($commentaire))
		{
			$q = $this->_db->prepare('UPDATE commentaire SET texte= :texte WHERE (voiture = :voiture AND technicien = :technicien AND date = :date)');
		    
			$q->bindValue(':voiture',$commentaire->voiture(),PDO::PARAM_STR);
			$q->bindValue(':technicien',$commentaire->technicien(),PDO::PARAM_INT);
			$q->bindValue(':date',$commentaire->date()->format('Y-m-d H:i:s'),PDO::PARAM_STR);
			$q->bindValue(':texte',$commentaire->texte(),PDO::PARAM_STR);
		    
			$q->execute();
			return self::ACTION_REUSSIE;
		}
		else
		{
			return self::ACTION_ECHOUEE;
		}
	}
}
