<?php
	if (!empty($_POST)) { // Checks to see if it received a form submission
		$jerseyNumber = substr_replace($_POST["jerseyNumber"],"",-1);
		$lastCharacter = substr($_POST["jerseyNumber"], -1);
      /*if ($jerseyNumber == "54321") {
			shell_exec('sudo halt');
		} else*/
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
        <meta charset="UTF-8">
		<link type="text/css" rel="stylesheet" href="style.css" />
		<script type="text/javascript">
			function num_keypress() {
                var key = event.keyCode;
                if ((key == 107) || (key == 109)) { // 107 = + 109 = -  works 82419
                    form1.submit();
                    event.preventDefault();
                }
				else if (key == 9) { //13 = CR  works but have to press escape to stop Chrome from waiting a responce.
                    
					document.getElementById("ourTeam").innerHTML = "";
					document.getElementById("theirTeam").innerHTML = "";
					document.getElementById("hdnOurTeam").value = "";
					document.getElementById("hdnTheirTeam").value = "";
                    event.stopPropagation();
                }
				else if (lastChar == 164) { // $ send keycode 122  $ = 164
                    //document.documentElement.requestFullscreen(); // document.body.requestFullscreen();
					document.getElementById("jerseyNumber").value = "";          
                    event.preventDefault();
				}
//				else if (key == 40) { // ( 				    
//                    closeFullscreen(); //closeFullscreen not needed esc works
//					event.preventDefault();
//				}
				else {
                    event.preventDefault();
				}
			}
			
//			function openFullscreen() {
//			  document.body.requestFullscreen();
//			}
//			function closeFullscreen() {
//			  ocument.cancelFullScreen();
//			}
		</script>
    </head>
    <body>
    	<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
			<input type="text" name="jerseyNumber" id="jerseyNumber"  onkeyup="num_keypress()" ><!--return num_keypress(event) -->
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
