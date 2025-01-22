<?php
if (isset($_POST['register'])) {
    // Get form inputs
    $username = $_POST['username'];
    $no_telp = $_POST['no_telp'];  // Phone number
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $nama_user = $_POST['nama_user'];  // Full name
    $id_pegawai = $_POST['id_pegawai'];  // Employee ID
    $level_user = $_POST['level_user'];  // User level (1 for admin, etc.)

    // Check if all fields are filled
    if (!empty($username) && !empty($no_telp) && !empty($password) && !empty($confirmPassword) && !empty($nama_user) && !empty($id_pegawai) && !empty($level_user)) {
        if ($password === $confirmPassword) {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

            // Connect to the database
            $conn = new mysqli('localhost', 'root', '', 'logistik');
            if ($conn->connect_error) {
                die("Koneksi gagal: " . $conn->connect_error);
            }

            // Check if the username or phone number already exists
            $stmt = $conn->prepare("SELECT id FROM db_user WHERE username = ? OR no_telp = ?");
            $stmt->bind_param("ss", $username, $no_telp);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $error = "Username atau Nomor Telepon sudah terdaftar!";
            } else {
                // Insert new user into db_user table
                $stmt = $conn->prepare("INSERT INTO db_user (username, no_telp, password, nama_user, id_pegawai, level_user, status, hapus, tgl_insert, tgl_update, user_update) VALUES (?, ?, ?, ?, ?, ?, 1, 0, NOW(), NOW(), NOW())");
                $stmt->bind_param("sssssi", $username, $no_telp, $hashedPassword, $nama_user, $id_pegawai, $level_user);
                if ($stmt->execute()) {
                    $success = "Registrasi berhasil! Anda dapat login sekarang.";
                } else {
                    $error = "Terjadi kesalahan saat menyimpan data.";
                }
            }
            $stmt->close();
            $conn->close();
        } else {
            $error = "Konfirmasi password tidak sesuai!";
        }
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
    <title>Registrasi</title>
    <link rel="stylesheet" href="adminlte/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="adminlte/dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="adminlte/plugins/iCheck/square/blue.css">
    <link rel="stylesheet" href="adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="adminlte/bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="adminlte/bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition register-page">
    <div class="register-box">
        <div class="register-logo">
            <a href="#"><b>Logistik</b>App</a>
        </div>
        <div class="register-box-body">
            <p class="login-box-msg">Register a new membership</p>
            <?php
            if (isset($success)) echo "<p style='color:green;'>$success</p>";
            if (isset($error)) echo "<p style='color:red;'>$error</p>";
            ?>
            <form method="POST">
                <div class="form-group has-feedback">
                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="text" name="no_telp" class="form-control" placeholder="Phone Number" required>
                    <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" name="confirm_password" class="form-control" placeholder="Retype password" required>
                    <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="text" name="nama_user" class="form-control" placeholder="Full Name" required>
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="text" name="id_pegawai" class="form-control" placeholder="Employee ID" required>
                    <span class="glyphicon glyphicon-briefcase form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <select name="level_user" class="form-control" required>
                        <option value="1">Admin</option>
                        <option value="2">User</option>
                    </select>
                    <span class="glyphicon glyphicon-cog form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-8">
                        <div class="checkbox icheck">
                            <label>
                                <input type="checkbox" required> I agree to the <a href="#">terms</a>
                            </label>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <button type="submit" name="register" class="btn btn-primary btn-block btn-flat">Register</button>
                    </div>
                </div>
            </form>
            <a href="login.php" class="text-center">I already have a membership</a>
        </div>
    </div>
    <script src="adminlte/plugins/jQuery/jquery-3.6.0.min.js"></script>
    <script src="adminlte/bootstrap/js/bootstrap.min.js"></script>
    <script src="adminlte/plugins/iCheck/icheck.min.js"></script>
    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' 
            });
        });
    </script>
</body>
</html>
