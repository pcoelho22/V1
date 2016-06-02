<?php
require 'inc/db.php'
require 'inc/nav.php';
require 'inc/search.php';

$sql = '
		SELECT mov_id, cat_name
		FROM movie
		JOIN category ON category.cat_id = movie.cat_id
		JOIN storage ON storage.sto_id = movie.sto_id
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





require 'inc/view_index.php';

