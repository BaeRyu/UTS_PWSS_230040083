<?php require __DIR__ . '/layout/header.php'; ?>
<h2 class="mb-4">Dashboard</h2>
<div class="row">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Total Produk</h5>
                <h2 class="text-primary"><?= number_format($stats['total_produk'] ?? 0) ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Total Stok</h5>
                <h2 class="text-success"><?= number_format($stats['total_stok'] ?? 0) ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Stok Menipis</h5>
                <h2 class="text-danger"><?= number_format($stats['stok_menipis'] ?? 0) ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Total Transaksi</h5>
                <h2 class="text-warning"><?= number_format($stats['total_transaksi'] ?? 0) ?></h2>
            </div>
        </div>
    </div>
</div>

<?php if (!empty($lowStock)): ?>
    <div class="card mt-4 border-danger">
        <div class="card-header bg-danger text-white">
            <i class="fas fa-exclamation-triangle"></i> Peringgatan: Stok Menipis (< 5 unit)
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Kategori</th>
                        <th>Stok Tersisa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lowStock as $p): ?>
                        <tr>
                            <td><?= htmlspecialchars($p['nama_produk']) ?></td>
                            <td><span class="badge bg-secondary"><?= $p['kategori'] ?></span></td>
                            <td><span class="badge bg-danger"><?= $p['stok'] ?> unit</span></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

<?php require __DIR__ . '/layout/footer.php'; ?>
