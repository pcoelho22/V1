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
	<form action="add_edit.php?search=<?= $_GET['search'] ?>" method="get">
		<fieldset>
			<input type="text" name="search">
			<input type="submit" value="remplir les champs">
		</fieldset>	
	</form>
	<br/><br/>
		<?php if(isset($_GET['mov_id'])): ?>
		<h1>Gestion du film: <?= $movieInfo['mov_title'] ?></h1>
		<form action="add_edit.php?mov_id=<?= $_GET['mov_id'] ?>" method="post" enctype="multipart/form-data" >
			<fieldset>
				<input type="text" name="title" placeholder="Titre du film" value="<?= $movieInfo['mov_title'] ?>"><br/>
				<input type="text" name="path" placeholder="Path" value="<?= $movieInfo['mov_path'] ?>"><br/>
				<input type="text" name="year" placeholder="Year" value="<?= $movieInfo['mov_year'] ?>"><br/>
				<textarea rows="4" cols="50" name="cast" placeholder="Cast"><?= $movieInfo['mov_cast'] ?></textarea><br/>
				<label>Genre</label>
				<select name="cat_id">
					<?php foreach ($cat_list as $key => $value): ?>
						<option value="<?= $value['cat_id'] ?>"><?= $value['cat_name'] ?></option>
					<?php endforeach; ?>
				</select><br/>
				<label>Storage</label>
				<select name="sto_id">
					<?php foreach ($sto_list as $key => $value2): ?>
						<option value="<?= $value2['sto_id'] ?>"><?= $value2['sto_name'] ?></option>
					<?php endforeach; ?>
				</select><br/>
				<textarea rows="4" cols="50" name="synopsis" placeholder="Synopsis" ><?= $movieInfo['mov_synopsis'] ?></textarea><br/>
				<input type="text" name="og_title" placeholder="Titre original" value="<?= $movieInfo['mov_original_title'] ?>"><br/>
				<input type="text" name="imageApi" placeholder="Lien de l'image api"><br/>
				<input type="file" name="image"><br/><br/>
				<input type="submit" name="valider" value="valider">
				<button><a href="confirmation.php?mov_id=<?= $_GET['mov_id'] ?>">supprimer</a></button>
			</fieldset>
	</form>
		<!-- -->
	<?php elseif (isset($_GET['search'])): ?>
		<h1>champs pre-remplis</h1>
		<form action="add_edit.php?search=<?= $_GET['search'] ?>" method="post" enctype="multipart/form-data" >
			<fieldset>
				<input type="text" name="title" placeholder="Titre du film" value="<?= $infoFilmImbd['Title'] ?>"><br/>
				<input type="text" name="path" placeholder="Path"><br/>
				<input type="text" name="year" placeholder="Year" value="<?= $infoFilmImbd['Year'] ?>"><br/>
				<textarea rows="4" cols="50" name="cast" placeholder="Cast"><?= $infoFilmImbd['Actors'] ?></textarea><br/>
				<label>Genre</label>
				<select name="cat_id">
					<?php foreach ($cat_list as $key => $value): ?>
						<option value="<?= $value['cat_id'] ?>"><?= $value['cat_name'] ?></option>
					<?php endforeach; ?>
				</select><br/> <h3>Genre Possibles: <?= $infoFilmImbd['Genre'] ?></h3>
				<label>Storage</label>
				<select name="sto_id">
					<?php foreach ($sto_list as $key => $value2): ?>
						<option value="<?= $value2['sto_id'] ?>"><?= $value2['sto_name'] ?></option>
					<?php endforeach; ?>
				</select><br/>
				<textarea rows="4" cols="50" name="synopsis" placeholder="Synopsis" ><?= $infoFilmImbd['Plot'] ?></textarea><br/>
				<input type="text" name="og_title" placeholder="Titre original" value="<?= $infoFilmImbd['Title'] ?>"><br/>
				<input type="text" name="imageApi" placeholder="Lien de l'image api" value="<?= $infoFilmImbd['Poster'] ?>"><br/>
				<input type="file" name="image"><br/><br/>
				<input type="submit" name="valider" value="valider">
			</fieldset>
	</form>
	<!-- -->
	<?php elseif (!isset($_GET['mov_id'])): ?>
		<form action="add_edit.php" method="post" enctype="multipart/form-data" >
			<fieldset>
				<input type="text" name="title" placeholder="Titre du film"><br/>
				<input type="text" name="path" placeholder="Path"><br/>
				<input type="text" name="year" placeholder="Year"><br/>
				<textarea rows="4" cols="50" name="cast" placeholder="Cast"></textarea><br/>
				<label>Genre</label>
				<select name="cat_id">
					<?php foreach ($cat_list as $key => $value): ?>
						<option value="<?= $value['cat_id'] ?>"><?= $value['cat_name'] ?></option>
					<?php endforeach; ?>
				</select><br/>
				<label>Storage</label>
				<select name="sto_id">
					<?php foreach ($sto_list as $key => $value2): ?>
						<option value="<?= $value2['sto_id'] ?>"><?= $value2['sto_name'] ?></option>
					<?php endforeach; ?>
				</select><br/>
				<textarea rows="4" cols="50" name="synopsis" placeholder="Synopsis"></textarea><br/>
				<input type="text" name="og_title" placeholder="Titre original"><br/>
				<input type="file" name="image"><br/>
				<input type="text" name="imageApi" placeholder="Lien de l'image api"><br/><br/>
				<input type="submit" name="valider" value="valider">
			</fieldset>
		</form>
<?php endif; ?>
</body>
</html>