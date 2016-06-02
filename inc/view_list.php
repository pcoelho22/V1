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
	<table>
		<thead>
			<tr>
				<td>Image</td>
				<td>Title</td>
				<td>Year</td>
				<td>Genres</td>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($moviesListe as $currentFilm) : ?>
				<tr>
					<td><a href="details.php?mov_id=<?= $currentFilm['mov_id'] ?>"><?= $currentFilm['mov_title'] ?> </a></td>
					<td><?= $currentFilm['mov_date_creation'] ?></td>
					<td><?= $currentFilm['mov_image'] ?></td>
					<td><?= $currentFilm['cat_name'] ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>

	<button class = "button1" ><a href="list.php?cat_id="<?= $catID ?>&nbPerPage=<?=$nbPerPage ?>&page=<?= ($currentPage+1) ?>">suivant</a></button>

	<?php

	if($currentPage!==0): ?>
		<button class = "button2" ><a href="list.php?cat_id="<?= $catID ?>&nbPerPage=<?=$nbPerPage ?>&page=<?= ($currentPage-1) ?>">précédent</a></button>
	<?php else :?>
	<p>aucun film</p>
	<?php endif; ?>
<?php endif; ?>
