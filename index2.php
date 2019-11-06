<?php
$arr = [5];
$message = "Didn't Connect";
$message2 = "Connected";
$query = "";
$playerDiv = "";
// Create connection

$conn = mysqli_connect("localhost", "root", "21802Ghc<", "SpotterDB");
if($conn === false) {
    echo "<script type='text/javascript'>alert('Didn't connect');</script>";
}
else {
	if (!empty($_POST)) { // Checks to see if it received a form submission
		if (($_POST["jerseyNumber"]) = "clear") {
            
			mysqli_query($conn,"DROP TABLE Screen;");
		}
		else {
			$jerseyNumber = substr_replace($_POST["jerseyNumber"],"",-1);
			$lastCharacter = substr($_POST["jerseyNumber"], -1);
		
        	if ($lastCharacter == "+") { // Test for Bruin
				// call the data for $jerseyNumber
				$query = "SELECT * FROM BRoster WHERE Number=$jerseyNumber;";
				$results = mysqli_query($conn,$query);
				// create an array of the data for player $jerseyNumber
				$row=mysqli_fetch_array($results,MYSQLI_NUM);
				//Read the name and position
				$name = $row[1];
				$position = $row[2];
			}
        	if ($lastCharacter == "-") { // test for Opposition
				// call the data for $jerseyNumber
				$query = "SELECT * FROM ORoster WHERE Number=$jerseyNumber;";
				$results = mysqli_query($conn,$query);
				// create an array of the data for player $jerseyNumber
				$row=mysqli_fetch_array($results,MYSQLI_NUM);
				//Read the name and position
				$name = $row[1];
				$position = $row[2];
			}

			$playerDiv = "<div class=\'player\'><span class=\'jerseyNumber\'>" . $jerseyNumber . "</span> <span class=\'name\'>" . $name . "</span> <span class=\'position\'>" . $position . "</span></div>";
            
			$query = "INSERT INTO `Screen` (`player`, `team`) VALUES ('$playerDiv', '$lastCharacter') ;";
        
			if((mysqli_query($conn,$query))==false)
			{
				echo "ERROR" . mysqli_error($conn) . "<br>";
			}
            $query = "SELECT * FROM Screen;";
            $result = mysqli_query($conn,$query);    
            while ($row = mysqli_fetch_assoc($result)){
                
                
                if ($row['team']=="+"){
                    $ourTeam = $row['player'] . $ourTeam;
                }
                elseif ($row['team']=="-"){
                    $theirTeam = $row['player'] . $theirTeam;
                }
                
            }
        }
	}
	
	// Now load the data from screen table
    
    
    

	mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Football Spotter Program</title>
        <meta charset="UTF-8">
		<link type="text/css" rel="stylesheet" href="style.css" />
		<script type="text/javascript">
			function num_keyup() {
                var key = event.keyCode;
                if ((key == 107) || (key == 109)) { // Plus or minus on keypad
                    form1.submit();
                    event.preventDefault();
                }
				else if (key == 13) { //Carriage return, send command to clear database
					document.getElementById(jerseyNumber).value="clear";
                }
				else {
                    console.log(key);
                    event.preventDefault();
				}
			}
			

		</script>
    </head>
    <body id="element">
    	<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="return false;" >
			<input type="text" name="jerseyNumber" id="jerseyNumber" onkeyup="num_keyup()" >
			<div id="ourTeam"><?= $ourTeam ?></div>
			<div id="theirTeam"><?= $theirTeam ?></div>
        </form>
		<script type="text/javascript">
			document.getElementById("jerseyNumber").focus();
		</script>
	</body>

</html>
