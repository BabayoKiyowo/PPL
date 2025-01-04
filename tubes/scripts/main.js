let orders = [];

    function addItem(button) {
      const container = button.parentElement;
      const quantityElement = container.querySelector('.quantity');

      // Show the increment and decrement buttons
      container.querySelector('.add-btn').style.display = 'none';
      container.querySelector('.minus-btn').style.display = 'inline-block';
      container.querySelector('.quantity').style.display = 'inline-block';
      container.querySelector('.plus-btn').style.display = 'inline-block';

      // Set initial quantity to 1
      if (quantityElement.textContent === '0') {
        quantityElement.textContent = '1';
      }

      // Show customization options
      const customization = container.parentElement.querySelector('.customization');
      if (customization) {
        customization.style.display = 'block';
      }

      updateOrderSummary();
    }





    function increment(button) {
      const container = button.parentElement;
      const quantity = container.querySelector('.quantity');
      quantity.textContent = parseInt(quantity.textContent) + 1;

      updateOrderSummary();
    }

    function decrement(button) {
      const container = button.parentElement;
      const quantity = container.querySelector('.quantity');
      const currentValue = parseInt(quantity.textContent);

      if (currentValue > 1) {
        quantity.textContent = currentValue - 1;
      } else {
        // Reset to 0 and hide quantity controls
        quantity.textContent = '0';
        container.querySelector('.add-btn').style.display = 'inline-block';
        container.querySelector('.minus-btn').style.display = 'none';
        container.querySelector('.quantity').style.display = 'none';
        container.querySelector('.plus-btn').style.display = 'none';

        // Hide customization options
        const customization = container.parentElement.querySelector('.customization');
        if (customization) {
          customization.style.display = 'none';
        }
      }

      updateOrderSummary();
    }




    // Perbaikan fungsi updateCustomization
