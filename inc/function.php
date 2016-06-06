<?php

function getMovieInfo($id_movie){
	global $pdo;
	//$pdo = connectToBd();

	$sql = "SELECT mov_id, mov_title
		FROM movie
		LEFT OUTER JOIN category ON category.cat_id = movie.cat_id
		LEFT OUTER JOIN storage ON storage.sto_id = movie.sto_id
		WHERE mov_id = :id_movie"; 
		
	$pdoStatement =  $pdo->prepare($sql);
	$pdoStatement->bindValue(':id_movie' , $id_movie, PDO::PARAM_INT);

	//si erreur
	if (!$pdoStatement->execute()) {
		print_r($pdo->errorInfo());
	}
	else{
		//recuperer toutes les données
		$infoMovie = $pdoStatement->fetch();
	}

	return $infoMovie;
}

function getMovieListSearch($search, $search2){
	global $pdo;
	//$pdo = connectToBd();

	$sql = "SELECT mov_id, mov_title
		LEFT OUTER JOIN category ON category.cat_id = movie.cat_id
		LEFT OUTER JOIN storage ON storage.sto_id = movie.sto_id
		WHERE mov_id = :id_movie
		OR mov_title LIKE :search OR mov_title LIKE :search2 
		OR mov_cast :search OR mov_cast :search2 
		OR mov_original_title LIKE :search OR mov_original_title LIKE :search2 
		OR category.cat_id LIKE :search OR category.cat_id LIKE :search2 ";

	$pdoStatement = $pdo->prepare($sql);
	$pdoStatement->bindValue(':search', "%$search%");
	$pdoStatement->bindValue(':search2', "%$search2%");

	if (!$pdoStatement->execute()) {
		print_r($pdo->errorInfo());
	}
	else{
		//recuperer toutes les données
		$movieListe = $pdoStatement->fetchAll();
		//print_r($etudiantListe);
	}

	return $movieListe;
}

function getNbElemTot($search, $search2){
	global $pdo;
	//$pdo = connectToBd();

	$sql2 = "SELECT COUNT(*) AS count
	FROM movie
	LEFT OUTER JOIN category ON category.cat_id = movie.cat_id
	LEFT OUTER JOIN storage ON storage.sto_id = movie.sto_id
	WHERE stu_name LIKE :search OR stu_name LIKE :search2 
	OR mov_title LIKE :search OR mov_title LIKE :search2 
	OR mov_cast LIKE :search OR mov_cast LIKE :search2 
	OR mov_original_title :search OR mov_original_title LIKE :search2 
	OR category.cat_id LIKE :search OR category.cat_id LIKE :search2 ";

	$pdoStatement2 = $pdo->prepare($sql2);
	$pdoStatement2->bindValue(':search', "%$search%");
	$pdoStatement2->bindValue(':search2', "%$search2%");

	if ($pdoStatement2->execute()) {
		$countElem = $pdoStatement2->fetch();
		$nbElemTot = intval($countElem['count']);
	}

	return $nbElemTot;
}

function getMovieList($id_session, $nbEtuPage, $currentOffset){
	global $pdo;
	//$pdo = connectToBd();

	$sql = "SELECT mov_id, mov_tittle
		FROM movie
		LEFT OUTER JOIN category ON category.cat_id = movie.cat_id
		LEFT OUTER JOIN storage ON storage.sto_id = movie.sto_id
		WHERE ses_id = :id_session
		LIMIT :offset, :nbEtuPage"; 
		
		$pdoStatement =  $pdo->prepare($sql);
		$pdoStatement->bindValue(':id_session', $id_session, PDO::PARAM_INT);
		$pdoStatement->bindValue(':nbEtuPage', $nbEtuPage, PDO::PARAM_INT);
		$pdoStatement->bindValue(':offset', $currentOffset, PDO::PARAM_INT);

		//si erreur
		if (!$pdoStatement->execute()) {
			print_r($pdo->errorInfo());
		}
		else{
			//recuperer toutes les données
			$movieListe = $pdoStatement->fetchAll();
		}

	return $movieListe;
}

