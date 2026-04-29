<?php
session_start();
include '../includes/db.php';

// Enforce login
if (!isset($_SESSION['username'])) {
    header("Location: ../sample.php");
    exit();
}

// Set headers to force download as an Excel-compatible CSV file
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=Staff_Data_Export_' . date('Y-m-d') . '.csv');

// Create a file pointer connected to the output stream
$output = fopen('php://output', 'w');

// Output the column headings (The column names the user requested)
fputcsv($output, array('ISBN', 'Author', 'Title', 'EDN', 'Price', 'Edition', 'QTY', 'YOP'));

// Fetch the data from the 'new' table
$query = "SELECT isbn, author, title, edn, price, edition, qty, yop FROM new";
$result = mysqli_query($con, $query);

if ($result) {
    // Loop through the rows and output them to the CSV
    while ($row = mysqli_fetch_assoc($result)) {
        fputcsv($output, $row);
    }
}

// Close the file pointer
fclose($output);
exit();
?>
