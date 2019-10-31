<?php
$con = mysqli_connect("localhost","root","21802Ghc<","BRoster");

if ($con)
{
    echo "connected";
    //print_r($_FILES['csvfile']);

}
else
{echo "connection failed";}
?>