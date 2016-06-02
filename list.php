<?php
//Je crée PDO
require 'inc/db.php';

// Je recupère les cat_id via GET

if (!empty($_GET['cat_id'])) {
	$catID = intval($_GET['cat_id']); // Type ? int
	//echo $sessionID;exit;

	// Nombre de films par page
	$currentOffset = 0;
	$currentPage=1;
	$nbPerPage=4;

	if(!empty($_GET['nbPerPage'])){
		$nbPerPage = intval($_GET['nbPerPage']);
	}
	if(array_key_exists('page', $_GET)){
		$currentPage=intval($_GET['page']);
		$currentOffset=($currentPage-1)*$nbPerPage;
	}

	$sql = '
		SELECT mov_image, mov_title, mov_date_creation, category.cat_name
		FROM movie
		JOIN category ON category.cat_id = movie.cat_id
		WHERE cat_id = :catID
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
	}
}
//J'affiche ma page
	require 'inc/nav.php';
	require 'inc/view_list.php';
	require 'details.php';
?>