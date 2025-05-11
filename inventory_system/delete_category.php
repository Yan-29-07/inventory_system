<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    // Periksa apakah ada item yang masih memakai kategori ini
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM items WHERE category_id = ?");
    $stmt->execute([$id]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        // Tidak boleh dihapus jika masih digunakan oleh barang
        echo "<script>
                alert('Kategori tidak dapat dihapus karena masih digunakan oleh barang.');
                window.location.href = 'index.php';
              </script>";
        exit;
    }

    // Hapus kategori
    $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->execute([$id]);
}

header('Location: index.php');
exit;
?>