function getElementTotList($id_session){
	global $pdo;
	//$pdo = connectToBd();

	$sql2 = "SELECT COUNT(*) AS count
			FROM movie
			WHERE cat_id = :idCategory";

	$pdoStatement2 = $pdo->prepare($sql2);
	$pdoStatement2->bindValue(':idCategory', $idCategory, PDO::PARAM_INT);

	if ($pdoStatement2->execute()) {
		$countElem = $pdoStatement2->fetch();
		$nbElemTot = intval($countElem['count']);
	}

	return $nbElemTot;
}

function getCategoyList(){
	global $pdo;
  	//$pdo = connectToBd();

	$sql = "SELECT cat_id, cat_name, cat_date_creation, cat_date_update FROM category";

	$pdoStatement = $pdo->query($sql);

	//si erreur
	if ($pdoStatement === false) {
		print_r($pdo->errorInfo());
	}
	else{
		//recuperer toutes les données
		$categoryList = $pdoStatement->fetchAll();
		//print_r($categoryList);
	}

	return $categoryList;
}

function getStatList(){
	global $pdo;
	//$pdo = connectToBd();

	$sql2 = "SELECT category.cat_name AS Category, COUNT(movie.cat_id) AS nbMovie
		FROM movie
		INNER JOIN category ON category.cat_id = movie.cat_id
		GROUP BY category.cat_name";


	$pdoStatement2 = $pdo->query($sql2);

	//si erreur
	if ($pdoStatement2 === false) {
		print_r($pdo->errorInfo());
	}
	else{
		//recuperer toutes les données
		$statList = $pdoStatement2->fetchAll();
		//print_r($categoryList);
	}

	return $statList;
}





//Index.php
function catListIndex(){
	global $pdo;

	$sql = "SELECT movie.cat_id AS cat_id, category.cat_name AS Category, COUNT(movie.cat_id) AS nbMovies
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
	}

	return $catList;
}

function movListIndex(){
	global $pdo;

	$sql2 = "SELECT mov_image, mov_title, mov_id FROM movie ORDER BY mov_date_creation LIMIT 4";

	$pdoStatement2 = $pdo->query($sql2);

	//si erreur
	if ($pdoStatement2 === false) {
		print_r($pdo->errorInfo());
	}
	else{
		//recuperer toutes les données
		$movListIndex = $pdoStatement2->fetchAll();
		//print_r($catList);
	}

	return $movListIndex;
}

//Search.php
function searchResult($search){
	global $pdo;

	$sql = "SELECT mov_title, mov_id, mov_year, mov_image, cat_name, mov_synopsis
	FROM movie 
	JOIN category ON category.cat_id = movie.cat_id
	WHERE mov_title LIKE :search
	OR mov_synopsis LIKE :search
	OR cat_name LIKE :search
	OR mov_path LIKE :search
	OR mov_cast LIKE :search";

	$pdoStatement = $pdo->prepare($sql);
	$pdoStatement->bindValue(":search","%$search%");
	// Si erreur
	if ($pdoStatement->execute()) {
		$mov_search = $pdoStatement->fetchAll();
	}
	else{
		print_r($pdo->errorInfo());
	}

	return $mov_search;
}

//details.php
function getMovieDetails($movId){
	global $pdo;

	$sql = '
		SELECT mov_id, mov_title, mov_cast, mov_synopsis, mov_path, mov_image, mov_year, sto_name, cat_name
		FROM movie
		JOIN category ON category.cat_id = movie.cat_id
		JOIN storage ON storage.sto_id = movie.sto_id
		WHERE mov_id = :movieX
	';

	// J'exécute ma requête et je récupère les données dans $pdoStatement
	$pdoStatement = $pdo->prepare($sql);
	$pdoStatement->bindValue(':movieX', $movId, PDO::PARAM_INT);
	// Si erreur
	if ($pdoStatement->execute() === false) {
		print_r($pdo->errorInfo());
	}
	// Je vérifie que la requête contient des résultats
	else if ($pdoStatement->rowCount() > 0) {
		// Je récupère le résultat dans un tableau
		$movieInfo = $pdoStatement->fetch();
	}

	return $movieInfo;
}

