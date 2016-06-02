<pre><?php
require 'inc/db.php';
require 'inc/nav.php';
//require 'inc/search.php';

$sql = "SELECT category.cat_name AS Category, COUNT(movie.cat_id) AS nbMovies
	FROM movie
	INNER JOIN category ON category.cat_id = movie.cat_id
	GROUP BY category.cat_name"
	LIMIT 4;

$pdoStatement = $pdo->query($sql);

//si erreur
if ($pdoStatement === false) {
	print_r($pdo->errorInfo());
}
else{
	//recuperer toutes les données
	$catList = $pdoStatement->fetchAll();
	print_r($catList);
}

//return $catList;


require 'inc/view_index.php';
?>
</pre>

