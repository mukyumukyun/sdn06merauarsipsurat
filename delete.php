<?php
// delete.php

session_start(); // For CSRF protection (optional but recommended)

// Get ID from POST
$id = $_POST['id'] ?? null;

if (!$id || !is_numeric($id)) {
    http_response_code(400);
    die("Invalid or missing record ID.");
}

try {
    $connection = new SQLite3('list.db');

    // Use prepared statement to prevent SQL injection
    $stmt = $connection->prepare("DELETE FROM mail WHERE id = :id");
    
    if ($stmt->bindValue(':id', intval($id), SQLITE3_INTEGER)) {
        $result = $stmt->execute();
        
        if ($result) {
            $namafile = $_POST['namafile'];

            unlink("document/pdf/$namafile");
            unlink("document/txt/$namafile.txt");
            echo "<script>alert('Record deleted successfully!'); window.location.href='index.php';</script>";
        } else {
            die("Error deleting record.");
        }
    }

} catch (Exception $e) {
    error_log("Delete failed: " . $e->getMessage());
    http_response_code(500);
    die("An error occurred while deleting the record.");
}

$connection->close();
?>