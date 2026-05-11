<?php
session_start();

$page = $_GET['page'] ?? 'dashboard';
$action = $_GET['action'] ?? 'index';

try {
    switch ($page) {
        case 'products':
            require_once __DIR__ . '/controllers/ProductController.php';
            $controller = new ProductController();

            if ($action === 'create') {
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $controller->createProduct($_POST);
                    $_SESSION['success'] = "Produk berhasiil ditambah.";
                    header('Location: index.php?page=products');
                    exit;
                }
                require __DIR__ . '/views/products/create.php';
            } elseif ($action === 'edit') {
                $id = $_GET['id'] ?? 0;
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $controller->updateProduct($id, $_POST);
                    $_SESSION['success'] = "Produk berhasiil diupdate.";
                    header('Location: index.php?page=products');
                    exit;
                }
                $product = $controller->getProductByIdRaw($id);
                if (!$product) throw new Exception("Produk tidak ditemukan.");
                require __DIR__ . '/views/products/edit.php';
            } elseif ($action === 'delete') {
                $id = $_GET['id'] ?? 0;
                $controller->deleteProduct($id);
                $_SESSION['success'] = "Produk berhasil dihapus.";
                header('Location: index.php?page=products');
                exit;
            } else {
                $products = $controller->getAllProductsRaw();
                require __DIR__ . '/views/products/index.php';
            }
            break;

        case 'transactions':
            require_once __DIR__ . '/controllers/TransactionController.php';
            $controller = new TransactionController();
            
            if ($action === 'create') {
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $controller->createTransaction($_POST);
                    $_SESSION['success'] = "Transakssi berhasil.";
                    header('Location: index.php?page=transactions');
                    exit;
                }
            } else {
                require_once __DIR__ . '/controllers/ProductController.php';
                $productCtrl = new ProductController();
                $products = $productCtrl->getAllProductsRaw();
                $transactions = $controller->getAllTransactions();
                require __DIR__ . '/views/transactions/index.php';
            }
            break;

        case 'dashboard':
        default:
            require_once __DIR__ . '/controllers/ProductController.php';
            $controller = new ProductController();
            $stats = $controller->getDashboardStats();
            $lowStock = $controller->getLowStockProducts();
            require __DIR__ . '/views/dashboard.php';
            break;
    }
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
    $referer = $_SERVER['HTTP_REFERER'] ?? 'index.php';
    header("Location: $referer");
    exit;
}
