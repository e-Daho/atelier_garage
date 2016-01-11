<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
        <meta charset="utf-8" />
		<link rel="stylesheet" href="style.css" />
        <title>TestClientManager</title>

<?php
	require('../objects/Client.class.php');
	require('../managers/ClientManager.class.php');

try
{
	$db = new PDO('mysql:host=127.0.0.1; port=3307;dbname=atelier_garage', 'root', 'toor');
}
catch(Exception $e)
{
	die('Erreur : '.$e->getMessage());
}

/*$client = new Client([
	'numero'=>'12345',
	'nom'=>'PERROT',
	'prenom'=>'thomas',
	'adresse'=>'paris',
	'referent'=>'marc']);*/
	
//print_r($client);

//on cree le manager
$clientManager = new ClientManager($db);
//print_r($clientManager);

//on rajoute une client en bdd
//$clientManager->add($client);

//on compte, doit retourner 1
//echo $clientManager->count();

//on supprime la client
//$clientManager->delete($client);

//on verifie si elle existe en bdd (doit retourner 1 si oui, 0 si non)
//echo $clientManager->exists($client);

//on test le get
$client = $clientManager->get('20');
if(empty($client))
{echo "c'est vide";}
else
{print_r($client);}

//on test update
$client->setAdresse('Paris');
$client->setReferent('daho');
$resultat = $clientManager->update($client);
echo (string)$resultat;

//on test getList
//on rempli d'abord la bdd
/*$clients = [];
$clients[] = new Client([
	'numero'=>'abc-456-69',
	'nom'=>'peugeot',
	'prenom'=>'sport',
	'adresse'=>2005,
	'referent'=>'1000',
	'date_arrivee'=>new DateTime("2012-07-08 11:14:15.638276"),
	'proprietaire'=>'djoka']);

$clients[] = new Client([
	'numero'=>'abc-123-38',
	'nom'=>'peugeot',
	'prenom'=>'sport',
	'adresse'=>1993,
	'referent'=>'120000',
	'date_arrivee'=>new DateTime("2012-07-08 11:14:15.638276"),
	'proprietaire'=>'002']);

$clients[] = new Client([
	'numero'=>'def-123-38',
	'nom'=>'renault',
	'prenom'=>'citadine',
	'adresse'=>2003,
	'referent'=>'8000',
	'date_arrivee'=>new DateTime("2012-07-08 11:14:15.638276"),
	'proprietaire'=>'192']);

$clientManager->add($clients[0]);
$clientManager->add($clients[1]);
$clientManager->add($clients[2]);
*/
//on test la requete
//print_r($clientManager->getList('abc%','%','%','%','%','%','%','%'));
//print_r($clientManager->getList('%','%','%','%','%','%','%','2'));

?>

	<body>
		
	</body>
	
</html>

<!--INSERT INTO `atelier_garage`.`client` (`numero`, `nom`, `prenom`, `adresse`, `referent`, `date_arrivee`, `proprietaire`) VALUES ('abc-123-38', 'renault', 'sport', '1993', '200000', '1998', '20'); -->
