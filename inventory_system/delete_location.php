<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    // Cek apakah lokasi sedang digunakan oleh barang
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM items WHERE location_id = ?");
    $stmt->execute([$id]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        // Jika digunakan, tampilkan pesan dan kembali
        echo "<script>alert('Lokasi tidak bisa dihapus karena masih digunakan oleh barang.'); window.location.href='index.php';</script>";
        exit;
    }

    // Hapus lokasi
    $stmt = $pdo->prepare("DELETE FROM locations WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: index.php");
    exit;
} else {
    header("Location: index.php");
    exit;
}
