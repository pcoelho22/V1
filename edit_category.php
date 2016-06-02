<?php
// Je crée PDO
require 'inc/db.php';

// Mettre ici le code pour la recherche
if (!empty($_GET['cat_id'])) {
	$cat_id = $_GET['cat_id'];

	$cat_name = array();//

	$sql = '
		SELECT cat_name
				FROM category
		        WHERE cat_id = :cat_id
		';

	$pdoStatement = $pdo->prepare($sql);

	// je donne la valeur au paramètre de requete
	$pdoStatement->bindValue(':cat_id',$cat_id);

// Si erreur
if ($pdoStatement->execute() === false) {
	print_r($pdo->errorInfo());
	}
else if ($pdoStatement->rowCount() > 0) {
	$cat_info = $pdoStatement->fetch();
	}
}

$sql = "SELECT cat_name, cat_id FROM category";
$pdoStatement = $pdo->prepare($sql);
// Si erreur
if ($pdoStatement->execute()) {
	$cat_list = $pdoStatement->fetchAll();
}



// J'affiche ma page
require 'inc/view_edit_category.php';