<?php 
// J'inclue le nav
require 'inc/nav.php';

if (!empty($_GET['mov_id'])) {
	$movieID = intval($_GET['mov_id']);

}

?>
<h3>Are you sure you want to remove the movie?</h3>
<button class = "buttonYes" ><a href="delete.php?mov_id=<?= $movieID ?>">YES</a></button>
<button class = "buttonNon" ><a href="add_edit.php?mov_id=<?= $movieID ?>">NO</a></button>