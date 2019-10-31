<?php
$con = mysqli_connect("localhost","root","21802Ghc<","BRoster");

if ($con)
{
    $file = $_FILES['csvfile']['tmp_name'];
    $handle = fopen($file,"r");
    while(($cont=fgetcsv($handle,1000,","))!==false)
    {
        $num=$con[0];
        $name=$con[1];
        $pos=$con[2];
        $class=$con[3];
        $h=$co[4];
        $w=$con[5];
//        $query="CREATATE TABLE $table($num INT(3),$name VARCHAR(30),$pos VARCHAR(5),$class VARCHAR(2),$h VARCHAR(5),$w INT(3));";
//        echo $query,"<br>";
        echo "it works";
    }
}
else
{echo "connection failed";}
?>