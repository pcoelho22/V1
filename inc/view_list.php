<form method="get">
	<input type="hidden" name="ses_id" value="<?=$sessionID?>">
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
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($moviesListe as $currentFilm) : ?>
				<tr>
					<td><a href='student.php?stu_id=<?= $currentFilm['mov_id']?>'><?= $currentFilm['mov_name'] ?> </a></td>
					<td><?= $currentFilm[''] ?></td>
					<td><?= $currentFilm[''] ?></td>
					<td><?= $currentFilm[''] ?></td>
					<td><?= $currentFilm[''] ?></td>
					<td><?= $currentFilm[''] ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
<button class = "button1" ><a href="list.php?ses_id=<?= $sessionID ?>&nbPerPage=<?=$nbPerPage ?>&page=<?= ($currentPage+1) ?>">suivant</a></button>

	<?php

	if($currentPage!==0){?>
		<button class = "button2" ><a href="list.php?ses_id=<?= $sessionID ?>&nbPerPage=<?=$nbPerPage ?>&page=<?= ($currentPage-1) ?>">précédent</a></button>
	<?php }?>