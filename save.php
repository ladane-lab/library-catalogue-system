<?php
session_start();
include 'conn.php';

// We now use the persistent session selection instead of just the POSTed checkboxes
if(isset($_SESSION['selected_books']) && !empty($_SESSION['selected_books'])){
    $success_count = 0;
    $staff_username = mysqli_real_escape_string($con, $_SESSION['username']);

    foreach($_SESSION['selected_books'] as $id){
        $id = mysqli_real_escape_string($con, $id);
        
        // Fetch the record from 'new' table
        $fetch_query = "SELECT * FROM `new` WHERE id = '$id'";
        $fetch_result = mysqli_query($con, $fetch_query);
        
        if($row = mysqli_fetch_assoc($fetch_result)) {
            $isbn = mysqli_real_escape_string($con, $row['isbn']);
            $author = mysqli_real_escape_string($con, $row['author']);
            $title = mysqli_real_escape_string($con, $row['title']);
            $edn = mysqli_real_escape_string($con, $row['edn']);
            $price = mysqli_real_escape_string($con, $row['price']);
            $edition = mysqli_real_escape_string($con, $row['edition']);
            $qty = mysqli_real_escape_string($con, $row['qty']);
            $yop = mysqli_real_escape_string($con, $row['yop']);
            
            // Insert into 'books' table with 'sent_by' column
            $insert_query = "INSERT INTO `books`(`isbn`, `author`, `title`, `edn`, `price`, `edition`, `qty`, `yop`, `sent_by`) 
                             VALUES ('$isbn', '$author', '$title', '$edn', '$price', '$edition', '$qty', '$yop', '$staff_username')";
            
            if(mysqli_query($con, $insert_query)) {
                // Delete from 'new' table
                mysqli_query($con, "DELETE FROM `new` WHERE id = '$id'");
                $success_count++;
            }
        }
    }
    
    if($success_count > 0) {
        $_SESSION['status'] = $success_count . " book(s) updated and sent to Librarian successfully!";
        // Clear the selection after successful update
        $_SESSION['selected_books'] = [];
    } else {
        $_SESSION['status'] = "No books were updated.";
    }
} else {
    $_SESSION['status'] = "Please select at least one book to update.";
}

header('location:staff.php');
exit();
?>