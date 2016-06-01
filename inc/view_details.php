<div id="leftSide">

	<!--si la image est dans la DB <img src="" name="imageMovie">-->
	<p><?= $movieInfo['mov_image'] ?></p>
	<!--Year Movie -->
	<h3><?= $movieInfo['mov_year'] ?></h3>
	<!--Storage Movie-->
	<h3><?= $movieInfo['sto_name'] ?></h3>
</div>

<div id="rightSide">
	<!--lien vers fichier, manque le chemin-->
	<h2><a href=""><?= $movieInfo['mov_title'] ?></h2>
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
