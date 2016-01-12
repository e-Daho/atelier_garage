<?php
class VoitureControleur{
	
	private $_voitureManager;
	
	public function __construct(VoitureManager $voitureManager){
		$this->_voitureManager=$voitureManager;
	}
	
	public function getList(){
		$immatriculation = '%';
		if (!empty($_POST['immatriculation'])) {$immatriculation.=$_POST['immatriculation'].'%';}
		
		$marque = '%';
		if (!empty($_POST['marque'])) {$marque.=$_POST['marque'].'%';}
		
		$type = '%';
		if (!empty($_POST['type'])) {$type.=$_POST['type'].'%';}
			
		$annee = '%';
		if (!empty($_POST['annee'])) {$annee.=$_POST['annee'].'%';}		
		
		$kilometrage = '%';
		if (!empty($_POST['kilometrage'])) {$kilometrage.=$_POST['kilometrage'].'%';}	
		
		$date_arrivee = '%';
		if (!empty($_POST['date_arrivee'])) {$date_arrivee.=$_POST['date_arrivee'].'%';}
		
		$proprietaire = '%';
		if (!empty($_POST['proprietaire'])) {$proprietaire.=$_POST['proprietaire'].'%';}
		
		$reparateur = '%';
		if (!empty(	$_POST['reparateur'])) {
		$reparateur.=$_POST['reparateur'].'%';}
		
		$liste_voitures = $this->_voitureManager->getList($immatriculation, $marque, $type, $annee, $kilometrage, $date_arrivee, $proprietaire, $reparateur);
		return $liste_voitures;
	}
	
	public function addVoiture(){
		//[TODO] Checker que l'immatriculation n'existe pas déjà
		//[TODO] Vérifier que tout les champs requis sont présents
		//[TODO] Si date vide -> date de jour
		//[TODO] page intermédiare de msg de confirmation
		//[TODO] gestion des clients et de "autre"
		
		if (!empty($_POST['immatriculation']) AND !empty($_POST['proprietaire'])) {
			$voiture = new Voiture($_POST);
			if (!$this->_voitureManager->exists($voiture)) {
				if (empty($_POST['date_arrivee'])){
					$_POST['date_arrivee']=1900-01-01;
				}
				$this->_voitureManager->add($voiture);
				
				header ('Location: ?page=afficherVoitures');
				exit();
			} else {
				$out='Erreur : cette immatriculation est déjà prise ! ';
			}
		}else{
			$out='Erreur : vous ne devriez pas être ici !';
		}
		
	}
	
	public function editVoiture(){
		
		if (!empty($_POST['immatriculation']) AND !empty($_POST['proprietaire'])) { $this->_voitureManager->update(new Voiture($_POST));}
		
		header ('Location: ?page=afficherVoitures');
		exit();
	}
	
}
?>