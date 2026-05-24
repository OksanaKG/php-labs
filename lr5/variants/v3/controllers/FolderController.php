<?php

class FolderController extends PageController
{
    private string $usersDir;

    public function __construct()
    {
        parent::__construct();
        $this->usersDir = DATA_DIR . '/users';

        if (!is_dir($this->usersDir)) {
            mkdir($this->usersDir, 0755, true);
        }
    }

    public function action_create(): void
    {
        $message = '';
        $error = '';

        if ($this->request->isPost()) {
            $login = trim($this->request->post('login', ''));
            $password = trim($this->request->post('password', ''));

            if ($login === '' || $password === '') {
                $error = 'Логін та пароль є обов\'язковими.';
            } elseif (!preg_match('/^[a-zA-Z0-9_]{1,64}$/', $login)) {
                $error = 'Логін: 1-64 символи (латинські літери, цифри, _).';
            } else {
                $userDir = $this->usersDir . '/' . $login;

                if (is_dir($userDir)) {
                    $error = "Папка для користувача \"{$login}\" вже існує!";
                } else {
                    mkdir($userDir, 0755, true);

                    $subfolders = ['video', 'music', 'photo'];
                    foreach ($subfolders as $sub) {
                        $subPath = $userDir . '/' . $sub;
                        mkdir($subPath, 0755, true);

                        // Create sample files
                        file_put_contents($subPath . '/readme.txt', "Папка {$sub} користувача {$login}\nСтворено: " . date('Y-m-d H:i'));
                        file_put_contents($subPath . '/example_1.txt', "Приклад файлу 1 в {$sub}");
                        file_put_contents($subPath . '/example_2.txt', "Приклад файлу 2 в {$sub}");
                    }

                    // Save password hash
                    file_put_contents($userDir . '/.password', password_hash($password, PASSWORD_DEFAULT));

                    $message = "Папку \"{$login}\" створено з підпапками video, music, photo!";
                }
            }
        }

        $folders = $this->getUserFolders();

        // load products (simple storage in data/products/products.json)
        $products = [];
        $productsDir = DATA_DIR . '/products';
        $productsFile = $productsDir . '/products.json';
        if (!is_dir($productsDir)) mkdir($productsDir, 0755, true);
        if (file_exists($productsFile)) {
            $json = file_get_contents($productsFile);
            $products = json_decode($json, true) ?: [];
        }

        // If no products, create some sample products
        if (empty($products)) {
            $products = [
                ['id'=>1,'name'=>'Плюшева іграшка','price'=>199.00,'description'=>"М'яка іграшка для дітей",'image'=>''],
                ['id'=>2,'name'=>'Попкорн великий','price'=>79.00,'description'=>'Смачний солоний попкорн','image'=>''],
                ['id'=>3,'name'=>'Футболка кіно','price'=>499.00,'description'=>'Футболка з логотипом кінотеатру','image'=>''],
            ];
            file_put_contents($productsFile, json_encode($products, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        }

        $this->render('folder/create', [
            'message' => $message,
            'error' => $error,
            'folders' => $folders,
            'products' => $products,
        ], 'Створення каталогу');
    }

    // Upload a product (admin only)
    public function action_upload_product(): void
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] !== 1) {
            $this->redirect('auth/login');
            return;
        }

        $name = trim($this->request->post('name', ''));
        $price = (float)$this->request->post('price', 0);
        $desc = trim($this->request->post('description', ''));

        $productsDir = DATA_DIR . '/products';
        if (!is_dir($productsDir)) mkdir($productsDir, 0755, true);
        $productsFile = $productsDir . '/products.json';

