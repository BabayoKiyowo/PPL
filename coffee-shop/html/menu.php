<?php
include_once('../db_config.php');
include_once('../database/db.php');

// Ambil menu dari kategori
$coffeeItems = getMenuByCategory('coffee');
$nonCoffeeItems = getMenuByCategory('non-coffee');
$foodItems = getMenuByCategory('food');
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
                <?php foreach ($coffeeItems as $item): ?>
                <div class="menu-item" data-name="<?= $item['name'] ?>" data-price="<?= $item['price'] ?>">
                    <img src="<?= $item['image_url'] ?>" alt="<?= $item['name'] ?>">
                    <p class="name"><?= $item['name'] ?></p>
                    <p class="price">Rp <?= number_format($item['price'], 0, ',', '.') ?></p>
                    <div class="button-container">
                        <button class="btn add-btn" onclick="addItem(this)">Add</button>
                        <button class="btn minus-btn" onclick="decrement(this)" style="display:none;">-</button>
                        <span class="quantity" style="display:none;">0</span>
                        <button class="btn plus-btn" onclick="increment(this)" style="display:none;">+</button>
                    </div>
                    <div class="customization" style="display: none;">
                        <h4>Kustomisasi:</h4>
                        <label><input type="checkbox" id="hot" value="0" onchange="updateCustomization(this)"> Hot</label><br>
                        <label><input type="checkbox" id="lessIce" value="0" onchange="updateCustomization(this)" disabled> Less Ice</label><br>
                        <label><input type="checkbox" value="5000" onchange="updateCustomization(this)"> Double Shot (+Rp 5.000)</label><br>
                        <label><input type="checkbox" id="ice" value="3000" onchange="updateCustomization(this)"> Ice (+Rp 3.000)</label><br>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Katalog Non-Coffee -->
        <div class="section">
            <h2>Non-Coffee</h2>
            <div class="catalog-container">
                <?php foreach ($nonCoffeeItems as $item): ?>
                <div class="menu-item" data-name="<?= $item['name'] ?>" data-price="<?= $item['price'] ?>">
                    <img src="<?= $item['image_url'] ?>" alt="<?= $item['name'] ?>">
                    <p class="name"><?= $item['name'] ?></p>
                    <p class="price">Rp <?= number_format($item['price'], 0, ',', '.') ?></p>
                    <div class="button-container">
                        <button class="btn add-btn" onclick="addItem(this)">Add</button>
                        <button class="btn minus-btn" onclick="decrement(this)" style="display:none;">-</button>
                        <span class="quantity" style="display:none;">0</span>
                        <button class="btn plus-btn" onclick="increment(this)" style="display:none;">+</button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Katalog Food -->
        <div class="section">
            <h2>Food</h2>
            <div class="catalog-container">
                <?php foreach ($foodItems as $item): ?>
                <div class="menu-item" data-name="<?= $item['name'] ?>" data-price="<?= $item['price'] ?>">
                    <img src="<?= $item['image_url'] ?>" alt="<?= $item['name'] ?>">
                    <p class="name"><?= $item['name'] ?></p>
                    <p class="price">Rp <?= number_format($item['price'], 0, ',', '.') ?></p>
                    <div class="button-container">
                        <button class="btn add-btn" onclick="addItem(this)">Add</button>
                        <button class="btn minus-btn" onclick="decrement(this)" style="display:none;">-</button>
                        <span class="quantity" style="display:none;">0</span>
                        <button class="btn plus-btn" onclick="increment(this)" style="display:none;">+</button>
                    </div>
                </div>
                <?php endforeach; ?>
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
