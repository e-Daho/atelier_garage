<?php
class RepareControleur{
	
	private $_repareManager;	
	
	public function __construct(RepareManager $repareManager){
		$this->_repareManager=$repareManager;
	}
	
	public function get($technicien, $voiture, $dateDebut){
		return $this->_repareManager->get($technicien, $voiture, $dateDebut);
	}
	
	public function getList(){
		$idFacture = '%';
		if (!empty($_POST['idFacture'])) {$idFacture.=$_POST['idFacture'].'%';}
		
		$technicien = '%';
		if (!empty($_POST['technicien'])) {$technicien.=$_POST['technicien'].'%';}
		
		$voiture = '%';
		if (!empty($_POST['voiture'])) {$voiture.=$_POST['voiture'].'%';}
		
		$dateDebut = '%';
		if (!empty($_POST['dateDebut'])) {$dateDebut.=$_POST['dateDebut'].'%';}
		
		$_dateFin = '%';
		if (!empty($_POST['_dateFin'])) {$_dateFin.=$_POST['_dateFin'].'%';}
					
		//$liste_repares = $this->_repareManager->getList($idFacture, $technicien, $voiture, $dateDebut, $_dateFin);
		$liste_repares = [];
		$liste_repares[] = new Repare([	'idFacture'=>'1',	'technicien'=>'213456',	'voiture'=>'123-456',	'dateDebut'=>'2016-01-13']);
		return $liste_repares;
	}
	
	public function addRepare(){
		$out='';
		if (!empty($_POST['technicien']) AND !empty($_POST['voiture']) AND !empty($_POST['dateDebut'])) {
			$repare = new Repare($_POST);
			
			if (!$this->_repareManager->exists($repare)) {
				if($this->_repareManager->add($repare)){
					$out='La réparation de la voiture immatriculé '.$_POST['voiture'].' par le technicient numéro '.$_POST['technicien'].' en date du '.$_POST['dateDebut'].' a bien été ajoutée.';
				}else{
					$out='OUPS ! Il y a eu un problème.'; 
				}
			} else {
				$out='Erreur : cette réparation existe déjà ! ';
			}
		}else{
			$out='Erreur : vous ne devriez pas être ici !';
		}
		return $out;
	}
	
	public function editRepare(){
		$out='';
		if (!empty($_POST['technicien']) AND !empty($_POST['voiture']) AND !empty($_POST['dateDebut'])) {
			$repare = new Repare($_POST);
			
			if ($this->_repareManager->exists($repare)) {
				if($this->_repareManager->update($repare)){
					$out='La réparation de la voiture immatriculé '.$_POST['voiture'].' par le technicient numéro '.$_POST['technicien'].' en date du '.$_POST['dateDebut'].' a bien été modifiée.';
				}else{
					$out='OUPS ! Il y a eu un problème.'; 
				}
			} else {
				$out='Erreur : cette réparation n\'existe pas ! ';
			}
		}else{
			$out='Erreur : vous ne devriez pas être ici !';
		}
		return $out;
	}
	
	public function deleteRepare($repare){
		return ($this->_repareManager->delete($repare))?'La réparation de la voiture immatriculé '.$repare->voiture().' par le technicient numéro '.$repare->technicien().' en date du '.$repare->dateDebut().' a bien été supprimée.':'OUPS ! Il y a eu un problème.'; 
	
	}
}
?>