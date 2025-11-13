

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
            <form class="form-inline my-2 my-lg-0" action="" method="post">
                <input class="form-control mr-sm-2" id="searchTxt" type="search" name="filter_value" placeholder="filter books"
                    aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="filter_btn">Filter</button>
            </form>
        </div>
    </nav>
    <div class="container ml-0">
        <div class="col-lg-12">
            
            <br>
            <h1 >Your books</h1>
            <br>
            <form method="post" action="save.php">
                <table class="table table-striped talbe-hover">
                    <tr class="bg-light text-dark text-center">
                        <th scope="col">Select</th>
                        <th scope="col"> ISBN </th>
                        <th scope="col"> Author </th>
                        <th scope="col"> Title </th>
                        <th scope="col"> EDN </th>
                        <th scope="col"> Price </th>
                        <th scope="col"> edition</th>
                        <th scope="col"> qty </th>
                        <th scope="col"> yop </th>
                       
                    
                    <?php
                    include 'conn.php';
                    if(isset($_POST['filter_btn']))
                    {
                        $value_filter = $_POST['filter_value'];
                        $query = "SELECT * FROM `new` WHERE CONCAT(isbn,author,title) LIKE '%$value_filter%' ";
                        $query_run = mysqli_query($con, $query);

                        if(mysqli_num_rows($query_run) > 0)
                        {
                            while($res = mysqli_fetch_array($query_run))
                            {
                                echo $res['isbn'];
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
                        }
                        else{
                            ?>
                            <tr>
                                <td>echo "no record found.!";</td>
                            </tr>
                            <?php    
                        }
                    }
                    ?>













                <tr class="bg-light text-dark text-center">
                    <th scope="col">Select</th>
                    <th scope="col"> ISBN </th>
                    <th scope="col"> Author </th>
                    <th scope="col"> Title </th>
                    <th scope="col"> EDN </th>
                    <th scope="col"> Price </th>
                    <th scope="col"> edition</th>
                    <th scope="col"> qty </th>
                    <th scope="col"> yop </th>
                </tr>
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
                          
        
                </table>
            </form>
            <button type="submit" class="btn btn-primary" name="submit">Update</button>

        
        </div>
    </div>
    <script type="text/javascript" src="//cdn.datatables.net/plug-ins/1.13.1/sorting/absolute.js"></script>
</body>
</html>
