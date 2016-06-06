<?php 
	require ('inc/db.php');
	require_once ('inc/function.php');

	if (!empty($_GET['search'])) {
		$searchVal = $_GET['search'];

		/*$sql = "SELECT mov_title, mov_id, mov_year, mov_image, cat_name, mov_synopsis
		FROM movie 
		JOIN category ON category.cat_id = movie.cat_id
		WHERE mov_title LIKE :search
		OR mov_synopsis LIKE :search
		OR cat_name LIKE :search
		OR mov_path LIKE :search
		OR mov_cast LIKE :search";

		$pdoStatement = $pdo->prepare($sql);
		$pdoStatement->bindValue(":search","%$searchVal%");
		// Si erreur
		if ($pdoStatement->execute()) {
			$mov_search = $pdoStatement->fetchAll();
		}
		else{
			print_r($pdo->errorInfo());
		}*/

		$mov_search = searchResult($searchVal);
	}
	elseif (empty($_GET['search'])) {
		$sql = "SELECT mov_title, mov_id, mov_year, mov_image, cat_name, mov_synopsis
		FROM movie 
		JOIN category ON category.cat_id = movie.cat_id";

		$pdoStatement = $pdo->prepare($sql);
		// Si erreur
		if ($pdoStatement->execute()) {
			$mov_search = $pdoStatement->fetchAll();
		}
		else{
			print_r($pdo->errorInfo());
		}
	} 
	require_once('inc/nav.php');
	require ('inc/view_list.php');
?>