<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add User</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        form { max-width: 500px; margin: auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px; }
        input[type="text"], input[type="email"] { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 4px; }
        button { background-color: #007BFF; color: white; padding: 12px 20px; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background-color: #0056b3; }
    </style>
</head>
<body>

<form action="tambah_data.php" method="POST" enctype="multipart/form-data">
    <label>Judul:</label><br>
    <input type="text" name="judul" id="judul" required><br><br>

    <label>Dari:</label><br>
    <input type="text" name="dari" id="dari" required><br><br>

    <label>Ke:</label><br>
    <input type="text" name="ke" id="ke" required><br><br>
    
    <label>Tanggal:</label><br>
    <input type="date" name="tanggal" id="tanggal" required><br><br>

    <label>Upload File:</label><br>
    <label>(Nama file akan diubah sesuai judul yang dimasukkan)</label><br>
    <input type="file" name="pdf_file" id="pdf_file" accept=".pdf" required><br><br>

    <button type="submit">Submit</button>
</form>

</body>
</html>