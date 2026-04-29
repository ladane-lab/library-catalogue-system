<?php
session_start();
include '../includes/db.php';

// Enforce login
if (!isset($_SESSION['username'])) {
    header("Location: ../screens/sample.php");
    exit();
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if(isset($_POST['submit'])){
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $author = mysqli_real_escape_string($con, $_POST['author']);
    $publication = mysqli_real_escape_string($con, $_POST['publication']);
    $edition = mysqli_real_escape_string($con, $_POST['edition']);
    $class = mysqli_real_escape_string($con, $_POST['class']);
    $sem = mysqli_real_escape_string($con, $_POST['sem']);

    $sql = "UPDATE `bookdata` SET name='$name', author='$author', publication='$publication', edition='$edition', class='$class', sem='$sem' WHERE id=$id";
    $result = mysqli_query($con, $sql);
    
    if($result){
        header('location:../screens/librarian.php');
        exit();
    } else {
        die(mysqli_error($con));
    }
}

// Fetch existing data
$fetch_query = "SELECT * FROM bookdata WHERE id=$id";
$fetch_result = mysqli_query($con, $fetch_query);
$book = mysqli_fetch_assoc($fetch_result);

if (!$book) {
    header("Location: ../screens/librarian.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <title>Update Book</title>
</head>
<body class="bg-light">
<?php include '../includes/navbar.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-edit"></i> Update Book Data</h4>
                </div>
                <div class="card-body p-4">
                    <form method="post">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">Book Name</label>
                                <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($book['name']); ?>" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">Author</label>
                                <input type="text" name="author" class="form-control" value="<?php echo htmlspecialchars($book['author']); ?>" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">Publication</label>
                                <input type="text" name="publication" class="form-control" value="<?php echo htmlspecialchars($book['publication']); ?>" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">Edition</label>
                                <input type="text" name="edition" class="form-control" value="<?php echo htmlspecialchars($book['edition']); ?>" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">Class</label>
                                <?php 
                                $classes = ['FYBCS', 'SYBCS', 'TYBCS', 'FYBCA', 'SYBCA', 'TYBCA', 'FYBIOINFORMATCIS', 'SYBIOINFORMATICS', 'TYBIOINFORMATICS', 'FYBIOTECHNOLOGY', 'SYBIOTECHNOLOGY', 'TYBIOTECHNOLOGY']; 
                                $current_class = $book['class'];
                                
                                // If the database has a legacy class not in our list, add it so it displays properly!
                                if (!empty($current_class) && !in_array($current_class, $classes)) {
                                    array_unshift($classes, $current_class);
                                }
                                ?>
                                <select class="form-control" name="class" required>
                                    <option value="" disabled <?php if(empty($current_class)) echo 'selected'; ?>>Select Class</option>
                                    <?php foreach ($classes as $c): ?>
                                        <option value="<?php echo htmlspecialchars($c); ?>" <?php if ($current_class == $c) echo 'selected'; ?>><?php echo htmlspecialchars($c); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold d-block">Semester</label>
                                <?php $current_sem = $book['sem']; ?>
                                <div class="custom-control custom-radio custom-control-inline mt-2">
                                    <input type="radio" id="semEven" name="sem" class="custom-control-input" value="Even Sem" <?php if ($current_sem == 'Even Sem' || strtolower(trim($current_sem)) == 'even') echo 'checked'; ?> required>
                                    <label class="custom-control-label" for="semEven">Even Sem</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline mt-2">
                                    <input type="radio" id="semOdd" name="sem" class="custom-control-input" value="Odd Sem" <?php if ($current_sem == 'Odd Sem' || strtolower(trim($current_sem)) == 'odd') echo 'checked'; ?> required>
                                    <label class="custom-control-label" for="semOdd">Odd Sem</label>
                                </div>
                            </div>
                        </div>

                        <hr class="mt-4">
                        <div class="d-flex justify-content-between">
                            <a href="../screens/librarian.php" class="btn btn-secondary font-weight-bold px-4"><i class="fas fa-arrow-left"></i> Cancel</a>
                            <button class="btn btn-success font-weight-bold px-4" type="submit" name="submit"><i class="fas fa-save"></i> Update Book</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
