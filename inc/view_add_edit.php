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
	<form action="add_edit.php" method="post" enctype="multipart/form-data" >
		<fieldset>
			<input type="text" name="title" placeholder="Titre du film"><br/>
			<input type="test" name="path" placeholder="Path"><br/>
			<input type="textarea" name="cast" placeholder="Cast"><br/>
			<select name="categoty">
				
			</select><br/>
			<input type="textarea" name="synopsis" placeholder="Synopsis"><br/>
			<input type="text" name="og_title" placeholder="Titre original"><br/>
			<input type="file" name="image"><br/><br/>
			<input type="submit" name="valider" value="valider">
			<button><a href="delete.php?mov_id=">supprimer</a></button>
		</fieldset>
	</form>

</body>
</html>