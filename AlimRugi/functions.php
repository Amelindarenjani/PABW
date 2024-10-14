<?php
include 'include/js.php';

session_start();

date_default_timezone_set("Asia/Jakarta");

$host        = "localhost";
$username    = "root";
$password    = "";
$database    = "alimrugi";

$conn         = mysqli_connect($host, $username, $password, $database);
if ($conn) {
    // echo "berhasil terkoneksi!";
} else {
    echo "gagal terkoneksi!";
}

// ======================================== FUNCTION ========================================

function setAlert($title = '', $text = '', $type = '', $buttons = '')
{
    $_SESSION["alert"]["title"]        = $title;
    $_SESSION["alert"]["text"]         = $text;
    $_SESSION["alert"]["type"]         = $type;
    $_SESSION["alert"]["buttons"]    = $buttons;
}

if (isset($_SESSION['alert'])) {
    $title         = $_SESSION["alert"]["title"];
    $text         = $_SESSION["alert"]["text"];
    $type         = $_SESSION["alert"]["type"];
    $buttons    = $_SESSION["alert"]["buttons"];

    echo "
		<div id='msg' data-title='" . $title . "' data-type='" . $type . "' data-text='" . $text . "' data-buttons='" . $buttons . "'></div>
		<script>
			let title 		= $('#msg').data('title');
			let type 		= $('#msg').data('type');
			let text 		= $('#msg').data('text');
			let buttons		= $('#msg').data('buttons');

			if(text != '' && type != '' && title != '') {
				Swal.fire({
					title: title,
					text: text,
					icon: type,
				});
			}
		</script>
	";
    unset($_SESSION["alert"]);
}

// function checkLogin()
// {
//     if (!isset($_SESSION['id_user'])) {
//         setAlert("Access Denied!", "Login First!", "error");
//         header('Location: login.php');
//     }
// }

// function checkLoginAtLogin()
// {
//     if (isset($_SESSION['id_user'])) {
//         setAlert("You has been logged!", "Welcome!", "success");
//         header('Location: index.php');
//     }
// }

// =============================================================================================================

// koneksi ke database mysqli_connect("host", "username", "pw", "nama database");
$conn = mysqli_connect("localhost", "root", "", "AlimRugi");

function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_Assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}


function registration($data)
{
    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]); //mysqli_real_escape_string memastikan jika user memasukan "" maka akan aman
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);

    // cek username sudah ada atau belum
    $result = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");

    if (mysqli_fetch_assoc($result)) {
        echo "<script>
        alert ('Username sudah terdaftar!');
        </script>";

        return false;
    }

    // cek konfirmasi password
    if ($password !== $password2) {
        echo "<script>
        alert ('Password tidak sesuai!');
        </script>";

        return false;
    }

    //  enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    //  jika password sesuai, masukan data ke tabel
    mysqli_query($conn, "INSERT INTO users VALUES ('','$username', '$password')");

    return mysqli_affected_rows($conn);
}
