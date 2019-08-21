<?php
	if (!empty($_POST)) { // Checks to see if it received a form submission
		$jerseyNumber = substr_replace($_POST["jerseyNumber"],"",-1);
		$lastCharacter = substr($_POST["jerseyNumber"], -1);
		
		if ($jerseyNumber == "54321") {
			shell_exec('sudo halt');
		} elseif ($lastCharacter == "+") {
			$roster = fopen("BRoster.csv","r");
		} elseif ($lastCharacter == "-") {
			$roster = fopen("Maxpreps.csv","r"); 
		}
		
		while(!feof($roster)) {
			$row = fgetcsv($roster);
			if ($row[0] == $jerseyNumber) {
				$name = $row[1];
				$position = $row[2];
			}
		}
		
		fclose($roster);

		$ourTeam = $_POST["hdnOurTeam"];
		$theirTeam = $_POST["hdnTheirTeam"];
		$playerDiv = "<div class='player'><span class='jerseyNumber'>" . $jerseyNumber . "</span> <span class='name'>" . $name . "</span> <span class='position'>" . $position . "</span></div>";
		if ($lastCharacter == "+") {
			
			$ourTeam = $_POST["hdnOurTeam"] . $playerDiv;
		} elseif ($lastCharacter == "-") {
			$theirTeam = $_POST["hdnTheirTeam"] . $playerDiv;
		}
	}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Football Spotter Program</title>
		<link type="text/css" rel="stylesheet" href="style.css" />
		<script type="text/javascript">
			function num_keypress(event) {
				var key = event.keyCode;
				console.log(key);
				if ((52 <= key) && (key <= 57)){} // 48 not $ 57 = (
				else if ((key == 109) || (key == 107)) { // 43 = execute 45 = insert
					form1.submit();
				}
				else if (key == 13) {
					document.getElementById("ourTeam").innerHTML = "";
					document.getElementById("theirTeam").innerHTML = "";
					document.getElementById("hdnOurTeam").value = "";
					document.getElementById("hdnTheirTeam").value = "";
				}
				else if (key == 52) { // $
					alert("$")
                    element.requestFullscreen(); //openFullscreen not right per google
					event.preventDefault();
				}
				else if (key == 57) { // ( not 40
					element.exitFullscreen(); //closeFullscreen not correct per google
					event.preventDefault();
				}
				else {
					event.preventDefault();
				}
			}
			
			function openFullscreen() {
			  document.documentElement.webkitRequestFullscreen();
			}

			function closeFullscreen() {
			  document.webkitCancelFullScreen();
			}
		</script>
    </head>
    <body>
    	<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
			<input type="text" name="jerseyNumber" id="jerseyNumber" onkeypress="return num_keypress(event)"> <!-- return num_keypress(event);-->
			<input type="hidden" id="hdnOurTeam" name="hdnOurTeam" value="<?= $ourTeam ?>">
			<input type="hidden" id="hdnTheirTeam" name="hdnTheirTeam" value="<?= $theirTeam ?>">
			<div id="ourTeam"><?= $ourTeam ?></div>
			<div id="theirTeam"><?= $theirTeam ?></div>
    	</form>
		<script type="text/javascript">
			document.getElementById("jerseyNumber").focus();
		</script>
	</body>

</html>
