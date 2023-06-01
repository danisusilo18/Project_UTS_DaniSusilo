<?php
    $returnPHP = isset($_GET['return_php']) ? $_GET['return_php'] : '';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Operasi Berhasil</title>    
    <script>
        window.onload = function() {
            var returnPHP = "<?php echo $returnPHP; ?>";
            var urlParams = new URLSearchParams(window.location.search);
            var pesan = urlParams.get('pesan');

            var pesanElem = document.getElementById('pesan');
            pesanElem.textContent = pesan;

            setTimeout(function() {
                window.location.href = returnPHP;
        }, 200); 
    };
    </script>
</head>
<body>
    <h1>Operasi Berhasil</h1>
    <p id="pesan"></p>
</body>
</html>
