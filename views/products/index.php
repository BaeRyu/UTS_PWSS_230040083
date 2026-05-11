<?php require __DIR__ . '/../layout/header.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Manajemen Produk</h2>
    <a href="index.php?page=products&action=create" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Produk
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Harga</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($products)): ?>
                        <tr><td colspan="6" class="text-center py-4">Belom ada produk.</td></tr>
                    <?php else: ?>
                        <?php foreach ($products as $p): ?>
                            <tr>
                                <td><?= $p['id'] ?></td>
                                <td><?= htmlspecialchars($p['nama_produk']) ?></td>
                                <td><span class="badge bg-info text-dark"><?= $p['kategori'] ?></span></td>
                                <td>
                                    <?php if ($p['stok'] < 5): ?>
                                        <span class="badge bg-danger"><?= $p['stok'] ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-success"><?= $p['stok'] ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>Rp <?= number_format($p['harga'], 0, ',', '.') ?></td>
                                <td class="text-end">
                                    <a href="index.php?page=products&action=edit&id=<?= $p['id'] ?>" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="index.php?page=products&action=delete&id=<?= $p['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin mo hapus produk ini?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require __DIR__ . '/../layout/footer.php'; ?>
