<?php
$con = mysql_connect("localhost","root","21802Ghc<","BRoster");

if ($con)
{
print_r($_FILES['csvfile']);

}
else
{echo "connection failed";}
?>