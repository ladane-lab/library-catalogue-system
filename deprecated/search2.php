<?php
include 'conn.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

   <!-- Bootstrap CSS -->
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
       integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
       <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"

integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>search data</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Mgm Library</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                </li>

            </ul>
            <form class="form-inline my-2 my-lg-0" method="post">
                <input class="form-control mr-sm-2" id="searchTxt" type="search" name="search" placeholder="Search"
                    aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="submit">Search</button>
            </form>
        </div>
    </nav>
    <div class="container my-5">
        <form method="post">
            <input type="text" placeholder="Search data" name="search">
            <button class="btn btn-dark" name="submit">search</button>
        
        </form>
        <div class="container my-5" >
            <table class="table">
                <?php
                if(isset($_POST['submit'])){
                    $search=$_POST['search'];
                    $sql="Select * from `bookdata` where id like '%$search%'
                    or name like '%$search%' or author like '%$search%'";
                    $result=mysqli_query($con,$sql);
                    if($result) {
                        if(mysqli_num_rows($result)>0){
                            echo '<thead>
                            <tr>
                            <th>id</th>
                            <th>name</th>
                            <th>author</th>
                            </tr>
                            </thead>
                            ';
                            while($row=mysqli_fetch_assoc($result)){
                            echo '<tbody>
                            <tr>
                            <td>'.$row['id'].'</td>
                            <td>'.$row['name'].'</td>
                            <td>'.$row['author'].'</td>
                            </tr>
                            </tbody>';
                            }
                        }else{
                            echo '<h2 class="text-danger">Data not found</h2>';
                        }
                    }

    }
    ?>
    

            </table>
        </div>
    </div>
</body>
</html>