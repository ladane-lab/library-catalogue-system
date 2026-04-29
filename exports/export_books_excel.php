<?php
session_start();
include 'conn.php';

// Enforce login
if (!isset($_SESSION['username'])) {
    header("Location: sample.php");
    exit();
}

// Set headers for CSV download
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=Books_Template_Export_' . date('Y-m-d') . '.csv');

$output = fopen('php://output', 'w');

// Output the column headings for Book Data
fputcsv($output, array('Name', 'Author', 'Publication', 'Edition', 'Class', 'Semester'));

// Fetch the existing data from 'bookdata'
$query = "SELECT name, author, publication, edition, class, sem FROM bookdata";
$result = mysqli_query($con, $query);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        fputcsv($output, $row);
    }
}

fclose($output);
exit();
?>
