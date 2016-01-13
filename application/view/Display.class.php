<?php
class Display{
	
	private $_voitureControleur;
	private $_utilisateurControleur;
	private $_technicienControleur;
	private $_repareControleur;
	private $_factureControleur;
	private $_interventionControleur;
	
	public function __construct(UtilisateurControleur $utilisateurControleur, VoitureControleur $voitureControleur, ClientControleur $clientControleur, TechnicienControleur $technicienControleur, RepareControleur $repareControleur, FactureControleur $factureControleur, InterventionControleur $interventionControleur){
		$this->_voitureControleur=$voitureControleur;
		$this->_utilisateurControleur=$utilisateurControleur;
		$this->_clientControleur=$clientControleur;
		$this->_technicienControleur=$technicienControleur;
		$this->_repareControleur=$repareControleur;
		$this->_factureControleur=$factureControleur;
		$this->_interventionControleur=$interventionControleur;
		
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
				<div id="tableau_de_bord" class="largeCenter">
					<a href="?page=afficherVoitures">Voitures</a>
					<a href="?page=afficherClients">Clients</a>
					<a href="?page=afficherTechniciens">Techniciens</a>
					<a href="?page=afficherRepares">Réparations</a>
					<a href="?page=afficherFactures">Factures</a>
					<a href="?page=afficherInterventions">Interventions</a>
				</div>';
		print_r($_SESSION);
		return $out;
	}
	
	//Voitures
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
		$liste_clients = $this->_clientControleur->getList('numero');
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
							<input type="text" class="table-cell" name="immatriculation" placeholder="Immatriculation : " required="required" >
							<input type="text" class="table-cell" name="marque" placeholder="Marque : " >
							<input type="text" class="table-cell" name="type" placeholder="Type : " ></div><div>
							<input type="text" class="table-cell" name="annee" placeholder="Année : " >
							<input type="text" class="table-cell" name="kilometrage" placeholder="Kilométrage : " >
							<input type="date" class="table-cell" name="date_arrivee" placeholder="Date d\'arrivée : " >
						</div>
							<label for="proprietaire">Propriétaire : </label>
							<select name="proprietaire" required="required" >
								<option value="" rel="none">Non sélectionné</option>
								<option value="" rel="other_client">Autre</option>';
		$liste_clients = $this->_clientControleur->getList('numero');
		foreach ($liste_clients as $client){
			$out.='				<option value="'.$client->numero().'" rel="none">'.$client->numero().'</option>';
		}
		$out.='				</select>';
		$out.='			<div rel="other_client" class="table"><div>
							<p>Nouveau client : </p>
							<input  type="text" class="table-cell" name="numero" placeholder="Numero : " required="required" ></div><div>
							<input  type="text" class="table-cell" name="nom" placeholder="Nom : " required="required" >
							<input  type="text" class="table-cell" name="prenom" placeholder="Prenom : " required="required" ></div><div>
							<input  type="text" class="table-cell" name="adresse" placeholder="Adresse : " >
							<input  type="text" class="table-cell" name="referent" placeholder="Referent : " ></div>
						</div>
						<p><input type="submit" class="ok" name="Ajouter" value="Ajouter"></p>
					</form>
				</div>';
		return $out;
	}
	
	public function ajouterVoiture(){
		return $this->_voitureControleur->addVoiture();
	}
	
	public function formModifierVoiture(){
		//[TODO]  Liste des client préchargée dans une liste déroulante + autre
		//[TODO] recharger les données connues de la voiture
		$voiture = $this->_voitureControleur->get($_GET['immatriculation']);
		$out='	<h1>Modifier une voiture</h1>
				<div class="pageRecherche">
					<form action="?page=modifierVoiture" id="getListVoitures_form" method="post" >
						<div class="table">
							<input type="text" class="table-cell" name="immatriculation" placeholder="Immatriculation : " value="'.$voiture->immatriculation().'" required="required" readonly="readonly" >
							<input type="text" class="table-cell" name="marque" placeholder="Marque : " value="'.$voiture->marque().'" >
							<input type="text" class="table-cell" name="type" placeholder="Type : " value="'.$voiture->type().'" ></div><div>
							<input type="text" class="table-cell" name="annee" placeholder="Année : " value="'.$voiture->annee().'" >
							<input type="text" class="table-cell" name="kilometrage" placeholder="Kilométrage : " value="'.$voiture->kilometrage().'" >
							<input type="date" class="table-cell" name="date_arrivee" placeholder="Date d\'arrivée : " value="'.$voiture->date_arrivee().'" >
						</div>
							<label for="proprietaire">Propriétaire : </label>
							<select name="proprietaire" required="required" >
								<option value="" rel="none">Non sélectionné</option>
								<option value="" rel="other_client">Autre</option>';
		$liste_clients = $this->_clientControleur->getList('numero');
		foreach ($liste_clients as $client){
			$selector = ($voiture->proprietaire()==$client->numero())?'selected':'';
			$out.='				<option value="'.$client->numero().'" rel="none" '.$selector.'>'.$client->numero().'</option>';
		}
		$out.='				</select>';
		$out.='			<div rel="other_client" class="table"><div>
							<p>Nouveau client : </p>
							<input  type="text" class="table-cell" name="numero" placeholder="Numero : " required="required" readonly="readonly" ></div><div>
							<input  type="text" class="table-cell" name="nom" placeholder="Nom : " required="required" >
							<input  type="text" class="table-cell" name="prenom" placeholder="Prenom : " required="required" ></div><div>
							<input  type="text" class="table-cell" name="adresse" placeholder="Adresse : " >
							<input  type="text" class="table-cell" name="referent" placeholder="Referent : " ></div>
						</div>
						<p><input type="submit" class="ok" name="Modifier" value="Modifier"></p>
					</form>
				</div>';
		return $out;
	}
	
	public function modifierVoiture(){
		return $this->_voitureControleur->editVoiture();
	}
	
	public function supprimerVoiture(){
		$voiture = $this->_voitureControleur->get($_GET['immatriculation']);
		return $this->_voitureControleur->deleteVoiture($voiture);
	}
	
	
	//Clients
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
					</form>
					<div class="alignRight">
						<form action="?page=formAjouterClient" method="post" >
							<p><input type="submit" class="ok" name="Ajouter" value="Ajouter"></p>
						</form>
					</div>
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
							<th></th>
							<th></th>
						</tr>';
		foreach ($liste_techniciens as $technicien){
		$out.='			<tr>
							<td>'.$technicien->numero().'</td>
							<td>'.$technicien->nom().'</td>
							<td>'.$technicien->prenom().'</td>
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
					</form>
					<div class="alignRight">
						<form action="?page=formAjouterRepare" method="post" >
							<p><input type="submit" class="ok" name="Ajouter" value="Ajouter"></p>
						</form>
					</div>
				</div>';
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
							<td>'.$facture->idFacture().'</td>
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
					</table>';
				
		/*$liste_factures_detail=$this->_factureControleur->getList();
		$out.='		<h1>Liste des factures</h1>
					<table>
						<tr>
							<th>Id Facture</th>
							<th>Prix Total</th>
							<th></th>
						</tr>';
		foreach ($liste_factures as $facture){
		$out.='			<tr>
							<td>'.$facture->idFacture().'</td>
							<td>'.$facture->prixTotal().'</td>
							<td><a href="?page=supprimerFacture&idFacture='.$facture->idFacture().'" onclick="return verifjs_suppr();">Supprimer</a></td>
						</tr>';
		}
		$out.='		</table>
				
				</div>';*/
		
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