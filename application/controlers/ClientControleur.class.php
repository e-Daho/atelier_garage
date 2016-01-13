<?php
class ClientControleur{
	
	private $_clientManager;
	
	
	private $_numero;
	private $_nom;
	private $_prenom;
	private $_adresse;
	private $_referent;
	
	public function __construct(ClientManager $clientManager){
		$this->_clientManager=$clientManager;
	}
	
	public function get($numero){
		return $this->_clientManager->get($numero);
	}
	
	public function getList(){
		//[TODO] enlever le NULL
		$numero = '%';
		if (!empty($_POST['numero'])) {$numero.=$_POST['numero'].'%';}
		
		$nom = '%';
		if (!empty($_POST['nom'])) {$nom.=$_POST['nom'].'%';}
		
		$prenom = '%';
		if (!empty($_POST['prenom'])) {$prenom.=$_POST['prenom'].'%';}
			
		$adresse = '%';
		if (!empty($_POST['adresse'])) {$adresse.=$_POST['adresse'].'%';}		
		
		$referant = '%';
		if (!empty($_POST['referant'])) {$referant.=$_POST['referant'].'%';}	
		
		$liste_clients = $this->_clientManager->getList($numero, $nom, $prenom, $adresse, $referant, 'numero');
		return $liste_clients;
	}
	
	public function addClient(){
		//[TODO] Checker que l'immatriculation n'existe pas déjà
		//[TODO] Vérifier que tout les champs requis sont présents
		//[TODO] Si date vide -> date de jour
		//[TODO] page intermédiare de msg de confirmation
		
		if (!empty($_POST['numero'])) { $this->_clientManager->add(new Client($_POST));}
		
		//header ('Location: ?page=afficherClients');
		//exit();
	}
	
	public function editClient(){
		
		if (!empty($_POST['numero']) ) { $this->_clientManager->update(new Client($_POST));}
		
		header ('Location: ?page=afficherClients');
		exit();
	}
	
}
?>