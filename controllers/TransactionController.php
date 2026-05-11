<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/ProductController.php';

class TransactionController
{
    private PDO $db;
    private ProductController $productCtrl;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
        $this->productCtrl = new ProductController();
    }

    public function createTransaction(array $data): bool
    {
        $productId = (int)($data['product_id'] ?? 0);
        $qty       = (int)($data['jumlah'] ?? 0);
        $catatan   = trim($data['catatan'] ?? '');

        if ($qty <= 0) throw new InvalidArgumentException("Jumlah penjualan harus lebih dari 0.");

        $product = $this->productCtrl->getProductById($productId);
        if (!$product) throw new RuntimeException("Produk tidak ditemukan.");

        $stokSebelum = $product->getStok();
        $product->sell($qty);
        $stokSesudah = $product->getStok();

        try {
            $this->db->beginTransaction();

            $stmtUpdate = $this->db->prepare("UPDATE products SET stok = ? WHERE id = ?");
            $stmtUpdate->execute([$stokSesudah, $productId]);

            $stmtInsert = $this->db->prepare(
                "INSERT INTO transactions (product_id, jumlah, stok_sebelum, stok_sesudah, catatan)
                 VALUES (?, ?, ?, ?, ?)"
            );
            $stmtInsert->execute([$productId, $qty, $stokSebelum, $stokSesudah, $catatan]);

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function getAllTransactions(): array
    {
        $stmt = $this->db->query(
            "SELECT t.*, p.nama_produk, p.kategori
             FROM transactions t
             JOIN products p ON t.product_id = p.id
             ORDER BY t.created_at DESC"
        );
        return $stmt->fetchAll();
    }
}
