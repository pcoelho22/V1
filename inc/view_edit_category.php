<h3>Liste des catégories</h3>
<form action="edit_category.php" method="get">
	<select name="cat_id">
		<?php foreach ($cat_list as $key => $value): ?>
			<option value="<?= $value['cat_id'] ?>"><?= $value['cat_name'] ?></option>
		<?php endforeach; ?>
	</select>
	<input type="submit" value="OK">
</form>
<form action="edit_category.php" method="get">
	<input type="text" name="search">
	<input type="submit" value="Ajouter nouvelle catégorie">
</form>

