<?php
// Je crée PDO
require 'inc/db.php';


$sql = "SELECT cat_name, cat_id FROM category";
$pdoStatement = $pdo->prepare($sql);
// Si erreur
if ($pdoStatement->execute()) {
	$cat_list = $pdoStatement->fetchAll();
}

if (!empty($_POST) && !empty($_POST['update'])) {

	$newCatName = trim($_POST['new_cat_name']);
	$cat_name = $_POST['update'];

	$sql3 = "UPDATE category SET cat_name = :newCatName WHERE cat_name = :catName";

	$pdoStatement2 = $pdo->prepare($sql3);

	$pdoStatement2->bindValue(":newCatName", $newCatName);
	$pdoStatement2->bindValue(":catName", $_POST['update']);

	if ($pdoStatement2->execute() === false) {
		print_r($pdo->errorInfo());
	}
	else{
		header('Location: edit_category.php');
	}
}
else if(!empty($_POST)){
	$newCatName = trim($_POST['new_cat_name']);

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





// J'affiche ma page
require ('inc/nav.php');
require 'inc/view_edit_category.php';