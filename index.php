<?php
	if (!empty($_POST)) { // Checks to see if it received a form submission
		$jerseyNumber = substr_replace($_POST["jerseyNumber"],"",-1);
		$lastCharacter = substr($_POST["jerseyNumber"], -1);
		
		if ($lastCharacter == "+") {
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
		$playerDiv = "<div class='player'><span class='jerseyNumber'>" . $jerseyNumber . "</span> <span class='name'>" . $name . "</span><span class='position'>" . $position . "</span></div>";
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
			function num_keypress(e)
			{
					var char = e.value;
					var lastChar = char[char.length -1];

					if ((lastChar == "+") || (lastChar == "-")) { // Lookup player
						form1.submit();
						return false;
					}
					
					if (lastChar && lastChar.which){ //if which property of event object is supported (NN4)
						lastChar = lastChar;
						keynum = lastChar.which; //character code is contained in NN4's which property
					}
					else {
						lastChar = event;
						keynum = lastChar.keyCode; //character code is contained in IE's keyCode property
					}
				
					if (keynum == 13) { //if enter key
						document.getElementById("ourTeam").innerHTML = "";
						document.getElementById("theirTeam").innerHTML = "";
						document.getElementById("hdnOurTeam").value = "";
						document.getElementById("hdnTheirTeam").value = "";
						return false;
					}
					else if (keynum == 36) { // $
						openFullscreen();
					}
					else if (keynum == 40) { // $
						closeFullscreen();
					}
			}
			
			function openFullscreen() {
			  if (elem.requestFullscreen) {
				elem.requestFullscreen();
			  } else if (elem.mozRequestFullScreen) { /* Firefox */
				elem.mozRequestFullScreen();
			  } else if (elem.webkitRequestFullscreen) { /* Chrome, Safari and Opera */
				elem.webkitRequestFullscreen();
			  } else if (elem.msRequestFullscreen) { /* IE/Edge */
				elem.msRequestFullscreen();
			  }
			}

			function closeFullscreen() {
			  if (document.exitFullscreen) {
				document.exitFullscreen();
			  } else if (document.mozCancelFullScreen) { /* Firefox */
				document.mozCancelFullScreen();
			  } else if (document.webkitExitFullscreen) { /* Chrome, Safari and Opera */
				document.webkitExitFullscreen();
			  } else if (document.msExitFullscreen) { /* IE/Edge */
				document.msExitFullscreen();
			  }
			}
		</script>
    </head>
    <body>
    	<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
			<input type="text" name="jerseyNumber" id="jerseyNumber" onkeyup="return num_keypress(jerseyNumber)" autofocus size="1">
			<input type="hidden" id="hdnOurTeam" name="hdnOurTeam" value="<?= $ourTeam ?>">
			<input type="hidden" id="hdnTheirTeam" name="hdnTheirTeam" value="<?= $theirTeam ?>">
			<div id="ourTeam">
				<?= $ourTeam ?>
			</div>
			<div id="theirTeam">
				<?= $theirTeam ?>
			</div>
    	</form>       </body>

</html>
