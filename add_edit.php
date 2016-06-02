<?php 
require ('inc/db.php');
require ('inc/function.php');

if (isset($_GET['mov_id'])) {
	$sql = "SELECT * FROM movie WHERE mov_id = :mov_id";
	
	$pdoStatement = $pdo->prepare($sql);
	$pdoStatement->bindValue(':mov_id', $_GET['mov_id'], PDO::PARAM_INT);

	if ($pdoStatement->execute()) {
		$movieInfo = $pdoStatement->fetch();
	}
	else{
		echo "pas executé";
	}
}

if (!empty($_POST)) {
	//print_r($_POST); 
	$extensionAutorisees = array('jpg', 'jpeg', 'png', 'gif', 'tif', 'svg');

	$title = trim($_POST['title']);
	$path = trim($_POST['path']);
	$imageApi = trim($_POST['imageApi']);
	$cast = trim($_POST['cast']);
	//$categoty = trim($_POST['categoty']);
	$synopsis = trim($_POST['synopsis']);
	$og_title = trim($_POST['og_title']);


	$titleValide = false;
	$pathValide = false;
	$castValide = false;
	$imageApiValide = false;
	$categotyValide = false;
	$synopsisValide = false;
	$og_titleValide = false;

	if (empty($title) || strlen($title) > 128) {
		echo 'le titre est vide ou trop long<br/>';
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

	if (empty($imageApi)) {
		echo "l'image de l'api est vide<br/>";
	}
	else {
		$imageApi = true;
	}

	if (empty($cast)) {
		echo 'le cast est vide<br/>';
	}
	else {
		$castValide = true;
	}

	if (empty($categoty)) {
		echo 'la categorie est vide<br/>';
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
		if ($titleValide || $og_titleValide || $pathValide || $castValide || $categotyValide || $synopsisValide || (isset($_FILES) || $imageApiValide)) {
			if (isset($_FILES)) {
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
								if (move_uploaded_file($fichier['tmp_name'], 'upload/'.$_GET['mov_id'].'.'.$extension)) {
									echo 'fichier téléversé<br />';
									$photo = 'upload/'.$_GET['mov_id'].'.'.$extension;

									$uptImage = "UPDATE movie SET mov_image = :image, mov_date_update = NOW() WHERE mov_id = :mov_id";
									$pdoStatement = $pdo->prepare($uptImage);
									$pdoStatement->bindValue(':mov_id' , $_GET['mov_id'], PDO::PARAM_INT);
									$pdoStatement->bindValue(':image' , $photo);
									if ($pdoStatement->execute()){
										echo "L'image du film a bien été modifié<br/>";
									}
									else{
										echo "uptImage pas executé<br/>";
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

			if ($imageApiValide) {
				$uptImage = "UPDATE movie SET mov_image = :image, mov_date_update = NOW() WHERE mov_id = :mov_id";
				$pdoStatement = $pdo->prepare($uptImage);
				$pdoStatement->bindValue(':mov_id' , $_GET['mov_id'], PDO::PARAM_INT);
				$pdoStatement->bindValue(':image' , $imageApi);
				if ($pdoStatement->execute()){
					echo "L'image du film a bien été modifié<br/>";
				}
				else{
					echo "uptImage pas executé <br/>";
				}
			}

			if ($titleValide) {
				$uptTitle = "UPDATE movie SET mov_title = :title, mov_date_update = NOW() WHERE mov_id = :mov_id";
				$pdoStatement = $pdo->prepare($uptTitle);
				$pdoStatement->bindValue(':mov_id' , $_GET['mov_id'], PDO::PARAM_INT);
				$pdoStatement->bindValue(':title' , $title);
				if ($pdoStatement->execute()){
					echo "le titre du film a bien été modifier<br/>";
				}
				else{
					echo " uptTitle pas executé <br/>";
				}
			}

			if ($og_titleValide) {
				$uptTitleOg = "UPDATE movie SET mov_original_title = :title, mov_date_update = NOW() WHERE mov_id = :mov_id";
				$pdoStatement = $pdo->prepare($uptTitleOg);
				$pdoStatement->bindValue(':mov_id' , $_GET['mov_id'], PDO::PARAM_INT);
				$pdoStatement->bindValue(':title' , $og_title);
				if ($pdoStatement->execute()){
					echo "le titre originel du film a bien été modifier<br/>";
				}
				else{
					echo "uptTitleOg pas executé <br/>";
				}
			}

			if ($pathValide) {
				$uptPath = "UPDATE movie SET mov_path = :chemin, mov_date_update = NOW() WHERE mov_id = :mov_id";
				$pdoStatement = $pdo->prepare($uptPath);
				$pdoStatement->bindValue(':mov_id' , $_GET['mov_id'], PDO::PARAM_INT);
				$pdoStatement->bindValue(':chemin' , $path);
				if ($pdoStatement->execute()){
					echo "le path du film a bien été modifier<br/>";
				}
				else{
					echo "uptPath pas executé <br/>";
				}
			}

			if ($castValide) {
				$uptCast = "UPDATE movie SET mov_cast = :cast, mov_date_update = NOW() WHERE mov_id = :mov_id";
				$pdoStatement = $pdo->prepare($uptCast);
				$pdoStatement->bindValue(':mov_id' , $_GET['mov_id'], PDO::PARAM_INT);
				$pdoStatement->bindValue(':cast' , $cast);
				if ($pdoStatement->execute()){
					echo "le cast du film a bien été modifier<br/>";
				}
				else{
					echo "uptCast pas executé <br/>";
				}
			}

			if ($categotyValide) {
				$uptCategory = "UPDATE movie SET cat_id = :category, mov_date_update = NOW() WHERE mov_id = :mov_id";
				$pdoStatement = $pdo->prepare($uptCategory);
				$pdoStatement->bindValue(':mov_id' , $_GET['mov_id'], PDO::PARAM_INT);
				$pdoStatement->bindValue(':category' , $categoty, PDO::PARAM_INT);
				if ($pdoStatement->execute()){
					echo "la categorie du film a bien été modifier<br/>";
				}
				else{
					echo "uptCategory pas executé <br/>";
				}
			}

			if ($synopsisValide) {
				$uptSynopsis = "UPDATE movie SET mov_synopsis = :synopsis, mov_date_update  = NOW() WHERE mov_id = :mov_id";
				$pdoStatement = $pdo->prepare($uptSynopsis);
				$pdoStatement->bindValue(':mov_id' , $_GET['mov_id'], PDO::PARAM_INT);
				$pdoStatement->bindValue(':synopsis' , $synopsis);
				if ($pdoStatement->execute()){
					echo "la synopsis du film a bien été modifier<br/>";
				}
				else{
					echo "uptSynopsis pas executé <br/>";
				}
			}
			
		}
	}
	else{
		if ($titleValide && $og_titleValide && $pathValide && $castValide && $categotyValide && $synopsis && (isset($_FILES) || $imageApiValide)) {
			if (isset($_FILES)) {
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
			else if ($imageApiValide){
				//fonction insert avec $imageApi au lieu de $photo
			}
		}
	}
}


require ('inc/view_add_edit.php');
?>