<?php
//Je crée PDO
require 'inc/db.php';
require_once ('inc/function.php');

// Je recupère les cat_id via GET

if (!empty($_GET['cat_id'])) {
	$catID = intval($_GET['cat_id']); // Type ? int
	
	// Nombre de films par page
	$currentOffset = 0;
	$currentPage=1;
	$nbPerPage=3;

	if(!empty($_GET['nbPerPage'])){
		$nbPerPage = intval($_GET['nbPerPage']);
	}
	if(array_key_exists('page', $_GET)){
		$currentPage=intval($_GET['page']);
		$currentOffset=($currentPage-1)*$nbPerPage;
	}

	/*$sql = '
		SELECT mov_id, mov_image, mov_title, mov_year, category.cat_name
		FROM movie
		JOIN category ON category.cat_id = movie.cat_id
		WHERE category.cat_id = :catID
		LIMIT :offset,:nbPerPage
	';
	$pdoStatement = $pdo->prepare($sql);
	// je donne la valeur au paramètre de requete
	$pdoStatement->bindValue(':catID',$catID, PDO::PARAM_INT);
	$pdoStatement->bindValue(':nbPerPage', $nbPerPage, PDO::PARAM_INT);
	$pdoStatement->bindValue(':offset', $currentOffset, PDO::PARAM_INT);

	// Si erreur
	if ($pdoStatement ->execute()===false) {
		print_r($pdo->errorInfo());
	}
	else if ($pdoStatement->rowCount() > 0) {
		$moviesListe = $pdoStatement->fetchAll();
	}*/
	$moviesListe = getMovieList($catID, $nbPerPage, $currentOffset);
}
//J'affiche ma page
	require_once 'inc/nav.php';
	require 'inc/view_list.php';
	//require 'details.php';
?>