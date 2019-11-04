<?php
$con = mysqli_connect("localhost","root","21802Ghc<", "SpotterDB");
// Open db SpotterDB
if($con === false)
{
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
else
{
    $query="DROP TABLE Screen;";
    if ((mysqli_query($con,$query))!==false) //test for table
    {
        echo "table deleted <br>";    
    }
    else
    {
        echo $query . "Error";
    }
    
    $query="CREATE TABLE Screen(Ourteam VARCHAR(41),Theirteam VARCHAR(41));"; 
    
    if ((mysqli_query($con,$query))!==false) //test for table
    {
        echo "table created <br>";    
    }
    
}
echo "Finished";
mysqli_close($con);