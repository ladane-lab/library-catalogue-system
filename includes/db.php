<?php

$con = mysqli_connect('localhost','root');
mysqli_select_db($con,'computer');
if(!$con){
    die(mysqli_error("Error"+$con));

}
?>