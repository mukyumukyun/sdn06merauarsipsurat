<?php

    session_start();

    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }
    
    $connection = new SQLite3('list.db');
    $results = $connection->query('SELECT * FROM mail');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <title>Mail Archive</title>
        
        <link href="Lato/Lato-Regular.ttf" rel="stylesheet">

        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="grid-container">
            <header class="header">
                <div class="header-left">
                    <a href="index.php">Dashboard</a>
                </div>
                <div style="margin-right: 150px">
                    <form action="search_text.php" method="GET">
                        <input type="text" name="keyword" placeholder="Masukkan teks pencarian">
                        <button type="submit">Cari</button>
                    </form>
                </div>

                <div class="header-right">
                    <a href="login.php">Login</a>
                    <a href="logout.php">Logout</a>
                </div>
            </header>
            
            <main class="main-container" style="margin-top:100px;">
                <button popovertarget="tambahdata" style="margin-left:250px;">Tambah Data</button>
                <dialog id="tambahdata" popover>
                    <form action="tambah_data.php" method="POST" enctype="multipart/form-data">
                        <label>Judul:</label><br>
                        <input type="text" name="judul" id="judul" required><br><br>

                        <label>Dari:</label><br>
                        <input type="text" name="dari" id="dari" required><br><br>

                        <label>Ke:</label><br>
                        <input type="text" name="ke" id="ke" required><br><br>
                        
                        <label>Tanggal:</label><br>
                        <input type="date" name="tanggal" id="tanggal" required><br><br>

                        <label>Jenis Surat</label><br>
                        <select name="jenis" id="jenis">
                            <option value="Lainnya">Lainnya</option>
                            <option value="Edaran">Edaran</option>
                            <option value="Penugasan">Penugasan</option>
                            <option value="Permohonan Izin">Permohonan Izin</option>
                            <option value="Pemberitahuan">Pemberitahuan</option>
                            <option value="Pengantar">Pengantar</option>
                            <option value="Undangan">Undangan</option>
                            <option value="Pengumuman">Pengumuman</option>
                            <option value="Keputusan">Keputusan</option>
                            <option value="Lamaran Kerja">Lamaran Kerja</option>
                            <option value="Pengantar Keuangan">Pengantar Keuangan</option>
                        </select><br><br>

                        <label>Upload File:</label><br>
                        <label>(Nama file akan diubah sesuai judul yang dimasukkan)</label><br>
                        <input type="file" name="pdf_file" id="pdf_file" accept=".pdf" required><br><br>

                        <button type="submit">Submit</button>
                    </form>
                </dialog>
                <button popovertarget="hapusdata">Hapus Data</button>
                <dialog id="hapusdata" popover>
                    <table border="1">
                        <tr><th>Judul</th><th>Dari</th><th>Ke</th><th>Action</th></tr>
                        
                        <!-- Sample data (you’d fetch from DB here) -->
                        <?php
                        $connection = new SQLite3('list.db');
                        $result = $connection->query("SELECT * FROM mail");
                        
                        while ($row = $result->fetchArray()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['judul']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['dari']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['ke']) . "</td>";
                            echo "<td>
                                    <form method='POST' action='delete.php'>
                                        <input type='hidden' name='id' value='" . intval($row['id']) . "' />
                                        <input type='hidden' name='namafile' value='" . htmlspecialchars($row['judul'] . ".pdf") . "' />
                                        <button type='submit' style='padding:5px 10px; background:#e74c3c; color:white; border:none;'>Delete</button>
                                    </form>
                                </td>";
                            echo "</tr>";
                        }
                        
                        $connection->close();
                        ?>
                    </table>
                </dialog>
                
                <table style="width: 75%; margin-top:10px; margin-left:250px; margin-right:250px">
                    <tr>
                        <th style="width: 1%;" rowspan="2">No</th>
                        <th rowspan="2" style="width: 15%;">Judul</th>
                        <th colspan="2" style="width: 20%;">Keterangan</th>
                        <th rowspan="2" style="width: 3%;">Tanggal</th>
                        <th rowspan="2" style="width: 1%;">Jenis</th>
                        <th rowspan="2" style="width: 1%;">Document</th>
                    </tr>
                    <tr>
                        <th style="width: 5px;">Dari</th>
                        <th style="width: 5px;">Ke</th>
                    </tr>
                    <?php
                    $i = 1;
                    while($row=$results->fetchArray(SQLITE3_ASSOC)){
                    ?>
                        <tr>
                            <td style="text-align: center;"><?php echo "$i";?></td>
                            <td style="padding: 10px;"><a href="document/txt/<?php echo "$row[judul]";?>.txt" style="color: #1d4bad;"><?php echo "$row[judul]";?></td>
                            <td style="padding: 10px;"><?php echo "$row[dari]";?></td>
                            <td style="padding: 10px;"><?php echo "$row[ke]";?></td>
                            <td style="text-align: center;"><?php echo "$row[tanggal]";?></td>
                            <td style="text-align: center;"><?php echo "$row[jenis]";?></td>
                            <td style="text-align: center;"><a href="document/pdf/<?php echo "$row[judul].pdf";?>" style="color: #1d4bad;">pdf</a></td>
                        </tr>
                    <?php
                    $i=$i+1;
                    }
                    ?>
                </table>

            </main>
            <!-- End Main -->
        </div>
            <main class="main-container"></main>
    </body>
</html>