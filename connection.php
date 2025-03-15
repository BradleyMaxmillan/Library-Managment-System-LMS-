<?php


//   server name,Username ,password, Datase name

$db =mysqli_connect("LocalHost","root","bradley2003","lms");

if(!$db)
{
    die ("connection failed: " . mysqli_connect_error());

}
    echo "connection Succsesful" ;


?>