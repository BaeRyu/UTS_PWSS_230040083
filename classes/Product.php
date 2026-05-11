<?php
abstract class Product
{
    protected int    $id;
    protected string $nama_produk;
    protected string $kategori;
    protected int    $stok;
    protected float  $harga;
    protected string $spesifikasi;

    public function __construct(
        int    $id,
        string $nama_produk,
        string $kategori,
        int    $stok,
        float  $harga,
        string $spesifikasi = ''
    ) {
        $this->id           = $id;
        $this->nama_produk  = $nama_produk;
        $this->kategori     = $kategori;
        $this->stok         = $stok;
        $this->harga        = $harga;
        $this->spesifikasi  = $spesifikasi;
    }

    abstract public function getInfo(): string;

    public function sell(int $qty): void
    {
        $this->validateQty($qty);
        if ($qty > $this->stok) {
            throw new RuntimeException("Stok tidak mencukupi. Tersedia: {$this->stok}, Diminta: {$qty}");
        }
        $this->stok -= $qty;
    }

    public function addStock(int $qty): void
    {
        $this->validateQty($qty);
        $this->stok += $qty;
    }

    public function isLowStock(): bool
    {
        return $this->stok < 5;
    }

    protected function validateQty(int $qty): void
    {
        if ($qty <= 0) {
            throw new InvalidArgumentException("Jumlah tidak valid: {$qty}");
        }
    }

    public function getId(): int { return $this->id; }
    public function getNamaProduk(): string { return $this->nama_produk; }
    public function getKategori(): string { return $this->kategori; }
    public function getStok(): int { return $this->stok; }
    public function getHarga(): float { return $this->harga; }
    public function getSpesifikasi(): string { return $this->spesifikasi; }

    public function setNamaProduk(string $nama): void
    {
        if (trim($nama) === '') {
            throw new InvalidArgumentException('Nama produk tidak boleh kosong.');
        }
        $this->nama_produk = trim($nama);
    }

    public function setStok(int $stok): void
    {
        if ($stok < 0) {
            throw new InvalidArgumentException('Stok tidak boleh negatif.');
        }
        $this->stok = $stok;
    }

    public function setHarga(float $harga): void
    {
        if ($harga < 0) {
            throw new InvalidArgumentException('Harga tidak boleh negatif.');
        }
        $this->harga = $harga;
    }

    public function setSpesifikasi(string $spek): void
    {
        $this->spesifikasi = $spek;
    }

    public function getHargaFormatted(): string
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }
}
