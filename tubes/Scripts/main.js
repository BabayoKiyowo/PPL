<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Laman Utama</title>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <link rel="stylesheet" href="/css/style.css">
</head>

<body>
  <header>
    <img src="/image/logo.png" alt="Logo" class="logo">
    <span class="header-title">Laman Utama</span>
  </header>
  <main>
    <h1>Selamat Datang di Coffee Shop</h1>
    <!-- Konten lainnya -->
  </main>
  <div class="search-bar">
    <input 
      type="text" 
      id="searchInput" 
      placeholder="Cari " 
      onkeyup="handleSearch(event)">
    <button id="searchButton" onclick="filterMenuByNameOrAlphabet()">Cari</button>
  </div>
  <!-- Baris 1: Katalog Makanan -->
  <div class="section">
    <h2>Coffee</h2>
    <div class="catalog-container">
      <!-- Menu Item 1 -->
      <div class="menu-item" data-name="Americano" data-price="15000">
        <img src="/image/Americano.png" alt="Americano">
        <p class="name">Americano</p>
        <p class="price">Rp 15.000</p>
        <div class="button-container">
          <button class="btn add-btn" onclick="addItem(this)">Add</button>
          <button class="btn minus-btn" onclick="decrement(this)" style="display:none;">-</button>
          <span class="quantity" style="display:none;">0</span>
          <button class="btn plus-btn" onclick="increment(this)" style="display:none;">+</button>
        </div>
        <div class="customization" style="display: none;">
          <h4>Kustomisasi:</h4>
          <label><input type="checkbox" id="hot" value="0" onchange="updateCustomization(this)"> Hot</label><br>
          <label><input type="checkbox" id="lessIce" value="0" onchange="updateCustomization(this)" disabled> Less
            Ice</label><br>
          <label><input type="checkbox" value="5000" onchange="updateCustomization(this)"> Double Shot (+Rp
            5.000)</label><br>
          <label><input type="checkbox" id="ice" value="3000" onchange="updateCustomization(this)"> Ice (+Rp
            3.000)</label><br>

        </div>
      </div>
      <!-- Menu Item 2 -->
      <div class="menu-item" data-name="Esspresso" data-price="10000">
        <img src="/image/Espresso.png" alt="Espresso">
        <p class="name">Esspresso</p>
        <p class="price">Rp 10.000</p>
        <div class="button-container">
          <button class="btn add-btn" onclick="addItem(this)">Add</button>
          <button class="btn minus-btn" onclick="decrement(this)" style="display:none;">-</button>
          <span class="quantity" style="display:none;">0</span>
          <button class="btn plus-btn" onclick="increment(this)" style="display:none;">+</button>
        </div>
        <div class="customization" style="display: none;">
          <h4>Kustomisasi:</h4>
          <label><input type="checkbox" value="7000" onchange="updateCustomization(this)"> Double shot (+Rp
            5.000)</label><br>
        </div>
      </div>
      <!-- Menu Item 3 -->
      <div class="menu-item" data-name="V60" data-price="22000">
        <img src="/image/V60.png" alt="V60">
        <p class="name">V60</p>
        <p class="price">Rp 22.000</p>
        <div class="button-container">
          <button class="btn add-btn" onclick="addItem(this)">Add</button>
          <button class="btn minus-btn" onclick="decrement(this)" style="display:none;">-</button>
          <span class="quantity" style="display:none;">0</span>
          <button class="btn plus-btn" onclick="increment(this)" style="display:none;">+</button>
        </div>
        <div class="customization" style="display: none;">
          <h4>Kustomisasi:</h4>
          <label><input type="checkbox" id="hot" value="0" onchange="updateCustomization(this)"> Hot</label><br>
          <label><input type="checkbox" id="lessIce" value="0" onchange="updateCustomization(this)" disabled> Less
            Ice</label><br>
          <label><input type="checkbox" id="ice" value="3000" onchange="updateCustomization(this)"> Ice (+Rp
            3.000)</label><br>
        </div>
      </div>
      <!-- Menu Item 4 -->
      <div class="menu-item" data-name="Cappuccino" data-price="18000">
        <img src="/image/Cappuccino.png" alt="Cappuccino">
        <p class="name">Cappuccino</p>
        <p class="price">Rp 18.000</p>
        <div class="button-container">
          <button class="btn add-btn" onclick="addItem(this)">Add</button>
          <button class="btn minus-btn" onclick="decrement(this)" style="display:none;">-</button>
          <span class="quantity" style="display:none;">0</span>
          <button class="btn plus-btn" onclick="increment(this)" style="display:none;">+</button>
        </div>
        <div class="customization" style="display: none;">
          <h4>Kustomisasi:</h4>
          <label><input type="checkbox" id="hot" value="0" onchange="updateCustomization(this)"> Hot</label><br>
          <label><input type="checkbox" id="lessIce" value="0" onchange="updateCustomization(this)" disabled> Less
            Ice</label><br>
          <label><input type="checkbox" id="ice" value="3000" onchange="updateCustomization(this)"> Ice (+Rp
            3.000)</label><br>
            <label><input type="checkbox" id="lesssugar" value="0" onchange="updateCustomization(this)"> Less
              Sugar</label><br>
        </div>
      </div>
      <!-- Menu Item 5 -->
      <div class="menu-item" data-name="Cold Brew" data-price="15000">
        <img src="/image/Cold Brew.png" alt="Cold Brew">
        <p class="name">Cold Brew</p>
        <p class="price">Rp 15.000</p>
        <div class="button-container">
          <button class="btn add-btn" onclick="addItem(this)">Add</button>
          <button class="btn minus-btn" onclick="decrement(this)" style="display:none;">-</button>
          <span class="quantity" style="display:none;">0</span>
          <button class="btn plus-btn" onclick="increment(this)" style="display:none;">+</button>
        </div>
        <div class="customization" style="display: none;">
          <h4>Kustomisasi:</h4>
          <label><input type="checkbox" value="0" onchange="updateCustomization(this)"> less ice</label><br>
        </div>
      </div>
      <!-- Menu Item 6 -->
      <div class="menu-item" data-name="Mocha Latte" data-price="28000">
        <img src="/image/Mocha Latte.png" alt="Mocha Latte">
        <p class="name">Mocha Latte</p>
        <p class="price">Rp 28.000</p>
        <div class="button-container">
          <button class="btn add-btn" onclick="addItem(this)">Add</button>
          <button class="btn minus-btn" onclick="decrement(this)" style="display:none;">-</button>
          <span class="quantity" style="display:none;">0</span>
          <button class="btn plus-btn" onclick="increment(this)" style="display:none;">+</button>
        </div>
        <div class="customization" style="display: none;">
          <h4>Kustomisasi:</h4>
          <label><input type="checkbox" id="hot" value="0" onchange="updateCustomization(this)"> Hot</label><br>
          <label><input type="checkbox" id="lessIce" value="0" onchange="updateCustomization(this)" disabled> Less
            Ice</label><br>
          <label><input type="checkbox" id="ice" value="3000" onchange="updateCustomization(this)"> Ice (+Rp
            3.000)</label><br>
              <label><input type="checkbox" id="lesssugar" value="0" onchange="updateCustomization(this)"> Less
                Sugar</label><br>
        </div>
      </div>
    </div>
  </div>
  <div class="section">
    <h2>Non-Coffee</h2>
    <div class="catalog-container">
      <!-- Menu Item 1 -->
      <div class="menu-item" data-name="Lime Squash" data-price="15000">
        <img src="/image/Lime Squash.png" alt="Lime Squash">
        <p class="name">Lime Squash</p>
        <p class="price">Rp 15.000</p>
        <div class="button-container">
          <button class="btn add-btn" onclick="addItem(this)">Add</button>
          <button class="btn minus-btn" onclick="decrement(this)" style="display:none;">-</button>
          <span class="quantity" style="display:none;">0</span>
          <button class="btn plus-btn" onclick="increment(this)" style="display:none;">+</button>
        </div>
        <div class="customization" style="display: none;">
          <h4>Kustomisasi:</h4>
          <label><input type="checkbox" id="less_Ice" value="0" onchange="updateCustomization(this)"> Less
            Ice</label><br>
            <label><input type="checkbox" id="lesssugar" value="0" onchange="updateCustomization(this)"> Less
              Sugar</label><br>
        </div>
      </div>
      <!-- Menu Item 2 -->
      <div class="menu-item" data-name="Lychee Fresh Sparkle" data-price="30000">
        <img src="/image/Lychee Fresh Sparkle.png" alt="Lychee Fresh Sparkle">
        <p class="name">Lychee Fresh Sparkle</p>
        <p class="price">Rp 30.000</p>
        <div class="button-container">
          <button class="btn add-btn" onclick="addItem(this)">Add</button>
          <button class="btn minus-btn" onclick="decrement(this)" style="display:none;">-</button>
          <span class="quantity" style="display:none;">0</span>
          <button class="btn plus-btn" onclick="increment(this)" style="display:none;">+</button>
        </div>
        <div class="customization" style="display: none;">
          <h4>Kustomisasi:</h4>
          <label><input type="checkbox" id="less_Ice" value="0" onchange="updateCustomization(this)"> Less
            Ice</label><br>
            <label><input type="checkbox" id="lesssugar" value="0" onchange="updateCustomization(this)"> Less
              Sugar</label><br>
        </div>
      </div>
      <!-- Menu Item 3 -->
      <div class="menu-item" data-name="Avocado Yogurt Smoothies" data-price="30000">
        <img src="/image/Milk Tea.png" alt="Avocado Yogurt Smoothies">
        <p class="name">Avocado Yogurt Smoothies</p>
        <p class="price">Rp 30.000</p>
        <div class="button-container">
          <button class="btn add-btn" onclick="addItem(this)">Add</button>
          <button class="btn minus-btn" onclick="decrement(this)" style="display:none;">-</button>
          <span class="quantity" style="display:none;">0</span>
          <button class="btn plus-btn" onclick="increment(this)" style="display:none;">+</button>
        </div>
        <div class="customization" style="display: none;">
          <h4>Kustomisasi:</h4>
          <label><input type="checkbox" id="less_Ice" value="0" onchange="updateCustomization(this)"> Less
            Ice</label><br>
            <label><input type="checkbox" id="lesssugar" value="0" onchange="updateCustomization(this)"> Less
              Sugar</label><br>
        </div>
      </div>
      <!-- Menu Item 4 -->
      <div class="menu-item" data-name="Milk Tea" data-price="18000">
        <img src="../image/Milk Tea.png" alt="Milk Tea">
        <p class="name">Milk Tea</p>
        <p class="price">Rp 18.000</p>
        <div class="button-container">
          <button class="btn add-btn" onclick="addItem(this)">Add</button>
          <button class="btn minus-btn" onclick="decrement(this)" style="display:none;">-</button>
          <span class="quantity" style="display:none;">0</span>
          <button class="btn plus-btn" onclick="increment(this)" style="display:none;">+</button>
        </div>
        <div class="customization" style="display: none;">
          <h4>Kustomisasi:</h4>
          <label><input type="checkbox" id="less_Ice" value="0" onchange="updateCustomization(this)"> Less
            Ice</label><br>
            <label><input type="checkbox" id="lesssugar" value="0" onchange="updateCustomization(this)"> Less
              Sugar</label><br>
        </div>
      </div>
      <!-- Menu Item 5 -->
      <div class="menu-item" data-name="Fries" data-price="15000">
        <img src="/image/Matcha float.png" alt="Fries">
        <p class="name">Matcha Float</p>
        <p class="price">Rp 15.000</p>
        <div class="button-container">
          <button class="btn add-btn" onclick="addItem(this)">Add</button>
          <button class="btn minus-btn" onclick="decrement(this)" style="display:none;">-</button>
          <span class="quantity" style="display:none;">0</span>
          <button class="btn plus-btn" onclick="increment(this)" style="display:none;">+</button>
        </div>
        <div class="customization" style="display: none;">
          <h4>Kustomisasi:</h4>
          <label><input type="checkbox" id="hot" value="0" onchange="updateCustomization(this)"> Hot</label><br>
          <label><input type="checkbox" id="lessIce" value="0" onchange="updateCustomization(this)" disabled> Less
            Ice</label><br>
          <label><input type="checkbox" id="ice" value="3000" onchange="updateCustomization(this)"> Ice (+Rp
            3.000)</label><br>
              <label><input type="checkbox" id="lesssugar" value="0" onchange="updateCustomization(this)"> Less
                Sugar</label><br>
        </div>
      </div>
      <!-- Menu Item 6 -->
      <div class="menu-item" data-name="Vanilla Tea" data-price="28000">
        <img src="/image/Vanilla Tea.png" alt="Tea">
        <p class="name">Vanilla Tea</p>
        <p class="price">Rp 28.000</p>
        <div class="button-container">
          <button class="btn add-btn" onclick="addItem(this)">Add</button>
          <button class="btn minus-btn" onclick="decrement(this)" style="display:none;">-</button>
          <span class="quantity" style="display:none;">0</span>
          <button class="btn plus-btn" onclick="increment(this)" style="display:none;">+</button>
        </div>
        <div class="customization" style="display: none;">
          <h4>Kustomisasi:</h4>
          <label><input type="checkbox" id="hot" value="0" onchange="updateCustomization(this)"> Hot</label><br>
          <label><input type="checkbox" id="lessIce" value="0" onchange="updateCustomization(this)" disabled> Less
            Ice</label><br>
          <label><input type="checkbox" id="ice" value="3000" onchange="updateCustomization(this)"> Ice (+Rp
            3.000)</label><br>
              <label><input type="checkbox" id="lesssugar" value="0" onchange="updateCustomization(this)"> Less
                Sugar</label><br>
        </div>
      </div>
    </div>
  </div>
  <div class="section">
    <h2>Food</h2>
    <div class="catalog-container">
      <!-- Menu Item 1 -->
      <div class="menu-item" data-name="Burger" data-price="15000">
        <img src="/image/Burger.png" alt="Burger">
        <p class="name">Burger</p>
        <p class="price">Rp 15.000</p>
        <div class="button-container">
          <button class="btn add-btn" onclick="addItem(this)">Add</button>
          <button class="btn minus-btn" onclick="decrement(this)" style="display:none;">-</button>
          <span class="quantity" style="display:none;">0</span>
          <button class="btn plus-btn" onclick="increment(this)" style="display:none;">+</button>
        </div>
        <div class="customization" style="display: none;">
          <h4>Kustomisasi:</h4>
          <label><input type="checkbox" id="burger-chesee" value="3000" onchange="updateCustomization(this)"> +chesee (+Rp 3.000)</label><br>
