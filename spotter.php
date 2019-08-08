<?php

//$num = 13;

$broster = fopen("BRoster.csv","r");


while(! feof($broster))
	{
	$player = fgetcsv($broster);
	if ($player[0] == $num) {$bplayer = $player[1];}
	}

fclose($broster);
echo "<h1>" , $bplayer , "</h1><br>";
?>
