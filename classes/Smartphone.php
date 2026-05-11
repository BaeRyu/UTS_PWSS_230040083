<?php
require_once __DIR__ . '/Product.php';

class Smartphone extends Product
{
    public function __construct(
        int    $id,
        string $nama_produk,
        int    $stok,
        float  $harga,
        string $spesifikasi = ''
    ) {
        parent::__construct($id, $nama_produk, 'Smartphone', $stok, $harga, $spesifikasi);
    }

    public function getInfo(): string
    {
        $status = $this->isLowStock() ? '⚠️ STOK MENIPIS' : '✅ Stok Aman';
        return sprintf(
            '[SMARTPHONE] %s | Stok: %d | Harga: %s | Status: %s',
            $this->nama_produk,
            $this->stok,
            $this->getHargaFormatted(),
            $status
        );
    }
}
