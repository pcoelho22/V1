<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title></title>
		<link rel="stylesheet" type="text/css" href="css/style.css">
	</head>
	<body>
		<div id="leftSide">

		<!--si la image est dans la DB <img src="" name="imageMovie">-->
		<img src="<?= $movieInfo['mov_image'] ?>"></img>

		<!--Year Movie -->
		<h3><?= $movieInfo['mov_year'] ?></h3>
		<!--Storage Movie-->
		<h3><?= $movieInfo['sto_name'] ?></h3>
		</div>

		<div id="rightSide">
			<!--lien vers fichier, manque le chemin-->
			<h2><a href=""><?= $movieInfo['mov_title'] ?></a></h2>
			<!--Name Movie -->
			<h3><?= $movieInfo['cat_name'] ?></h3>
			<!--Category Movie -->
			<p><?= $movieInfo['mov_synopsis'] ?></p>
			<!--Synopsis Movie -->
			<p><?= $movieInfo['mov_cast'] ?></p>
			<!--Cast Movie -->
			<p><?= $movieInfo['mov_path'] ?></p>
			<!--Path Movie -->
		</div>
	</body>
</html>


