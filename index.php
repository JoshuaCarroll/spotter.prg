<?php
	if (!empty($_POST)) { // Checks to see if it received a form submission
		$broster = fopen("BRoster.csv","r");
		$num1 = substr_replace($_POST["num"],"",-1);
			while(! feof($broster)) {
				$player = fgetcsv($broster);
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
					var flg = "";
					if (lastChar == "+") { // Lookup Bruins
						form1.submit();
						return false;
					} else if (lastChar == "-") { // Lookup other team 
						form1.submit(); 
						return false;
					}

					if(lastChar && lastChar.which){ //(NN4)
						lastChar = lastChar;
						keynum = lastChar.which;
					}
					else{
						lastChar = event;
						keynum = lastChar.keyCode; //(IE)
					}
					if(keynum == 13){ //if enter key
						document.getElementById("names").value = ""; //submit the form

						return false;
					}
					else{
						return true;
					}
			}
		</script>
    </head>
    <body>
    	<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
			<input type="text" name="num" onkeyup="num_keypress(num)" autofocus size="1">
			<textarea name="names" id="names" rows=10 cols=20>
				<?= $names ?>
			</textarea>
    	</form>    
    </body>

</html>
