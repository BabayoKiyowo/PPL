<?php
// Debugging untuk memastikan path file database benar
if (!file_exists('../database/db_config.php')) {
    die("File db_config.php tidak ditemukan.");
}

if (!file_exists('../database/data.php')) {
    die("File data.php tidak ditemukan.");
}

// Menyertakan file koneksi dan fungsi database
include_once('../database/db_config.php');  // db_config.php di folder database
include_once('../database/data.php');       // Menggunakan data.php yang baru

// Ambil menu dari kategori
$coffeeItems = getMenuByCategory('coffee') ?? [];
$nonCoffeeItems = getMenuByCategory('non-coffee') ?? [];
$foodItems = getMenuByCategory('food') ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laman Utama</title>
    <link rel="stylesheet" href="../css/menu.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
</head>
<body>
    <header>
        <img src="/image/logo.png" alt="Logo" class="logo">
        <span class="header-title">Laman Utama</span>
    </header>
    <main>
        <h1>Selamat Datang di Coffee Shop</h1>

        <!-- Katalog Coffee -->
        <div class="section">
            <h2>Coffee</h2>
            <div class="catalog-container">
                <?php if (empty($coffeeItems)): ?>
                    <p>Belum ada menu untuk kategori ini.</p>
                <?php else: ?>
                    <?php foreach ($coffeeItems as $item): ?>
                        <div class="menu-item" data-name="<?= htmlspecialchars($item['nama']) ?>" data-price="<?= htmlspecialchars($item['harga']) ?>">
                            <img src="<?= htmlspecialchars($item['image_url'] ?? '/image/default-coffee.jpg') ?>" alt="<?= htmlspecialchars($item['nama']) ?>">
                            <p class="name"><?= htmlspecialchars($item['nama']) ?></p>
                            <p class="price">Rp <?= number_format($item['harga'], 0, ',', '.') ?></p>
                            <div class="button-container">
                                <button class="btn add-btn" onclick="addItem(this)">Add</button>
                                <button class="btn minus-btn" onclick="decrement(this)" style="display:none;">-</button>
                                <span class="quantity" style="display:none;">0</span>
                                <button class="btn plus-btn" onclick="increment(this)" style="display:none;">+</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Katalog Non-Coffee -->
        <div class="section">
            <h2>Non-Coffee</h2>
            <div class="catalog-container">
                <?php if (empty($nonCoffeeItems)): ?>
                    <p>Belum ada menu untuk kategori ini.</p>
                <?php else: ?>
                    <?php foreach ($nonCoffeeItems as $item): ?>
                        <div class="menu-item" data-name="<?= htmlspecialchars($item['nama']) ?>" data-price="<?= htmlspecialchars($item['harga']) ?>">
                            <img src="<?= htmlspecialchars($item['image_url'] ?? '/image/default-noncoffee.jpg') ?>" alt="<?= htmlspecialchars($item['nama']) ?>">
                            <p class="name"><?= htmlspecialchars($item['nama']) ?></p>
                            <p class="price">Rp <?= number_format($item['harga'], 0, ',', '.') ?></p>
                            <div class="button-container">
                                <button class="btn add-btn" onclick="addItem(this)">Add</button>
                                <button class="btn minus-btn" onclick="decrement(this)" style="display:none;">-</button>
                                <span class="quantity" style="display:none;">0</span>
                                <button class="btn plus-btn" onclick="increment(this)" style="display:none;">+</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Katalog Food -->
        <div class="section">
            <h2>Food</h2>
            <div class="catalog-container">
                <?php if (empty($foodItems)): ?>
                    <p>Belum ada menu untuk kategori ini.</p>
                <?php else: ?>
                    <?php foreach ($foodItems as $item): ?>
                        <div class="menu-item" data-name="<?= htmlspecialchars($item['nama']) ?>" data-price="<?= htmlspecialchars($item['harga']) ?>">
                            <img src="<?= htmlspecialchars($item['image_url'] ?? '/image/default-food.jpg') ?>" alt="<?= htmlspecialchars($item['nama']) ?>">
                            <p class="name"><?= htmlspecialchars($item['nama']) ?></p>
                            <p class="price">Rp <?= number_format($item['harga'], 0, ',', '.') ?></p>
                            <div class="button-container">
                                <button class="btn add-btn" onclick="addItem(this)">Add</button>
                                <button class="btn minus-btn" onclick="decrement(this)" style="display:none;">-</button>
                                <span class="quantity" style="display:none;">0</span>
                                <button class="btn plus-btn" onclick="increment(this)" style="display:none;">+</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <button class="btn-order" onclick="showOrderSummary()">Pesan</button>
    </main>

    <div id="successAlert" class="alert">Pesanan berhasil</div>

    <!-- Pop-up for Order Summary -->
    <div id="orderPopup">
        <div class="popup-content">
            <h3>Struk Pesanan</h3>
            <ul id="orderList"></ul>
            <p><strong>Total Harga: Rp <span id="totalPrice">0</span></strong></p>
            <button class="btn" onclick="downloadPDF()">Cetak Struk</button>
            <button class="btn btn-close" onclick="closePopup()">Tutup</button>
        </div>
    </div>

    <script src="../Scripts/main.js"></script>
</body>
</html>