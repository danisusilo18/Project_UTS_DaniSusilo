<!DOCTYPE html>
<html>
<head>
    <title>Matakuliah</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
        }
    </style>
</head>
<body>
    <a href="menu.html">Kembali ke Menu</a>    
    <h1>Data Matakuliah</h1>

    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="id">ID    :</label>
        <input type="text" id="id" name="id"><br><br>

        <label for="nama">Nama  :</label>
        <input type="text" id="nama" name="nama" required><br><br>

        <label for="kode_matakuliah">Kode Matakuliah :</label>
        <input type="text" id="kode_matakuliah" name="kode_matakuliah" required><br><br>

        <label for="deskripsi">Descripsi:</label>
        <input type="text" id="deskripsi" name="deskripsi" required><br><br>

        <input type="submit" name="insert" value="Insert">
        <input type="submit" name="update" value="Update">
        <input type="submit" name="delete" value="Delete" onclick="removeRequired()">
    </form>
    
    <h2>Data</h2>
    <?php
    // Konfigurasi basis data
    $host = "localhost";
    $username = "root";
    $password = "password";
    $database = "siakad";

    // Membuat koneksi ke basis data
    $conn = new mysqli($host, $username, $password, $database);

    // Memeriksa koneksi
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // jika insert data
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["insert"])) {
        $id = $_POST["id"];
        $nama = $_POST["nama"];
        $kode_matakuliah = $_POST["kode_matakuliah"];
        $deskripsi = $_POST["deskripsi"];

        if (empty($id) && !empty($nama) && !empty($kode_matakuliah) && !empty($deskripsi)) {
            $sql = "INSERT INTO matakuliah(nama, kode_matakuliah, deskripsi) VALUES ('$nama','$kode_matakuliah', '$deskripsi')";

            if ($conn->query($sql) === TRUE) {
                $pesan = "Data berhasil ditambahkan";
                header("Location: sukses.php?return_php=matakuliah.php&pesan=" . urlencode($pesan));
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }  else{
            echo "<script>alert('ID harus kosong');</script>";
        }

    }

    // Operasi UPDATE (mengubah data)
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
        $id = $_POST["id"];
        $nama = $_POST["nama"];
        $kode_matakuliah = $_POST["kode_matakuliah"];
        $deskripsi = $_POST["deskripsi"];

        if (!empty($nama) && !empty($kode_matakuliah) && !empty($deskripsi)) {
            $sql = "UPDATE matakuliah SET nama='$nama', kode_matakuliah='$kode_matakuliah', deskripsi='$deskripsi' WHERE id='$id'";

            if ($conn->query($sql) === TRUE) {
                $pesan = "Data berhasil diperbaharui";
                header("Location: sukses.php?return_php=matakuliah.php&pesan=" . urlencode($pesan));
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } 
    }

    // Operasi DELETE (menghapus data)
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"])) {
        $id = $_POST["id"];

        if (!empty($id)) {
            $sql = "DELETE FROM matakuliah WHERE id = '$id'";

            if ($conn->query($sql) === TRUE) {
                $pesan = "Data berhasil dihapus";
                header("Location: sukses.php?return_php=matakuliah.php&pesan=" . urlencode($pesan));
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }         

    }

    // Operasi READ (mengambil data)
    $sql = "SELECT '',id, nama, kode_matakuliah, deskripsi FROM matakuliah";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th></th><th>ID</th><th>Nama</th><th>kode_matakuliah</th><th>Jenjang Pendidikan</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td><button onclick='getData(this)'>Upd/Del</button></td>";
            echo "<td class='kolom2'>" . $row["id"] . "</td>";
            echo "<td class='kolom3'>" . $row["nama"] . "</td>";
            echo "<td class='kolom3'>" . $row["kode_matakuliah"] . "</td>";
            echo "<td class='kolom4'>" . $row["deskripsi"] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "Tidak ada data.";
    }

    // Menutup koneksi ke basis data
    $conn->close();
    ?>
</body>
</html>

<script>
    function removeRequired() {
        var namaInput = document.getElementById('nama');
        var kode_matakuliahInput = document.getElementById('kode_matakuliah');
        var deskripsiInput = document.getElementById('deskripsi');
        
        namaInput.removeAttribute('required');
        kode_matakuliahInput.removeAttribute('required');
        deskripsiInput.removeAttribute('required');
    }

    function getData(button) {
        var row = button.parentNode.parentNode;
        var row_id = row.cells[1].innerText;
        var row_nama = row.cells[2].innerText;
        var row_kode_matakuliah = row.cells[3].innerText;
        var row_deskripsi = row.cells[4].innerText;

        var idInput = document.getElementById("id");
        var namaInput = document.getElementById("nama");
        var kode_matakuliahInput = document.getElementById("kode_matakuliah");
        var deskripsiInput = document.getElementById("deskripsi");

        idInput.value = row_id;
        namaInput.value = row_nama;
        kode_matakuliahInput.value = row_kode_matakuliah;
        deskripsiInput.value = row_deskripsi;
        
    }    
</script>

<style>
table {
        border-collapse: collapse;
        width: 60%;
        table-layout: auto;
    }

    th, td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
        white-space: nowrap; 
        overflow: hidden; 
        text-overflow: ellipsis;
    }

    th {
        background-color: #f2f2f2;
    }

    input[type="submit"] {
        padding: 8px 12px;
        background-color: #4CAF50;
        color: #fff;
        border: none;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #45a049;
    }

    .message {
        background-color: #dff0d8;
        color: #3c763d;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #d6e9c6;
        border-radius: 4px;
    }
    
    .kolom1 {
        width: 5%; 
    }
    
    .kolom2 {
        width: 10%; 
    }    

    .kolom3 {
        width: 30%; 
    }    

    .kolom4 {
        width: 55%;
    }

    label {
        display: inline-block;
        width: 100px; 
        text-align: right;
        margin-right: 10px;
    }

    input[type="text"]
    {
        width: 200px; 
    }
    
</style>

