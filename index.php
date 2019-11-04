<?php
$message = "Didn't Connect";
$message2 = "Connected";
// Create connection

$conn = mysqli_connect("localhost", "root", "21802Ghc<", "SpotterDB");
if($con === false){
    echo "<script type='text/javascript'>alert('$message');</script>";}
	if (!empty($_POST)) { // Checks to see if it received a form submission
		$jerseyNumber = substr_replace($_POST["jerseyNumber"],"",-1);
		$lastCharacter = substr($_POST["jerseyNumber"], -1);
        if ($lastCharacter == "+") // Test for Bruin
        {
          // call the data for $jerseyNumber
          $query = "SELECT * FROM BRoster WHERE Number=$jerseyNumber;";
          $results = mysqli_query($conn,$query);
          // create an array of the data for player $jerseyNumber
          $row=mysqli_fetch_array($results,MYSQLI_NUM);
          //Read the name and position
          $name = $row[1];
          $position = $row[2];
        }
        if ($lastCharacter == "-") // test for Opposition
        {
          // call the data for $jerseyNumber
          $query = "SELECT * FROM ORoster WHERE Number=$jerseyNumber;";
          $results = mysqli_query($conn,$query);
          // create an array of the data for player $jerseyNumber
          $row=mysqli_fetch_array($results,MYSQLI_NUM);
          //Read the name and position
          $name = $row[1];
          $position = $row[2];
        }

		$ourTeam = $_POST["hdnOurTeam"];
		$theirTeam = $_POST["hdnTheirTeam"];
		$playerDiv = "<div class='player'><span class='jerseyNumber'>" . $jerseyNumber . "</span> <span class='name'>" . $name . "</span> <span class='position'>" . $position . "</span></div>";
		if ($lastCharacter == "+") {
			
			$ourTeam = $_POST["hdnOurTeam"] . $playerDiv;
		} elseif ($lastCharacter == "-") {
			$theirTeam = $_POST["hdnTheirTeam"] . $playerDiv;
		}
        $query = "DELETE * FROM Screen";
        if (mysqli_query($con,$query)) {
            echo DELETED;
        }
        
        echo $ourTeam;
        $query = "INSERT INTO Screen (Ourteam) VALUES ('11 Dylan Allison WR');";
        if((mysqli_query($con,$query))!==false)
        {
            echo "Records inserted successfully <br>";
     //       echo $ourTeam . " " . $theirTeam;
        } else{
            echo $ourTeam . $theirTeam . "ERROR" . mysqli_error($con) . "<br>";
        }
        
        $query = "SELECT FROM Screen;";
        
        if ($result){
        echo "1";
        }
        $row = mysqli_fetch_assoc($result);
        if ($row){
        $Screen = $row[0];
        echo "2";}
        echo "3";
        echo $Screen;
	}
//mysqli_close($conn);
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
				else if (key == 13) { //Carriage return
					document.getElementById("ourTeam").innerHTML = "";
					document.getElementById("theirTeam").innerHTML = "";
					document.getElementById("hdnOurTeam").value = "";
					document.getElementById("hdnTheirTeam").value = "";
                    //document.getElementById("jerseyNumber").value = "";
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
			<input type="hidden" id="hdnOurTeam" name="hdnOurTeam" value="<?= $ourTeam ?>">
			<input type="hidden" id="hdnTheirTeam" name="hdnTheirTeam" value="<?= $theirTeam ?>">
<!--			<div id="ourTeam"><?= $ourTeam ?></div>
			<div id="theirTeam"><?= $theirTeam ?></div>
-->         <div id="screen"><?= $Screen ?></div>
        </form>
		<script type="text/javascript">
			document.getElementById("jerseyNumber").focus();
		</script>
	</body>

</html>
