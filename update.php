<?php

if (!empty($_POST["url"])) {
	$table = $_POST["team"];
	$url = "https://wt-90a32ef8ce619cb1158f5b6850fb1f12-0.sandbox.auth0-extend.com/maxprepsTeamScraper?url=" . $_POST["url"]; // path to the JSON file
	$data = file_get_contents($url);  // load contents of the page 
	$roster = json_decode($data, true); // parse the JSON into an object
	
    $output = "INSERT INTO $table (Number, Name, Position) VALUES ";
	
	foreach ($roster as $player) {
        if ($player[jersey]){
            $output = $output . "('" . $player[jersey] . "','" . $player[name] . "','" . $player[position] . "'), ";
        }
	   
	}
	$output = $output . "('','','');";
	echo $output;
	$conn = mysqli_connect("localhost", "root", "Passw0rd", "SpotterDB");
	mysqli_query($conn, "DELETE FROM $table;");
    if (mysqli_query($conn, $output) == false) {echo (mysqli_error($conn));}
	 // Execute the insert statement
	mysqli_close($conn);
}

?><!DOCTYPE html>
<html>
    <head>
        <title>Football Spotter Update</title>
        <meta charset="UTF-8">    
		<script>
			function radBruins_selected() {
				document.getElementById("url").value = "https://www.maxpreps.com/high-schools/pulaski-academy-bruins-(little-rock,ar)/football/roster.htm";
			}
		</script>
    </head>
    
    <body>
    	<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
			Update which team:
			<label for="radBruins">Bruins</label><input type="radio" name="team" id="radBruins" value="BRoster" onselect="radBruins_selected()"> 
			<label for="radOpp">Opponent</label><input type="radio" name="team" id="radOpp" value="ORoster" checked="checked"><br>
			<label for="url">Maxpreps roster URL: </label><input type="text" name="url" id="url" /><br>
			<input type="submit" value="Submit" />
        </form>
	</body>
</html>
