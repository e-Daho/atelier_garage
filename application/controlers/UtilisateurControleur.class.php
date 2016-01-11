<?php
class UtilisateurControleur{
	
	private $_bdd;
	
	public function __construct($bdd){
		$this->_bdd=$bdd;
	}
	
	public function isConnected(){
		if (!empty($_SESSION['pseudo'])) { //Si l'utilisateur est connecter, on retourne true
			return true;
		}else{
			return false;
		}
	}
	
	public function connexion(){
	
		if (!empty($_POST['Pseudo']) AND !empty($_POST['Password'])) { //On verifie qu'aucun champ n'est vide
		
			
			// Hachage du mot de passe, c'est à dire son cryptage
			$pass_hache = sha1($_POST['Password']);
			echo $pass_hache;
			
			//On recherche si le pseudo et le mot de passe correspondent à un utilisateur dans la base de donnee
			$requete=$this->_bdd->prepare('SELECT * FROM utilisateurs WHERE Pseudo = \''.$_POST['Pseudo'].'\' AND Pass = \''.$pass_hache.'\'');
			$requete->execute();
			$utilisateur=$requete->fetch();
			
			if (!empty($utilisateur)) { //Si on trouve un utilisateur avec le pseudo et le mot de passe, on connecte et on redirige vers l'accueil
				$_SESSION['id'] = $utilisateur['id'];
				$_SESSION['pseudo'] = $utilisateur['Pseudo'];
				$_SESSION['Privileges'] = $utilisateur['Privileges'];
				
				header ('Location: ?page=accueil');
				exit();
			
			} else { //Si on ne trouve pas de utilisateur avec ce pseudo et ce mot de passe, on affiche un msg
				$out = '<p class="msg_erreur" >Pseudo ou Password incorrect</p>';
			}
			
		} else { //Si il y a des champs vides alors qu'ils sont tous requis pour valider le formulaire, on affiche un msg
			$out = '<p class="msg_erreur" >Vous ne devriez pas être ici</p>';
		}
		
		//on retourne la variable $out pour qu'elle soit affichee plus tard
		return $out;
	}
	public function deconnexion() {

		session_destroy(); //On detruit les variables $_SESSION
		
		//ON redirige vers accueil
		header ('Location: ?page=accueil');
		exit();
	}
}
?>