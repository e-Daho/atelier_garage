<?php
session_start();

// appel des fichiers de classes :
function chargerClasse($classe){
	require_once ROOT_PATH.'/application/.'.$classe.'.php';
}
spl_autoload_register('chargerClasse');


require_once ROOT_PATH.'/application/controlers/UtilisateurControleur.class.php';

require_once ROOT_PATH.'/application/objects/Voiture.class.php';
require_once ROOT_PATH.'/application/objects/Client.class.php';
require_once ROOT_PATH.'/application/objects/Technicien.class.php';
require_once ROOT_PATH.'/application/objects/Repare.class.php';

require_once ROOT_PATH.'/application/managers/VoitureManager.class.php';
require_once ROOT_PATH.'/application/managers/ClientManager.class.php';
require_once ROOT_PATH.'/application/managers/TechnicienManager.class.php';
require_once ROOT_PATH.'/application/managers/RepareManager.class.php';

require_once ROOT_PATH.'/application/controlers/VoitureControleur.class.php';
require_once ROOT_PATH.'/application/controlers/ClientControleur.class.php';
require_once ROOT_PATH.'/application/controlers/TechnicienControleur.class.php';
require_once ROOT_PATH.'/application/controlers/RepareControleur.class.php';

require_once ROOT_PATH.'/application/view/Display.class.php';

require_once ROOT_PATH.'/application/connexion.php';



//Connection à la base de donnee ; En cas d'erreur, on affiche un message et on arrête tout grâce aux ligne de code en fin de cette page.
try {
	$bdd = new PDO('mysql:host=localhost;dbname=atelier_garage', $identifiant, $motdepasse);

//instancie les managers, les controleurs, et la vue
$utilisateurControleur = new UtilisateurControleur($bdd);

$clientManager = new ClientManager($bdd);
$voitureManager = new VoitureManager($bdd);
$technicienManager = new TechnicienManager($bdd);
$repareManager = new RepareManager($bdd);

$clientControleur = new ClientControleur($clientManager);
$voitureControleur = new VoitureControleur($voitureManager, $clientControleur);
$technicienControleur = new TechnicienControleur($technicienManager);
$repareControleur = new RepareControleur($repareManager);

$display = new Display($utilisateurControleur, $voitureControleur, $clientControleur, $technicienControleur, $repareControleur);
	
	
//recupère le nom de la page demandee, ou redirige vers accueil s'il n'y en a pas
if( isset($_GET['page']) ){
	$page = $_GET['page'];
} else {
	$page = 'accueil';
}
//definie le nom de l'onglet dans le navigateur avec le nom de la page
$titre = 'Garage - '.$page;

//Active la fonction correspondant à la page demandee
//Une fonction permet soit le deroulement d'un process invisible, soit l'edition dans la variable $out du contenu de la page (hors header, menu, ou footer)
switch($page){
	case 'accueil': //"Dans le cas où $page==accueil, faire ce qui suit jusqu'au prochain break;
		$out = $display->accueil();
		break;
	case 'tableau_de_bord':
		$out = $display->tableau_de_bord();
		break;
		
	case 'connexion_form':
		$out = $display->connexion_form();
		break;
	case 'connexion':
		$out = $utilisateurControleur->connexion();
		break;
	case 'deconnexion':
		$out = $utilisateurControleur->deconnexion();
		break;
		
	//voitures
	case 'afficherVoitures':
		$out = $display->afficherVoitures();
		break;
	case 'formAjouterVoiture':
		$out = $display->formAjouterVoiture();
		break;
	case 'ajouterVoiture':
		$out = $display->ajouterVoiture();
		break;
	case 'formModifierVoiture':
		$out = $display->formModifierVoiture();
		break;
	case 'modifierVoiture':
		$out = $display->modifierVoiture();
		break;
	case 'supprimerVoiture':
		$out = $display->supprimerVoiture();
		break;
		
	//clients
	case 'afficherClients':
		$out = $display->afficherClients();
		break;
	case 'formAjouterClient':
		$out = $display->formAjouterClient();
		break;
	case 'ajouterClient':
		$out = $display->ajouterClient();
		break;
	case 'formModifierClient':
		$out = $display->formModifierClient();
		break;
	case 'modifierClient':
		$out = $display->modifierClient();
		break;
	case 'supprimerClient':
		$out = $display->supprimerClient();
		break;
		
	//techniciens
	case 'afficherTechniciens':
		$out = $display->afficherTechniciens();
		break;
	case 'formAjouterTechnicien':
		$out = $display->formAjouterTechnicien();
		break;
	case 'ajouterTechnicien':
		$out = $display->ajouterTechnicien();
		break;
	case 'formModifierTechnicien':
		$out = $display->formModifierTechnicien();
		break;
	case 'modifierTechnicien':
		$out = $display->modifierTechnicien();
		break;
	case 'supprimerTechnicien':
		$out = $display->supprimerTechnicien();
		break;
		
	//repares
	case 'afficherRepares':
		$out = $display->afficherRepares();
		break;
	/*case 'formAjouterRepare':
		$out = $display->formAjouterRepare();
		break;
	case 'ajouterRepare':
		$out = $display->ajouterRepare();
		break;
	case 'formModifierRepare':
		$out = $display->formModifierRepare();
		break;
	case 'modifierRepare':
		$out = $display->modifierRepare();
		break;
	case 'supprimerRepare':
		$out = $display->supprimerRepare();
		break;*/


	default:	//cas où le nom de la page ne correspond à aucun cas precedent.
		$out = 'la page '.$page.' n\'éxiste pas';
		$titre = 'erreur';
		break;
}

// appel de la page skeleton.phtml, qui affiche le contenu des page. Jusqu'ici, rien n'est affiche, le contenu est dans $out. 
require_once ROOT_PATH.'/application/templates/skeleton.phtml';



// En cas d'erreur, on affiche un message et on arrête tout
} catch(PDOException $e) {
	$titre = 'erreur';
	$out = $e->getMessage().'<br />'.print_r($bdd->errorInfo(), true);
	require_once ROOT_PATH.'/application/templates/skeleton.phtml';
}
?>