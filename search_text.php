<?php
session_start();

    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }
    
$keyword = $_GET['keyword'];
$directory = 'document/txt/';
$file_list = glob("$directory/*.txt");

foreach ($file_list as $file) {
    if (is_file($file)) {
        $content = file_get_contents($file);
        if (stripos($content, $keyword) !== false) {
            $file = basename($file);
            echo "<script>alert('$file' + ' contains the string: ' + '$keyword'); window.location.href='index.php';</script>";
        }
    }
}
?>