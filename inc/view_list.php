
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body>
	<?php if (!isset($_GET['search'])):?>
		<form method="get">
		<input type="hidden" name="cat_id" value="<?=$catID?>">
		<select name="nbPerPage">
			<option value="1">1 par page</option>
			<option value="2">2 par page</option>
			<option value="3">3 par page</option>
			<option value="4">4 par page</option>
			<option value="5">5 par page</option>
			<option value="6">6 par page</option>
		</select>
		<input type="submit" value="OK">
		</form>


		<h3>Liste des films</h3>

		<?php if (isset($moviesListe) && sizeof($moviesListe) > 0) : ?>
			<?php foreach ($moviesListe as $currentFilm) : ?>
				<tr>
					<td><a href="details.php?mov_id=<?= $currentFilm['mov_id'] ?>"><?= $currentFilm['mov_title'] ?> </a></td>
					<td><?= $currentFilm['mov_year'] ?></td>
					<td><?= $currentFilm['mov_image'] ?></td>
					<td><?= $currentFilm['cat_name'] ?></td>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>
	<?php else: ?>
		<h3>Liste des films</h3>

		<?php if (isset($searchVal) && sizeof($mov_search) > 0) : ?>
			<?php foreach ($mov_search as $currentFilm) : ?>
				
				<img src="<?= $currentFilm['mov_image'] ?>">
				<div>
					<p>#<?= $currentFilm['mov_id'] ?> <a href="details.php?mov_id=<?= $currentFilm['mov_id'] ?>"> <?= $currentFilm['mov_title'] ?></a></p>
					<p><?= $currentFilm['mov_synopsis'] ?></p>
					<a href="details.php?mov_id=<?= $currentFilm['mov_id'] ?>">Details</a>
					<a href="add_edit.php?mov_id=<?= $currentFilm['mov_id'] ?>">Modifier</a>
				</div>
				<br/>
				<br/>
			
			<?php endforeach; ?>
		<?php endif; ?>
	<?php endif; ?>
</body>
</html>