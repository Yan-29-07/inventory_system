<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    if (!empty($name)) {
        $stmt = $pdo->prepare("INSERT INTO locations (name) VALUES (:name)");
        $stmt->execute(['name' => $name]);
        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Lokasi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="navbar" style="padding: 10px;">
        <a href="index.php" style="text-decoration: none; font-weight: bold;">Dashboard</a>
    </div>

    <div class="container" style="max-width: 600px; margin: 50px auto;">
        <div class="card" style="padding: 25px;">
            <h2 style="text-align: center; margin-bottom: 20px;">Tambah Lokasi</h2>
            <form method="POST">
                <div style="margin-bottom: 15px;">
                    <label for="name">Nama Lokasi:</label>
                    <input type="text" id="name" name="name" required
                           style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
                </div>
                <div style="text-align: center;">
                    <button type="submit" class="btn-custom">Tambah</button>
                </div>
            </form>
            <div style="margin-top: 20px; text-align: center;">
                <a href="index.php" class="btn-custom" style="text-decoration: none; display: inline-block; padding: 10px 20px;">Kembali</a>
            </div>
        </div>
    </div>
</body>
</html>
