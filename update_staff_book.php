<?php
session_start();
include 'conn.php';

if (!isset($_SESSION['username'])) {
    header("Location: sample.php");
    exit();
}

$id = $_GET['id'];
$q = "SELECT * FROM books WHERE id = '$id'";
$query = mysqli_query($con, $q);
$res = mysqli_fetch_array($query);

if (isset($_POST['submit'])) {
    $isbn = mysqli_real_escape_string($con, $_POST['isbn']);
    $author = mysqli_real_escape_string($con, $_POST['author']);
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $edn = mysqli_real_escape_string($con, $_POST['edn']);
    $price = mysqli_real_escape_string($con, $_POST['price']);
    $edition = mysqli_real_escape_string($con, $_POST['edition']);
    $qty = mysqli_real_escape_string($con, $_POST['qty']);
    $yop = mysqli_real_escape_string($con, $_POST['yop']);

    $update_query = "UPDATE books SET isbn='$isbn', author='$author', title='$title', edn='$edn', price='$price', edition='$edition', qty='$qty', yop='$yop' WHERE id='$id'";
    
    if (mysqli_query($con, $update_query)) {
        header("Location: librarian.php?msg=Staff record updated successfully");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Update Staff Submission - Librarian</title>
    <style>
        body { background-color: #f8f9fa; }
        .card { border: none; border-radius: 15px; }
        .card-header { border-radius: 15px 15px 0 0 !important; }
        .form-control { border-radius: 8px; padding: 12px; }
        .btn-update { border-radius: 8px; padding: 12px 30px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0"><i class="fas fa-edit mr-2"></i> Update Staff Submission</h4>
                            <a href="librarian.php" class="btn btn-light btn-sm font-weight-bold shadow-sm">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-5">
                        <form method="POST">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="font-weight-bold text-muted small">ISBN NUMBER</label>
                                    <input type="text" name="isbn" value="<?php echo htmlspecialchars($res['isbn']); ?>" class="form-control" required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="font-weight-bold text-muted small">AUTHOR NAME</label>
                                    <input type="text" name="author" value="<?php echo htmlspecialchars($res['author']); ?>" class="form-control" required>
                                </div>
                                <div class="col-12 form-group">
                                    <label class="font-weight-bold text-muted small">BOOK TITLE</label>
                                    <input type="text" name="title" value="<?php echo htmlspecialchars($res['title']); ?>" class="form-control" required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="font-weight-bold text-muted small">EDN (Publication)</label>
                                    <input type="text" name="edn" value="<?php echo htmlspecialchars($res['edn']); ?>" class="form-control" required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="font-weight-bold text-muted small">PRICE</label>
                                    <input type="text" name="price" value="<?php echo htmlspecialchars($res['price']); ?>" class="form-control" required>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label class="font-weight-bold text-muted small">EDITION</label>
                                    <input type="text" name="edition" value="<?php echo htmlspecialchars($res['edition']); ?>" class="form-control" required>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label class="font-weight-bold text-muted small">QUANTITY</label>
                                    <input type="number" name="qty" value="<?php echo htmlspecialchars($res['qty']); ?>" class="form-control" required>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label class="font-weight-bold text-muted small">YEAR OF PUB (YOP)</label>
                                    <input type="text" name="yop" value="<?php echo htmlspecialchars($res['yop']); ?>" class="form-control" required>
                                </div>
                            </div>
                            
                            <div class="text-center mt-4">
                                <button type="submit" name="submit" class="btn btn-primary btn-update btn-block shadow">
                                    <i class="fas fa-check-circle mr-2"></i> Confirm & Save Updates
                                </button>
                                <p class="text-muted mt-3 small">
                                    <i class="fas fa-info-circle mr-1"></i> Initially sent by: <strong><?php echo htmlspecialchars($res['sent_by'] ?? 'N/A'); ?></strong>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