//edit_category.php
function updtCategory($newCatName, $cat_name){
	global $pdo;

	$sql3 = "UPDATE category SET cat_name = :newCatName WHERE cat_name = :catName";

	$pdoStatement2 = $pdo->prepare($sql3);

	$pdoStatement2->bindValue(":newCatName", $newCatName);
	$pdoStatement2->bindValue(":catName", $cat_name);

	if ($pdoStatement2->execute() === false) {
		print_r($pdo->errorInfo());
	}
	else{
		header('Location: edit_category.php');
	}
}

function insertCategory($newCatName){
	global $pdo;

	$sql3 = "INSERT INTO category (cat_name, cat_date_creation) VALUES (:newCatName, NOW())";

	$pdoStatement2 = $pdo->prepare($sql3);

	$pdoStatement2->bindValue(":newCatName", $newCatName);

	if ($pdoStatement2->execute() === false) {
		print_r($pdo->errorInfo());
	}
	else{
		header('Location: edit_category.php');
	}
}

//delete.php
function deleteMovie($movId){
	global $pdo;

	$sql = '
		DELETE  
		FROM movie
		WHERE mov_id = :movieX
	';
	// J'exécute ma requête et je récupère les données dans $pdoStatement
	$pdoStatement = $pdo->prepare($sql);
	$pdoStatement->bindValue(':movieX', $movId, PDO::PARAM_INT);
		// Si erreur
		if ($pdoStatement->execute() === false) {
			print_r($pdo->errorInfo());
		}
	header('Location: index.php');
}

//add_edit.php
function getStorageList(){
	global $pdo;

	$sql = "SELECT sto_name, sto_id FROM storage";
	$pdoStatement = $pdo->prepare($sql);
	// Si erreur
	if ($pdoStatement->execute()) {
		$sto_list = $pdoStatement->fetchAll();
	}
	return $sto_list;
}

function getMovieDetailsEdit($movId){
	global $pdo;

	$sql = "SELECT * FROM movie WHERE mov_id = :mov_id";
	
	$pdoStatement = $pdo->prepare($sql);
	$pdoStatement->bindValue(':mov_id', $movId, PDO::PARAM_INT);

	if ($pdoStatement->execute()) {
		$movieInfo = $pdoStatement->fetch();
	}
	else{
		echo "pas executé";
	}

	return $movieInfo;
}

function insertMovieWthFile($cat_id, $sto_id, $mov_title, $mov_year, $mov_cast, $mov_synopsis, $mov_path, $mov_original_title, $photo){
	global $pdo;

	$insertInto = "INSERT INTO movie(cat_id, sto_id, mov_title, mov_year, mov_cast, mov_synopsis, mov_path, mov_original_title, mov_image, mov_date_creation) VALUES( :cat_id, :sto_id, :titre, :annee, :acteurs, :synopsis, :filename, :ogTitre, :affiche, NOW())";

	// Je prépare ma requête
	$pdoStatement = $pdo->prepare($insertInto);
	// Je bind toutes les variables de requête
	$pdoStatement->bindValue(':cat_id', $cat_id, PDO::PARAM_INT);
	$pdoStatement->bindValue(':sto_id', $sto_id, PDO::PARAM_INT);
	$pdoStatement->bindValue(':titre', $mov_title);
	$pdoStatement->bindValue(':annee', $mov_year, PDO::PARAM_INT);
	$pdoStatement->bindValue(':acteurs', $mov_cast);
	$pdoStatement->bindValue(':synopsis', $mov_synopsis);
	$pdoStatement->bindValue(':filename', $mov_path);
	$pdoStatement->bindValue(':ogTitre', $mov_original_title);
	$pdoStatement->bindValue(':affiche', $photo);
	// J'exécute la requête, et ça me renvoi true ou false
	if ($pdoStatement->execute()) {
		$newId = $pdo->lastInsertId();
		// Je redirige sur la même page, à laquelle j'ajoute l'id du film créé => modification
		// Pas de formulaire soumis sur la page de redirection => pas de POST
		header('Location: details.php?mov_id='.$newId);
		//echo "insert ok avec image file";
	}
	else{
		echo $insertInto.'<br/>';
		print_r($pdoStatement->errorInfo());
	}
}

