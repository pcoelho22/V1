<?php 
	if (!empty($_GET['search'])) {
		$searchVal = $_GET['search'];
	}
	else{
		$searchVal = '';
	} 
?>
<form action="search.php" method="get">
	<input type="text" name="search" value="<?= $searchVal ?>">
	<button type="submit">Rechercher</button>
</form>