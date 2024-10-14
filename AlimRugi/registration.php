<?php 

require 'functions.php';

if(isset($_POST["register"])) {
    if(registration($_POST) > 0){
        echo "<script>
        alert('Registrasi Berhasil!');
        </script>";
    } else {
        echo mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlimRugi - Registrasi</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
    <!-- <h1>AlimRugi - Registrasi</h1> -->

    <form method="post" action="">
        <ul>
            <li>
                <label for="username">Username :</label>
                <input type="text" name="username" id="username">
            </li>
            <li>
                <label for="password">Password :</label>
                <input type="password" name="password" id="password">
            </li>
            <li>
                <label for="password2">Konfirmasi Password :</label>
                <input type="password" name="password2" id="password2">
            </li>
            <li>
                <button type="submit" name="register">Register</button>
            </li>
        </ul>
    </form>

    <a href="login.php">Sudah punya akun? Login</a>
</body>
</html>