﻿<?php
class Display{
	
	private $_voitureControleur;
	private $_utilisateurControleur;
	
	public function __construct(UtilisateurControleur $utilisateurControleur, VoitureControleur $voitureControleur, ClientControleur $clientControleur){
		$this->_voitureControleur=$voitureControleur;
		$this->_utilisateurControleur=$utilisateurControleur;
		$this->_clientControleur=$clientControleur;
	}
	
	public function accueil(){
		if ($this->_utilisateurControleur->isConnected()){
			//ON redirige vers le tableau de bord
			header ('Location: ?page=tableau_de_bord');
			exit();
		}else{
			//ON redirige vers le formulaire de connexion
			header ('Location: ?page=connexion_form');
			exit();
		}
		return $out;
	}
	
	public function connexion_form(){
		$out = '<div id=page_connexion_form>
				<h1>Bienvenu sur le site de gestion de Garage 3A</h1>
				<p>Connectez vous pour continuer...</p>';
		
		$out .= '<article>
					<h1>Connexion</h1>
					<form action="?page=connexion" id="connexion_form" method="post" >
						<table>
							<tr>	<td><label for="Pseudo" >Pseudo : </label></td>	<td><input type="text" required="required" name="Pseudo" ></td>	</tr>
							<tr>	<td><label for="Password" >Password : </label></td>	<td><input type="password" required="required" name="Password" ></td>	</tr>
						</table>
						<p><input type="submit" class="ok" name="connexion" value="Connexion"></p>
					</form>
				</article>
				</div>';
		return $out;
	}
	
	public function tableau_de_bord(){
		$out = '<h1>Tableau de bord</h1>
				<div id="tableau_de_bord">
					<a href="?page=afficherVoitures">Voitures</a>
					<a href="?page=clients">Clients</a>
					<a href="?page=techniciens">Techniciens</a>
				</div>';
		return $out;
	}
	
	public function afficherVoitures(){
		//[TODO]  Liste des client préchargée dans une liste déroulante
		$out='	<h1>Recherche parmi les voitures</h1>
				<div class="pageRecherche">
					<form action="?page=afficherVoitures" id="getListVoitures_form" method="post" >
						<div class="table">
							<input type="text" class="table-cell" name="immatriculation" placeholder="Immatriculation : " >
							<input type="text" class="table-cell" name="marque" placeholder="Marque : " >
							<input type="text" class="table-cell" name="type" placeholder="Type : " >
							<input type="text" class="table-cell" name="annee" placeholder="Année : " >
							<input type="text" class="table-cell" name="kilometrage" placeholder="Kilométrage : " >
							<input type="date" class="table-cell" name="date_arrivee" placeholder="Date d\'arrivée : " >
							<select name="proprietaire">
								<option value="" >Non sélectionné</option>';
		$liste_clients = $this->_clientControleur->getList();
		foreach ($liste_clients as $client){
			$out.='				<option value="'.$client->numero().'" >'.$client->numero().'</option>';
		}
		$out.='				</select>';
		$out.='
							<input type="text" class="table-cell" name="reparateur" placeholder="Réparateur : " >
						</div>
						<p><input type="submit" class="ok" name="Rechercher" value="Rechercher"></p>
					</form>
					<div class="alignRight">
						<form action="?page=formAjouterVoiture" method="post" >
							<p><input type="submit" class="ok" name="Ajouter" value="Ajouter"></p>
						</form>
					</div>';
		$liste_voitures=$this->_voitureControleur->getList();
		$out.='		<h1>Liste des voitures</h1>
					<table>
						<tr>
							<th>Immatriculation</th>
							<th>Marque</th>
							<th>Type</th>
							<th>Année</th>
							<th>Kilometrage</th>
							<th>Date d\'arrivée</th>
							<th>Proprietaire</th>
							<th></th>
							<th></th>
						</tr>';
		foreach ($liste_voitures as $voiture){
		$out.='			<tr>
							<td>'.$voiture->immatriculation().'</td>
							<td>'.$voiture->marque().'</td>
							<td>'.$voiture->type().'</td>
							<td>'.$voiture->annee().'</td>
							<td>'.$voiture->kilometrage().'</td>
							<td>'.$voiture->date_arrivee().'</td>
							<td>'.$voiture->proprietaire().'</td>
							<td><a href="?page=formModifierVoiture&immatriculation='.$voiture->immatriculation().'">Modifier</a></td>
							<td><a href="?page=supprimerVoiture&immatriculation='.$voiture->immatriculation().'" onclick="return verifjs_suppr();">Supprimer</a></td>
						</tr>';
		}
		$out.='		</table>
				</div>';
		return $out;
	}
	
