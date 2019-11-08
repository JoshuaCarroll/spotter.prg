<?php
$query = "";
$playerDiv = "";
 $refreshInterval = "checked";
// Create connection

$conn = mysqli_connect("localhost", "root", "21802Ghc<", "SpotterDB");

if (!empty($_POST)) { // Checks to see if it received a form submission
    $refreshInterval = ""; // Clear this because this person is entering values
	if (($_POST["jerseyNumber"]) == "clear") {
		mysqli_query($conn,"DROP * FROM Screen");
		
	}
	else {
		$jerseyNumber = substr_replace($_POST["jerseyNumber"],"",-1);
		$lastCharacter = substr($_POST["jerseyNumber"], -1);

		$playerTable = "";
		if ($lastCharacter == "+") { // Test for Bruin
			$playerTable = "BRoster";
		}
		else {
			$playerTable = "ORoster";
		}
		
		$query = "SELECT * FROM " . $playerTable . " WHERE Number='" . $jerseyNumber . "'";
		$results = mysqli_query($conn,$query);
		// create an array of the data for player $jerseyNumber
		$row = mysqli_fetch_array($results,MYSQLI_NUM);
		//Read the name and position
		$name = $row[1];
		$position = $row[2];

		$playerDiv = '<div class="player"><span class="jerseyNumber">' . $jerseyNumber . '</span> <span class="name">' . $name . '</span> <span class="position">' . $position . '</span></div>';
		$query = "INSERT INTO Screen (player, team) VALUES ('" . $playerDiv . "', '" . $lastCharacter . "') ;";

		mysqli_query($conn,$query);  // Let this show the error
		//if((mysqli_query($conn,$query))==false) {
		//	echo "ERROR" . mysqli_error($conn) . "<br>";
		//}
	}
} // no... THIS.. is the end of POST

// Initialize the variables
$ourTeam = "";
$theirTeam = "";

$query = "SELECT * FROM Screen";
$result = mysqli_query($conn,$query);    

while ($row = mysqli_fetch_assoc($result)) {
	if ($row['team']=="+") {
		$ourTeam = $ourTeam . $row['player'];  // Add the lastest to the END, not the beginning
	}
	elseif ($row['team']=="-") {
		$theirTeam = $theirTeam . $row['player'];
	}
}

mysqli_close($conn);
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
                if ((key == 107) || (key == 109) || (key == 189) || (key == 187)) { // Plus or minus
                    form1.submit();
                    event.preventDefault();
                }
		else if (key == 13) { //Carriage return, send command to clear database
		document.getElementById('jerseyNumber').value="clear";
                    form1.submit();
                    event.preventDefault();
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
			<input type="text" name="jerseyNumber" id="jerseyNumber" onkeyup="num_keyup()" />
			<div id="ourTeam"><?= $ourTeam ?></div>
			<div id="theirTeam"><?= $theirTeam ?></div>
			<label for="refresh">Auto refresh</label>
            <input type="checkbox" name="refresh" id="refresh" />
        </form>
        
		<script type="text/javascript">
			document.getElementById("jerseyNumber").focus();
            
            var refreshInterval = setInterval(refreshInterval_tick, 3000);
			
			function refreshInterval_tick() {
				if (document.getElementById("refresh").checked) {
					location.reload();
				}
			}
		</script>
	</body>

</html>
