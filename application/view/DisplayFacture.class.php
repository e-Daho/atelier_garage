<?php
class DisplayFacture{

	private $_factureControleur;
	private $_facture_interventionControleur;
	
	public function __construct(FactureControleur $factureControleur, Facture_InterventionControleur $facture_interventionControleur){
		$this->_factureControleur=$factureControleur;
		$this->_facture_interventionControleur=$facture_interventionControleur;
		
	}
	//Factures
	public function afficherFactures(){
		$out='	<h1>Recherche parmi les factures</h1>
				<div class="pageRecherche">
					<form action="?page=afficherFactures" id="getListFactures_form" method="post" >
						<div class="table">
							<input type="text" class="table-cell" name="idFacture" placeholder="Id Facture : " >
							<input type="text" class="table-cell" name="prixTotal" placeholder="Prix Total : " >
						<p><input type="submit" class="ok" name="Rechercher" value="Rechercher"></p>
					</form>
					<div class="alignRight">
						<form action="?page=formAjouterFacture" method="post" >
							<p><input type="submit" class="ok" name="Ajouter" value="Ajouter"></p>
						</form>
					</div>
				</div>';
		$liste_factures=$this->_factureControleur->getList();
		$out.='		<h1>Liste des factures</h1>
					<table>
						<tr>
							<th>Id Facture</th>
							<th>Prix Total</th>
							<th></th>
						</tr>';
		foreach ($liste_factures as $facture){
		$out.='			<tr>
							<td><a href="?page=ficheFacture&idFacture='.$facture->idFacture().'">'.$facture->idFacture().'</a></td>
							<td>'.$facture->prixTotal().'</td>
							<td><a href="?page=supprimerFacture&idFacture='.$facture->idFacture().'" onclick="return verifjs_suppr();">Supprimer</a></td>
						</tr>';
		}
		$out.='		</table>
				</div>';
		return $out;		
	}
	
	public function formAjouterFacture(){	
		$out='	<h1>Ajouter un facture</h1>
				<div class="pageRecherche">
					<form action="?page=ajouterFacture" id="getListFactures_form" method="post" >
						<div class="table">
							<input type="text" class="table-cell" name="idFacture" placeholder="Id Facture : " required="required"  >
							<input type="text" class="table-cell" name="prixTotal" placeholder="Prix Total : ">
						</div>
						<p><input type="submit" class="ok" name="Ajouter" value="Ajouter"></p>
					</form>
				</div>';
		return $out;
	}
	
	public function ajouterFacture(){
		return $this->_factureControleur->addFacture();
	}
	
	public function supprimerFacture(){
		$facture = $this->_factureControleur->get($_GET['idFacture']);
		return $this->_factureControleur->deleteFacture($facture);
	}
	
	public function ficheFacture(){
		$facture = $this->_factureControleur->get($_GET['idFacture']);
		$out='	<h1>Facture détaillée</h1>
				<div class="pageRecherche">
					<table>
						<tr><th>Id Facture : </th><td>'.$facture->idFacture().'</td></tr>
						<tr><th>Prix Total : </th><td>'.$facture->prixTotal().'</td></tr>
					</table>
					<h1>Ajouter une intervention : </h1>
					<form action="?page=ajouterFacture_Intervention" id="getListFactures_Intervention_form" method="post" >
						<div class="table">
							<input type="text" class="table-cell" name="idFacture" placeholder="Id Facture : " required="required" value="'.$facture->idFacture().'" readonly="readonly">
							<input type="text" class="table-cell" name="idIntervention" placeholder="Id Intervention : " required="required" >
						</div>
						<p><input type="submit" class="ok" name="Ajouter" value="Ajouter"></p>
					</form>	';
					
		$liste_factures_detail=$this->_facture_interventionControleur->getList();
		$out.='		<h1>Liste des interventions</h1>
					<table>
						<tr>
							<th>Id Facture</th>
							<th>Id Intervention</th>
							<th>Prix Total</th>
							<th>Nom</th>
							<th>prix</th>
							<th></th>
						</tr>';
		foreach ($liste_factures_detail as $facture_detail){
		$out.='			<tr>
							<td>'.$facture_detail->idFacture().'</td>
							<td>'.$facture_detail->idIntervention().'</td>
							<td>'.$facture_detail->prixTotal().'</td>
							<td>'.$facture_detail->nom().'</td>
							<td>'.$facture_detail->prix().'</td>
							<td><a href="?page=supprimerFacture_Intervention&idFacture='.$facture_detail->idFacture().'&idIntervention='.$facture_detail->idIntervention().'" onclick="return verifjs_suppr();">Supprimer</a></td>
						</tr>';
		}
		$out.='		</table>
				
				</div>';
		return $out;
		
	}
}
?>