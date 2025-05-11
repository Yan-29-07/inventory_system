<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['category_name'];
    if (!empty($name)) {
        $stmt = $pdo->prepare("INSERT INTO categories (name) VALUES (:name)");
        $stmt->execute(['name' => $name]);
        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kategori</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="navbar" style="padding: 10px;">
        <a href="index.php" style="text-decoration: none; font-weight: bold;">Dashboard</a>
    </div>

    <div class="container" style="max-width: 600px; margin: 50px auto;">
        <div class="card" style="padding: 20px;">
            <h2 style="text-align: center; margin-bottom: 20px;">Tambah Kategori</h2>
            <form action="add_category.php" method="POST">
                <div style="margin-bottom: 15px;">
                    <label for="category_name">Nama Kategori</label>
                    <input type="text" id="category_name" name="category_name" required style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
                </div>
                <div style="text-align: center;">
                    <button type="submit" class="btn-custom">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