        $imagePath = '';
        if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($_FILES['product_image']['name'], PATHINFO_EXTENSION));
            $safe = time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
            $dest = $productsDir . '/' . $safe;
            if (move_uploaded_file($_FILES['product_image']['tmp_name'], $dest)) {
                $imagePath = 'data/products/' . $safe;
            }
        }

        $products = [];
        if (file_exists($productsFile)) {
            $products = json_decode(file_get_contents($productsFile), true) ?: [];
        }

        $id = count($products) ? (int)end($products)['id'] + 1 : 1;
        $products[] = ['id' => $id, 'name' => $name, 'price' => $price, 'description' => $desc, 'image' => $imagePath];
        file_put_contents($productsFile, json_encode($products, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        $_SESSION['flash_success'] = 'Товар додано';
        $this->redirect('folder/create');
    }

    // Show buy page for product
    public function action_buy_product(): void
    {
        $id = (int)$this->request->get('id', 0);
        $productsDir = DATA_DIR . '/products';
        $productsFile = $productsDir . '/products.json';
        $product = null;
        if (file_exists($productsFile)) {
            $products = json_decode(file_get_contents($productsFile), true) ?: [];
            foreach ($products as $p) if ((int)$p['id'] === $id) { $product = $p; break; }
        }
        if (!$product) {
            $this->redirect('folder/create');
            return;
        }

        $this->render('folder/buy_product', ['product' => $product], 'Купівля товару');
    }

    // Process product purchase (simple receipt)
    public function action_purchase_product(): void
    {
        $productId = (int)$this->request->post('product_id', 0);
        $name = trim($this->request->post('name', 'Гість'));
        $productsDir = DATA_DIR . '/products';
        $productsFile = $productsDir . '/products.json';
        $product = null;
        if (file_exists($productsFile)) {
            $products = json_decode(file_get_contents($productsFile), true) ?: [];
            foreach ($products as $p) if ((int)$p['id'] === $productId) { $product = $p; break; }
        }
        if (!$product) {
            $this->redirect('folder/create');
            return;
        }
        // record purchase
        $purchasesFile = $productsDir . '/purchases.json';
        $purchases = [];
        if (file_exists($purchasesFile)) $purchases = json_decode(file_get_contents($purchasesFile), true) ?: [];
        $receipt = ['id' => time(), 'product' => $product, 'buyer' => $name, 'price' => $product['price'], 'created_at' => date('Y-m-d H:i:s')];
        $purchases[] = $receipt;
        file_put_contents($purchasesFile, json_encode($purchases, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        $this->render('folder/receipt', ['receipt' => $receipt], 'Чек товару');
    }

    public function action_delete(): void
    {
        $message = '';
        $error = '';

        if ($this->request->isPost()) {
            $login = trim($this->request->post('login', ''));
            $password = trim($this->request->post('password', ''));

            if ($login === '' || $password === '') {
                $error = 'Логін та пароль є обов\'язковими.';
            } elseif (!preg_match('/^[a-zA-Z0-9_]{1,64}$/', $login)) {
                $error = 'Логін: 1-64 символи (латинські літери, цифри, _).';
            } else {
                $userDir = $this->usersDir . '/' . $login;

                if (!is_dir($userDir)) {
                    $error = "Папку \"{$login}\" не знайдено.";
                } else {
                    $hashFile = $userDir . '/.password';
                    if (!file_exists($hashFile)) {
                        $error = 'Файл паролю не знайдено.';
                    } elseif (!password_verify($password, file_get_contents($hashFile))) {
                        $error = 'Невірний пароль.';
                    } else {
                        $this->deleteDirectory($userDir);
                        $message = "Папку \"{$login}\" з усім вмістом видалено!";
                    }
                }
            }
        }

        $this->render('folder/delete', [
            'message' => $message,
            'error' => $error,
        ], 'Видалення каталогу');
    }

    private function getUserFolders(): array
    {
        $folders = [];
        $dirs = glob($this->usersDir . '/*', GLOB_ONLYDIR);

        if ($dirs) {
            foreach ($dirs as $dir) {
                $name = basename($dir);
                $subfolders = [];
                $subDirs = glob($dir . '/*', GLOB_ONLYDIR);
                if ($subDirs) {
                    foreach ($subDirs as $subDir) {
                        $subName = basename($subDir);
                        $fileCount = count(glob($subDir . '/*'));
                        $subfolders[] = ['name' => $subName, 'files' => $fileCount];
                    }
                }
                $folders[] = ['name' => $name, 'subfolders' => $subfolders];
            }
        }

        return $folders;
    }

    private function deleteDirectory(string $dir): void
    {
        $items = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($items as $item) {
            if ($item->isDir()) {
                rmdir($item->getPathname());
            } else {
                unlink($item->getPathname());
            }
        }

        rmdir($dir);
    }
}
