
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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">
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
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" id="searchTxt" type="search" placeholder="Search"
                    aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>
    <div class="container">
        <div class="col-lg-12">
            <br>
            <h1 >Your books</h1>
            <br>
            <table id="datatableid" class="table table-striped talbe-hover">
                <tr class="bg-light text-dark text-center">
                    <th> Id </th>
                    <th> Name </th>
                    <th> Author </th>
                    <th> Action </th>
                    <th> Action </th>
                </tr>
                 <?php
                include 'conn.php';

                $q = "select * from bookdata ";

                $query = mysqli_query($con, $q);
                while($res = mysqli_fetch_array($query)){
 
                ?>
                <tr class="text-center">
                    <td> <?php echo $res['id'] ?> </td>
                    <td> <?php echo $res['name'] ?> </td>
                    <td> <?php echo $res['author'] ?> </td>
                    <td> <button class="btn-danger btn"><a href="delete.php?id=<?php echo $res['id']; ?>" class="text-white">delete</a></
                    button> </td>
                    <td> <button class="btn-primary btn"><a href="update.php?id=<?php echo $res['id']; ?>" class="text-white">update</a></
                    button> </td>

                </tr>
                <?php
                    }
                ?>
            </table>

        
        </div>
    </div>
    <script> src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script> src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function () {
        $('#datatableid').DataTable();
        });
    </script>
</body>
</html>
