<h3>Liste des catégories</h3>
<form action="search.php" method="get">
	<input type="text" name="search">
	<input type="submit" value="Rechercher">
</form>

<form method="get">
	<input type="hidden" name="cat_name" value="<?=$mcapp_sql1?>">
	<select name="cat_name">
		<option value="cat_id"></option>
	</select>
	<input type="submit" value="OK">
</form>
<h3>Liste des films</h3>
<table>
	<thead>
		<tr>
			<td>Affiche</td>
			<td>Titre du film</td>

		</tr>
	</thead>
</table>
