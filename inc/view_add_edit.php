<!DOCTYPE html>
<html>
<head>
	<?php require ('inc/header.php') ?>
	<link rel="stylesheet" type="text/css" href="css/styleAddEdit.css">
	<title>ajout/modification de films</title>
</head>
<body>
	<?php require ('inc/nav.php') ?>
	<br/>
	<br/>
	<br/>
	<?php if (!isset($_GET['mov_id'])): ?>
		<form action="add_edit.php" method="post" enctype="multipart/form-data" >
			<fieldset>
				<input type="text" name="title" placeholder="Titre du film"><br/>
				<input type="text" name="path" placeholder="Path"><br/>
				<textarea rows="4" cols="50" name="cast" placeholder="Cast"></textarea><br/>
				<select name="categoty">
					
				</select><br/>
				<textarea rows="4" cols="50" name="synopsis" placeholder="Synopsis"></textarea><br/>
				<input type="text" name="og_title" placeholder="Titre original"><br/>
				<input type="file" name="image"><br/>
				<input type="text" name="imageApi" placeholder="Lien de l'image api"><br/><br/>
				<input type="submit" name="valider" value="valider">
			</fieldset>
		</form>
	<?php else: ?>
		<h1>Gestion du film: <?= $movieInfo['mov_title'] ?></h1>
		<form action="add_edit.php?mov_id=<?= $_GET['mov_id'] ?>" method="post" enctype="multipart/form-data" >
			<fieldset>
				<input type="text" name="title" placeholder="Titre du film" value="<?= $movieInfo['mov_title'] ?>"><br/>
				<input type="text" name="path" placeholder="Path" value="<?= $movieInfo['mov_path'] ?>"><br/>
				<textarea rows="4" cols="50" name="cast" placeholder="Cast"><?= $movieInfo['mov_cast'] ?></textarea><br/>
				<select name="categoty">
					
				</select><br/>
				<textarea rows="4" cols="50" name="synopsis" placeholder="Synopsis" ><?= $movieInfo['mov_synopsis'] ?></textarea><br/>
				<input type="text" name="og_title" placeholder="Titre original" value="<?= $movieInfo['mov_original_title'] ?>"><br/>
				<input type="text" name="imageApi" placeholder="Lien de l'image api"><br/>
				<input type="file" name="image"><br/><br/>
				<input type="submit" name="valider" value="valider">
				<button><a href="confirmation.php?mov_id=<?= $_GET['mov_id'] ?>">supprimer</a></button>
			</fieldset>
	</form>
<?php endif; ?>
</body>
</html>