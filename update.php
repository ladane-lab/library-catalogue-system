<?php

include 'conn.php';
$id = $_GET['id'];
if(isset($_POST['submit'])){
   
    $name = $_POST['name'];
    $author = $_POST['author'];
    $publication = $_POST['publication'];
    $edition = $_POST['edition'];
    $class = $_POST['class'];
    $sem = $_POST['sem'];

   
    $sql = " UPDATE `bookdata` SET  id =$id,name='$name',author='$author',publication='$publication',edition='$edition',class='$class',sem='$sem' WHERE id=$id ";
    $result = mysqli_query($con,$sql);
    if($result){
        echo "updated successfully ";
    }else{
        die(mysqli_error($con));
    }

    header('location:librarian.php');

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <!-- Required meta tags -->
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

   <!-- Bootstrap CSS -->
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
       integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
       <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"

integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

   
    <title>update</title>
</head>
<body>
    <div class="col-lg-6 m-auto">
        <form method="post">
            <div class="card">
                <br><br><div class="card-header bg-dark">
                    <h1 class="text-white text-center">update Operation</h1>
                </div>
                <label>Book Name: </label>
                <input type="text" name="name" class="form-control"><br>

                <label>Author:</label>
                <input type="text" name="author" class="form-control"><br>

                <label>Publication:</label>
                <input type="text" name="publication" class="form-control"><br>

                <label>Edition:</label>
                <input type="text" name="edition" class="form-control"><br>
                
                <label>Class:</label>
                <input type="text" name="class" class="form-control"><br>

                <label>Semester:</label>
                <input type="text" name="sem" class="form-control"><br>
                <button class="btn btn-success" type="submit" name="submit">update</button>
            </div>

        </form>

    </div>
</body>
</html>