<label><input type="checkbox" id="burger-egg" value="5000" onchange="updateCustomization(this)"> +egg (+Rp 5.000)</label><br>
<label><input type="checkbox" id="burger-hot" value="3000" onchange="updateCustomization(this)"> hot (+Rp 3.000)</label><br>

        </div>
      </div>
      <!-- Menu Item 2 -->
      <div class="menu-item" data-name="Sausage" data-price="30000">
        <img src="/image/Sosis.png" alt="Sausage">
        <p class="name">Sausage</p>
        <p class="price">Rp 30.000</p>


        <div class="button-container">
          <button class="btn add-btn" onclick="addItem(this)">Add</button>
          <button class="btn minus-btn" onclick="decrement(this)" style="display:none;">-</button>
          <span class="quantity" style="display:none;">0</span>
          <button class="btn plus-btn" onclick="increment(this)" style="display:none;">+</button>
        </div>


        <div class="customization" style="display: none;">
          <h4>Kustomisasi:</h4>
          <label><input type="checkbox" value="7000" onchange="updateCustomization(this)"> Extra Topping (+Rp
            7.000)</label><br>
        </div>
      </div>

      <!-- Menu Item 3 -->
      <div class="menu-item" data-name="Chicken Nugget" data-price="22000">
        <img src="/image/Chicken Nugget.png" alt="Chicken Nugget">
        <p class="name">Chicken Nugget</p>
        <p class="price">Rp 22.000</p>
        <div class="button-container">
          <button class="btn add-btn" onclick="addItem(this)">Add</button>
          <button class="btn minus-btn" onclick="decrement(this)" style="display:none;">-</button>
          <span class="quantity" style="display:none;">0</span>
          <button class="btn plus-btn" onclick="increment(this)" style="display:none;">+</button>
        </div>
        <div class="customization" style="display: none;">
          <h4>Kustomisasi:</h4>
          <label><input type="checkbox" value="5000" onchange="updateCustomization(this)"> Mushroom (+Rp
            5.000)</label><br>
        </div>
      </div>
      <!-- Menu Item 4 -->
      <div class="menu-item" data-name="Noodles" data-price="18000">
        <img src="/image/Noodles.png" alt="Noodles">
        <p class="name">Noodles</p>
        <p class="price">Rp 18.000</p>
        <div class="button-container">
          <button class="btn add-btn" onclick="addItem(this)">Add</button>
          <button class="btn minus-btn" onclick="decrement(this)" style="display:none;">-</button>
          <span class="quantity" style="display:none;">0</span>
          <button class="btn plus-btn" onclick="increment(this)" style="display:none;">+</button>
        </div>
        <div class="customization" style="display: none;">
          <h4>Kustomisasi:</h4>
          <label><input type="checkbox" value="4000" onchange="updateCustomization(this)"> Egg (+Rp 4.000)</label><br>
        </div>
      </div>
      <!-- Menu Item 5 -->
      <div class="menu-item" data-name="Fries" data-price="15000">
        <img src="/image/Fries.png" alt="Fries">
        <p class="name">Fries</p>
        <p class="price">Rp 15.000</p>
        <div class="button-container">
          <button class="btn add-btn" onclick="addItem(this)">Add</button>
          <button class="btn minus-btn" onclick="decrement(this)" style="display:none;">-</button>
          <span class="quantity" style="display:none;">0</span>
          <button class="btn plus-btn" onclick="increment(this)" style="display:none;">+</button>
        </div>
        <div class="customization" style="display: none;">
          <h4>Kustomisasi:</h4>
          <label><input type="checkbox" value="2000" onchange="updateCustomization(this)"> Cheese (+Rp
            2.000)</label><br>
        </div>
      </div>
      <!-- Menu Item 6 -->
      <div class="menu-item" data-name="Chicken" data-price="28000">
        <img src="/image/Chicken Wings.png" alt="Chicken">
        <p class="name">Chicken</p>
        <p class="price">Rp 28.000</p>
        <div class="button-container">
          <button class="btn add-btn" onclick="addItem(this)">Add</button>
          <button class="btn minus-btn" onclick="decrement(this)" style="display:none;">-</button>
          <span class="quantity" style="display:none;">0</span>
          <button class="btn plus-btn" onclick="increment(this)" style="display:none;">+</button>
        </div>
        <div class="customization" style="display: none;">
          <h4>Kustomisasi:</h4>
          <label><input type="checkbox" value="6000" onchange="updateCustomization(this)"> Spicy (+Rp 6.000)</label><br>
        </div>
      </div>
    </div>
  </div>

  <!-- Pop-up for Add Order Warning -->
  <div id="addOrderPopup" style="display: none;">
    <div class="popup-content">
      <h3>Perhatian</h3>
      <p>Tambahkan pesanan terlebih dahulu</p>
      <button class="btn btn-close" onclick="closeAddOrderPopup()">Tutup</button>
    </div>
  </div>


  <button class="btn-order" onclick="showOrderSummary()">Pesan</button>

  
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


  <footer class="footer">
  <div class="footer-content">
    <p>&copy; 2024 Coffee Shop. All rights reserved.</p>
    <div class="footer-links">
      <a href="#">Privacy Policy</a>
      <a href="#">Terms of Service</a>
      <a href="#">Contact</a>
    </div>
  </div>
</footer>

</body>

</html>
