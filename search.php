<?php 
//Je me connecte a la BD
require ('inc/db.php');
require ('inc/functions.php');

$rowCount = 0;
$nbEtuPage = 0;

if (!empty($_GET['search'])) {
	$searchEx = explode(' ', $_GET['search']);
	if (isset($searchEx[0])){
		$search = $searchEx[0];
	}
	else{
		$search = '';
	}
	if (isset($searchEx[1])) {
		$search2 = $searchEx[1];
	}
	else{
		$search2 = ' ';
	}
}
else{
	$search = '';
	$search2 = ' ';
}

$currentOffset = 0;
if (array_key_exists('offset', $_GET) && $_GET['offset'] > 0) {
	$currentOffset = intval($_GET['offset']);
}

$etudiantListe = array();

/*$sql = "SELECT stu_id, stu_email, stu_birthdate AS birthdate, stu_name, stu_firstname, cou_name, cit_name, mar_name, ses_id
	FROM student
	LEFT OUTER JOIN country ON country.cou_id = student.cou_id
	LEFT OUTER JOIN city ON city.cit_id = student.cit_id
	LEFT OUTER JOIN marital_status ON marital_status.mar_id = student.mar_id
	WHERE stu_name LIKE :search OR stu_name LIKE :search2 
	OR stu_firstname LIKE :search OR stu_firstname LIKE :search2 
	OR cit_name LIKE :search OR cit_name LIKE :search2 
	OR mar_name LIKE :search OR mar_name LIKE :search2 
	OR stu_email LIKE :search OR stu_email LIKE :search2 ";

$pdoStatement = $pdo->prepare($sql);
$pdoStatement->bindValue(':search', "%$search%");
$pdoStatement->bindValue(':search2', "%$search2%");

if (!$pdoStatement->execute()) {
	print_r($pdo->errorInfo());
}
else{
	//recuperer toutes les données
	$etudiantListe = $pdoStatement->fetchAll();
	//print_r($etudiantListe);
}*/
$etudiantListe = getStudentListSearch($search, $search2);

/*$sql2 = "SELECT COUNT(*) AS count
	FROM student
	LEFT OUTER JOIN country ON country.cou_id = student.cou_id
	LEFT OUTER JOIN city ON city.cit_id = student.cit_id
	LEFT OUTER JOIN marital_status ON marital_status.mar_id = student.mar_id
	WHERE stu_name LIKE :search OR stu_name LIKE :search2 
	OR stu_firstname LIKE :search OR stu_firstname LIKE :search2 
	OR cit_name LIKE :search OR cit_name LIKE :search2 
	OR mar_name LIKE :search OR mar_name LIKE :search2 
	OR stu_email LIKE :search OR stu_email LIKE :search2 ";

$pdoStatement2 = $pdo->prepare($sql2);
$pdoStatement2->bindValue(':search', "%$search%");
$pdoStatement2->bindValue(':search2', "%$search2%");

if ($pdoStatement2->execute()) {
	$countElem = $pdoStatement2->fetch();
	$nbElemTot = intval($countElem['count']);
}
*/
$nbElemTot = getNbElemTot($search, $search2);
require ('inc/list_view.php');