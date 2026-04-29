

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

    <title>displayt</title>
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
    <div class="container ml-0">
        <div class="col-lg-12">
            
            <br>
            <h1 >Your books</h1>
            <br>
            <?php
            include 'conn.php';
                        $q = "select * from new ";

                         $query = mysqli_query($con, $q);
                         $rowcount=mysqli_num_rows($query);
                         if(isset($_REQUEST["submit_btn"])){
                            $chk-$_REQUEST["chk"];
                            $a=implode(",",$chk);
                            echo $a;
                         }
                    


            ?>
            <form method="post" action="">
                
                        
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
                            </tr>

                            

                        <?php
                        for($i=1;$i<=$rowcount;$i++)
                        {
                            $row=mysqli_fetch_array($query);
                            ?>
                            <tr class="text-center">
                            <td><input type="checkbox" name="chk[]" value="<?php echo $row["id"]?>"></td>
                            <td> <?php echo $row['isbn'] ?> </td>
                            <td> <?php echo $row['author'] ?> </td>
                            <td> <?php echo $row['title'] ?> </td>
                            <td> <?php echo $row['edn'] ?> </td>
                            <td> <?php echo $row['price'] ?> </td>
                            <td> <?php echo $row['edition'] ?> </td>
                            <td> <?php echo $row['qty'] ?> </td>
                            <td> <?php echo $row['yop'] ?> </td>
                            </tr>
                        
                            <?php
                             
                        }
                ?>
                        </table>
                        
                
            </form>
            
            <button type="submit" class="btn btn-primary" name="submit_btn">Update</button>

        
        </div>
    </div>
    <script type="text/javascript" src="//cdn.datatables.net/plug-ins/1.13.1/sorting/absolute.js"></script>
</body>
</html>
