<?php
class DisplayClient{
	
	private $_clientControleur;
	
	public function __construct(ClientControleur $clientControleur){
		$this->_clientControleur=$clientControleur;
	}
	
	#Affiche la liste des clients précédée d'un formulaire de recherche et d'un lien vers le formulaire d'ajout ainsi que la liste des villes et leur nombre 
	public function afficherClients(){
		//[TODO]  Liste des client préchargée dans une liste déroulante
		$out='	<h1>Recherche parmi les clients</h1>
				<div class="pageRecherche">
					<form action="?page=afficherClients" id="getListClients_form" method="post" >
						<div class="table">
							<input type="text" class="table-cell" name="numero" placeholder="Numéro : " >
							<input type="text" class="table-cell" name="nom" placeholder="Nom : " >
							<input type="text" class="table-cell" name="prenom" placeholder="Prénom : " ></div><div>
							<input type="text" class="table-cell" name="adresse" placeholder="Adresse : " >
							<input type="text" class="table-cell" name="referent" placeholder="Référent : " >
							<p><input type="submit" class="ok" name="Rechercher" value="Rechercher"></p>
						</div>
					</form>
					<div class="alignRight">
						<form action="?page=formAjouterClient" method="post" >
							<p><input type="submit" class="ok" name="Ajouter" value="Ajouter"></p>
						</form>
					</div>';
		$liste_clients=$this->_clientControleur->getList('nom');
		$out.='		<h1>Liste des clients</h1>
					<table>
						<tr>
							<th>Numéro</th>
							<th>Nom</th>
							<th>Prénom</th>
							<th>Adresse</th>
							<th>Référent</th>
							<th></th>
							<th></th>
						</tr>';
		foreach ($liste_clients as $client){
		$out.='			<tr>
							<td>'.$client->numero().'</td>
							<td>'.$client->nom().'</td>
							<td>'.$client->prenom().'</td>
							<td>'.$client->adresse().'</td>
							<td>'.$client->referent().'</td>
							<td><a href="?page=formModifierClient&numero='.$client->numero().'">Modifier</a></td>
							<td><a href="?page=supprimerClient&numero='.$client->numero().'" onclick="return verifjs_suppr();">Supprimer</a></td>
						</tr>';
		}
		$out.='		</table>
					<h1>Recherche parmi les villes</h1>
					<form action="?page=afficherClients" id="getListClients_form" method="post" >
						<div class="table">
							<input type="text" class="table-cell" name="nomVille" placeholder="Nom : " >
							<input type="text" class="table-cell" name="nombre" placeholder="Nombre : " >
						<p><input type="submit" class="ok" name="Rechercher" value="Rechercher"></p>
					</form>';
		$liste_villes=$this->_clientControleur->getVilles();
		$out.='		<h1>Liste des villes</h1>
					<table>
						<tr>
							<th>Nom</th>
							<th>Nombre</th>
						</tr>';
		foreach ($liste_villes as $ville){
		$out.='			<tr>
							<td>'.$ville->nom().'</td>
							<td>'.$ville->nombre().'</td>
						</tr>';
		}
		$out.='		</table>
				</div>';
		return $out;		
	}
	
	public function formAjouterClient(){
		//[TODO]  Liste des référents préchargée dans une liste déroulante + autre		
		$out='	<h1>Ajouter un client</h1>
				<div class="pageRecherche">
					<form action="?page=ajouterClient" id="getListClients_form" method="post" >
						<div class="table">
							<input type="text" class="table-cell" name="numero" placeholder="Numéro : " required="required"  >
							<input type="text" class="table-cell" name="nom" placeholder="Nom : " required="required" >
							<input type="text" class="table-cell" name="prenom" placeholder="Prénom : " required="required" ></div><div>
							<input type="text" class="table-cell" name="adresse" placeholder="Adresse : " >
							<input type="text" class="table-cell" name="referent" placeholder="Référent : " >
						</div>
						<p><input type="submit" class="ok" name="Ajouter" value="Ajouter"></p>
					</form>
				</div>';
		return $out;
	}
	
	public function ajouterClient(){
		return $this->_clientControleur->addClient();
	}
	
	public function formModifierClient(){
		//[TODO]  Liste des référents préchargée dans une liste déroulante + autre
		//[TODO] recharger les données connues du client
		$client = $this->_clientControleur->get($_GET['numero']);
		$out='	<h1>Modifier un client</h1>
				<div class="pageRecherche">
					<form action="?page=modifierClient" id="getListClients_form" method="post" >
						<div class="table">
							<input type="text" class="table-cell" name="numero" placeholder="Numéro : " value="'.$client->numero().'" required="required"  readonly="readonly" >
							<input type="text" class="table-cell" name="nom" placeholder="Nom : " value="'.$client->nom().'" required="required" >
							<input type="text" class="table-cell" name="prenom" placeholder="Prénom : " value="'.$client->prenom().'" required="required" ></div><div>
							<input type="text" class="table-cell" name="adresse" placeholder="Adresse : " value="'.$client->adresse().'">
							<input type="text" class="table-cell" name="referent" placeholder="Référent : " value="'.$client->referent().'">
						</div>
						<p><input type="submit" class="ok" name="Modifier" value="Modifier"></p>
					</form>
				</div>';
		return $out;
	}
	
	public function modifierClient(){
		return $this->_clientControleur->editClient();
	}
	
	public function supprimerClient(){
		$client = $this->_clientControleur->get($_GET['numero']);
		return $this->_clientControleur->deleteClient($client);
	}
}
?>