<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../classes/Product.php';
require_once __DIR__ . '/../classes/Laptop.php';
require_once __DIR__ . '/../classes/Smartphone.php';

class ProductController
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    private function hydrateProduct(array $row): Product
    {
        if ($row['kategori'] === 'Laptop') {
            return new Laptop((int)$row['id'], $row['nama_produk'], (int)$row['stok'], (float)$row['harga'], $row['spesifikasi'] ?? '');
        }
        return new Smartphone((int)$row['id'], $row['nama_produk'], (int)$row['stok'], (float)$row['harga'], $row['spesifikasi'] ?? '');
    }

    public function getAllProducts(): array
    {
        $stmt = $this->db->query("SELECT * FROM products ORDER BY kategori, nama_produk");
        $rows = $stmt->fetchAll();
        return array_map(fn($row) => $this->hydrateProduct($row), $rows);
    }

    public function getAllProductsRaw(): array
    {
        $stmt = $this->db->query("SELECT * FROM products ORDER BY kategori, nama_produk");
        return $stmt->fetchAll();
    }

    public function getProductById(int $id): ?Product
    {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ? $this->hydrateProduct($row) : null;
    }

    public function getProductByIdRaw(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function createProduct(array $data): bool
    {
        $stok  = (int)($data['stok'] ?? 0);
        $harga = (float)($data['harga'] ?? 0);

        if ($stok < 0) throw new InvalidArgumentException('Stok tidak boleh negatif.');
        if ($harga < 0) throw new InvalidArgumentException('Harga tidak boleh negatif.');
        if (empty(trim($data['nama_produk'] ?? ''))) throw new InvalidArgumentException('Nama produk tidak boleh kosong.');
        if (!in_array($data['kategori'] ?? '', ['Laptop', 'Smartphone'])) throw new InvalidArgumentException('Kategori tidak valid.');

        $stmt = $this->db->prepare(
            "INSERT INTO products (nama_produk, kategori, stok, harga, spesifikasi)
             VALUES (:nama_produk, :kategori, :stok, :harga, :spesifikasi)"
        );
        return $stmt->execute([
            ':nama_produk' => trim($data['nama_produk']),
            ':kategori'    => $data['kategori'],
            ':stok'        => $stok,
            ':harga'       => $harga,
            ':spesifikasi' => trim($data['spesifikasi'] ?? ''),
        ]);
    }

    public function updateProduct(int $id, array $data): bool
    {
        $product = $this->getProductById($id);
        if (!$product) throw new RuntimeException("Produk ID {$id} tidak ditemukan.");

        $stok  = (int)($data['stok'] ?? 0);
        $harga = (float)($data['harga'] ?? 0);

        $product->setNamaProduk($data['nama_produk'] ?? '');
        $product->setStok($stok);
        $product->setHarga($harga);
        $product->setSpesifikasi($data['spesifikasi'] ?? '');

        $stmt = $this->db->prepare(
            "UPDATE products
             SET nama_produk = :nama_produk,
                 kategori    = :kategori,
                 stok        = :stok,
                 harga       = :harga,
                 spesifikasi = :spesifikasi
             WHERE id = :id"
        );
        return $stmt->execute([
            ':nama_produk' => $product->getNamaProduk(),
            ':kategori'    => $data['kategori'] ?? $product->getKategori(),
            ':stok'        => $product->getStok(),
            ':harga'       => $product->getHarga(),
            ':spesifikasi' => $product->getSpesifikasi(),
            ':id'          => $id,
        ]);
    }

    public function deleteProduct(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM products WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getLowStockProducts(): array
    {
        $stmt = $this->db->query("SELECT * FROM products WHERE stok < 5 ORDER BY stok ASC");
        return $stmt->fetchAll();
    }

    public function getDashboardStats(): array
    {
        $row = $this->db->query(
            "SELECT
                COUNT(*) AS total_produk,
                SUM(stok) AS total_stok,
                SUM(CASE WHEN stok < 5 THEN 1 ELSE 0 END) AS stok_menipis,
                SUM(CASE WHEN kategori = 'Laptop' THEN 1 ELSE 0 END) AS total_laptop,
                SUM(CASE WHEN kategori = 'Smartphone' THEN 1 ELSE 0 END) AS total_smartphone
             FROM products"
        )->fetch();

        $totalTx = $this->db->query("SELECT COUNT(*) AS total FROM transactions")->fetch();
        $row['total_transaksi'] = $totalTx['total'];

        return $row;
    }
}
