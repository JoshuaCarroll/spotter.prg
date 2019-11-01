<?php
$con = mysqli_connect("localhost","root","21802Ghc<","BRoster");

if ($con)
{
    $file = $_FILES['csvfile']['tmp_name'];
    $handle = fopen($file,"r");
 //   $i=0;
    $table=rtrim($_FILES['csvfile']['name'],".csv");
    echo $table;
    $query="CREATATE TABLE $table(Number INT(3),Name VARCHAR(30),Postion VARCHAR(5),Class VARCHAR(2),Height VARCHAR(5),Weight INT(3));";
    mysqli_query($con,$query);
    echo $query,"<br>";
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
            $query="INSERT INTO $table ($num,$name,$pos,$class,$h,$w) VALUES ('$cont[0]','$cont[1]','$cont[2]','$cont[3]','$cont[4]','$cont[5]');";
            mysqli_query($con,$query);
            echo $query,"<br>";
    }
 //       $i++;
 //   }
    
}
else
{echo "connection failed";}
echo "Finished";
mysqli_close($con);
?>