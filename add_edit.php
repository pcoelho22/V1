<?php 
require ('inc/db.php');
require ('inc/function.php');

if (!empty($_POST)) {
	//print_r($_POST); 
	$extensionAutorisees = array('jpg', 'jpeg', 'png', 'gif', 'tif', 'svg');

	$title = trim($_POST['title']);
	$path = trim($_POST['path']);
	$cast = trim($_POST['cast']);
	$categoty = trim($_POST['categoty']);
	$synopsis = trim($_POST['synopsis']);
	$og_title = trim($_POST['og_title']);


	$titleValide = false;
	$pathValide = false;
	$castValide = false;
	$categotyValide = false;
	$synopsisValide = false;
	$og_titleValide = false;

	if (empty($title) || strlen($title) > 128) {
		echo 'le nom est vide ou trop long<br/>';
	}
	else {
		$titleValide = true;
	}

	if (empty($path) || strlen($path) > 255) {
		echo 'le path est vide ou trop long <br/>';
	}
	else {
		$pathValide = true;
	}

	if (empty($cast)) {
		echo 'le cast est vide<br/>';
	}
	else {
		$castValide = true;
	}

	if (empty($categoty)) {
		echo 'le prenom est vide ou trop court <br/>';
	}
	else {
		$categotyValide = true;
	}

	if (empty($synopsis)) {
		echo 'la synopsis est vide<br/>';
	}
	else {
		$synopsisValide = true;
	}

	if (empty($og_title) || strlen($og_title) > 128) {
		echo 'le titre originel est vide<br/>';
	}
	else {
		$og_titleValide = true;
	}
	if (isset($_GET['mov_id'])) {
		if ($titleValide || $og_titleValide || $pathValide && $castValide || $categotyValide || $synopsis || isset($_FILES)) {
			foreach ($_FILES as $key => $fichier) {
				// Je teste si le fichier a été uploadé
				if (!empty($fichier) && !empty($fichier['name'])) {
					print_r($fichier);
					if ($fichier['size'] <= 250000) {
						$filename = $fichier['name'];
						$dotPos = strrpos($filename, '.');
						$extension = strtolower(substr($filename, $dotPos+1));
						// Je test si c'est pas un hack (sur l'extension)
						//if (substr($fichier['name'], -4) != '.php') {
						if (in_array($extension, $extensionAutorisees)) {
							// Je déplace le fichier uploadé au bon endroit
							if (move_uploaded_file($fichier['tmp_name'], 'upload/'.md5($email).'.'.$extension)) {
								echo 'fichier téléversé<br />';
								$photo = md5($email).'.'.$extension;

								//fontion pour update
								if ($insertOk == true) {
									echo "L'étudiant a bien été modifié";
								}
								else{
									echo "Pas executé";
								}
							}
							else {
								echo 'une erreur est survenue<br />';
							}
						}
						else {
							echo 'extension interdite<br />';
						}
					}
					else {
						echo 'fichier trop lourd<br />';
					}
				}
			}
		}
	}
	else{
		if ($titleValide && $og_titleValide && $pathValide && $castValide && $categotyValide && $synopsis && isset($_FILES)) {
			foreach ($_FILES as $key => $fichier) {
				// Je teste si le fichier a été uploadé
				if (!empty($fichier) && !empty($fichier['name'])) {
					print_r($fichier);
					if ($fichier['size'] <= 250000) {
						$filename = $fichier['name'];
						$dotPos = strrpos($filename, '.');
						$extension = strtolower(substr($filename, $dotPos+1));
						// Je test si c'est pas un hack (sur l'extension)
						//if (substr($fichier['name'], -4) != '.php') {
						if (in_array($extension, $extensionAutorisees)) {
							// Je déplace le fichier uploadé au bon endroit
							if (move_uploaded_file($fichier['tmp_name'], 'upload/'.md5($email).'.'.$extension)) {
								echo 'fichier téléversé<br />';
								$photo = md5($email).'.'.$extension;

								//fontion pour insert
								if ($insertOk == true) {
									echo "L'étudiant a bien été ajouté";
								}
								else{
									echo "Pas executé";
								}
							}
							else {
								echo 'une erreur est survenue<br />';
							}
						}
						else {
							echo 'extension interdite<br />';
						}
					}
					else {
						echo 'fichier trop lourd<br />';
					}
				}
			}
		}
	}
}


require ('inc/view_add_edit.php');
?>