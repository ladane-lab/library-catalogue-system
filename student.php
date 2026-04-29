<?php
include 'conn.php';

$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
if ($limit < 1) $limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

function getPaginationUrl($pageNum, $limit) {
    $params = $_GET;
    $params['page'] = $pageNum;
    $params['limit'] = $limit;
    return '?' . http_build_query($params);
}
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

    <title>displayt</title>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    
            <a class="navbar-brand" href="index.php">
                <h6 class="m-0"><b style="color: white;">WELCOME TO LIBRARY <span style="color: rgb(236, 134, 17)">ZONE</span></b></h6>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto font-weight-bold mr-4">
                    <li class="nav-item">
                        <a class="nav-link text-white px-3" href="index.php">Home</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link text-white px-3" href="student.php">Student</a>
                    </li>

                </ul>
                <form class="form-inline my-2 my-lg-0" method="get" action="student.php">
                    <input type="hidden" name="limit" value="<?php echo htmlspecialchars($limit); ?>">
                    <div class="input-group">
                        <input class="form-control" id="searchTxt" name="search" type="text" placeholder="Quick Search..."
                            aria-label="Search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                        <div class="input-group-append">
                            <button class="btn btn-warning font-weight-bold text-dark" type="submit" name="submit">Search</button>
                        </div>
                    </div>
                </form>
            </div>
       
    </nav>

    <div class="container mt-5">
        <div class="card shadow-sm border-0 rounded-lg mb-5">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">🔍 Advanced Filter</h4>
                <form method="get" class="form-inline m-0">
                    <?php
                    foreach ($_GET as $key => $value) {
                        if ($key != 'limit' && $key != 'page') {
                            echo '<input type="hidden" name="'.htmlspecialchars($key).'" value="'.htmlspecialchars($value).'">';
                        }
                    }
                    ?>
                    <label for="limit" class="mr-2 font-weight-bold text-white">Items per page:</label>
                    <select name="limit" id="limit" class="form-control form-control-sm" onchange="this.form.submit()">
                        <option value="5" <?php echo $limit == 5 ? 'selected' : ''; ?>>5</option>
                        <option value="10" <?php echo $limit == 10 ? 'selected' : ''; ?>>10</option>
                        <option value="20" <?php echo $limit == 20 ? 'selected' : ''; ?>>20</option>
                        <option value="50" <?php echo $limit == 50 ? 'selected' : ''; ?>>50</option>
                    </select>
                </form>
            </div>
            <div class="card-body bg-light p-4">
                <form id="libraryForm" method="get" action="student.php" novalidate>
                    <input type="hidden" name="limit" value="<?php echo htmlspecialchars($limit); ?>">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="bookName" class="col-sm-3 col-form-label font-weight-bold">Name</label>
                                <div class="col-sm-9">
                                    <input type="text" name="name" class="form-control" placeholder="Book title" value="<?php echo isset($_GET['name']) ? htmlspecialchars($_GET['name']) : ''; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="author" class="col-sm-3 col-form-label font-weight-bold">Author</label>
                                <div class="col-sm-9">
                                    <input type="text" name="author" class="form-control" placeholder="Author name" value="<?php echo isset($_GET['author']) ? htmlspecialchars($_GET['author']) : ''; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="publication" class="col-sm-3 col-form-label font-weight-bold">Publication</label>
                                <div class="col-sm-9">
                                    <input type="text" name="publication" class="form-control" placeholder="Publication" value="<?php echo isset($_GET['publication']) ? htmlspecialchars($_GET['publication']) : ''; ?>">
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="edition" class="col-sm-3 col-form-label font-weight-bold">Edition</label>
                                <div class="col-sm-9">
                                    <input type="text" name="edition" class="form-control" placeholder="Edition" value="<?php echo isset($_GET['edition']) ? htmlspecialchars($_GET['edition']) : ''; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="class" class="col-sm-3 col-form-label font-weight-bold">Class</label>
                                <div class="col-sm-9">
                                    <select name="class" id="class" class="form-control">
                                        <option value="#">Select Class</option>
                                        <?php 
                                        $classes = ['fybcs', 'sybcs', 'fybca', 'sybca', 'tybca'];
                                        foreach($classes as $c) {
                                            $selected = (isset($_GET['class']) && $_GET['class'] == $c) ? 'selected' : '';
                                            echo "<option value=\"$c\" $selected>".strtoupper($c)."</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label class="col-sm-3 col-form-label font-weight-bold">Semester</label>
                                <div class="col-sm-9 d-flex align-items-center">
                                    <div class="form-check mr-4">
                                        <input type="radio" class="form-check-input" id="radio0" name="sem" value="" <?php echo (!isset($_GET['sem']) || $_GET['sem'] == '') ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="radio0">All</label>
                                    </div>
                                    <div class="form-check mr-4">
                                        <input type="radio" class="form-check-input" id="radio1" name="sem" value="I" <?php echo (isset($_GET['sem']) && $_GET['sem'] == 'I') ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="radio1">Sem 1</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" id="radio2" name="sem" value="II" <?php echo (isset($_GET['sem']) && $_GET['sem'] == 'II') ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="radio2">Sem 2</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    <div class="text-right">
                        <a href="student.php" class="btn btn-outline-secondary px-4 mr-2">Clear</a>
                        <button type="submit" class="btn btn-warning font-weight-bold px-5" name="sbmt">Apply Filter</button>
                    </div>
                </form>
            </div>
        </div>
        
        <?php if(isset($_GET['sbmt'])): ?>
        <div class="mt-5 p-0">
            <h3>Filter Result</h3>
            <div class="row col-lg-12 table-responsive m-0 p-0">
                <table class="table table-striped table-hover table-bordered shadow-sm bg-white">
                    <thead class="thead-dark">
                        <tr class="text-center">
                            <th>Name</th>
                            <th>Author</th>
                            <th>Publication</th>
                            <th>Edition</th>
                            <th>Class</th>
                            <th>Semester</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <?php
                            $name = mysqli_real_escape_string($con, $_GET['name']);
                            $author = mysqli_real_escape_string($con, $_GET['author']);
                            $publication = mysqli_real_escape_string($con, $_GET['publication']);
                            $edition = mysqli_real_escape_string($con, $_GET['edition']);
                            $class = mysqli_real_escape_string($con, $_GET['class']);
                            $sem = isset($_GET['sem']) ? mysqli_real_escape_string($con, $_GET['sem']) : '';

                            $conditions = array();

                            if(!empty($name)){ $conditions[] = "name LIKE '%$name%'"; }
                            if(!empty($author)){ $conditions[] = "author LIKE '%$author%'"; }
                            if(!empty($publication)){ $conditions[] = "publication LIKE '%$publication%'"; }
                            if(!empty($edition)){ $conditions[] = "edition LIKE '%$edition%'"; }
                            if(!empty($class) && $class != '#'){ $conditions[] = "class = '$class'"; }
                            if(!empty($sem)){ $conditions[] = "sem = '$sem'"; }

                            $whereClause = count($conditions) > 0 ? "WHERE " . implode(' AND ', $conditions) : "";
                            
                            $countQuery = "SELECT COUNT(*) as total FROM `bookdata` $whereClause";
                            $countResult = mysqli_query($con, $countQuery);
                            $totalRows = mysqli_fetch_assoc($countResult)['total'];
                            $totalPages = ceil($totalRows / $limit);

                            $query = "SELECT * FROM `bookdata` $whereClause LIMIT $offset, $limit";
                            $data = mysqli_query($con, $query) or die(mysqli_error($con));
                            
                            if(mysqli_num_rows($data) > 0){
                                while($row = mysqli_fetch_assoc($data)){
                                    ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['name']);?></td>
                                        <td><?php echo htmlspecialchars($row['author']);?></td>
                                        <td><?php echo htmlspecialchars($row['publication']);?></td>
                                        <td><?php echo htmlspecialchars($row['edition']);?></td>
                                        <td><?php echo htmlspecialchars($row['class']);?></td>
                                        <td><?php echo htmlspecialchars($row['sem']);?></td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="6">Records Not Found</td>
                                </tr>
                                <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>
            
            <?php if($totalPages > 1): ?>
            <nav class="mt-4">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                        <a class="page-link" href="<?php echo getPaginationUrl($page - 1, $limit); ?>">Previous</a>
                    </li>
                    <?php for($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                            <a class="page-link" href="<?php echo getPaginationUrl($i, $limit); ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?php echo ($page >= $totalPages) ? 'disabled' : ''; ?>">
                        <a class="page-link" href="<?php echo getPaginationUrl($page + 1, $limit); ?>">Next</a>
                    </li>
                </ul>
            </nav>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <?php if(isset($_GET['submit'])): ?>
        <div class="col-lg-12 table-responsive mt-4 p-0">
            <h3 >Searched books</h3>
            <table class="table table-striped table-hover table-bordered shadow-sm bg-white col-lg-12">
                <thead class="thead-dark">
                    <tr class="text-center">
                        <th>Name</th>
                        <th>Author</th>
                        <th>Publication</th>
                        <th>Edition</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                <?php
                    $search=mysqli_real_escape_string($con, $_GET['search']);
                    $whereClause="where id like '%$search%' or name like '%$search%' or author like '%$search%' or publication like '%$search%' or edition like '%$search%'";
                    
                    $countQuery = "SELECT COUNT(*) as total FROM `bookdata` $whereClause";
                    $countResult = mysqli_query($con, $countQuery);
                    $totalRows = mysqli_fetch_assoc($countResult)['total'];
                    $totalPages = ceil($totalRows / $limit);

                    $sql="Select * from `bookdata` $whereClause LIMIT $offset, $limit";
                    $result=mysqli_query($con,$sql);
                    if($result) {
                        if(mysqli_num_rows($result)>0){
                            while($row=mysqli_fetch_assoc($result)){
                                echo '<tr>
                                <td>'.htmlspecialchars($row['name']).'</td>
                                <td>'.htmlspecialchars($row['author']).'</td>
                                <td>'.htmlspecialchars($row['publication']).'</td>
                                <td>'.htmlspecialchars($row['edition']).'</td>
                                </tr>';
                            }
                        }else{
                            echo '<tr><td colspan="4" class="text-danger font-weight-bold">Data not found</td></tr>';
                        }
                    }
                ?>
                </tbody>
            </table>
            
            <?php if($totalPages > 1): ?>
            <nav class="mt-4">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                        <a class="page-link" href="<?php echo getPaginationUrl($page - 1, $limit); ?>">Previous</a>
                    </li>
                    <?php for($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                            <a class="page-link" href="<?php echo getPaginationUrl($i, $limit); ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?php echo ($page >= $totalPages) ? 'disabled' : ''; ?>">
                        <a class="page-link" href="<?php echo getPaginationUrl($page + 1, $limit); ?>">Next</a>
                    </li>
                </ul>
            </nav>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <?php if(!isset($_GET['sbmt']) && !isset($_GET['submit'])): ?>
        <div class="mt-4 p-0">
            <div class="col-lg-12 table-responsive m-0 p-0">
                <h3 >Your books</h3>
                <br>
                <table class="table table-striped table-hover table-bordered shadow-sm bg-white">
                    <thead class="thead-dark">
                        <tr class="text-center">
                            <th> Name </th>
                            <th> Author </th>
                            <th> Publication </th>
                            <th> Edition </th>
                            <th> Class </th>
                            <th> Semester </th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                    <?php
                        $countQuery = "SELECT COUNT(*) as total FROM `bookdata`";
                        $countResult = mysqli_query($con, $countQuery);
                        $totalRows = mysqli_fetch_assoc($countResult)['total'];
                        $totalPages = ceil($totalRows / $limit);

                        $q = "select * from bookdata LIMIT $offset, $limit";
                        $query = mysqli_query($con, $q);
                        if(mysqli_num_rows($query) > 0) {
                            while($res = mysqli_fetch_array($query)){
                            ?>
                            <tr>
                                <td> <?php echo htmlspecialchars($res['name']) ?> </td>
                                <td> <?php echo htmlspecialchars($res['author']) ?> </td>
                                <td> <?php echo htmlspecialchars($res['publication']) ?> </td>
                                <td> <?php echo htmlspecialchars($res['edition']) ?> </td>
                                <td> <?php echo htmlspecialchars($res['class']) ?> </td>
                                <td> <?php echo htmlspecialchars($res['sem']) ?> </td>
                            </tr>
                            <?php
                            }
                        } else {
                            echo '<tr><td colspan="6">No books found in the library.</td></tr>';
                        }
                    ?>
                    </tbody>
                </table>
                
                <?php if($totalPages > 1): ?>
                <nav class="mt-4">
                    <ul class="pagination justify-content-center">
                        <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="<?php echo getPaginationUrl($page - 1, $limit); ?>">Previous</a>
                        </li>
                        <?php for($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                                <a class="page-link" href="<?php echo getPaginationUrl($i, $limit); ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item <?php echo ($page >= $totalPages) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="<?php echo getPaginationUrl($page + 1, $limit); ?>">Next</a>
                        </li>
                    </ul>
                </nav>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <br><br>
</body>
</html>
