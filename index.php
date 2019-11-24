<?php
$query = "";
$playerDiv = "";
$refreshInterval = "checked";
// Create connection

$row = 0;
if (($handle = fopen("../.sec/hold", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
        //echo "<p> $num fields in line $row: <br /></p>\n";
        
        if ($row = 1) {
            $host_name = $data[0];
            $database = $data[1];
            $yser_name = $data[2];
            $password = $data[3];
            
        }
        $row++;
        
    } 
    
} 

fclose($handle);

echo $row . "  " . $host_name . "<br>";
    $host_name = 'db5000222557.hosting-data.io';
    $database = 'dbs217277';
    $user_name = 'dbu341512';
    $password = '1234Passw0rd?';
    $conn = mysqli_connect($host_name, $user_name, $password, $database);

    if (mysqli_connect_errno()) {
      die('<p>Failed to connect to MySQL: '.mysqli_connect_error().'</p>');
    } 
//$conn = mysqli_connect("localhost", "root", "Passw0rd?", "dbs217277");
if ($conn == false){echo "error loading db";}
if (!empty($_POST)) { // Checks to see if it received a form submission
    $refreshInterval = ""; // Clear this because this person is entering values
	if (($_POST["jerseyNumber"]) == "clear") {
		mysqli_query($conn,"DELETE FROM Screen");
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
		$query = "SELECT * FROM $playerTable WHERE Number=$jerseyNumber;";
		$results = mysqli_query($conn,$query);
		// create an array of the data for player $jerseyNumber
        if ($results == false) {echo (mysqli_error_list($conn));}
		$row = mysqli_fetch_array($results,MYSQLI_NUM);
		//Read the name and position
		$name = $row[1];
		$position = $row[2];
		$playerDiv = '<div class="player"><span class="jerseyNumber">' . $jerseyNumber . '</span> <span class="name">' . $name . '</span> <span class="position">' . $position . '</span></div>';
		$query = "INSERT INTO Screen (player, team) VALUES ('" . $playerDiv . "', '" . $lastCharacter . "') ;";
		mysqli_query($conn,$query);  
	}
} // end of POST

// Initialize the variables
$ourTeam = "";
$theirTeam = "";

$query = "SELECT * FROM Screen";
$result = mysqli_query($conn,$query);    
//build the array
while ($row = mysqli_fetch_assoc($result)) {
	if ($row['team']=="+") {
		$ourTeam = $ourTeam . $row['player'];  
	}
	elseif ($row['team']=="-") {
		$theirTeam = $theirTeam . $row['player'];
	}
}
// Close the DB connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Football Spotter Program</title>
        <meta charset="UTF-8">
		<link type="text/css" rel="stylesheet" href="style.css" />
		<script type="text/javascript">
            //check for key entry
			function num_keyup() {
                var key = event.keyCode;
                if ((key == 107) || (key == 109) || (key == 189) || (key == 187)) { // Plus or minus on numeric pad and Mac
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
    <!-- Build the basic page -->
    <body id="element">
    	<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="return false;" >
			<input type="text" name="jerseyNumber" id="jerseyNumber" onkeyup="num_keyup()" />
			<div id="ourTeam"><?= $ourTeam ?></div>
			<div id="theirTeam"><?= $theirTeam ?></div>
			<label for="refresh" id="lblRefresh">Auto refresh</label>
            <input type="checkbox" name="refresh" id="refresh" <?php echo $refreshInterval ?> />
        </form>
        <!--  -->
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
