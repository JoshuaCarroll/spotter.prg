<?php

if (!empty($_POST)) { // Checks to see if it received a form submission
	$broster = fopen("BRoster.csv","r");
	while(! feof($broster)) {
		$player = fgetcsv($broster);
		$num1 = substr_replace($_POST["num"],"",-1);
		if ($player[0] == $num1) {
			$bplayer = $player[1];
		}
	}
	fclose($broster);
	
	$names = $_POST["names"].$num1." " . $bplayer ;
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

//				if (window.event) { // IE
//				   keynum = lastChar.keyCode;
//				} else if (lastChar.which) { // Netscape/Firefox/Opera
//				   keynum = lastChar.which;
//				}
				if (lastChar == "+") { // Lookup Bruins
					form1.submit(); // I don't remember if this is how its done
					return;}
//				} else if (key == "-") { // Lookup other team 
//					// You don't have this yet, so we'll just do the same thing for now
//					$("form1").submit(); // I don't remember if this is how its done
//					return false;
//				}
//				else if (keynum == "13") {
//					// Clear the value of players
//					getElementById("names").value = "";
//					return false;
//			}
			return ;
		}
	</script>
    </head>
    <body>
    	<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
			<input type="text" name="num" onkeyup="num_keypress(num)" autofocus >
			<textarea name="names" id="names" rows=10 cols=20>
				<?= $names ?>
			</textarea>
    	</form>    
    </body>

</html>
