<?php
require 'inc/db.php';
require 'inc/nav.php';
require_once 'inc/function.php';

/*$sql = "SELECT movie.cat_id AS cat_id, category.cat_name AS Category, COUNT(movie.cat_id) AS nbMovies
	FROM movie
	INNER JOIN category ON category.cat_id = movie.cat_id
	GROUP BY category.cat_name
	LIMIT 4";

$pdoStatement = $pdo->query($sql);

//si erreur
if ($pdoStatement === false) {
	print_r($pdo->errorInfo());
}
else{
	//recuperer toutes les données
	$catList = $pdoStatement->fetchAll();
	//print_r($catList);
}*/

$catList = catListIndex();

/*$sql2 = "SELECT mov_image, mov_title, mov_id FROM movie ORDER BY mov_date_creation LIMIT 4";

$pdoStatement2 = $pdo->query($sql2);

//si erreur
if ($pdoStatement2 === false) {
	print_r($pdo->errorInfo());
}
else{
	//recuperer toutes les données
	$movListIndex = $pdoStatement2->fetchAll();
}*/

$movListIndex = movListIndex();

require 'inc/view_index.php';
?>