function insertMovieWthApi($cat_id, $sto_id, $mov_title, $mov_year, $mov_cast, $mov_synopsis, $mov_path, $mov_original_title, $imageApi){
	global $pdo;

	$insertInto = "INSERT INTO movie(cat_id, sto_id, mov_title, mov_year, mov_cast, mov_synopsis, mov_path, mov_original_title, mov_image, mov_date_creation) VALUES( :cat_id, :sto_id, :titre, :annee, :acteurs, :synopsis, :filename, :ogTitre, :affiche, NOW())";

	// Je prépare ma requête
	$pdoStatement = $pdo->prepare($insertInto);
	// Je bind toutes les variables de requête
	$pdoStatement->bindValue(':cat_id', $cat_id, PDO::PARAM_INT);
	$pdoStatement->bindValue(':sto_id', $sto_id, PDO::PARAM_INT);
	$pdoStatement->bindValue(':titre', $mov_title);
	$pdoStatement->bindValue(':annee', $mov_year, PDO::PARAM_INT);
	$pdoStatement->bindValue(':acteurs', $mov_cast);
	$pdoStatement->bindValue(':synopsis', $mov_synopsis);
	$pdoStatement->bindValue(':filename', $mov_path);
	$pdoStatement->bindValue(':ogTitre', $mov_original_title);
	$pdoStatement->bindValue(':affiche', $imageApi);

	// J'exécute la requête, et ça me renvoi true ou false
	if ($pdoStatement->execute()) {
		$newId = $pdo->lastInsertId();
		// Je redirige sur la même page, à laquelle j'ajoute l'id du film créé => modification
		// Pas de formulaire soumis sur la page de redirection => pas de POST
		header('Location: details.php?mov_id='.$newId);

		//echo "insert ok avec api";
	}
	else{
		print_r($pdoStatement->errorInfo());
	}
}


function updtImage($photo, $mov_id){
	global $pdo;

	$uptImage = "UPDATE movie SET mov_image = :image, mov_date_update = NOW() WHERE mov_id = :mov_id";
	$pdoStatement = $pdo->prepare($uptImage);
	$pdoStatement->bindValue(':mov_id' , $mov_id, PDO::PARAM_INT);
	$pdoStatement->bindValue(':image' , $photo);
	if ($pdoStatement->execute()){
		echo "L'image du film a bien été modifié<br/>";
	}
	else{
		echo "uptImage pas executé<br/>";
	}
}

function updtImageApi($imageApi, $mov_id){
	global $pdo;

	$uptImage = "UPDATE movie SET mov_image = :image, mov_date_update = NOW() WHERE mov_id = :mov_id";
	$pdoStatement = $pdo->prepare($uptImage);
	$pdoStatement->bindValue(':mov_id' , $mov_id, PDO::PARAM_INT);
	$pdoStatement->bindValue(':image' , $imageApi);
	if ($pdoStatement->execute()){
		echo "L'image du film a bien été modifié<br/>";
	}
	else{
		echo "uptImage pas executé <br/>";
	}
}

function updtTitle($imageApi, $mov_id){
	global $pdo;

	$uptTitle = "UPDATE movie SET mov_title = :title, mov_date_update = NOW() WHERE mov_id = :mov_id";
	$pdoStatement = $pdo->prepare($uptTitle);
	$pdoStatement->bindValue(':mov_id' , $mov_id, PDO::PARAM_INT);
	$pdoStatement->bindValue(':title' , $mov_title);
	if ($pdoStatement->execute()){
		echo "le titre du film a bien été modifier<br/>";
	}
	else{
		echo " uptTitle pas executé <br/>";
	}
}

