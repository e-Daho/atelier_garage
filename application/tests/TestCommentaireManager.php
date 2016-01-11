<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
        <meta charset="utf-8" />
		<link rel="stylesheet" href="style.css" />
        <title>TestCommentaireManager</title>

<?php
	require('../objects/Commentaire.class.php');
	require('../managers/CommentaireManager.class.php');

try
{
	$db = new PDO('mysql:host=127.0.0.1; port=3307;dbname=atelier_garage', 'root', 'toor');
}
catch(Exception $e)
{
	die('Erreur : '.$e->getMessage());
}

$commentaire = new Commentaire([
	'voiture'=>'xyz-789-38',
	'technicien'=>7,
	'date'=>'',
	'texte'=>'Cette voiture a l\'air en salle état']);
	
print_r($commentaire);

//on cree le manager
$commentaireManager = new CommentaireManager($db);
//print_r($commentaireManager);

//on rajoute un commentaire en bdd
$commentaireManager->add($commentaire);

//on compte, doit retourner 1
echo $commentaireManager->count();

//on supprime la commentaire
//$commentaireManager->delete($commentaire);

//on verifie si elle existe en bdd (doit retourner 1 si oui, 0 si non)
//echo $commentaireManager->exists($commentaire);

//on test le get
//$commentaire = $commentaireManager->get('11');
/*if(empty($commentaire))
{echo "c'est vide";}
else
{print_r($commentaire);}*/

//on test update
$commentaire->setTexte('lol');
$resultat = $commentaireManager->update($commentaire);
echo (string)$resultat;

?>

	<body>
		
	</body>
	
</html>

<!--INSERT INTO `atelier_garage`.`commentaire` (`voiture`, `technicien`, `date`, `texte`, `kilometrage`, `date_arrivee`, `proprietaire`) VALUES ('abc-123-38', 'renault', 'sport', '1993', '200000', '1998', '20'); -->
