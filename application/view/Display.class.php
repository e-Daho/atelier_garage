<?php
class Display{
	
	private $_utilisateurControleur;
	
	public function __construct(UtilisateurControleur $utilisateurControleur){
		$this->_utilisateurControleur=$utilisateurControleur;
		
	}
	
	public function accueil(){
		if ($this->_utilisateurControleur->isConnected()){
			$out = '<h1>Tableau de bord</h1>
					<div id="tableau_de_bord" class="largeCenter">
						<a href="?page=afficherVoitures">Voitures</a>
						<a href="?page=afficherClients">Clients</a>
						<a href="?page=afficherTechniciens">Techniciens</a></div><div id="tableau_de_bord" class="largeCenter">
						<a href="?page=afficherRepares">Réparations</a>
						<a href="?page=afficherFactures">Factures</a>
						<a href="?page=afficherInterventions">Interventions</a>';
			$out.=($_SESSION['Privileges']==3)?'<a href="?page=afficherUtilisateurs">Gestion Utilisateurs</a>':'';
			$out.='	</div>';
			return $out;
		}else{
			//ON redirige vers le formulaire de connexion
			header ('Location: ?page=connexion_form');
			exit();
		}
		return $out;
	}
	
}
?>