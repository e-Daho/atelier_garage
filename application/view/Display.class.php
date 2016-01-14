<?php
class Display{
	
	private $_utilisateurControleur;
	
	public function __construct(UtilisateurControleur $utilisateurControleur){
		$this->_utilisateurControleur=$utilisateurControleur;
		
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
	
}
?>