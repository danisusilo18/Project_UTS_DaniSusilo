<!DOCTYPE html>
<html>
<head>
    <title>Dosen</title>
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
    <h1>Data Dosen</h1>

    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="id">ID    :</label>
        <input type="text" id="id" name="id"><br><br>

        <label for="nama">Nama  :</label>
        <input type="text" id="nama" name="nama" required><br><br>

        <label for="nidn">NIDN :</label>
        <input type="text" id="nidn" name="nidn" required><br><br>

        <label for="jenjang_pendidikan">Jenjang Pendidikan:</label>
        <select id="jenjang_pendidikan" name="jenjang_pendidikan">
            <option value="S2">S2</option>
            <option value="S3">S3</option>
        </select> <br><br> 

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
        $nidn = $_POST["nidn"];
        $jenjang_pendidikan = $_POST["jenjang_pendidikan"];

        if (empty($id) && !empty($nama) && !empty($nidn) && !empty($jenjang_pendidikan)) {
            $sql = "INSERT INTO dosen(nama, nidn, jenjang_pendidikan) VALUES ('$nama','$nidn', '$jenjang_pendidikan')";

            if ($conn->query($sql) === TRUE) {
                $pesan = "Data berhasil ditambahkan";
                header("Location: sukses.php?return_php=dosen.php&pesan=" . urlencode($pesan));
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
        $nidn = $_POST["nidn"];
        $jenjang_pendidikan = $_POST["jenjang_pendidikan"];

        if (!empty($nama) && !empty($nidn) && !empty($jenjang_pendidikan)) {
            $sql = "UPDATE dosen SET nama='$nama', nidn='$nidn', jenjang_pendidikan='$jenjang_pendidikan' WHERE id='$id'";

            if ($conn->query($sql) === TRUE) {
                $pesan = "Data berhasil diperbaharui";
                header("Location: sukses.php?return_php=dosen.php&pesan=" . urlencode($pesan));
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
            $sql = "DELETE FROM dosen WHERE id = '$id'";

            if ($conn->query($sql) === TRUE) {
                $pesan = "Data berhasil dihapus";
                header("Location: sukses.php?return_php=dosen.php&pesan=" . urlencode($pesan));
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }         

    }

    // Operasi READ (mengambil data)
    $sql = "SELECT '',id, nama, nidn, jenjang_pendidikan FROM dosen";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th></th><th>ID</th><th>Nama</th><th>NIDN</th><th>Jenjang Pendidikan</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td><button onclick='getData(this)'>Upd/Del</button></td>";
            echo "<td class='kolom2'>" . $row["id"] . "</td>";
            echo "<td class='kolom3'>" . $row["nama"] . "</td>";
            echo "<td class='kolom3'>" . $row["nidn"] . "</td>";
            echo "<td class='kolom4'>" . $row["jenjang_pendidikan"] . "</td>";
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
        var nidnInput = document.getElementById('nidn');
        var jenjang_pendidikanInput = document.getElementById('jenjang_pendidikan');
        
        namaInput.removeAttribute('required');
        nidnInput.removeAttribute('required');
        jenjang_pendidikanInput.removeAttribute('required');
    }

    function getData(button) {
        var row = button.parentNode.parentNode;
        var row_id = row.cells[1].innerText;
        var row_nama = row.cells[2].innerText;
        var row_nidn = row.cells[3].innerText;
        var row_jenjang_pendidikan = row.cells[4].innerText;

        var idInput = document.getElementById("id");
        var namaInput = document.getElementById("nama");
        var nidnInput = document.getElementById("nidn");
        var jenjang_pendidikanInput = document.getElementById("jenjang_pendidikan");

        idInput.value = row_id;
        namaInput.value = row_nama;
        nidnInput.value = row_nidn;
        jenjang_pendidikanInput.value = row_jenjang_pendidikan;
        
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

