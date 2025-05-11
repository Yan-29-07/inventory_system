<?php
include 'config.php';

// Fetch data
$categories = $pdo->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);
$locations = $pdo->query("SELECT * FROM locations")->fetchAll(PDO::FETCH_ASSOC);
$items = $pdo->query("SELECT i.id, i.name, i.category_id, i.location_id, c.name AS category, l.name AS location FROM items i
    JOIN categories c ON i.category_id = c.id
    JOIN locations l ON i.location_id = l.id")->fetchAll(PDO::FETCH_ASSOC);
$loans = $pdo->query("SELECT l.id, i.name AS item, l.borrower_name, l.loan_date, l.return_date FROM loans l
    JOIN items i ON l.item_id = i.id")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sistem Inventaris Barang Kantor</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <style>
        .grid {
            grid-template-columns: 1.3fr 1fr;
        }

        .btn-edit {
            background-color: #ffc107;
            color: black;
            padding: 6px 10px;
            text-decoration: none;
            border-radius: 4px;
            margin-right: 5px;
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
            padding: 6px 10px;
            text-decoration: none;
            border-radius: 4px;
        }

        .btn-edit:hover, .btn-delete:hover {
            opacity: 0.8;
        }

        .list-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .list-item span {
            flex: 1;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="#" class="navbar-brand">Inventaris Barang</a>
    </div>

    <div class="container">
        <div class="grid">
            <!-- Barang -->
            <div class="card" id="barang">
                <h3>Barang</h3>
                <a href="add_item.php" class="btn-custom">Tambah Barang</a>
                <table>
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Lokasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item): ?>
                            <tr>
                                <td><?= htmlspecialchars($item['name']) ?></td>
                                <td><?= htmlspecialchars($item['category']) ?></td>
                                <td><?= htmlspecialchars($item['location']) ?></td>
                                <td>
                                    <a href="edit_item.php?id=<?= $item['id'] ?>" class="btn-edit">Edit</a>
                                    <a href="delete_item.php?id=<?= $item['id'] ?>" class="btn-delete" onclick="return confirm('Yakin ingin menghapus barang ini?');">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Peminjaman -->
            <div class="card" id="peminjaman">
                <h3>Peminjaman</h3>
                <a href="add_loan.php" class="btn-custom">Tambah Peminjaman</a>
                <table>
                    <thead>
                        <tr>
                            <th>Barang</th>
                            <th>Peminjam</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($loans as $loan): ?>
                            <tr>
                                <td><?= htmlspecialchars($loan['item']) ?></td>
                                <td><?= htmlspecialchars($loan['borrower_name']) ?></td>
                                <td><?= htmlspecialchars($loan['loan_date']) ?></td>
                                <td><?= htmlspecialchars($loan['return_date'] ?? '-') ?></td>
                                <td>
                                    <a href="edit_loan.php?id=<?= $loan['id'] ?>" class="btn-edit">Edit</a>
                                    <a href="delete_loan.php?id=<?= $loan['id'] ?>" class="btn-delete" onclick="return confirm('Yakin ingin menghapus data peminjaman ini?');">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Kategori -->
            <div class="card" id="kategori">
                <h3>Kategori</h3>
                <a href="add_category.php" class="btn-custom">Tambah Kategori</a>
                <ul>
                    <?php foreach ($categories as $category): ?>
                        <li class="list-item">
                            <span><?= htmlspecialchars($category['name']) ?></span>
                            <a href="delete_category.php?id=<?= $category['id'] ?>" class="btn-delete" onclick="return confirm('Hapus kategori ini?')">Hapus</a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Lokasi -->
            <div class="card" id="lokasi">
                <h3>Lokasi</h3>
                <a href="add_location.php" class="btn-custom">Tambah Lokasi</a>
                <ul>
                    <?php foreach ($locations as $location): ?>
                        <li class="list-item">
                            <span><?= htmlspecialchars($location['name']) ?></span>
                            <a href="delete_location.php?id=<?= $location['id'] ?>" class="btn-delete" onclick="return confirm('Hapus lokasi ini?')">Hapus</a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
