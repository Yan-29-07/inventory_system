<?php
include 'config.php';

// Fetch categories and locations
$categories = $pdo->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);
$locations = $pdo->query("SELECT * FROM locations")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $category_id = $_POST['category_id'];
    $location_id = $_POST['location_id'];

    if (!empty($name) && !empty($category_id) && !empty($location_id)) {
        $stmt = $pdo->prepare("INSERT INTO items (name, category_id, location_id) VALUES (:name, :category_id, :location_id)");
        $stmt->execute([
            'name' => $name,
            'category_id' => $category_id,
            'location_id' => $location_id,
        ]);
        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="navbar" style="padding: 10px;">
        <a href="index.php" style="text-decoration: none; font-weight: bold;">Dashboard</a>
    </div>

    <div class="container" style="max-width: 700px; margin: 50px auto;">
        <div class="card" style="padding: 25px;">
            <h2 style="text-align: center; margin-bottom: 20px;">Tambah Barang</h2>
            <form method="POST">
                <div style="margin-bottom: 15px;">
                    <label for="name">Nama Barang:</label>
                    <input type="text" id="name" name="name" required
                           style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label for="category_id">Kategori:</label>
                    <select id="category_id" name="category_id" required
                            style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
                        <option value="">Pilih Kategori</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div style="margin-bottom: 20px;">
                    <label for="location_id">Lokasi:</label>
                    <select id="location_id" name="location_id" required
                            style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
                        <option value="">Pilih Lokasi</option>
                        <?php foreach ($locations as $location): ?>
                            <option value="<?= $location['id'] ?>"><?= htmlspecialchars($location['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
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