	public function formAjouterVoiture(){
		//[TODO]  Liste des client préchargée dans une liste déroulante + autre		
		$out='	<h1>Ajouter une voiture</h1>
				<div class="pageRecherche">
					<form action="?page=ajouterVoiture" id="getListVoitures_form" method="post" >
						<div class="table">
							<input type="text" class="table-cell" name="immatriculation" placeholder="Immatriculation : " >
							<input type="text" class="table-cell" name="marque" placeholder="Marque : " >
							<input type="text" class="table-cell" name="type" placeholder="Type : " ></div><div>
							<input type="text" class="table-cell" name="annee" placeholder="Année : " >
							<input type="text" class="table-cell" name="kilometrage" placeholder="Kilométrage : " >
							<input type="date" class="table-cell" name="date_arrivee" placeholder="Date d\'arrivée : " >
						</div>
							<label for="proprietaire">Propriétaire : </label>
							<select name="proprietaire">
								<option value="" rel="none">Non sélectionné</option>
								<option value="" rel="other_client">Autre</option>';
		$liste_clients = $this->_clientControleur->getList();
		foreach ($liste_clients as $client){
			$out.='				<option value="'.$client->numero().'" rel="none">'.$client->numero().'</option>';
		}
		$out.='				</select>';
		$out.='			<div rel="other_client" class="table"><div>
							<p>Nouveau client : </p>
							<input  type="text" class="table-cell" name="numero" placeholder="Numero : " ></div><div>
							<input  type="text" class="table-cell" name="nom" placeholder="Nom : " >
							<input  type="text" class="table-cell" name="prenom" placeholder="Prenom : " ></div><div>
							<input  type="text" class="table-cell" name="adresse" placeholder="Adresse : " >
							<input  type="text" class="table-cell" name="referent" placeholder="Referent : " ></div>
						</div>
						<p><input type="submit" class="ok" name="Ajouter" value="Ajouter"></p>
					</form>
				</div>';
		return $out;
	}
	
	public function ajouterVoiture(){
		//[TODO] msg de confirmation
		$this->_voitureControleur->addVoiture();
		$out='';
		
		//header ('Location: ?page=afficherVoitures');
		//exit();
	}
	
	public function formModifierVoiture(){
		//[TODO]  Liste des client préchargée dans une liste déroulante + autre
		//[TODO] recharger les données connues de la voiture
		$voiture = $this->_voitureControleur->get($_GET['immatriculation']);
		$out='	<h1>Ajouter une voiture</h1>
				<div class="pageRecherche">
					<form action="?page=modifierVoiture" id="getListVoitures_form" method="post" >
						<div class="table">
							<input type="text" class="table-cell" name="immatriculation" placeholder="Immatriculation : " value="'.$voiture->immatriculation().'" >
							<input type="text" class="table-cell" name="marque" placeholder="Marque : " value="'.$voiture->marque().'" >
							<input type="text" class="table-cell" name="type" placeholder="Type : " value="'.$voiture->type().'" ></div><div>
							<input type="text" class="table-cell" name="annee" placeholder="Année : " value="'.$voiture->annee().'" >
							<input type="text" class="table-cell" name="kilometrage" placeholder="Kilométrage : " value="'.$voiture->kilometrage().'" >
							<input type="date" class="table-cell" name="date_arrivee" placeholder="Date d\'arrivée : " value="'.$voiture->date_arrivee().'" >
						</div>
							<label for="proprietaire">Propriétaire : </label>
							<select name="proprietaire">
								<option value="" rel="none">Non sélectionné</option>
								<option value="" rel="other_client">Autre</option>';
		$liste_clients = $this->_clientControleur->getList();
		foreach ($liste_clients as $client){
			$selector = ($voiture->proprietaire()==$client->numero())?'selected':'';
			$out.='				<option value="'.$client->numero().'" rel="none" '.$selector.'>'.$client->numero().'</option>';
		}
		$out.='				</select>';
		$out.='			<div rel="other_client" class="table"><div>
							<p>Nouveau client : </p>
							<input  type="text" class="table-cell" name="numero" placeholder="Numero : " ></div><div>
							<input  type="text" class="table-cell" name="nom" placeholder="Nom : " >
							<input  type="text" class="table-cell" name="prenom" placeholder="Prenom : " ></div><div>
							<input  type="text" class="table-cell" name="adresse" placeholder="Adresse : " >
							<input  type="text" class="table-cell" name="referent" placeholder="Referent : " ></div>
						</div>
						<p><input type="submit" class="ok" name="Modifier" value="Modifier"></p>
					</form>
				</div>';
		return $out;
	}
	
	public function modifierVoiture(){
		//[TODO] msg de confirmation
		$this->_voitureControleur->editVoiture();
	}
	
	public function supprimerVoiture(){
		//[TODO] msg de confirmation
		$voiture = $this->_voitureControleur->get($_GET['immatriculation']);
		$this->_voitureControleur->deleteVoiture($voiture);
	}
	
	public function afficherClients(){
		
	}
}
?>