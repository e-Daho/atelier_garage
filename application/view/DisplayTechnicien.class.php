<?php
class DisplayTechnicien{
	
	private $_technicienControleur;
	
	public function __construct(TechnicienControleur $technicienControleur){
		$this->_technicienControleur=$technicienControleur;		
	}
	//Techniciens
	public function afficherTechniciens(){
		//[TODO]  Liste des client préchargée dans une liste déroulante
		$out='	<h1>Recherche parmi les techniciens</h1>
				<div class="pageRecherche">
					<form action="?page=afficherTechniciens" id="getListTechniciens_form" method="post" >
						<div class="table">
							<input type="text" class="table-cell" name="numero" placeholder="Numéro : " >
							<input type="text" class="table-cell" name="nom" placeholder="Nom : " >
							<input type="text" class="table-cell" name="prenom" placeholder="Prénom : " ></div><div>
						<p><input type="submit" class="ok" name="Rechercher" value="Rechercher"></p>
					</form>
					<div class="alignRight">
						<form action="?page=formAjouterTechnicien" method="post" >
							<p><input type="submit" class="ok" name="Ajouter" value="Ajouter"></p>
						</form>
					</div>
				</div>';
		$liste_techniciens=$this->_technicienControleur->getList();
		$out.='		<h1>Liste des techniciens</h1>
					<table>
						<tr>
							<th>Numéro</th>
							<th>Nom</th>
							<th>Prénom</th>
							<th>Nombre de réparations terminées</th>
							<th></th>
							<th></th>
						</tr>';
		foreach ($liste_techniciens as $technicien){
		$out.='			<tr>
							<td>'.$technicien->numero().'</td>
							<td>'.$technicien->nom().'</td>
							<td>'.$technicien->prenom().'</td>
							<td>'.$technicien->nombre().'</td>
							<td><a href="?page=formModifierTechnicien&numero='.$technicien->numero().'">Modifier</a></td>
							<td><a href="?page=supprimerTechnicien&numero='.$technicien->numero().'" onclick="return verifjs_suppr();">Supprimer</a></td>
						</tr>';
		}
		$out.='		</table>
				</div>';
		return $out;		
	}
	
	public function formAjouterTechnicien(){	
		$out='	<h1>Ajouter un technicien</h1>
				<div class="pageRecherche">
					<form action="?page=ajouterTechnicien" id="getListTechniciens_form" method="post" >
						<div class="table">
							<input type="text" class="table-cell" name="numero" placeholder="Numéro : " required="required"  >
							<input type="text" class="table-cell" name="nom" placeholder="Nom : " required="required" >
							<input type="text" class="table-cell" name="prenom" placeholder="Prénom : " required="required" >
						</div>
						<p><input type="submit" class="ok" name="Ajouter" value="Ajouter"></p>
					</form>
				</div>';
		return $out;
	}
	
	public function ajouterTechnicien(){
		return $this->_technicienControleur->addTechnicien();
	}
	
	public function formModifierTechnicien(){
		$technicien = $this->_technicienControleur->get($_GET['numero']);
		print_r($technicien);
		$out='	<h1>Modifier un technicien</h1>
				<div class="pageRecherche">
					<form action="?page=modifierTechnicien" id="getListTechniciens_form" method="post" >
						<div class="table">
							<input type="text" class="table-cell" name="numero" placeholder="Numéro : " value="'.$technicien->numero().'" required="required"  readonly="readonly" >
							<input type="text" class="table-cell" name="nom" placeholder="Nom : " value="'.$technicien->nom().'" required="required" >
							<input type="text" class="table-cell" name="prenom" placeholder="Prénom : " value="'.$technicien->prenom().'" required="required" >
						</div>
						<p><input type="submit" class="ok" name="Modifier" value="Modifier"></p>
					</form>
				</div>';
		return $out;
	}
	
	public function modifierTechnicien(){
		return $this->_technicienControleur->editTechnicien();
	}
	
	public function supprimerTechnicien(){
		$technicien = $this->_technicienControleur->get($_GET['numero']);
		return $this->_technicienControleur->deleteTechnicien($technicien);
	}
}
?>