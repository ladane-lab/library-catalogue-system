
<?php
include 'conn.php';
?>




<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"

 integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Welcome to MGM's Library</title>
</head>

<body class="bg-white">
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
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="submit" >Search</button>
            </form>
        </div>
    </nav>

    <div id="message"></div>


    <div class="container my-3 ">
        
        <h3>MGM's Library</h3>
        <hr>
        <form id="libraryForm" method="post" action="store.php">
            <div class="form-group row">
                <label for="bookName" class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="name" id="bookName" placeholder="Book Name">
                </div>
            </div>
            <div class="form-group row">
                <label for="Author" class="col-sm-2 col-form-label">Author</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="author" id="author" placeholder="Author">
                </div>
            </div>
            <div class="form-group row">
                <label for="bookName" class="col-sm-2 col-form-label">Publication</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="publication" id="bookName" placeholder="publication">
                </div>
            </div>
            <div class="form-group row">
                <label for="Author" class="col-sm-2 col-form-label">Edition</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="edition" id="author" placeholder="edition">
                </div>
            </div>
            <div class="form-group row">
                <label for="bookName" class="col-sm-2 col-form-label">Class</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="class" id="bookName" placeholder="class">
                </div>
            </div>
            <div class="form-group row">
                <label for="Author" class="col-sm-2 col-form-label">Semester</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="sem" id="author" placeholder="semester">
                </div>
            </div>
            

            <div class="form-group row">
                <div class="col-sm-10">
                    <button type="submit"  class="btn btn-primary" name="done">Add Book</button>
                </div>
            </div>
        </form>
        <h3>Send To Staff</h3>
        <a href="fill.html"><button type="button" class="btn btn-primary">Fill Data</button></a>
       <a><button onclick="myFunction()" type="button" class="btn btn-danger">Delete Table</button></a>
        
         <script>
            function myFunction() {
            let text = "Do you want to delete data of staff table!";
            if (confirm(text) == true) {
                window.location = "deletetable.php";
            } else {
                text = "You canceled!";
            }

            }
        </script>
        
        
        <hr>
        
        <div class="col-lg-12 table-responsive">
        <table class="table table-striped talbe-hover ">
            
            <?php
                if(isset($_POST['submit'])){
                    $search=$_POST['search'];
                    $sql="Select * from `bookdata` where id like '%$search%'
                    or name like '%$search%' or author like '%$search%' or publication like '%$search%' or edition like '%$search%'";
                    $result=mysqli_query($con,$sql);
                    if($result) {
                        if(mysqli_num_rows($result)>0){
                            
                            echo ' <h3 >Searched books</h3>';
                            echo '<thead>
                            <tr class="bg-dark text-white text-center">
                            
                            <th>name</th>
                            <th>author</th>
                            <th>publication</th>
                            <th>edition</th>
                            </tr>
                            </thead>
                            ';
                            while($row=mysqli_fetch_assoc($result)){
                            echo '<tbody>
                            <tr class="text-center">
                            
                            <td>'.$row['name'].'</td>
                            <td>'.$row['author'].'</td>
                            <td>'.$row['publication'].'</td>
                            <td>'.$row['edition'].'</td>
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
            
        
        <div class="col-lg-12 table-responsive">
            <br>
            <h3>Student Data</h3>
            <br>
            <table class="table table-striped talbe-hover bg-white ">
                <tr class="bg-dark text-white text-center">
                    
                    <th> Name </th>
                    <th> Author </th>
                    <th> publication </th>
                    <th> edition </th>
                    <th> Class </th>
                    <th> Semester </th>
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
               
                    <td> <?php echo $res['name'] ?> </td>
                    <td> <?php echo $res['author'] ?> </td>
                    <td> <?php echo $res['publication'] ?> </td>
                    <td> <?php echo $res['edition'] ?> </td>
                    <td> <?php echo $res['class'] ?> </td>
                    <td> <?php echo $res['sem'] ?> </td>
                    <td> <button class="btn-danger btn"><a href="delete.php?id=<?php echo $res['id']; ?>" class="text-white ">delete</a></
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
        <hr>
        <div class="container table-responsive">
       
        
        <div id="table">
            <h3>Updated list form staff</h3>

            <table class="table table-striped talbe-hover ">
                    <tr class="bg-dark text-white text-center">
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

                $q = "select * from books ";

                    $query = mysqli_query($con, $q);
                    while($res = mysqli_fetch_array($query)){
    
    ?>
                    <tr class="text-center">
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
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <!-- <script src="index.js"></script> -->
    <script src="ndexes6.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
        
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
         integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
         crossorigin="anonymous"></script>
        
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
         integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
         crossorigin="anonymous"></script>
    </body>

</html>
