<?php

session_start();

    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }

$connection = new SQLite3('list.db');

if (!$connection) {
    die("Error opening database: " . $connection->lastErrorCode());
}

$judul = $_POST['judul'];
$dari = $_POST['dari'];
$ke = $_POST['ke'];
$tanggal = $_POST['tanggal'];
$jenis = $_POST['jenis'];
$namafile = basename($_FILES["pdf_file"]["name"]);

$sql = "INSERT INTO mail(judul, dari, ke, tanggal, jenis) VALUES ('$judul', '$dari', '$ke', '$tanggal', '$jenis');";

$target_dir = "document/pdf/";
$target_file = $target_dir . $judul . ".pdf";
$uploadOk = 1;

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "File tidak dapat terunggah.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["pdf_file"]["tmp_name"], $target_file)) {
    echo "File ". htmlspecialchars( basename( $_FILES["pdf_file"]["name"])). " telah diunggah.";
  } else {
    echo "Ada kesalahan dalam pengunggahan file.";
  }
}

$result = $connection->exec($sql);
if ($result === false) {
    die("Error inserting record: " . $connection->lastErrorMsg());
} else {
    echo "Record inserted successfully!";
}

// extract_pdf_text.php
$command = "pdfjs-dist/build/pdf.min.js";
exec("node --experimental-specifier-path=" . $command . " -t 'extract'", $output);

// extract_pdf_text.php
$command = "pdftotext -layout '$target_file' -";
exec($command, $output);

$text_content = implode("\n", $output);

file_put_contents("document/txt/$judul.txt", implode("\n", $output));

// Close connection
$connection->close();
?>