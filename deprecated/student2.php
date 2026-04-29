<?php
include 'conn.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">

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
            <form class="form-inline my-2 my-lg-0" method="post" >
                <input class="form-control mr-sm-2" id="searchTxt" name="search" type="text" placeholder="Search"
                    aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="submit">Search</button>
            </form>
        </div>
    </nav>

    <h4 class="text-center">For better experiance device should keep horizontal</h4>
    <div class="container">
        <br>
        <h1>Add Filter</h1>
       
        <hr>
        <form id="libraryForm" method="post">
            <div class="form-group row">
                <label for="bookName" class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-6">
                <input type="text" name="name" class="form-control" placeholder="book title" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="Author" class="col-sm-2 col-form-label">Author</label>
                <div class="col-sm-6">
                <input type="text" name="author" class="form-control" placeholder="author" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="bookName" class="col-sm-2 col-form-label">Publication</label>
                <div class="col-sm-6">
                <input type="text" name="publication" class="form-control" placeholder="publication" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="Author" class="col-sm-2 col-form-label">Edition</label>
                <div class="col-sm-6">
                <input type="text" name="edition" class="form-control" placeholder=" edition" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="bookName" class="col-sm-2 col-form-label">Class</label>
                <div class="col-sm-10">
                <select name="class" id="class" class="form-control col-sm-2">
                    <option value="volvo">Fybcs</option>
                    <option value="saab">Sybcs</option>
                    <option value="opel">Fybca</option>
                    <option value="audi">Fybca</option>
                </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="Author" class="col-sm-2 col-form-label">Semester</label>
                <div class="form-check">
                    <input type="radio" class="form-check-input" id="radio1" name="sem" value="first" checked>
                    <label class="form-check-label" for="radio1">Sem 1</label>
                    </div>
                    <div class="form-check">
                    <input type="radio" class="form-check-input" id="radio2" name="sem" value="second">
                    <label class="form-check-label" for="radio2">Sem 2</label>
                    </div>
                    
                </div>
            </div>
            <button type="submit"  class="btn btn-primary" name="sbmt">Submit</button>

            
        </form>
        <div class="col-lg-12">
            
            <table class="table table-striped talbe-hover">
            
            <?php
                if(isset($_POST['sbmt'])){
                    $name = $_POST['name'];
                    $author = $_POST['author'];
                    $publication = $_POST['publication'];
                    $edition = $_POST['edition'];
                    $class = $_POST['class'];
                    $sem = $_POST['sem'];
                    $sql="Select * from `bookdata` where name like '%$name%' 
                    or author like '%$author%' or publication like '%$publication%' or edition like '%$edition%' or class like '%$class%' or sem like '%$sem%'";
                    $result=mysqli_query($con,$sql);
                    if($result) {
                        if(mysqli_num_rows($result)>0){
                            
                            echo ' <h1 >Filtered Result</h1>';
                            echo '<thead>
                            <tr class="bg-dark text-white text-center">
                            
                            <th>name</th>
                            <th>author</th>
                            <th>publication</th>
                            <th>edition</th>
                            <th>class</th>
                            <th>semester</th>
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
                            <td>'.$row['class'].'</td>
                            <td>'.$row['sem'].'</td>
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
        <hr>
        <div class="col-lg-12">
            
            <table class="table table-striped talbe-hover">
            
            <?php
                if(isset($_POST['submit'])){
                    $search=$_POST['search'];
                    $sql="Select * from `bookdata` where id like '%$search%'
                    or name like '%$search%' or author like '%$search%' or publication like '%$search%' or edition like '%$search%'";
                    $result=mysqli_query($con,$sql);
                    if($result) {
                        if(mysqli_num_rows($result)>0){
                            
                            echo ' <h1 >Searched books</h1>';
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

    </div>
    <div class="container">
        <div class="col-lg-12">
            <br>
            <h1 >Your books</h1>
            <br>
            <table class="table table-striped talbe-hover">
                <tr class="bg-dark text-white text-center">
                   
                    <th> Name </th>
                    <th> Author </th>
                    <th> Publication </th>
                    <th> Edition </th>
                    <th> Class </th>
                    <th> Semester </th>
                </tr>
                <?php
                include 'conn.php';
                // if(isset($_POST['search']))
                // {
                //     $value_filter = $_POST['searchvalue'];
                //     $query = "SELECT * FROM 'bookdata' WHERE CONCAT(name,author,publication,edition,class,sem) LIKE '%$value_filter%' ";
                //     $query_run = mysqli_query($con,$query);
                //     if(mysqli_num_rows($query_run) > 0)
                //     {
                //         while($row = mysqli_fetch_array($query_run))
                //         {
                //             echo $row['name'];
                            
                //         }
                //     }
                //     else
                //     {
                //         echo "No Record Found.!";
                //     }
                // }
                

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
                </tr>
                <?php
                    }
                ?>
            </table>

        
        </div>
    </div>
</body>
</html>