function updateCustomization(checkbox) {
  const container = checkbox.closest('.menu-item');

  // Mengambil elemen dengan atribut data-id unik (jika ada) atau langsung menggunakan nama ID
  const iceCheckbox = container.querySelector('[id="ice"]');
  const hotCheckbox = container.querySelector('[id="hot"]');
  const lessIceCheckbox = container.querySelector('[id="lessIce"]');

  // Jika "Hot" dipilih, nonaktifkan "Ice" dan "Less Ice"
  if (hotCheckbox && hotCheckbox.checked) {
      if (iceCheckbox) {
          iceCheckbox.disabled = true;
          iceCheckbox.checked = false;
      }
      if (lessIceCheckbox) {
          lessIceCheckbox.disabled = true;
          lessIceCheckbox.checked = false;
      }
  } else {
      if (iceCheckbox) iceCheckbox.disabled = false;
  }

  // Jika "Ice" dipilih, aktifkan "Less Ice"
  if (iceCheckbox && iceCheckbox.checked) {
      if (lessIceCheckbox) lessIceCheckbox.disabled = false;
  } else {
      if (lessIceCheckbox) {
          lessIceCheckbox.disabled = true;
          lessIceCheckbox.checked = false;
      }
  }

  // Menghitung harga setelah kustomisasi
  const basePrice = parseInt(container.getAttribute('data-price'), 10);
  let totalPrice = basePrice;

  // Menambahkan harga berdasarkan kustomisasi yang dipilih
  const checkboxes = container.querySelectorAll('input[type="checkbox"]:checked');
  checkboxes.forEach(cb => {
      const value = parseInt(cb.value, 10);
      if (!isNaN(value)) {
          totalPrice += value;
      }
  });

  // Update harga pada menu
  const priceElement = container.querySelector('.price');
  if (priceElement) {
      priceElement.textContent = `Rp ${totalPrice.toLocaleString('id-ID')}`;
  }

  // Update ringkasan pesanan (jika ada fungsi terkait)
  if (typeof updateOrderSummary === 'function') {
      updateOrderSummary();
  }
}

    
    




    function updateOrderSummary() {
      const items = document.querySelectorAll('.menu-item');
      const orderList = document.getElementById('orderList');
      const totalPriceEl = document.getElementById('totalPrice');
      let total = 0;
    
      // Clear the order summary list
      orderList.innerHTML = '';
    
      items.forEach(item => {
        const quantity = parseInt(item.querySelector('.quantity').textContent || '0');
        if (quantity > 0) {
          const name = item.getAttribute('data-name');
          let basePrice = parseInt(item.getAttribute('data-price'), 10);
    
          // Mengambil kustomisasi yang dipilih
          const customizations = item.querySelectorAll('.customization input[type="checkbox"]:checked');
          let customizationPrice = 0;
          let customizationList = []; // Array untuk menyimpan kustomisasi
    
          customizations.forEach(cust => {
            customizationPrice += parseInt(cust.value, 10);
            customizationList.push(cust.parentElement.textContent.trim()); // Menambahkan kustomisasi ke list
          });
    
          // Harga akhir per item (termasuk kustomisasi)
          const itemPrice = (basePrice + customizationPrice) * quantity;
          total += itemPrice;
    
          // Menambahkan item ke ringkasan pesanan
          const li = document.createElement('li');
          li.textContent = `${name} x${quantity} - Rp ${itemPrice.toLocaleString()}`;
    
          // Jika ada kustomisasi, tambahkan ke dalam daftar
          if (customizationList.length > 0) {
            const ul = document.createElement('ul');
            customizationList.forEach(cust => {
              const custLi = document.createElement('li');
              custLi.textContent = cust;
              ul.appendChild(custLi);
            });
            li.appendChild(ul);
          }
    
          orderList.appendChild(li);
        }
      });
    
      // Update total harga
      totalPriceEl.textContent = total.toLocaleString();
    }
    


    
  function showOrderSummary() {
  const items = document.querySelectorAll('.menu-item');
  let itemAdded = false;

  // Memeriksa apakah ada item yang ditambahkan (quantity > 0)
  items.forEach(item => {
    const quantity = parseInt(item.querySelector('.quantity').textContent || '0');
    if (quantity > 0) {
      itemAdded = true;
    }
  });

  if (!itemAdded) {
    document.getElementById('addOrderPopup').style.display = 'flex';
    return; // Keluar jika tidak ada item yang ditambahkan
  }

  // Menampilkan ringkasan pesanan jika ada item yang ditambahkan
  const summary = document.getElementById('orderPopup');
  summary.style.display = 'flex';
}



    function closeAddOrderPopup() {
      document.getElementById('addOrderPopup').style.display = 'none';
    }



    function closePopup() {
      document.getElementById('orderPopup').style.display = 'none';
    }

    function downloadPDF() {
      const { jsPDF } = window.jspdf;
      const doc = new jsPDF();
      const pageHeight = doc.internal.pageSize.height; // Tinggi halaman
      const margin = 10; // Margin halaman
      const currentDate = new Date().toLocaleString('id-ID', {
        weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric'
    });
      let y = 20; // Posisi awal vertikal
    
      // Fungsi untuk memindahkan ke halaman berikutnya jika melebihi batas
      function checkPageSpace(doc, currentY, extraSpace = 10) {
        if (currentY + extraSpace > pageHeight - margin) {
          doc.addPage();
          return margin; // Reset posisi ke margin awal
        }
        return currentY;
      }
    
      // Header
      const restaurantName = "Coffee Shop";
      const restaurantAddress = "Jl. Ketintang No. 123, Kota Surabaya";
      const restaurantPhone = "Telp: 012-3456-7890";
      doc.text(`Tanggal: ${currentDate}`, 20, y);
      y += 6;
      doc.setFontSize(16);
      doc.text(restaurantName, 20, y);
      y += 8;
      doc.setFontSize(12);
      doc.text(restaurantAddress, 20, y);
      y += 6;
      doc.text(restaurantPhone, 20, y);
      y += 6;
    
      // Garis pemisah
      doc.line(20, y, 190, y);
      y += 6;
    
      // Detail Pesanan Header
      doc.setFontSize(14);
      doc.text("Struk Pesanan", 20, y);
      y += 10;
    
      doc.setFontSize(12);
      doc.text("Nama Item", 20, y);
      doc.text("Qty", 100, y);
      doc.text("Harga", 130, y);
      doc.text("Total", 160, y);
      y += 6;
    
      
      y = checkPageSpace(doc, y);
    
      // Isi Tabel Pesanan
      const orderList = document.getElementById("orderList");
      const items = orderList?.children || [];
      const totalPrice = document.getElementById("totalPrice")?.textContent || "0";
    
      Array.from(items).forEach(item => {
        const text = item.textContent.split(" - ")[0];
        const totalPriceText = item.textContent.split(" - ")[1];
    
        // Memisahkan nama, jumlah, dan harga satuan
        const [name, quantity] = text.split(" x");
        const quantityValue = parseInt(quantity.trim(), 10);
        const basePrice = parseInt(totalPriceText.replace("Rp ", "").replace(/\./g, ""), 10) / quantityValue;
    
        // Menampilkan data dalam kolom
        doc.text(name.trim(), 20, y);
        doc.text(quantity.trim(), 100, y);
        doc.text(`Rp ${basePrice.toLocaleString("id-ID")}`, 130, y);
        doc.text(`Rp ${parseInt(totalPriceText.replace("Rp ", "").replace(/\./g, ""), 10).toLocaleString("id-ID")}`, 160, y);
    
        y += 8;
        y = checkPageSpace(doc, y);
    
        // Tambahkan kustomisasi jika ada
        const customizationList = item.querySelectorAll("ul li");
        customizationList.forEach(cust => {
          doc.setFontSize(10);
          doc.text(`  - ${cust.textContent.trim()}`, 25, y); // Indentasi kustomisasi
          y += 6; // Jarak antar kustomisasi
          y = checkPageSpace(doc, y, 6);
        });
    
        y += 4; // Jarak antar item
        y = checkPageSpace(doc, y);
      });
    
      // Garis pemisah sebelum total harga
      y += 4;
      doc.line(20, y, 190, y);
      y += 6;
    
      // Total Harga
      doc.setFontSize(14);
      doc.text(`Total Harga: Rp ${totalPrice}`, 20, y);
      y += 20;
      y = checkPageSpace(doc, y);
    
      // Footer
      doc.setFontSize(12);
      doc.text("Terima kasih atas kunjungan Anda!", 20, y);
      y += 6;
      doc.text("Semoga hari Anda menyenangkan!", 20, y);
    
      // Mengunduh PDF
      doc.save("struk_pesanan.pdf");
    
      // Tampilkan pesan sukses dan reset pesanan
      showAlert("Pesanan berhasil disimpan.");
      resetOrderDetails();
    }
    
    
    
    
    
    function resetOrderDetails() {
      // Reset elemen pesanan
      const orderList = document.getElementById('orderList');
      const totalPrice = document.getElementById('totalPrice');
      const menuItems = document.querySelectorAll('.menu-item');
    
      if (orderList) orderList.innerText = "";
      if (totalPrice) totalPrice.textContent = "0";
    
      // Reset tampilan setiap item menu
      menuItems.forEach(item => {
        const quantityElement = item.querySelector('.quantity');
        if (quantityElement) quantityElement.textContent = "0";
    
        // Menyembunyikan elemen kontrol jumlah
        const addBtn = item.querySelector('.add-btn');
        const minusBtn = item.querySelector('.minus-btn');
        const plusBtn = item.querySelector('.plus-btn');
        const customization = item.querySelector('.customization');
    
        if (addBtn) addBtn.style.display = 'inline-block';
        if (minusBtn) minusBtn.style.display = 'none';
        if (plusBtn) plusBtn.style.display = 'none';
        if (customization) customization.style.display = 'none';
    
        // Reset checkbox kustomisasi
        const checkboxes = item.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(cb => {
          cb.checked = false;
          cb.disabled = false;
        });
    
        // Reset harga ke harga dasar
        const basePrice = parseInt(item.getAttribute('data-price'), 10);
        const priceElement = item.querySelector('.price');
        if (priceElement) {
          priceElement.textContent = `Rp ${basePrice.toLocaleString('id-ID')}`;
        }
      });
    
      // Menutup popup (jika ada)
      closePopup();
    }
    
    function showAlert(message) {
      const alert = document.getElementById('successAlert');
      if (alert) {
        alert.textContent = message;
        alert.style.display = 'block';
    
        // Menutup alert secara otomatis setelah 3 detik
        setTimeout(() => {
          alert.style.display = 'none';
        }, 3000);
    
        // Menampilkan popup pesanan berhasil
        showSuccessPopup();
      }
    }
    
    function showSuccessPopup() {
      const successPopup = document.getElementById('successPopup');
      if (successPopup) {
        successPopup.style.display = 'flex';
    
        // Menutup popup secara otomatis setelah 3 detik
        setTimeout(() => {
          successPopup.style.display = 'none';
        }, 3000);
      }
    }
    
    function closePopup() {
      const popup = document.getElementById('orderPopup');
      if (popup) {
        popup.style.display = 'none';
      }
    }
    
    
    
    // Fungsi pencarian utama
