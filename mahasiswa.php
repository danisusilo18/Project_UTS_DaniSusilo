<!DOCTYPE html>
<html>
<head>
    <title>Mahasiswa</title>
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
    <h1>Data Mahasiswa</h1>

    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="id">ID    :</label>
        <input type="text" id="id" name="id"><br><br>

        <label for="nama">Nama  :</label>
        <input type="text" id="nama" name="nama" required><br><br>

        <label for="nim">NIM :</label>
        <input type="text" id="nim" name="nim" required><br><br>

        <label for="program_studi">Program Studi:</label>
        <input type="text" id="program_studi" name="program_studi" required><br><br>

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
        $nim = $_POST["nim"];
        $program_studi = $_POST["program_studi"];

        if (empty($id) && !empty($nama) && !empty($nim) && !empty($program_studi)) {
            $sql = "INSERT INTO mahasiswa(nama, nim, program_studi) VALUES ('$nama','$nim', '$program_studi')";

            if ($conn->query($sql) === TRUE) {
                $pesan = "Data berhasil ditambahkan";
                header("Location: sukses.php?return_php=mahasiswa.php&pesan=" . urlencode($pesan));
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
        $nim = $_POST["nim"];
        $program_studi = $_POST["program_studi"];

        if (!empty($id) && !empty($nama) && !empty($nim) && !empty($program_studi)) {
            $sql = "UPDATE mahasiswa SET nama='$nama', nim='$nim', program_studi='$program_studi' WHERE id='$id'";

            if ($conn->query($sql) === TRUE) {
                $pesan = "Data berhasil diperbaharui";
                header("Location: sukses.php?return_php=mahasiswa.php&pesan=" . urlencode($pesan));
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
            $sql = "DELETE FROM mahasiswa WHERE id = '$id'";

            if ($conn->query($sql) === TRUE) {
                $pesan = "Data berhasil dihapus";
                header("Location: sukses.php?return_php=mahasiswa.php&pesan=" . urlencode($pesan));
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }         

    }

    // Operasi READ (mengambil data)
    $sql = "SELECT '',id, nama, nim, program_studi FROM mahasiswa";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th></th><th>ID</th><th>Nama</th><th>NIM</th><th>Program Studi</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td><button onclick='getData(this)'>Upd/Del</button></td>";
            echo "<td class='kolom2'>" . $row["id"] . "</td>";
            echo "<td class='kolom3'>" . $row["nama"] . "</td>";
            echo "<td class='kolom3'>" . $row["nim"] . "</td>";
            echo "<td class='kolom4'>" . $row["program_studi"] . "</td>";
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
        var nimInput = document.getElementById('nim');
        var program_studiInput = document.getElementById('program_studi');
        
        namaInput.removeAttribute('required');
        nimInput.removeAttribute('required');
        program_studiInput.removeAttribute('required');
    }

    function getData(button) {
        var row = button.parentNode.parentNode;
        var row_id = row.cells[1].innerText;
        var row_nama = row.cells[2].innerText;
        var row_nim = row.cells[3].innerText;
        var row_program_studi = row.cells[4].innerText;

        var idInput = document.getElementById("id");
        var namaInput = document.getElementById("nama");
        var nimInput = document.getElementById("nim");
        var program_studiInput = document.getElementById("program_studi");

        idInput.value = row_id;
        namaInput.value = row_nama;
        nimInput.value = row_nim;
        program_studiInput.value = row_program_studi;
        
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

