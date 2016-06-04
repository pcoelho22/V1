<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body>
	<h3>Liste des catégories</h3>
	<form action="edit_category.php?cat_name=<?= $value['cat_name'] ?>" method="get">
		<select name="cat_name">
			<?php foreach ($cat_list as $key => $value): ?>
				<option value="<?= $value['cat_name'] ?>"><?= $value['cat_name'] ?></option>
			<?php endforeach; ?>
		</select>
		<input type="submit" value="OK">
	</form>
	<?php if (isset($_GET['cat_name'])):?>
		<form action="edit_category.php" method="post">
		<input type="hidden" name="update" value="<?= $_GET['cat_name'] ?>">
		<input type="text" name="new_cat_name" value="<?= $_GET['cat_name'] ?>">
		<input type="submit" value="Modifier catégorie">
	</form>
	<?php else: ?>
	<form action="edit_category.php" method="post">
		<input type="text" name="new_cat_name">
		<input type="submit" value="Ajouter nouvelle catégorie">
	</form>
	<?php endif; ?>
</body>
</html>
