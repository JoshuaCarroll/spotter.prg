<?php
$con = mysqli_connect("localhost","root","21802Ghc<","BRoster");

if ($con)
{
    $file = $_FILES['csvfile']['tmp_name'];
    $handle = fopen($file,"r");
    while(($cont=fgetcsv($handle,1000,","))!==false)
    {
        $num=$cont[0];
        $name=$cont[1];
        $pos=$cont[2];
        $class=$cont[3];
        $h=$cont[4];
        $w=$cont[5];
        $query="CREATATE TABLE $table($num INT(3),$name VARCHAR(30),$pos VARCHAR(5),$class VARCHAR(2),$h VARCHAR(5),$w INT(3));";
        echo $query,"<br>";
        
    }
}
else
{echo "connection failed";}
?>