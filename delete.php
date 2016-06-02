<?php
require ('inc/db.php');
require ('inc/function.php');


if (!empty($_GET['mov_id'])) {
	$movieID = intval($_GET['mov_id']);
	// pour debug
	//print_r($_GET);
	$sql = '
		DELETE  
		FROM movie
		WHERE mov_id = :movieX
	';
	// J'exécute ma requête et je récupère les données dans $pdoStatement
	$pdoStatement = $pdo->prepare($sql);
	$pdoStatement->bindValue(':movieX', $movieID, PDO::PARAM_INT);
		// Si erreur
		if ($pdoStatement->execute() === false) {
			print_r($pdo->errorInfo());
		}
	header('Location: index.php');
}


?>