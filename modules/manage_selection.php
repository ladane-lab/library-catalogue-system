<?php
session_start();

if (!isset($_SESSION['selected_books'])) {
    $_SESSION['selected_books'] = [];
}

if (isset($_POST['id']) && isset($_POST['action'])) {
    $id = $_POST['id'];
    $action = $_POST['action'];

    if ($action == 'add') {
        if (!in_array($id, $_SESSION['selected_books'])) {
            $_SESSION['selected_books'][] = $id;
        }
    } elseif ($action == 'remove') {
        if (($key = array_search($id, $_SESSION['selected_books'])) !== false) {
            unset($_SESSION['selected_books'][$key]);
        }
        $_SESSION['selected_books'] = array_values($_SESSION['selected_books']);
    }
    
    echo json_encode(['status' => 'success', 'count' => count($_SESSION['selected_books'])]);
}
?>
