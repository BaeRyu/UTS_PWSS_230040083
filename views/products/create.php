<?php require __DIR__ . '/../layout/header.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Tambah Produk Baru</h2>
    <a href="index.php?page=products" class="btn btn-secondary">Kembali</a>
</div>

<div class="card">
    <div class="card-body">
        <form action="index.php?page=products&action=create" method="POST">
            <div class="mb-3">
                <label class="form-label">Nama Produk</label>
                <input type="text" name="nama_produk" class="form-control" required>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Kategori</label>
                    <select name="kategori" class="form-select" required>
                        <option value="Laptop">Laptop</option>
                        <option value="Smartphone">Smartphone</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Stok Awal</label>
                    <input type="number" name="stok" class="form-control" min="0" value="0" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Harga (Rp)</label>
                    <input type="number" name="harga" class="form-control" min="0" step="0.01" value="0" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Spesifikasi</label>
                <textarea name="spesifikasi" class="form-control" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpen Produk</button>
        </form>
    </div>
</div>
<?php require __DIR__ . '/../layout/footer.php'; ?>
