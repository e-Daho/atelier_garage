<?php
class DisplayIntervention{
	
	private $_interventionControleur;
	
	public function __construct(InterventionControleur $interventionControleur){
		$this->_interventionControleur=$interventionControleur;	
	}
	//Interventions
	public function afficherInterventions(){
		$out='	<h1>Recherche parmi les interventions</h1>
				<div class="pageRecherche">
					<form action="?page=afficherInterventions" id="getListInterventions_form" method="post" >
						<div class="table">
							<input type="text" class="table-cell" name="id" placeholder="Id : " >
							<input type="text" class="table-cell" name="nom" placeholder="Nom : " >
							<input type="text" class="table-cell" name="prix" placeholder="Prix : " >
						<p><input type="submit" class="ok" name="Rechercher" value="Rechercher"></p>
					</form>
					<div class="alignRight">
						<form action="?page=formAjouterIntervention" method="post" >
							<p><input type="submit" class="ok" name="Ajouter" value="Ajouter"></p>
						</form>
					</div>
				</div>';
		$liste_interventions=$this->_interventionControleur->getList();
		$out.='		<h1>Liste des interventions</h1>
					<table>
						<tr>
							<th>Id</th>
							<th>Nom</th>
							<th>Prix</th>
							<th></th>
							<th></th>
						</tr>';
		foreach ($liste_interventions as $intervention){
		$out.='			<tr>
							<td>'.$intervention->id().'</td>
							<td>'.$intervention->nom().'</td>
							<td>'.$intervention->prix().'</td>
							<td><a href="?page=formModifierIntervention&id='.$intervention->id().'">Modifier</a></td>
							<td><a href="?page=supprimerIntervention&id='.$intervention->id().'" onclick="return verifjs_suppr();">Supprimer</a></td>
						</tr>';
		}
		$out.='		</table>
				</div>';
		return $out;		
	}
	
	public function formAjouterIntervention(){	
		$out='	<h1>Ajouter un intervention</h1>
				<div class="pageRecherche">
					<form action="?page=ajouterIntervention" id="getListInterventions_form" method="post" >
						<div class="table">
							<input type="text" class="table-cell" name="nom" placeholder="Nom : " required="required"   >
							<input type="text" class="table-cell" name="prix" placeholder="Prix : " required="required"   >
						</div>
						<p><input type="submit" class="ok" name="Ajouter" value="Ajouter"></p>
					</form>
				</div>';
		return $out;
	}
	
	public function ajouterIntervention(){
		return $this->_interventionControleur->addIntervention();
	}
	
	public function formModifierIntervention(){
		$intervention = $this->_interventionControleur->get($_GET['id']);
		$out='	<h1>Modifier un intervention</h1>
				<div class="pageRecherche">
					<form action="?page=modifierIntervention" id="getListInterventions_form" method="post" >
						<div class="table">
							<input type="text" class="table-cell" name="id" placeholder="Id : " required="required" value="'.$intervention->id().'"  readonly="readonly"  >
							<input type="text" class="table-cell" name="nom" placeholder="Nom : " required="required" value="'.$intervention->nom().'">
							<input type="text" class="table-cell" name="prix" placeholder="Prix : " required="required" value="'.$intervention->prix().'">
						</div>
						<p><input type="submit" class="ok" name="Modifier" value="Modifier"></p>
					</form>
				</div>';
		return $out;
	}
	
	public function modifierIntervention(){
		return $this->_interventionControleur->editIntervention();
	}
	
	public function supprimerIntervention(){
		$intervention = $this->_interventionControleur->get($_GET['id']);
		return $this->_interventionControleur->deleteIntervention($intervention);
	}
}
?>