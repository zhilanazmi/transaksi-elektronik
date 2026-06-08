-- DATA SEED BULK UNTUK LAUNDRYPAY
-- Jalankan query ini setelah melakukan 'php artisan migrate'

SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE contracts;
TRUNCATE TABLE mitra_applications;
TRUNCATE TABLE users;
SET FOREIGN_KEY_CHECKS = 1;

-- 1. INSERT USERS (Admin, Staff, Customer default)
INSERT INTO `users` (`id`, `name`, `email`, `role`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Admin LaundryPay', 'admin@laundrypay.test', 'admin', '$2y$12$zMFrKsMB2KjAPTaPiZgMmOsaHStXOWsiQw3ww9MHdJuO8k0eciv5O', NOW(), NOW()),
(2, 'Staff POS', 'staff@laundrypay.test', 'staff', '$2y$12$zMFrKsMB2KjAPTaPiZgMmOsaHStXOWsiQw3ww9MHdJuO8k0eciv5O', NOW(), NOW()),
(3, 'Budi Santoso', 'customer@laundrypay.test', 'customer', '$2y$12$zMFrKsMB2KjAPTaPiZgMmOsaHStXOWsiQw3ww9MHdJuO8k0eciv5O', NOW(), NOW());

-- 2. INSERT MITRA USERS (15 Users)
INSERT INTO `users` (`id`, `name`, `email`, `role`, `password`, `created_at`, `updated_at`) VALUES
(6, 'Mitra Supplier 1', 'mitra.supplier.1@example.com', 'mitra', '$2y$12$zMFrKsMB2KjAPTaPiZgMmOsaHStXOWsiQw3ww9MHdJuO8k0eciv5O', NOW(), NOW()),
(7, 'Mitra Supplier 2', 'mitra.supplier.2@example.com', 'mitra', '$2y$12$zMFrKsMB2KjAPTaPiZgMmOsaHStXOWsiQw3ww9MHdJuO8k0eciv5O', NOW(), NOW()),
(8, 'Mitra Supplier 3', 'mitra.supplier.3@example.com', 'mitra', '$2y$12$zMFrKsMB2KjAPTaPiZgMmOsaHStXOWsiQw3ww9MHdJuO8k0eciv5O', NOW(), NOW()),
(9, 'Mitra Supplier 4', 'mitra.supplier.4@example.com', 'mitra', '$2y$12$zMFrKsMB2KjAPTaPiZgMmOsaHStXOWsiQw3ww9MHdJuO8k0eciv5O', NOW(), NOW()),
(10, 'Mitra Supplier 5', 'mitra.supplier.5@example.com', 'mitra', '$2y$12$zMFrKsMB2KjAPTaPiZgMmOsaHStXOWsiQw3ww9MHdJuO8k0eciv5O', NOW(), NOW()),
(11, 'Mitra Supplier 6', 'mitra.supplier.6@example.com', 'mitra', '$2y$12$zMFrKsMB2KjAPTaPiZgMmOsaHStXOWsiQw3ww9MHdJuO8k0eciv5O', NOW(), NOW()),
(12, 'Mitra Supplier 7', 'mitra.supplier.7@example.com', 'mitra', '$2y$12$zMFrKsMB2KjAPTaPiZgMmOsaHStXOWsiQw3ww9MHdJuO8k0eciv5O', NOW(), NOW()),
(13, 'Mitra Distributor 1', 'mitra.distributor.1@example.com', 'mitra', '$2y$12$zMFrKsMB2KjAPTaPiZgMmOsaHStXOWsiQw3ww9MHdJuO8k0eciv5O', NOW(), NOW()),
(14, 'Mitra Distributor 2', 'mitra.distributor.2@example.com', 'mitra', '$2y$12$zMFrKsMB2KjAPTaPiZgMmOsaHStXOWsiQw3ww9MHdJuO8k0eciv5O', NOW(), NOW()),
(15, 'Mitra Distributor 3', 'mitra.distributor.3@example.com', 'mitra', '$2y$12$zMFrKsMB2KjAPTaPiZgMmOsaHStXOWsiQw3ww9MHdJuO8k0eciv5O', NOW(), NOW()),
(16, 'Mitra Distributor 4', 'mitra.distributor.4@example.com', 'mitra', '$2y$12$zMFrKsMB2KjAPTaPiZgMmOsaHStXOWsiQw3ww9MHdJuO8k0eciv5O', NOW(), NOW()),
(17, 'Mitra Distributor 5', 'mitra.distributor.5@example.com', 'mitra', '$2y$12$zMFrKsMB2KjAPTaPiZgMmOsaHStXOWsiQw3ww9MHdJuO8k0eciv5O', NOW(), NOW()),
(18, 'Mitra Distributor 6', 'mitra.distributor.6@example.com', 'mitra', '$2y$12$zMFrKsMB2KjAPTaPiZgMmOsaHStXOWsiQw3ww9MHdJuO8k0eciv5O', NOW(), NOW()),
(19, 'Mitra Distributor 7', 'mitra.distributor.7@example.com', 'mitra', '$2y$12$zMFrKsMB2KjAPTaPiZgMmOsaHStXOWsiQw3ww9MHdJuO8k0eciv5O', NOW(), NOW()),
(20, 'Mitra Distributor 8', 'mitra.distributor.8@example.com', 'mitra', '$2y$12$zMFrKsMB2KjAPTaPiZgMmOsaHStXOWsiQw3ww9MHdJuO8k0eciv5O', NOW(), NOW());

-- 3. INSERT MITRA APPLICATIONS
INSERT INTO `mitra_applications` (`id`, `user_id`, `nama_mitra`, `jenis_mitra`, `produk_mitra`, `durasi_mitra`, `kewajiban_mitra`, `kewajiban_pemilik`, `status`, `approved_at`, `created_at`, `updated_at`) VALUES
(1, 6, 'CV Deterjen Maju', 'supplier', 'Deterjen Cair', '1 Tahun', 'Kewajiban mensuplai stok harian.', 'Kewajiban membayar tagihan mingguan.', 'approved', NOW(), NOW(), NOW()),
(2, 13, 'PT Logistik Kilat', 'distributor', 'Cabang Bandung', '2 Tahun', 'Mendistribusikan ke outlet.', 'Memberikan akses data stok.', 'approved', NOW(), NOW(), NOW());

-- 4. INSERT MITRA CONTRACTS
INSERT INTO `contracts` (`id`, `mitra_application_id`, `contract_number`, `issued_at`, `contract_value`, `status`, `content`, `created_at`, `updated_at`) VALUES
(1, 1, 'CTR-MITRA-SUP-001', CURDATE(), 0, 'active', 'KONTRAK KERJASAMA SUPPLIER...', NOW(), NOW()),
(2, 2, 'CTR-MITRA-DIST-001', CURDATE(), 0, 'active', 'KONTRAK KERJASAMA DISTRIBUTOR...', NOW(), NOW());
