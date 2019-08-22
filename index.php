<?php
	if (!empty($_POST)) { // Checks to see if it received a form submission
		$jerseyNumber = substr_replace($_POST["jerseyNumber"],"",-1);
		$lastCharacter = substr($_POST["jerseyNumber"], -1);
/*      if ($jerseyNumber == "54321") {
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
		<link type="text/css" rel="stylesheet" href="style.css" />
		<script type="text/javascript">
			function num_keypress(event) {
				var char = event.value;
                var lastChar = char[char.length -1];
//                if(lastChar && lastChar.which){ //if which  property of event object is supported (NN4)
//					key = lastChar.which; //character code is contained in NN4's which property
//				}
//				else{
//					key = lastChar.keyCode; //character code is contained in IE's keyCode property
//				}
                    var key = event.keyCode;
                    alert(key);
                    //if ((40 <= key) && (key <= 36)){} // 48 = $ 57 = (
                    if ((lastChar == "+") || (lastChar == "-")) { // 43 = + 45 = -
                    form1.submit();
				}
				else if (key == 13) { //13 = CR
                    alert("CR");
					document.getElementById("ourTeam").innerHTML = "";
					document.getElementById("theirTeam").innerHTML = "";
					document.getElementById("hdnOurTeam").value = "";
					document.getElementById("hdnTheirTeam").value = "";
                }
				else if (lastChar == "$") { // $ was 36
                    openFullscreen(); // 
					//return false;
                    event.preventDefault();
				}
//				else if (key == 40) { // ( 				    
//                    closeFullscreen(); //closeFullscreen not needed esc works
//					event.preventDefault();
//				}
				else {
                    //alert("The End")
					return true;
                    event.preventDefault();
				}
			}
			
			function openFullscreen() {
			  document.body.requestFullscreen();
			}

//			function closeFullscreen() {
//			  ocument.cancelFullScreen();
//			}
		</script>
    </head>
    <body>
    	<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
			<input type="text" name="jerseyNumber" id="jerseyNumber" onkeyup="num_keypress(jerseyNumber)" ><!-- -->
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
