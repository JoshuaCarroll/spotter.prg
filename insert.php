<?php
$con = mysqli_connect("localhost","root","21802Ghc<", "SpotterDB");
// Open db SpotterDB
if($con === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
else
{
    
    $file = "BRoster.csv";
    $handle = fopen($file,"r");
    // Create a table for the Bruins
    $query="CREATE TABLE BRoster(Number INT(3),Name VARCHAR(30),Position VARCHAR(5), INDEX (Number));"; 
    
    if ((mysqli_query($con,$query))!==false) //test for table
    {
        echo "table created <br>";    
    }
    else
    {
        echo "table exists <br>";
    }
    while(($cont = fgetcsv($handle,1000,","))!==false)
    {
        $query="INSERT INTO BRoster(Number,Name,Position) VALUES('$cont[0]','$cont[1]','$cont[2]');";    
            if((mysqli_query($con,$query))!==false)
            {
                echo "Records inserted successfully <br>";
            } else{
                echo "ERROR: Not able to execute" . mysqli_error($con) . "<br>";
            }
    }
    //Open ORoster.csv
    $file = "ORoster.csv";
    $handle = fopen($file,"r");
    // Create a table for the Bruins
    $query="CREATE TABLE BRoster(Number INT(3),Name VARCHAR(30),Position VARCHAR(5), INDEX (Number));"; 
    if ((mysqli_query($con,$query))!==false) //test for table
    {
        echo "table created <br>";    
    }
    else
    {
        echo "table exists <br>";
    }
    while(($cont = fgetcsv($handle,1000,","))!==false)
    {
        $query="INSERT INTO ORoster(Number,Name,Position) VALUES('$cont[0]','$cont[1]','$cont[2]');";    
            if((mysqli_query($con,$query))!==false)
            {
                echo "Records inserted successfully <br>";
            } else{
                echo "ERROR: Not able to execute" . mysqli_error($con) . "<br>";
            }
    }
}

echo "Finished";
mysqli_close($con);
?>