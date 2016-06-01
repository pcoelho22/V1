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



<button class = "button1" ><a href="list.php?ses_id=<?= $sessionID ?>&nbPerPage=<?=$nbPerPage ?>&page=<?= ($currentPage+1) ?>">suivant</a></button>

	<?php

	if($currentPage!==0){?>
		<button class = "button2" ><a href="list.php?ses_id=<?= $sessionID ?>&nbPerPage=<?=$nbPerPage ?>&page=<?= ($currentPage-1) ?>">précédent</a></button>
	<?php }?>