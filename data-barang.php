<?php
// Koneksi ke database
$host = 'localhost';
$user = 'root';
$password = ''; // Sesuaikan dengan password database Anda
$database = 'logistik';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Proses penyimpanan data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
    $nama_barang = isset($_POST['nama_barang']) ? $conn->real_escape_string($_POST['nama_barang']) : '';
    $stok = isset($_POST['stok']) ? (int) $_POST['stok'] : 0;
    $harga = isset($_POST['harga']) ? (float) $_POST['harga'] : 0;

    if ($action === 'save') {
        // Tambah data baru
        $created_at = date('Y-m-d H:i:s');
        $sql = "INSERT INTO data_barang (nama_barang, stok, harga, created_at) VALUES ('$nama_barang', $stok, $harga, '$created_at')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Data berhasil disimpan!'); window.location.href='data-barang.php';</script>";
        } else {
            echo "<script>alert('Gagal menyimpan data: " . $conn->error . "');</script>";
        }
    } elseif ($action === 'update') {
        // Update data
        if ($id > 0) {
            $sql = "UPDATE data_barang SET 
                    nama_barang = '$nama_barang',
                    stok = $stok,
                    harga = $harga
                    WHERE id = $id";

            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Data berhasil diperbarui!'); window.location.href='data-barang.php';</script>";
            } else {
                echo "<script>alert('Gagal memperbarui data: " . $conn->error . "');</script>";
            }
        } else {
            echo "<script>alert('ID tidak valid. Update dibatalkan.'); window.location.href='data-barang.php';</script>";
        }
    }
}

// Tangkap Data untuk Form Edit
$edit_data = null;
if (isset($_GET['edit_id'])) {
    $edit_id = (int) $_GET['edit_id'];
    $sql = "SELECT * FROM data_barang WHERE id = $edit_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $edit_data = $result->fetch_assoc();
    } else {
        echo "<script>alert('Data tidak ditemukan!'); window.location.href='data-barang.php';</script>";
    }
}

// Hapus Data
if (isset($_GET['delete_id'])) {
    $delete_id = (int) $_GET['delete_id'];

    $sql = "DELETE FROM data_barang WHERE id = $delete_id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Data berhasil dihapus!'); window.location.href='data-barang.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data: " . $conn->error . "');</script>";
    }
}

// Ambil semua data dari tabel data_barang
$sql_get_data = "SELECT * FROM data_barang ORDER BY created_at ASC";
$result = $conn->query($sql_get_data);

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <?php include 'c:/laragon/www/logistik/template/styles.php'; ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <header class="main-header">
        <?php include 'c:/laragon/www/logistik/template/header.php'; ?>
        </header>
        <!-- Include Sidebar -->
        <?php include 'c:/laragon/www/logistik/template/sidebar.php'; ?>

        <div class="content-wrapper">
            <section class="content-header">
                <h1>Form Input Data Barang</h1>
            </section>
            <section class="content">
                
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tambah Data Barang</h3>
                    </div>
                    <form action="" method="POST">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="nama_barang">Nama Barang</label>
                                <input type="text" name="nama_barang" id="nama_barang" class="form-control" placeholder="Masukkan nama barang" required>
                            </div>
                            <div class="form-group">
                                <label for="stok">Stok</label>
                                <input type="number" name="stok" id="stok" class="form-control" placeholder="Masukkan jumlah stok" required>
                            </div>
                            <div class="form-group">
                                <label for="harga">Harga</label>
                                <input type="number" name="harga" id="harga" class="form-control" placeholder="Masukkan harga barang" required>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
                        <section class="content">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Daftar Barang</h3>
                </div>
                <div class="box-body">
                <!-- Form Edit -->
                   <?php if ($edit_data): ?>
                        <h3>Edit Data Barang</h3>
                        <form action="data-barang.php" method="POST" class="mb-4">
                            <input type="hidden" name="id" value="<?php echo $edit_data['id']; ?>"> <!-- ID Barang untuk Update -->
                            <div class="mb-3">
                                <label>Nama Barang</label>
                                <input type="text" name="nama_barang" class="form-control" value="<?php echo $edit_data['nama_barang']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label>Stok</label>
                                <input type="number" name="stok" class="form-control" value="<?php echo $edit_data['stok']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label>Harga</label>
                                <input type="number" name="harga" class="form-control" value="<?php echo $edit_data['harga']; ?>" required>
                            </div>
                            <button type="submit" name="update" class="btn btn-success">Update</button>
                            <a href="data-barang.php" class="btn btn-secondary">Batal</a>
                        </form>
                    <?php endif; ?>

                    <!-- Tabel Data Barang -->
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Barang</th>
                            <th>Stok</th>
                            <th>Harga</th>
                            <th>Tanggal Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['nama_barang']; ?></td>
                                    <td><?php echo $row['stok']; ?></td>
                                    <td><?php echo $row['harga']; ?></td>
                                    <td><?php echo $row['created_at']; ?></td>
                                    <td>
                                        <a href="data-barang.php?edit_id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="data-barang.php?delete_id=<?php echo $row['id']; ?>" 
                                        class="btn btn-danger btn-sm" 
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6">Tidak ada data</td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            </section>
        </div>
        <footer class="main-footer">
            <?php include 'c:/laragon/www/logistik/template/footer.php'; ?>
        </footer>
          <?php include 'c:/laragon/www/logistik/template/control-layout.php'; ?>
    </div>
    <?php include 'c:/laragon/www/logistik/template/script.php'; ?>
</body>
</html>
