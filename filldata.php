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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <title>Send Data To Staff - Library Zone</title>
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
                <li class="nav-item">
                    <a class="nav-link text-white font-weight-bold" href="librarian.php">Dashboard</a>
                </li>
            </ul>

            <ul class="navbar-nav">
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

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2><i class="fas fa-paper-plane text-primary"></i> Send Data To Staff</h2>
                    <a href="export_excel.php" class="btn btn-success font-weight-bold shadow-sm">
                        <i class="fas fa-file-excel"></i> Export Table to Excel
                    </a>
                </div>
                
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <form method="post" action="fill.php">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="font-weight-bold">ISBN</label>
                                    <input type="text" name="isbn" class="form-control" placeholder="character value" required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="font-weight-bold">Author</label>
                                    <input type="text" name="author" class="form-control" placeholder="character value" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label class="font-weight-bold">Title</label>
                                    <input type="text" name="title" class="form-control" placeholder="character value" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="font-weight-bold">Edition (EDN)</label>
                                    <input type="text" name="edn" class="form-control" placeholder="integer value" required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="font-weight-bold">Price</label>
                                    <input type="text" name="price" class="form-control" placeholder="float value" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label class="font-weight-bold">New Book/Edition</label>
                                    <input type="text" name="edition" class="form-control" placeholder="character value" required>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label class="font-weight-bold">Quantity (QTY)</label>
                                    <input type="text" name="qty" class="form-control" placeholder="integer value" required>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label class="font-weight-bold">Year of Pub (YOP)</label>
                                    <input type="text" name="yop" class="form-control" placeholder="integer value" required>
                                </div>
                            </div>
                            
                            <hr>
                            <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn-primary font-weight-bold px-4" name="submit">
                                    <i class="fas fa-paper-plane"></i> Submit to Staff
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="mt-4 text-center">
                    <a href="librarian.php" class="text-muted"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>