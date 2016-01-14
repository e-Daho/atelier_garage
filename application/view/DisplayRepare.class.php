<?php
class DisplayRepare{
	
	private $_repareControleur;
	
	public function __construct(RepareControleur $repareControleur){
		$this->_repareControleur=$repareControleur;
	}
	//Réparations
	public function afficherRepares(){
		$out='	<h1>Recherche parmi les réparations</h1>
				<div class="pageRecherche">
					<form action="?page=afficherRepares" id="getListRepares_form" method="post" >
						<div class="table">
							<input type="text" class="table-cell" name="idFacture" placeholder="Id Facture : " >
							<input type="text" class="table-cell" name="technicien" placeholder="Technicien : " >
							<input type="text" class="table-cell" name="voiture" placeholder="Voiture : " ></div><div>
							<input type="date" class="table-cell" name="dateDebut" placeholder="Date de début : " >
							<input type="date" class="table-cell" name="dateFin" placeholder="Date de fin : " >
							<p><input type="submit" class="ok" name="Rechercher" value="Rechercher"></p>
						</div>
					</form>
					<div class="alignRight">
						<form action="?page=formAjouterRepare" method="post" >
							<p><input type="submit" class="ok" name="Ajouter" value="Ajouter"></p>
						</form>
					</div>
				';
		$liste_repares=$this->_repareControleur->getList();
		$out.='		<h1>Liste des réparations</h1>
					<table>
						<tr>
							<th>Id Facture</th>
							<th>Technicien</th>
							<th>Voiture</th>
							<th>Date de début</th>
							<th>Date de fin</th>
							<th></th>
							<th></th>
						</tr>';
		foreach ($liste_repares as $repare){
		$out.='			<tr>
							<td>'.$repare->idFacture().'</td>
							<td>'.$repare->technicien().'</td>
							<td>'.$repare->voiture().'</td>
							<td>'.$repare->dateDebut().'</td>
							<td>'.$repare->dateFin().'</td>
							<td><a href="?page=formModifierRepare&technicien='.$repare->technicien().'&voiture='.$repare->voiture().'&dateDebut='.$repare->dateDebut().'">Modifier</a></td>
							<td><a href="?page=supprimerRepare&technicien='.$repare->technicien().'&voiture='.$repare->voiture().'&dateDebut='.$repare->dateDebut().'" onclick="return verifjs_suppr();">Supprimer</a></td>
						</tr>';
		}
		$out.='		</table>
				</div>';
		return $out;		
	}
	
	public function formAjouterRepare(){	
		$out='	<h1>Ajouter une réparation</h1>
				<div class="pageRecherche">
					<form action="?page=ajouterRepare" id="getListRepares_form" method="post" >
						<div class="table">
							<input type="text" class="table-cell" name="idFacture" placeholder="Id Facture : " >
							<input type="text" class="table-cell" name="technicien" placeholder="Technicien : " required="required"  >
							<input type="text" class="table-cell" name="voiture" placeholder="Voiture : " required="required"  ></div><div>
							<input type="date" class="table-cell" name="dateDebut" placeholder="Date de début : " required="required"  >
							<input type="date" class="table-cell" name="dateFin" placeholder="Date de fin : " >
						</div>
						<p><input type="submit" class="ok" name="Ajouter" value="Ajouter"></p>
					</form>
				</div>';
		return $out;
	}
	
	public function ajouterRepare(){
		return $this->_repareControleur->addRepare();
	}
	
	public function formModifierRepare(){
		$repare = $this->_repareControleur->get($_GET['technicien'],$_GET['voiture'],$_GET['dateDebut']);
		print_r($repare);
		$out='	<h1>Modifier une réparation</h1>
				<div class="pageRecherche">
					<form action="?page=modifierRepare" id="getListRepares_form" method="post" >
						<div class="table">
							<input type="text" class="table-cell" name="idFacture" placeholder="Id Facture : " value="'.$repare->idFacture().'">
							<input type="text" class="table-cell" name="technicien" placeholder="Technicien : " value="'.$repare->technicien().'" required="required"  readonly="readonly"  >
							<input type="text" class="table-cell" name="voiture" placeholder="Voiture : " value="'.$repare->voiture().'" required="required"   readonly="readonly" ></div><div>
							<input type="date" class="table-cell" name="dateDebut" placeholder="Date de début : " value="'.$repare->dateDebut().'" required="required"   readonly="readonly" >
							<input type="date" class="table-cell" name="dateFin" placeholder="Date de fin : " value="'.$repare->dateFin().'" >
						</div>
						<p><input type="submit" class="ok" name="Modifier" value="Modifier"></p>
					</form>
				</div>';
		return $out;
	}
	
	public function modifierRepare(){
		return $this->_repareControleur->editRepare();
	}
	
	public function supprimerRepare(){
		$repare = $this->_repareControleur->get($_GET['technicien'],$_GET['voiture'],$_GET['dateDebut']);
		return $this->_repareControleur->deleteRepare($repare);
	}
}
?>