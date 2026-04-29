<?php
session_start();
include 'conn.php';

if (!isset($_SESSION['username'])) {
    header("Location: sample.php");
    exit();
}
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <title>Librarian Dashboard - Library Zone</title>
</head>

<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <a class="navbar-brand" href="librarian.php">
            <h6 class="m-0"><b style="color: white;">WELCOME TO LIBRARY <span style="color: rgb(236, 134, 17)">ZONE</span></b></h6>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link text-white font-weight-bold px-3" href="librarian.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link text-white font-weight-bold px-3" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link text-white font-weight-bold px-3" href="student.php">Student</a></li>
                <li class="nav-item"><a class="nav-link text-white font-weight-bold px-3" href="faculty.php">Faculty</a></li>
                <li class="nav-item"><a class="nav-link text-white font-weight-bold px-3" href="sample.php">Librarian</a></li>
                <li class="nav-item"><a class="nav-link text-white font-weight-bold px-3" href="admin.php">Admin</a></li>
            </ul>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white font-weight-bold" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user-circle"></i> Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="change_password.php">Change Password</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="logout.php">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    
    <div class="container-fluid mt-4">
        
        <?php if(isset($_GET['import_success'])): ?>
        <div class="alert alert-success alert-dismissible fade show font-weight-bold" role="alert">
            <i class="fas fa-check-circle"></i> Successfully imported <?php echo htmlspecialchars($_GET['import_success']); ?> books from the Excel file!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php endif; ?>
        
        <?php if(isset($_GET['import_error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show font-weight-bold" role="alert">
            <i class="fas fa-exclamation-circle"></i> Error importing file. Please ensure it is a valid CSV.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php endif; ?>

        <div class="row">
            <!-- Add Book Form -->
            <div class="col-lg-8 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0"><i class="fas fa-plus-circle"></i> Add New Book</h5>
                    </div>
                    <div class="card-body">
                        <form id="libraryForm" method="post" action="store.php">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="font-weight-bold">Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="Enter book name" required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="font-weight-bold">Author</label>
                                    <input type="text" class="form-control" name="author" placeholder="Enter author name" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="font-weight-bold">Publication</label>
                                    <input type="text" class="form-control" name="publication" placeholder="Enter publication" required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="font-weight-bold">Edition</label>
                                    <input type="text" class="form-control" name="edition" placeholder="Enter edition" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="font-weight-bold">Class</label>
                                    <select class="form-control" name="class" required>
                                        <option value="" disabled selected>Select Class</option>
                                        <option value="FYBCS">FYBCS</option>
                                        <option value="SYBCS">SYBCS</option>
                                        <option value="TYBCS">TYBCS</option>
                                        <option value="FYBCA">FYBCA</option>
                                        <option value="SYBCA">SYBCA</option>
                                        <option value="TYBCA">TYBCA</option>
                                        <option value="FYBIOINFORMATCIS">FYBIOINFORMATCIS</option>
                                        <option value="SYBIOINFORMATICS">SYBIOINFORMATICS</option>
                                        <option value="TYBIOINFORMATICS">TYBIOINFORMATICS</option>
                                        <option value="FYBIOTECHNOLOGY">FYBIOTECHNOLOGY</option>
                                        <option value="SYBIOTECHNOLOGY">SYBIOTECHNOLOGY</option>
                                        <option value="TYBIOTECHNOLOGY">TYBIOTECHNOLOGY</option>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="font-weight-bold d-block">Semester</label>
                                    <div class="custom-control custom-radio custom-control-inline mt-2">
                                        <input type="radio" id="semEven" name="sem" class="custom-control-input" value="Even Sem" >
                                        <label class="custom-control-label" for="semEven">Even Sem</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline mt-2">
                                        <input type="radio" id="semOdd" name="sem" class="custom-control-input" value="Odd Sem" >
                                        <label class="custom-control-label" for="semOdd">Odd Sem</label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <button type="submit" class="btn btn-success font-weight-bold px-4" name="done">
                                <i class="fas fa-save"></i> Save Book
                            </button>
                        </form>
                        
                        <hr class="mt-4 mb-4">
                        <div class="bg-light p-3 rounded border">
                            <h6 class="font-weight-bold"><i class="fas fa-file-excel text-success"></i> Bulk Import via Excel</h6>
                            <p class="text-muted small mb-3">Download the template, fill it out, and upload the CSV to add multiple books at once.</p>
                            <form action="import_books.php" method="post" enctype="multipart/form-data" class="d-flex align-items-center">
                                <div class="custom-file mr-2">
                                    <input type="file" name="file" class="custom-file-input" id="customFile" accept=".csv" required>
                                    <label class="custom-file-label" for="customFile">Choose CSV file</label>
                                </div>
                                <button type="submit" name="import" class="btn btn-primary font-weight-bold px-4 shadow-sm">
                                    <i class="fas fa-upload"></i> Import
                                </button>
                            </form>
                            <div class="mt-2">
                                <a href="export_books_excel.php" class="text-success font-weight-bold small"><i class="fas fa-download"></i> Download CSV Template</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Controls -->
            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-light text-dark border-bottom-0">
                        <h5 class="mb-0 font-weight-bold"><i class="fas fa-cogs text-secondary"></i> System Actions</h5>
                    </div>
                    <div class="card-body bg-white rounded-bottom">
                        <p class="text-muted mb-4" style="font-size: 0.95rem;">Use these controls to send the survey of book related to the course work like which books required for current syllabus. Proceed with caution.</p>
                        
                        <a href="filldata.php" class="btn btn-outline-info btn-block font-weight-bold mb-3 py-2" style="border-width: 2px;">
                            <i class="fas fa-upload"></i> Send Data To Staff
                        </a>
                        
                        <button onclick="confirmDelete()" type="button" class="btn btn-outline-danger btn-block font-weight-bold py-2" style="border-width: 2px;">
                            <i class="fas fa-trash-alt"></i> Delete Staff Table Data
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <script>
            function confirmDelete() {
                if (confirm("WARNING: Are you sure you want to completely clear the staff table data? This cannot be undone.")) {
                    window.location = "deletetable.php";
                }
            }
        </script>
        
        <!-- Student Data Table -->
        <div id="books-table-card" class="card shadow-sm border-0 mb-5">
            <div class="card-header bg-white d-flex flex-column flex-md-row justify-content-between align-items-md-center py-3">
                <h5 class="mb-3 mb-md-0 text-dark"><i class="fas fa-book-open"></i> Books Data</h5>
                <form class="form-inline m-0 ajax-filter-form" method="get" id="librarianCatalogControls" data-target-tbody="books-data-tbody" data-target-pagination="books-pagination">
                    <div class="d-flex align-items-center mb-2 mb-md-0 mr-md-3">
                        <label class="mr-2 small font-weight-bold">Show</label>
                        <select name="limit" class="form-control form-control-sm">
                            <?php 
                                $limits = [5, 10, 20, 50, 100];
                                $current_limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 5;
                                foreach($limits as $l) {
                                    echo '<option value="'.$l.'" '.($current_limit == $l ? 'selected' : '').'>'.$l.'</option>';
                                }
                            ?>
                        </select>
                        <label class="ml-2 small font-weight-bold">rows</label>
                    </div>

                    <div class="input-group input-group-sm shadow-sm">
                        <input class="form-control border-warning" type="search" name="search" placeholder="Search Books..." aria-label="Search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                        <div class="input-group-append">
                            <button class="btn btn-warning text-dark font-weight-bold px-3" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered mb-0">
                        <thead class="thead-light text-center">
                            <tr>
                                <th>Name</th>
                                <th>Author</th>
                                <th>Publication</th>
                                <th>Edition</th>
                                <th>Class</th>
                                <th>Semester</th>
                                <th colspan="2">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="books-data-tbody">
    <?php
                                include 'conn.php';

                                // Pagination and Search logic
                                $limit = isset($_GET['limit']) && is_numeric($_GET['limit']) ? (int)$_GET['limit'] : 5;
                                $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
                                $offset = ($page - 1) * $limit;

                                $searchQuery = "";
                                $searchParam = "";
                                if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
                                    $search = mysqli_real_escape_string($con, $_GET['search']);
                                    $searchQuery = " WHERE name LIKE '%$search%' OR author LIKE '%$search%' OR publication LIKE '%$search%' OR edition LIKE '%$search%' OR class LIKE '%$search%'";
                                    $searchParam = "&search=" . urlencode($_GET['search']);
                                }

                                $limitParam = "&limit=" . $limit;

                                // Get total rows
                                $total_query = mysqli_query($con, "SELECT COUNT(*) as total FROM bookdata" . $searchQuery);
                                $total_row = mysqli_fetch_assoc($total_query);
                                $total_pages = ceil($total_row['total'] / $limit);

                                // Fetch current page data
                                $q = "SELECT * FROM bookdata" . $searchQuery . " LIMIT $limit OFFSET $offset";
                                $query = mysqli_query($con, $q);
                                
                                if (mysqli_num_rows($query) > 0) {
                                    while($res = mysqli_fetch_array($query)){
                            ?>
                                        <tr class="text-center align-middle">
                                            <td class="align-middle"> <?php echo htmlspecialchars($res['name']); ?> </td>
                                            <td class="align-middle"> <?php echo htmlspecialchars($res['author']); ?> </td>
                                            <td class="align-middle"> <?php echo htmlspecialchars($res['publication']); ?> </td>
                                            <td class="align-middle"> <?php echo htmlspecialchars($res['edition']); ?> </td>
                                            <td class="align-middle"> <?php echo htmlspecialchars($res['class']); ?> </td>
                                            <td class="align-middle"> <?php echo htmlspecialchars($res['sem']); ?> </td>
                                            <td class="align-middle"> 
                                                <a href="delete.php?id=<?php echo $res['id']; ?>" class="btn btn-outline-danger btn-sm font-weight-bold shadow-sm">Delete</a> 
                                            </td>
                                            <td class="align-middle"> 
                                                <a href="update.php?id=<?php echo $res['id']; ?>" class="btn btn-outline-primary btn-sm font-weight-bold shadow-sm">Update</a> 
                                            </td>
                                        </tr>
                            <?php
                                    }
                                } else {
                                    echo '<tr><td colspan="8" class="text-center text-muted py-4">No books data available.</td></tr>';
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Pagination Controls -->
            <?php if($total_pages > 1): ?>
            <div id="books-pagination" class="card-footer bg-light border-top d-flex justify-content-center py-3">
                <nav aria-label="Books pagination">
                    <ul class="pagination mb-0 shadow-sm">
                        <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                            <a class="page-link font-weight-bold" href="<?php echo ($page <= 1) ? '#' : '?page='.($page - 1) . $searchParam . $limitParam; ?>" tabindex="-1">Previous</a>
                        </li>
                        
                        <?php for($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $i . $searchParam . $limitParam; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>
                        
                        <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                            <a class="page-link font-weight-bold" href="<?php echo ($page >= $total_pages) ? '#' : '?page='.($page + 1) . $searchParam . $limitParam; ?>">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
            <?php endif; ?>
        </div>

        <!-- Updated List from Staff Table -->
        <div id="staff-updates-card" class="card shadow-sm border-0 mb-5">
            <div class="card-header bg-white d-flex flex-column flex-md-row justify-content-between align-items-md-center py-3">
                <h5 class="mb-3 mb-md-0 text-dark"><i class="fas fa-list-alt"></i> Updated List From Staff</h5>
                
                <form class="form-inline m-0 ajax-filter-form" method="get" id="staffUpdatesControls" data-target-tbody="staff-updates-tbody" data-target-pagination="staff-updates-pagination">
                    <!-- Rows Limit -->
                    <div class="d-flex align-items-center mb-2 mb-md-0 mr-md-3">
                        <label class="mr-2 small font-weight-bold">Show</label>
                        <select name="limit3" class="form-control form-control-sm">
                            <?php 
                                $limits = [5, 10, 20, 50, 100];
                                $current_limit3 = isset($_GET['limit3']) ? (int)$_GET['limit3'] : 5;
                                foreach($limits as $l) {
                                    echo '<option value="'.$l.'" '.($current_limit3 == $l ? 'selected' : '').'>'.$l.'</option>';
                                }
                            ?>
                        </select>
                        <label class="ml-2 small font-weight-bold">rows</label>
                    </div>

                    <!-- Faculty Filter -->
                    <div class="input-group input-group-sm mr-md-3 mb-2 mb-md-0">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-light"><i class="fas fa-filter text-primary"></i></span>
                        </div>
                        <select name="faculty" class="form-control">
                            <option value="">All Faculty</option>
                            <?php 
                                $fac_q = mysqli_query($con, "SELECT DISTINCT sent_by FROM books WHERE sent_by IS NOT NULL AND sent_by != '' ORDER BY sent_by ASC");
                                while($f = mysqli_fetch_array($fac_q)) {
                                    $selected = (isset($_GET['faculty']) && $_GET['faculty'] == $f['sent_by']) ? 'selected' : '';
                                    echo '<option value="'.htmlspecialchars($f['sent_by']).'" '.$selected.'>'.htmlspecialchars($f['sent_by']).'</option>';
                                }
                            ?>
                        </select>
                    </div>

                    <!-- Search Bar -->
                    <div class="input-group input-group-sm shadow-sm">
                        <input class="form-control border-primary" type="search" name="search3" placeholder="Search staff updates..." aria-label="Search Staff Updates" value="<?php echo isset($_GET['search3']) ? htmlspecialchars($_GET['search3']) : ''; ?>">
                        <div class="input-group-append">
                            <button class="btn btn-primary text-white font-weight-bold px-3" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered mb-0">
                        <thead class="thead-light text-center">
                            <tr>
                                <th>Sent By</th>
                                <th>ISBN</th>
                                <th>Author</th>
                                <th>Title</th>
                                <th>EDN</th>
                                <th>Price</th>
                                <th>Edition</th>
                                <th>Qty</th>
                                <th>YOP</th>
                                <th colspan="2">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="staff-updates-tbody">
                            <?php
                                // Pagination, Filter and Search logic for Table 3
                                $limit3 = isset($_GET['limit3']) && is_numeric($_GET['limit3']) ? (int)$_GET['limit3'] : 5;
                                $page3 = isset($_GET['p3']) && is_numeric($_GET['p3']) ? (int)$_GET['p3'] : 1;
                                $offset3 = ($page3 - 1) * $limit3;

                                $where_clause3 = " WHERE 1=1 ";
                                $params3 = "";

                                // Faculty Filter
                                if (isset($_GET['faculty']) && !empty($_GET['faculty'])) {
                                    $fac = mysqli_real_escape_string($con, $_GET['faculty']);
                                    $where_clause3 .= " AND sent_by = '$fac' ";
                                    $params3 .= "&faculty=" . urlencode($_GET['faculty']);
                                }

                                // Search Filter
                                if (isset($_GET['search3']) && !empty(trim($_GET['search3']))) {
                                    $s3 = mysqli_real_escape_string($con, $_GET['search3']);
                                    $where_clause3 .= " AND (isbn LIKE '%$s3%' OR author LIKE '%$s3%' OR title LIKE '%$s3%' OR sent_by LIKE '%$s3%' OR edn LIKE '%$s3%' OR edition LIKE '%$s3%' OR price LIKE '%$s3%' OR yop LIKE '%$s3%') ";
                                    $params3 .= "&search3=" . urlencode($_GET['search3']);
                                }

                                $limitParam3 = "&limit3=" . $limit3;

                                // Get total rows
                                $total_query3 = mysqli_query($con, "SELECT COUNT(*) as total FROM books" . $where_clause3);
                                $total_row3 = mysqli_fetch_assoc($total_query3);
                                $total_pages3 = ceil($total_row3['total'] / $limit3);

                                $q3 = "SELECT * FROM books" . $where_clause3 . " ORDER BY sent_by ASC, id DESC LIMIT $limit3 OFFSET $offset3";
                                $query3 = mysqli_query($con, $q3);
                                
                                if(mysqli_num_rows($query3) > 0) {
                                    while($res3 = mysqli_fetch_array($query3)){
                                ?>
                                <tr class="text-center">
                                    <td class="align-middle font-weight-bold text-primary">
                                        <i class="fas fa-user-tie mr-1"></i> <?php echo htmlspecialchars($res3['sent_by'] ?? 'Unknown'); ?>
                                    </td>
                                    <td class="align-middle"><?php echo htmlspecialchars($res3['isbn']); ?></td>
                                    <td class="align-middle"><?php echo htmlspecialchars($res3['author']); ?></td>
                                    <td class="align-middle"><?php echo htmlspecialchars($res3['title']); ?></td>
                                    <td class="align-middle"><?php echo htmlspecialchars($res3['edn']); ?></td>
                                    <td class="align-middle"><?php echo htmlspecialchars($res3['price']); ?></td>
                                    <td class="align-middle"><?php echo htmlspecialchars($res3['edition']); ?></td>
                                    <td class="align-middle"><?php echo htmlspecialchars($res3['qty']); ?></td>
                                    <td class="align-middle"><?php echo htmlspecialchars($res3['yop']); ?></td>
                                    <td class="align-middle">
                                        <a href="update_staff_book.php?id=<?php echo $res3['id']; ?>" class="btn btn-outline-primary btn-sm px-3 shadow-sm font-weight-bold">Update</a>
                                    </td>
                                    <td class="align-middle">
                                        <a href="delete_staff_book.php?id=<?php echo $res3['id']; ?>" onclick="return confirm('Are you sure you want to delete this staff update?')" class="btn btn-outline-danger btn-sm px-3 shadow-sm font-weight-bold">Delete</a>
                                    </td>
                                </tr>
                                <?php
                                    }
                                } else {
                                    echo '<tr><td colspan="11" class="text-center text-muted py-4">No matching updates found.</td></tr>';
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Pagination Controls for Table 3 -->
            <?php if($total_pages3 > 1): ?>
            <div id="staff-updates-pagination" class="card-footer bg-light border-top d-flex justify-content-center py-3">
                <nav aria-label="Staff updates pagination">
                    <ul class="pagination mb-0 shadow-sm">
                        <li class="page-item <?php echo ($page3 <= 1) ? 'disabled' : ''; ?>">
                            <a class="page-link font-weight-bold" href="<?php echo ($page3 <= 1) ? '#' : '?p3='.($page3 - 1) . $params3 . $limitParam3; ?>" tabindex="-1">Previous</a>
                        </li>
                        <?php for($k = 1; $k <= $total_pages3; $k++): ?>
                            <li class="page-item <?php echo ($page3 == $k) ? 'active' : ''; ?>">
                                <a class="page-link" href="?p3=<?php echo $k . $params3 . $limitParam3; ?>"><?php echo $k; ?></a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item <?php echo ($page3 >= $total_pages3) ? 'disabled' : ''; ?>">
                            <a class="page-link font-weight-bold" href="<?php echo ($page3 >= $total_pages3) ? '#' : '?p3='.($page3 + 1) . $params3 . $limitParam3; ?>">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
            <?php endif; ?>
        </div>
        
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
        
    <!-- Global Dashboard AJAX Handler -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Helper to trigger AJAX update
            const updateTable = (targetId, url) => {
                const card = document.getElementById(targetId);
                if (!card) return;
                
                const tbody = card.querySelector('tbody');
                const paginationId = card.querySelector('[id$="-pagination"]')?.id || card.getAttribute('data-target-pagination');
                const pagination = document.getElementById(paginationId);
                
                if (tbody) tbody.style.opacity = '0.5';
                
                fetch(url)
                    .then(response => response.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        
                        const newCard = doc.getElementById(targetId);
                        if (newCard) {
                            const newTbody = newCard.querySelector('tbody');
                            const newPagination = doc.getElementById(paginationId);
                            
                            if (newTbody && tbody) {
                                tbody.innerHTML = newTbody.innerHTML;
                                tbody.style.opacity = '1';
                            }
                            if (newPagination && pagination) {
                                pagination.innerHTML = newPagination.innerHTML;
                                pagination.style.display = newPagination.style.display;
                            }
                        }
                        window.history.pushState({path: url}, '', url);
                    })
                    .catch(err => {
                        console.error('AJAX Update failed:', err);
                        if (tbody) tbody.style.opacity = '1';
                    });
            };

            // 1. Handle Pagination Clicks (Delegated)
            document.addEventListener('click', function(e) {
                const link = e.target.closest('.page-link');
                if (!link) return;
                
                e.preventDefault();
                const url = link.getAttribute('href');
                if (!url || url === '#') return;
                
                const card = link.closest('.card');
                if (card && card.id) {
                    updateTable(card.id, url);
                }
            });

            // 2. Handle Filter Changes (Delegated)
            document.addEventListener('change', function(e) {
                const form = e.target.closest('.ajax-filter-form');
                if (!form) return;
                
                const card = form.closest('.card');
                if (!card || !card.id) return;
                
                const formData = new FormData(form);
                const params = new URLSearchParams(window.location.search);
                
                // Update params with current form values
                for (const [key, value] of formData.entries()) {
                    if (value !== '') params.set(key, value);
                    else params.delete(key);
                }
                
                const url = window.location.pathname + '?' + params.toString();
                updateTable(card.id, url);
            });

            // 3. Handle Search Submits (Delegated)
            document.addEventListener('submit', function(e) {
                const form = e.target.closest('.ajax-filter-form');
                if (!form) return;
                
                e.preventDefault();
                const card = form.closest('.card');
                if (!card || !card.id) return;
                
                const formData = new FormData(form);
                const params = new URLSearchParams(window.location.search);
                
                for (const [key, value] of formData.entries()) {
                    if (value !== '') params.set(key, value);
                    else params.delete(key);
                }
                
                // Reset page on search
                const tableNum = card.id.includes('staff') ? 'p3' : 'page';
                params.delete(tableNum);
                
                const url = window.location.pathname + '?' + params.toString();
                updateTable(card.id, url);
            });

            // File input listener
            const fileInput = document.getElementById("customFile");
            if(fileInput) {
                fileInput.addEventListener('change', function(e) {
                    var fileName = e.target.files[0].name;
                    var nextSibling = e.target.nextElementSibling;
                    if(nextSibling) nextSibling.innerText = fileName;
                });
            }
        });
    </script>
</body>
</html>
