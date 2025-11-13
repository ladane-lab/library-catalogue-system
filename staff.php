<?php
include 'conn.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">

   <!-- Bootstrap CSS -->
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
       integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
       <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"

integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>displayt</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">MGM's Library</a>
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
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="sbt">Search</button>
            </form>
        </div>
    </nav>
    
    <hr>
        <div class="col-lg-12 table-responsive">
            
            <table class="table table-striped talbe-hover col-lg-12 ">
            
            <?php
                if(isset($_POST['sbt'])){
                    $search=$_POST['search'];
                    $sql="Select * from `new` where id like '%$search%'
                    or isbn like '%$search%' or author like '%$search%' or title like '%$search%' or edn like '%$search%' or price like '%$search%' or edition like '%$search%' or qty like '%$search%' or yop like '%$search%'";
                    $result=mysqli_query($con,$sql);
                    if($result) {
                        if(mysqli_num_rows($result)>0){
                            
                            echo ' <h3 >Searched books</h3>';
                            echo '<thead>
                            <tr class="bg-dark text-white text-center">
                            
                            <th>isbn</th>
                            <th>author</th>
                            <th>title</th>
                            <th>edn</th>
                            <th>price</th>
                            <th>edition</th>
                            <th>qty</th>
                            <th>yop</th>
                            </tr>
                            </thead>
                            ';
                            while($row=mysqli_fetch_assoc($result)){
                            echo '<tbody>
                            <tr class="text-center">
                            
                            <td>'.$row['isbn'].'</td>
                            <td>'.$row['author'].'</td>
                            <td>'.$row['title'].'</td>
                            <td>'.$row['edn'].'</td>
                            <td>'.$row['price'].'</td>
                            <td>'.$row['edition'].'</td>
                            <td>'.$row['qty'].'</td>
                            <td>'.$row['yop'].'</td>
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
    <div class="container">
        <div class="col-lg-12 table-responsive">
            <?php
                if(isset($_SESSION['status']))
                {
                    echo "<h4>".$_SESSION['status']."</h4>";
                    unset($_SESSION['status']);
                }
            ?>
            <br>
            <h3 >Your books</h3>
            <br>
            <form method="post">
                
                <table class="table table-striped talbe-hover">
                    <tr class="bg-light text-dark text-center">
                        <th>Select</th>
                        <th> ISBN </th>
                        <th> Author </th>
                        <th> Title </th>
                        <th> EDN </th>
                        <th> Price </th>
                        <th> edition</th>
                        <th> qty </th>
                        <th> yop </th>
                        <?php
                    include 'conn.php';

                $q = "select * from new ";

                    $query = mysqli_query($con, $q);
                    while($res = mysqli_fetch_array($query)){
    
    ?>
                    <tr class="text-center">
                        <td><input type="checkbox" name="brands[]"></td>
                        <td> <?php echo $res['isbn'] ?> </td>
                        <td> <?php echo $res['author'] ?> </td>
                        <td> <?php echo $res['title'] ?> </td>
                        <td> <?php echo $res['edn'] ?> </td>
                        <td> <?php echo $res['price'] ?> </td>
                        <td> <?php echo $res['edition'] ?> </td>
                        <td> <?php echo $res['qty'] ?> </td>
                        <td> <?php echo $res['yop'] ?> </td>
                    
    


                    </tr>
                    <?php
                        }
                    ?>
                    </tr>
        
                </table>
                

                <button onclick="myFunction()" type="submit" class="btn btn-primary" name="submit">Update</button>
            </form>
            
            <script>
            function myFunction() {
            let text = "Do you want to submit data!";
            if (confirm(text) == true) {
                window.location = "save.php";
            } else {
                text = "You canceled!";
            }

            }
        </script>
        
        </div>
    </div>
    <script type="text/javascript" src="//cdn.datatables.net/plug-ins/1.13.1/sorting/absolute.js"></script>
</body>
</html>
