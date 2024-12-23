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





    function updateCustomization(checkbox) {
      const container = checkbox.closest('.menu-item');
      
      // Memastikan hanya mengambil elemen dengan ID yang unik untuk item tertentu
      const iceCheckbox = container.querySelector('[id$="-ice"]');
      const hotCheckbox = container.querySelector('[id$="-hot"]');
      const lessIceCheckbox = container.querySelector('[id$="-lessIce"]');
    
      // Jika "Hot" dipilih, nonaktifkan "Ice" dan "Less Ice"
      if (hotCheckbox && hotCheckbox.checked) {
        iceCheckbox.disabled = true;
        lessIceCheckbox.disabled = true;
        iceCheckbox.checked = false;
        lessIceCheckbox.checked = false;
      } else {
        iceCheckbox.disabled = false;
      }
    
      // Jika "Ice" dipilih, aktifkan "Less Ice"
      if (iceCheckbox && iceCheckbox.checked) {
        lessIceCheckbox.disabled = false;
      } else {
        lessIceCheckbox.disabled = true;
        lessIceCheckbox.checked = false;
      }
    
      // Menghitung harga setelah kustomisasi
      const basePrice = parseInt(container.getAttribute('data-price'), 10);
      let totalPrice = basePrice;
    
      // Menghitung harga berdasarkan kustomisasi yang dipilih
      const checkboxes = container.querySelectorAll('input[type="checkbox"]:checked');
      checkboxes.forEach(cb => {
        totalPrice += parseInt(cb.value, 10);
      });
    
      // Update harga pada menu
      container.querySelector('.price').textContent = `Rp ${totalPrice.toLocaleString()}`;
    
      // Update ringkasan pesanan
      updateOrderSummary();
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
    
      const orderList = document.getElementById('orderList').innerText;
      const totalPrice = document.getElementById('totalPrice').textContent;
    
      doc.text("Struk Pesanan", 20, 20);
      doc.text(orderList, 20, 30);
      doc.text(`Total Harga: Rp ${totalPrice}`, 20, 50);
    
      doc.save('struk_pesanan.pdf');
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


    
