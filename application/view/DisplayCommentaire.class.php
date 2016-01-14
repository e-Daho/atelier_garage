<?php
class DisplayCommentaire{
	
	private $_commentaireControleur;
	
	public function __construct(CommentaireControleur $commentaireControleur){
		$this->_commentaireControleur=$commentaireControleur;
		
	}
	//Commentaire
	public function ajouterCommentaire(){
		$this->_commentaireControleur->addCommentaire();
		header('Location:?page=ficheVoiture&immatriculation='.$_POST['immatriculation'].'');
		exit();
	}
	
	public function supprimerCommentaire(){
		$commentaire = $this->_commentaireControleur->get($_GET['voiture'],$_GET['technicien'],$_GET['datecommentaire']);
		$this->_commentaireControleur->deleteCommentaire($commentaire);
		header('Location:?page=ficheVoiture&immatriculation='.$_GET['voiture'].'');
		exit();
	}
}
?>