// Fungsi pencarian utama (nama dan alfabet)
function filterMenuByNameOrAlphabet() {
  const input = document.getElementById('searchInput');
  const filter = input.value.toLowerCase();
  const menuItems = document.querySelectorAll('.menu-item');

  menuItems.forEach(item => {
    const name = item.getAttribute('data-name').toLowerCase();
    
    // Cek apakah nama menu mengandung teks pencarian atau dimulai dengan alfabet tertentu
    if (name.includes(filter) || name.startsWith(filter)) {
      item.style.display = ''; // Tampilkan item
    } else {
      item.style.display = 'none'; // Sembunyikan item
    }
  });
}

// Fungsi untuk menangani Enter atau klik tombol
function handleSearch(event) {
  if (event.type === 'keyup' && event.key === 'Enter') {
    filterMenuByNameOrAlphabet(); // Panggil fungsi pencarian
  }
}


fetch('/api/menu')
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const menuContainer = document.getElementById('menuContainer');
            menuContainer.innerHTML = data.menu.map(item => `
                <div>
                    <img src="${item.image_url}" alt="${item.name}">
                    <h3>${item.name}</h3>
                    <p>Rp ${item.price}</p>
                    <p>${item.customization || ''}</p>
                </div>
            `).join('');
        }
    });
