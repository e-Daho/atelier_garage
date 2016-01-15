<?php
class InterventionControleur{
	
	private $_interventionManager;
	
	public function __construct(InterventionManager $interventionManager){
		$this->_interventionManager=$interventionManager;
	}
	
	public function get($id){
		return $this->_interventionManager->get($id);
	}
	
	public function getList(){
		$id = '%';
		if (!empty($_POST['id'])) {$id.=$_POST['id'].'%';}
		
		$nom = '%';
		if (!empty($_POST['nom'])) {$nom.=$_POST['nom'].'%';}
		
		$prix = '%';
		if (!empty($_POST['prix'])) {$prix.=$_POST['prix'].'%';}
		
		$liste_interventions = $this->_interventionManager->getList($id, $nom, $prix);
		return $liste_interventions;
	}
	
	public function addIntervention(){
		$out='';
		if (!empty($_POST['nom']) AND !empty($_POST['prix'])) {
			$intervention = new Intervention($_POST);
			
			if (!$this->_interventionManager->exists($intervention)) {
				if($this->_interventionManager->add($intervention)){
					$out='L\'intervention '.$intervention->nom().' a bien été ajoutée avec comme id '.$intervention->id();
				}else{
					$out='OUPS ! Il y a eu un problème.'; 
				}
			} else {
				$out='Erreur : cette intervention existe déjà ! ';
			}
		}else{
			$out='Erreur : vous ne devriez pas être ici !';
		}
		return $out;
	}
	
	public function editIntervention(){		
		$out='';
		if (!empty($_POST['id']) AND !empty($_POST['nom']) AND !empty($_POST['prix'])) {
			$intervention = new Intervention($_POST);
			
			if ($this->_interventionManager->exists($intervention)) {
				if($this->_interventionManager->update($intervention)){
					$out='L\'intervention '.$_POST['nom'].' a bien été modifié.';
				}else{
					$out='OUPS ! Il y a eu un problème.'; 
				}
			} else {
				$out='Erreur : cette intervention n\'existe pas ! ';
			}
		}else{
			$out='Erreur : vous ne devriez pas être ici !';
		}
		return $out;
	}
	
	public function deleteIntervention($intervention){		
		return ($this->_interventionManager->delete($intervention))?'L\'intervention  '.$intervention->nom().' a bien été supprimée.':'OUPS ! Il y a eu un problème.'; 
	}
	
}
?>