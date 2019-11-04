<?php
$con = mysqli_connect("localhost","root","21802Ghc<", "SpotterDB");
// Open db SpotterDB
if($con === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
else
{
    $query="CREATE TABLE Screen(Number INT(3),Name VARCHAR(30),Position VARCHAR(8), INDEX (Number));"; 
    
    if ((mysqli_query($con,$query))!==false) //test for table
    {
        echo "table created <br>";    
    }
    else
    {
        echo "table exists <br>";
    }
}
echo "Finished";
mysqli_close($con);