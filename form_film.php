<?php

require 'inc/db.php';
// Si un formulaire a été soumis

if (!empty($_POST)) {
	//print_pre($_POST);
	// Récupération et traitement des variables du formulaire d'ajout/modification
	$mov_id = isset($_POST['mov_id']) ? intval(trim($_POST['mov_id'])) : 0;
	$cat_id = isset($_POST['cat_id']) ? intval(trim($_POST['cat_id'])) : 0;
	$sto_id = isset($_POST['sto_id']) ? intval(trim($_POST['sto_id'])) : 0;
	$mov_title = isset($_POST['mov_title']) ? trim($_POST['mov_title']) : '';
	$mov_original_title = isset($_POST['mov_original_title']) ? trim($_POST['mov_original_title']) : '';
	$mov_year = isset($_POST['mov_year']) ? trim($_POST['mov_year']) : 0;
	$mov_synopsis = isset($_POST['mov_synopsis']) ? trim($_POST['mov_synopsis']) : '';
	$mov_path = isset($_POST['mov_path']) ? trim($_POST['mov_path']) : '';
	$mov_cast = isset($_POST['mov_cast']) ? trim($_POST['mov_cast']) : '';
	$mov_image = isset($_POST['mov_image']) ? trim($_POST['mov_image']) : '';

	// si l'id dans le formulaire est > 0 => film existant => modification
	if ($mov_id > 0) {
		// J'écris ma requête dans une variable
		$updateSQL = '
			UPDATE movie
			SET mov_title = :titre,
			mov_original_title = :ogTitre,
			mov_year = :annee,
			mov_synopsis = :synopsis,
			mov_path = :description,
			mov_cast = :acteurs,
			mov_image = :affiche,
			cat_id = :cat_id,
			sto_id = :sto_id,
			fil_updated = NOW()
			WHERE fil_id = :fil_id
		';
		// Je prépare ma requête
		$pdoStatement = $pdo->prepare($updateSQL);
		// Je bind toutes les variables de requête
		$pdoStatement->bindValue(':titre', $mov_title);
		$pdoStatement->bindValue(':ogTitre', $mov_original_title);
		$pdoStatement->bindValue(':annee', $mov_year);
		$pdoStatement->bindValue(':synopsis', $mov_synopsis);
		$pdoStatement->bindValue(':description', $mov_path);
		$pdoStatement->bindValue(':acteurs', $mov_cast);
		$pdoStatement->bindValue(':affiche', $mov_image);
		$pdoStatement->bindValue(':fil_id', $mov_id);
		$pdoStatement->bindValue(':cat_id', $cat_id);
		$pdoStatement->bindValue(':sup_id', $sto_id);

		// J'exécute la requête, et ça me renvoi true ou false
		if ($pdoStatement->execute()) {
			// Je redirige sur la même page
			// Pas de formulaire soumis sur la page de redirection => pas de POST
			header('Location: form_film.php?id='.$mov_id);
			exit;
		}
	}
	// Sinon Ajout
	else {
		// J'écris ma requête dans une variable
		$insertInto = "INSERT INTO movie( cat_id, sto_id, mov_title, mov_year, mov_cast, mov_synopsis, mov_path, mov_original_title, mov_image, mov_date_creation, mov_date_updated ) VALUES( :cat_id, :sto_id, :titre, :annee, :acteurs, :synopsis, :filename, :ogTitre, :affiche, NOW(), NOW())";

		/*INSERT INTO movie( cat_id, sto_id, mov_title, mov_year, mov_cast, mov_synopsis, mov_path, mov_original_title, mov_image, mov_date_creation, mov_date_updated ) VALUES( :cat_id, :sto_id, :titre, :annee, :acteurs, :synopsis, :filename, :ogTitre, :affiche, NOW(), NOW())*/
		// Je prépare ma requête
		$pdoStatement = $pdo->prepare($insertInto);
		// Je bind toutes les variables de requête
		$pdoStatement->bindValue(':titre', $mov_title);
		$pdoStatement->bindValue(':ogTitre', $mov_original_title);
		$pdoStatement->bindValue(':annee', $mov_year);
		$pdoStatement->bindValue(':synopsis', $mov_synopsis);
		$pdoStatement->bindValue(':description', $mov_path);
		$pdoStatement->bindValue(':acteurs', $mov_cast);
		$pdoStatement->bindValue(':affiche', $mov_image);
		$pdoStatement->bindValue(':cat_id', $cat_id);
		$pdoStatement->bindValue(':sup_id', $sto_id);

		// J'exécute la requête, et ça me renvoi true ou false
		if ($pdoStatement->execute()) {
			$newId = $pdo->lastInsertId();
			// Je redirige sur la même page, à laquelle j'ajoute l'id du film créé => modification
			// Pas de formulaire soumis sur la page de redirection => pas de POST
			header('Location: form_film.php?id='.$newId);
			exit;
		}
	}
}

