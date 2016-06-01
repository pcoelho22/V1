<?php 
// J'inclue le nav
require 'inc/nav.php';
// Je me connect DB
require 'inc/db.php';
require 'inc/list.php';

// je recupere mov_id choissi
if (!empty($_GET['mov_id'])) {
	$movieID = intval($_GET['mov_id']);
	// pour debug
	//print_r($_GET);
	$sql = '
		SELECT mov_id, mov_title, mov_cast, mov_synopsis, mov_path, mov_image, mov_year, sto_name, cat_name
		FROM movie
		LEFT OUTER JOIN category ON category.cat_id = movie.cat_id
		LEFT OUTER JOIN storage ON storage.sto_id = movie.sto_id
		WHERE mov_id = :movieX
	';

	// J'exécute ma requête et je récupère les données dans $pdoStatement
	$pdoStatement = $pdo->prepare($sql);
	$pdoStatement->bindValue(':movieX', $movieID, PDO::PARAM_INT);
		// Si erreur
		if ($pdoStatement->execute() === false) {
			print_r($pdo->errorInfo());
		}
		// Je vérifie que la requête contient des résultats
		else if ($pdoStatement->rowCount() > 0) {
			// Je récupère le résultat dans un tableau
			$movieInfo = $pdoStatement->fetch();
		}
}else{
	echo 'Aucun film !'
}