function updtOgTitle($imageApi, $mov_id){
	global $pdo;

	$uptPath = "UPDATE movie SET mov_path = :chemin, mov_date_update = NOW() WHERE mov_id = :mov_id";
	$pdoStatement = $pdo->prepare($uptPath);
	$pdoStatement->bindValue(':mov_id' , $mov_id, PDO::PARAM_INT);
	$pdoStatement->bindValue(':chemin' , $mov_path);
	if ($pdoStatement->execute()){
		echo "le path du film a bien été modifier<br/>";
	}
	else{
		echo "uptPath pas executé <br/>";
	}
}

function updtPath($mov_path, $mov_id){
	global $pdo;

	$uptPath = "UPDATE movie SET mov_path = :chemin, mov_date_update = NOW() WHERE mov_id = :mov_id";
	$pdoStatement = $pdo->prepare($uptPath);
	$pdoStatement->bindValue(':mov_id' , $mov_id, PDO::PARAM_INT);
	$pdoStatement->bindValue(':chemin' , $mov_path);
	if ($pdoStatement->execute()){
		echo "le path du film a bien été modifier<br/>";
	}
	else{
		echo "uptPath pas executé <br/>";
	}
}


function updtCast($mov_cast, $mov_id){
	global $pdo;

	$uptCast = "UPDATE movie SET mov_cast = :cast, mov_date_update = NOW() WHERE mov_id = :mov_id";
	$pdoStatement = $pdo->prepare($uptCast);
	$pdoStatement->bindValue(':mov_id' , $mov_id, PDO::PARAM_INT);
	$pdoStatement->bindValue(':cast' , $mov_cast);
	if ($pdoStatement->execute()){
		echo "le cast du film a bien été modifier<br/>";
	}
	else{
		echo "uptCast pas executé <br/>";
	}
}

function updtMovieCategory($cat_id, $mov_id){
	global $pdo;

	$uptCategory = "UPDATE movie SET cat_id = :category, mov_date_update = NOW() WHERE mov_id = :mov_id";
	$pdoStatement = $pdo->prepare($uptCategory);
	$pdoStatement->bindValue(':mov_id' , $mov_id, PDO::PARAM_INT);
	$pdoStatement->bindValue(':category' , $cat_id, PDO::PARAM_INT);
	if ($pdoStatement->execute()){
		echo "la categorie du film a bien été modifier<br/>";
	}
	else{
		echo "uptCategory pas executé <br/>";
	}
}

function updtSynopsis($mov_synopsis, $mov_id){
	global $pdo;

	$uptSynopsis = "UPDATE movie SET mov_synopsis = :synopsis, mov_date_update  = NOW() WHERE mov_id = :mov_id";
	$pdoStatement = $pdo->prepare($uptSynopsis);
	$pdoStatement->bindValue(':mov_id' , $mov_id, PDO::PARAM_INT);
	$pdoStatement->bindValue(':synopsis' , $mov_synopsis);
	if ($pdoStatement->execute()){
		echo "la synopsis du film a bien été modifier<br/>";
	}
	else{
		echo "uptSynopsis pas executé <br/>";
	}
}

function updtYear($mov_year, $mov_id){
	global $pdo;

	$uptYear = "UPDATE movie SET mov_year = :year, mov_date_update  = NOW() WHERE mov_id = :mov_id";
	$pdoStatement = $pdo->prepare($uptYear);
	$pdoStatement->bindValue(':mov_id' , $mov_id, PDO::PARAM_INT);
	$pdoStatement->bindValue(':year' , $mov_year);
	if ($pdoStatement->execute()){
		echo "la synopsis du film a bien été modifier<br/>";
	}
	else{
		echo "uptSynopsis pas executé <br/>";
	}
}