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

    $query="CREATE TABLE BRoster(Number INT(3),Name VARCHAR(30),Position VARCHAR(5));"; 
    // removed ,Class VARCHAR(2),Height VARCHAR(5),Weight INT(4)
    
    if ((mysqli_query($con,$query))!==false) //test for table
    {
        echo "table created";    
    }
    else
    {
        echo "table exists";
        
    
    }
    while(($cont = fgetcsv($handle,1000,","))!==false)
    {
            $query="INSERT INTO BRoster(Number,Name,Position) VALUES('$cont[0]','$cont[1]','$cont[2]');";
            
            if((mysqli_query($con,$query))!==false){
                echo "Records inserted successfully";
                } else{
                echo "ERROR: Not able to execute" . mysqli_error($con) . "<br>";
                }
            }
}

echo "Finished";
mysqli_close($con);
?>