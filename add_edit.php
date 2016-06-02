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

if (isset($_GET["search"])) {
	$champ = $_GET["search"];
	$search = file_get_contents("http://www.omdbapi.com/?t=$champ");
	$infoFilmImbd = json_decode($search, true);
	var_dump($infoFilmImbd);
}

if (!empty($_POST)) {
	//print_r($_POST); 
	$extensionAutorisees = array('jpg', 'jpeg', 'png', 'gif', 'tif', 'svg');

	/*$title = trim($_POST['title']);
	$path = trim($_POST['path']);
	$cast = trim($_POST['cast']);
	//$categoty = trim($_POST['categoty']);
	$synopsis = trim($_POST['synopsis']);
	$og_title = trim($_POST['og_title']);*/

	$cat_id = isset($_POST['cat_id']) ? intval(trim($_POST['cat_id'])) : 0;
	$sto_id = isset($_POST['sto_id']) ? intval(trim($_POST['sto_id'])) : 0;
	$mov_title = isset($_POST['title']) ? trim($_POST['title']) : '';
	$mov_original_title = isset($_POST['og_title']) ? trim($_POST['og_title']) : '';
	$mov_year = isset($_POST['mov_year']) ? trim($_POST['mov_year']) : 0;
	$mov_synopsis = isset($_POST['synopsis']) ? trim($_POST['synopsis']) : '';
	$mov_path = isset($_POST['path']) ? trim($_POST['path']) : '';
	$mov_cast = isset($_POST['cast']) ? trim($_POST['cast']) : '';
	$imageApi = isset($_POST['imageApi']) ? trim($_POST['imageApi']) : '';


	$titleValide = false;
	$pathValide = false;
	$castValide = false;
	$imageApiValide = false;
	$categotyValide = false;
	$synopsisValide = false;
	$og_titleValide = false;
	$movYearValide = false;
	$storageValide = false;

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

	if (empty($mov_year)) {
		echo "l'année est vide<br/>";
	}
	else{
		$movYearValide = true;
	}

	if (empty($sto_id)) {
		echo "le storage est vide<br/>";
	}
	else{
		$storageValide = true;
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
								if (move_uploaded_file($fichier['tmp_name'], 'upload/'.$mov_title.'.'.$extension)) {
									echo 'fichier téléversé<br />';
									$photo = 'upload/'.$mov_title.'.'.$extension;

									// J'écris ma requête dans une variable
									$insertInto = "INSERT INTO movie( cat_id, sto_id, mov_title, mov_year, mov_cast, mov_synopsis, mov_path, mov_original_title, mov_image, mov_date_creation, mov_date_updated ) VALUES( :cat_id, :sto_id, :titre, :annee, :acteurs, :synopsis, :filename, :ogTitre, :affiche, NOW(), NOW())";

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
										header('Location: details.php?mov_id='.$newId);

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