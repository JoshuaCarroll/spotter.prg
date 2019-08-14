<?php
	if (!empty($_POST)) { // Checks to see if it received a form submission
		$jerseyNumber = substr_replace($_POST["num"],"",-1);
		$lastCharacter = substr($_POST["num"], -1);
		
		if ($lastCharacter == "+") {
			$roster = fopen("BRoster.csv","r");
		} elseif ($lastCharacter == "-") {
			$roster = fopen("BRoster.csv","r"); // What's the filename? You didn't upload it
		}
		
		while(! feof($roster)) {
			$row = fgetcsv($roster);
			if ($row[0] == $jerseyNumber) {
				$name = $row[1];
				$position = $row[2];
			}
		}
		
		fclose($roster);

		$names = $_POST["names"] . $jerseyNumber . " " . $name;
	}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Football Spotter Program</title>
		<script type="text/javascript">
			function num_keypress(e)
			{
					var char = e.value;
					var lastChar = char[char.length -1];
					var flg = "";
					if ((lastChar == "+") || (lastChar == "-")) { // Lookup Bruins
						form1.submit();
						return false;
					}
					else if(keynum == 13) { //if enter key
						document.getElementById("ourTeam").innerHTML = "";
						document.getElementById("theirTeam").innerHTML = "";
						return false;
					}
					else {
						return true;
					}
			}
		</script>
    </head>
    <body>
    	<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
			<input type="text" name="jerseyNumber" id="jerseyNumber" onkeyup="num_keypress(num)" autofocus size="1">
			<input type="hidden" name="ourTeam" value="<?= $ourTeam ?>">
			<input type="hidden" name="theirTeam" value="<?= $theirTeam ?>">
			<div id="ourTeam">
				<?= $ourTeam ?>
			</div>
			<div id="theirTeam">
				<?= $theirTeam ?>
			</div>
    	</form>    
    </body>

</html>
