<?php
session_start();
include 'conn.php';

if (!isset($_SESSION['username'])) {
    header("Location: sample.php");
    exit();
}

if (isset($_POST["import"])) {
    $fileName = $_FILES["file"]["tmp_name"];
    
    if ($_FILES["file"]["size"] > 0) {
        $file = fopen($fileName, "r");
        
        // Skip the first row (headers)
        fgetcsv($file, 10000, ",");
        
        $count = 0;
        while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
            // Ensure we have at least the basic columns
            if (count($column) >= 4) {
                $name = mysqli_real_escape_string($con, $column[0] ?? '');
                $author = mysqli_real_escape_string($con, $column[1] ?? '');
                $publication = mysqli_real_escape_string($con, $column[2] ?? '');
                $edition = mysqli_real_escape_string($con, $column[3] ?? '');
                $class = mysqli_real_escape_string($con, $column[4] ?? '');
                $sem = mysqli_real_escape_string($con, $column[5] ?? '');

                if (!empty($name) && !empty($author)) {
                    $sqlInsert = "INSERT into bookdata (name, author, publication, edition, class, sem) 
                                  values ('$name','$author','$publication','$edition','$class','$sem')";
                    mysqli_query($con, $sqlInsert);
                    $count++;
                }
            }
        }
        
        fclose($file);
        
        // Redirect back with success message parameter
        header("Location: librarian.php?import_success=" . $count);
        exit();
    } else {
        header("Location: librarian.php?import_error=empty");
        exit();
    }
} else {
    header("Location: librarian.php");
    exit();
}
?>
