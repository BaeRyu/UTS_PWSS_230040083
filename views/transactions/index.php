<?php require __DIR__ . '/../layout/header.php'; ?>
<div class="row mb-4">
    <div class="col-md-8">
        <h2>Riwayat Transaksi</h2>
    </div>
    <div class="col-md-4 text-end">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#transactionModal">
            <i class="fas fa-cart-arrow-down"></i> Transaksi Baru
        </button>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>Produk</th>
                        <th>Kategori</th>
                        <th>Terjual</th>
                        <th>Stok Sblm</th>
                        <th>Stok Ssdh</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($transactions)): ?>
                        <tr><td colspan="7" class="text-center py-4">Belom ada transaksi.</td></tr>
                    <?php else: ?>
                        <?php foreach ($transactions as $t): ?>
                            <tr>
                                <td><?= date('d/m/Y H:i', strtotime($t['created_at'])) ?></td>
                                <td><?= htmlspecialchars($t['nama_produk']) ?></td>
                                <td><span class="badge bg-info text-dark"><?= $t['kategori'] ?></span></td>
                                <td><strong class="text-danger">-<?= $t['jumlah'] ?></strong></td>
                                <td><?= $t['stok_sebelum'] ?></td>
                                <td><?= $t['stok_sesudah'] ?></td>
                                <td><?= htmlspecialchars($t['catatan'] ?? '') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="transactionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Trasaksi Penjualan Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="index.php?page=transactions&action=create" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Pilih Produk</label>
                        <select name="product_id" class="form-select" required>
                            <option value="">-- Pilih --</option>
                            <?php foreach ($products as $p): ?>
                                <option value="<?= $p['id'] ?>" data-stok="<?= $p['stok'] ?>">
                                    [<?= $p['kategori'] ?>] <?= htmlspecialchars($p['nama_produk']) ?> (Stok: <?= $p['stok'] ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumblah Penjualan</label>
                        <input type="number" name="jumlah" class="form-control" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan (Opsional)</label>
                        <input type="text" name="catatan" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan Transaksi</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require __DIR__ . '/../layout/footer.php'; ?>
