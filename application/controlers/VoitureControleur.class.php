﻿<?php
class VoitureControleur{
	
	private $_voitureManager;
	private $_clientControleur;
	
	public function __construct(VoitureManager $voitureManager, ClientControleur $clientControleur){
		$this->_voitureManager=$voitureManager;
		$this->_clientControleur=$clientControleur;
	}
	
	public function get($immatriculation){
		return $this->_voitureManager->get($immatriculation);
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
		$out='';
		if (!empty($_POST['immatriculation']) AND (!empty($_POST['proprietaire'])OR!empty($_POST['numero']))) {
			if(!empty($_POST['numero'])){
				$_POST['proprietaire']=$_POST['numero'];
			}
			$voiture = new Voiture($_POST);
			$client = new Client($_POST);
			
			$this->_clientControleur->addClient($client);
			
			if (!$this->_voitureManager->exists($voiture)) {
				$this->_voitureManager->add($voiture);
			} else {
				$out='Erreur : cette immatriculation est déjà prise ! ';
			}
		}else{
			$out='Erreur : vous ne devriez pas être ici !';
		}
		return $out;
	}
	
	public function editVoiture(){		
		$out='';
		if (!empty($_POST['immatriculation']) AND (!empty($_POST['proprietaire'])OR!empty($_POST['numero']))) {
			if(!empty($_POST['numero'])){
				$_POST['proprietaire']=$_POST['numero'];
			}
			$voiture = new Voiture($_POST);
			$client = new Client($_POST);
			
			$this->_clientControleur->addClient($client);
			
			if ($this->_voitureManager->exists($voiture)) {
				$this->_voitureManager->update($voiture);
			} else {
				$out='Erreur : cette immatriculation n\'existe pas ! ';
			}
		}else{
			$out='Erreur : vous ne devriez pas être ici !';
		}
		return $out;
	}
	
	public function deleteVoiture($voiture){		
		return $this->_voitureManager->delete($voiture);
	}
	
}
?>