<?php
include '../includes/db.php';

$sql = "ALTER TABLE `books` ADD COLUMN `sent_by` VARCHAR(255) DEFAULT NULL";
if (mysqli_query($con, $sql)) {
    echo "Column 'sent_by' added successfully.";
} else {
    echo "Error or column already exists: " . mysqli_error($con);
}
?>
