<?php
$con = mysqli_connect('localhost','root');
mysqli_select_db($con,'computer');
if($con){
    echo "data stored successfully";

}
else
{
    echo "not connected";
}
?>