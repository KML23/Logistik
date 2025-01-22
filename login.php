<?php
session_start();

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {
        // Koneksi ke database
        $conn = new mysqli('localhost', 'root', '', 'logistik');
        if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
        }

        // Ambil data pengguna berdasarkan username dengan validasi `status` aktif dan `hapus` tidak dihapus
        $stmt = $conn->prepare("SELECT id, password, level_user FROM db_user WHERE username = ? AND status = 1 AND hapus = 0");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($id, $hashedPassword, $level_user);
        $stmt->fetch();

        if ($hashedPassword && password_verify($password, $hashedPassword)) {
            // Jika password benar, simpan data ke sesi
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            $_SESSION['level_user'] = $level_user;

            // Redirect ke dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Username atau password salah!";
        }

        $stmt->close();
        $conn->close();
    } else {
        $error = "Semua kolom wajib diisi!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="adminlte/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="adminlte/dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="adminlte/plugins/iCheck/square/blue.css">
    <link rel="stylesheet" href="adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="adminlte/bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="adminlte/bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <b>Logistik</b>App
        </div>
        <div class="login-box-body">
            <p class="login-box-msg">Sign in to start your session</p>
            <?php
            if (isset($error)) echo "<p style='color:red;'>$error</p>";
            ?>
            <form method="POST">
                <div class="form-group has-feedback">
                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <button type="submit" name="login" class="btn btn-primary btn-block btn-flat">Login</button>
            </form>
            <a href="register.php" class="text-center">I don't have a membership</a>
        </div>
    </div>
    <script src="adminlte/plugins/jQuery/jquery-3.6.0.min.js"></script>
    <script src="adminlte/bootstrap/js/bootstrap.min.js"></script>
    <script src="adminlte/plugins/iCheck/icheck.min.js"></script>
</body>
</html>
