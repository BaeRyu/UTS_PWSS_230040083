CREATE DATABASE IF NOT EXISTS `inventaris_retail`
  DEFAULT CHARACTER SET utf8mb4
  DEFAULT COLLATE utf8mb4_unicode_ci;

USE `inventaris_retail`;

CREATE TABLE IF NOT EXISTS `products` (
  `id`           INT UNSIGNED    NOT NULL AUTO_INCREMENT,
  `nama_produk`  VARCHAR(150)    NOT NULL,
  `kategori`     ENUM('Laptop','Smartphone') NOT NULL,
  `stok`         INT UNSIGNED    NOT NULL DEFAULT 0,
  `harga`        DECIMAL(15,2)   NOT NULL DEFAULT 0.00,
  `spesifikasi`  TEXT            NULL,
  `created_at`   TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`   TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `transactions` (
  `id`            INT UNSIGNED  NOT NULL AUTO_INCREMENT,
  `product_id`    INT UNSIGNED  NOT NULL,
  `jumlah`        INT UNSIGNED  NOT NULL,
  `stok_sebelum`  INT UNSIGNED  NOT NULL,
  `stok_sesudah`  INT UNSIGNED  NOT NULL,
  `catatan`       VARCHAR(255)  NULL,
  `created_at`    TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_transactions_product`
    FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `products` (`nama_produk`, `kategori`, `stok`, `harga`, `spesifikasi`) VALUES
('ASUS VivoBook 15',      'Laptop',      12, 8500000.00,  'Intel Core i5-1235U, RAM 8GB, SSD 512GB, 15.6" FHD'),
('Lenovo ThinkPad E15',   'Laptop',       3, 12000000.00, 'Intel Core i7-1255U, RAM 16GB, SSD 512GB, 15.6" FHD IPS'),
('MacBook Air M2 2023',   'Laptop',       6, 18500000.00, 'Apple M2, RAM 8GB, SSD 256GB, 13.6" Liquid Retina'),
('HP Pavilion 14',        'Laptop',       2, 9200000.00,  'AMD Ryzen 5 5500U, RAM 8GB, SSD 512GB, 14" FHD'),
('Acer Aspire 5 A515',    'Laptop',       9, 7800000.00,  'Intel Core i5-1135G7, RAM 8GB, SSD 512GB, 15.6" FHD'),
('Samsung Galaxy S24 Ultra','Smartphone',15, 17500000.00, 'Snapdragon 8 Gen 3, RAM 12GB, 256GB, Kamera 200MP'),
('iPhone 15 Pro Max',      'Smartphone',  4, 22000000.00, 'Apple A17 Pro, RAM 8GB, 256GB, Kamera 48MP ProRAW'),
('Xiaomi 14 Ultra',        'Smartphone',  7, 13800000.00, 'Snapdragon 8 Gen 3, RAM 16GB, 512GB, Leica Kamera'),
('OPPO Find X7',           'Smartphone', 11, 10500000.00, 'Dimensity 9300, RAM 12GB, 256GB, Kamera 50MP'),
('Vivo V29 Pro',           'Smartphone',  1,  6800000.00, 'Dimensity 8200, RAM 12GB, 256GB, Kamera 50MP OIS');

INSERT INTO `transactions` (`product_id`, `jumlah`, `stok_sebelum`, `stok_sesudah`, `catatan`, `created_at`) VALUES
(1,  3, 15, 12, 'Penjualan ke toko mitra',       '2026-05-01 09:15:00'),
(6,  2, 17, 15, 'Penjualan online marketplace',  '2026-05-02 10:30:00'),
(3,  1,  7,  6, 'Pembelian pelanggan langsung',  '2026-05-03 13:45:00'),
(8,  2,  9,  7, 'Flash sale weekend',            '2026-05-04 11:00:00'),
(2,  2,  5,  3, 'Penjualan korporat',            '2026-05-05 14:20:00'),
(9,  1, 12, 11, 'Pre-order customer',            '2026-05-06 09:00:00'),
(5,  1, 10,  9, 'Penjualan tunai',               '2026-05-07 16:10:00'),
(7,  1,  5,  4, 'Penjualan ke reseller',         '2026-05-08 10:45:00'),
(10, 3,  4,  1, 'Diskon akhir bulan',            '2026-05-09 15:30:00'),
(4,  2,  4,  2, 'Penjualan B2B',                 '2026-05-10 08:00:00');
