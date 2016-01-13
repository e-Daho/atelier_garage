<?php
class Facture_InterventionControleur{
	
	private $_technicienManager;
		
	public function __construct(TechnicienManager $technicienManager){
		$this->_technicienManager=$technicienManager;
	}
	
	public function get($numero){
		return $this->_technicienManager->get($numero);
	}
	
	public function getList(){
		$numero = '%';
		if (!empty($_POST['numero'])) {$numero.=$_POST['numero'].'%';}
		
		$nom = '%';
		if (!empty($_POST['nom'])) {$nom.=$_POST['nom'].'%';}
		
		$prenom = '%';
		if (!empty($_POST['prenom'])) {$prenom.=$_POST['prenom'].'%';}
					
		$liste_techniciens = $this->_technicienManager->getList($numero, $nom, $prenom);
		return $liste_techniciens;
	}
	
	public function addTechnicien(){
		$out='';
		if (!empty($_POST['numero']) ) {
			$technicien = new Technicien($_POST);
			
			if (!$this->_technicienManager->exists($technicien)) {
				if($this->_technicienManager->add($technicien)){
					$out='Le technicien numéro '.$_POST['numero'].' a bien été ajouté.';
				}else{
					$out='OUPS ! Il y a eu un problème.'; 
				}
			} else {
				$out='Erreur : ce numéro est déjà pris ! ';
			}
		}else{
			$out='Erreur : vous ne devriez pas être ici !';
		}
		return $out;
	}
	
	public function editTechnicien(){
		$out='';
		if (!empty($_POST['numero']) ) {
			$technicien = new Technicien($_POST);
			
			if ($this->_technicienManager->exists($technicien)) {
				if($this->_technicienManager->update($technicien)){
					$out='Le technicien numéro '.$_POST['numero'].' a bien été modifié.';
				}else{
					$out='OUPS ! Il y a eu un problème.'; 
				}
			} else {
				$out='Erreur : ce numéro n\'existe pas ! ';
			}
		}else{
			$out='Erreur : vous ne devriez pas être ici !';
		}
		return $out;
	}
	
	public function deleteTechnicien($technicien){
		return ($this->_technicienManager->delete($technicien))?'Le technicien immatriculée '.$technicien->numero().' a bien été supprimé.':'OUPS ! Il y a eu un problème.'; 
	}
	
}
?>