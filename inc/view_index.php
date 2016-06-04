<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body>
	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

	<form action="search.php" method="get">
			<input type="text" name="search" value="" placeholder="Search..." />
			<input type="submit" value="rechercherHome" />
	</form>
	<!-- il faut faire un foreach-->
	<ul>
		<?php foreach ($catList as $key => $value) :?>
			<li><a href="list.php?cat_id=<?= $value['cat_id'] ?>"><?= $value['Category'] ?></a>: <?= $value['nbMovies'] ?></li>
		<?php endforeach; ?>
	</ul>

	<ul>
		<?php foreach ($movListIndex as $key => $value) :?>
			<li><img src="<?= $value['mov_image'] ?>"><br><p><a href="details.php?mov_id=<?= $value['mov_id']?>"><?= $value['mov_title'] ?></a></p></li>
		<?php endforeach; ?>
	</ul>
</body>
</html>