// J'initialise mes variables pour l'affichage du formulaire/de la page
$currentId = 0;
$cat_id = 0;
$sto_id = 0;
$mov_title = '';
$mov_original_title = '';
$mov_year = '';
$mov_synopsis = '';
$mov_path = '';
$mov_cast = '';
$mov_image = '';
$imdb = '';
$imdbCategory = '';
$imdbResultsList = array();
$noImdbResult = false;

// Si l'id est passé en paramètre de l'URL : "form_film.php?id=54" => $_GET['id'] à pour valeur 54
if (isset($_GET['id'])) {
	// Je m'assure que la valeur est un integer
	$currentId = intval($_GET['id']);

	// J'écris ma requête dans une variable
	$sql = 'SELECT cat_id, sto_id, mov_title, mov_year, mov_synopsis, mov_path, mov_cast, mov_image
	FROM movie
	WHERE mov_id = '.$currentId;
	// J'envoi ma requête à MySQL et je récupère le Statement
	$pdoStatement = $pdo->query($sql);
	// Si la requête a fonctionnée et qu'on a au moins une ligne de résultat
	if ($pdoStatement && $pdoStatement->rowCount() > 0) {
		// Je "fetch" les données de la première ligne de résultat dans $resList
		$resList = $pdoStatement->fetch();

		// Je récupère toutes les valeurs que j'affecte dans les variables destinées à l'affichage du formulaire
		// => ça me permet de pré-remplir le formulaire
		$cat_id = intval($resList['cat_id']);
		$sup_id = intval($resList['sup_id']);
		$mov_title = $resList['mov_title'];
		$mov_year = $resList['mov_year'];
		$mov_synopsis = $resList['mov_synopsis'];
		$mov_path = $resList['mov_path'];
		$mov_cast = $resList['mov_cast'];
		$mov_image = $resList['mov_image'];
	}
}

// Si un titre de film IMDb est passé en paramètre de l'URL : "form_film.php?imdb=the+matrix" => $_GET['imdb'] à pour valeur "the matrix"
// => Si une recherche sur le titre IMDb a été effectuée
if (isset($_GET['imdb'])) {
	// Je traite la chaine de caractères
	$imdb = strip_tags(trim($_GET['imdb']));

	// On inclut nos packages composer, avec l'API IMDb
	require_once 'vendor/autoload.php';

	// NE PAS retenir try - catch pour l'instant
	try {
		// J'effectue d'abord une recherche sur les termes passés en paramètre d'URL
		$imdbResultsList = \Jleagle\Imdb\Imdb::search($imdb);
		//print_pre($imdbResultsList);exit;
	}
	catch (Exception $e) {
		// Si une erreur survient, alors on n'a aucun résultat
		$noImdbResult = true;
	}

	// Si un titre exact de film a été renseigné ou si on n'a qu'un seul résultat lors de la recherche
	if (isset($_GET['imdbExact']) || sizeof($imdbResultsList) == 1) {
		// On vide le tableau de résultats de la recherche
		$imdbResultsList = array();
		try {
			// On récupère les infos sur un seul film
			$movie = \Jleagle\Imdb\Imdb::retrieve($imdb);
			
			// On donne les bonnes valeurs aux variables destinées à l'affichage
			// => pré-remplir le formulaire
			$mov_title = $movie->title;
			$mov_year = $movie->year;
			$mov_synopsis = $movie->plot;
			$mov_path = $movie->plot;
			$mov_cast = $movie->actors;
			$mov_image = $movie->poster;
			$imdbCategory = $movie->genre;
		}
		catch (Exception $e) {
		}
	}
}
