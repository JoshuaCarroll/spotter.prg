<?php
$con = mysqli_connect("localhost","root","21802Ghc<","BRoster");
if($con === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
else
{
    $file = $_FILES['csvfile']['tmp_name'];
    $handle = fopen($file,"r");
 //   $i=0;
 //   $table=rtrim($_FILES['csvfile']['name'],".csv");
    echo $table;
    $query="CREATE TABLE players(Number INT,Name VARCHAR(30),Position VARCHAR(5),Class VARCHAR(2),Height VARCHAR(5),Weight INT;";
    if (mysqli_query($con,$query)){
    echo "table created";    
    }
    else
    {echo "table exists";}
//    echo $query,"<br>";
    while(($cont=fgetcsv($handle,1000,","))!==false)
    {
        
//        if(i==0){
//            $num=$cont[0];
//            $name=$cont[1];
//            $pos=$cont[2];
//            $class=$cont[3];
//            $h=$cont[4];
//            $w=$cont[5];
            
 //           mysqli_query($con,$query);

//        }
//        else
//        {
            $query="INSERT INTO players(Number,Name,Position,Class,Height,Weight) VALUES ($cont[0],$cont[1],$cont[2],$cont[3],$cont[4],$cont[5]);";
            
            if(mysqli_query($con,$query)){
                echo "Records inserted successfully";
                } else{
                echo "ERROR: Not able to execute $query. <br> " . mysqli_error($link);
                }
//            echo $query,"<br>";
            }
 //       $i++;
 //   }
    
}

echo "Finished";
mysqli_close($con);
?>