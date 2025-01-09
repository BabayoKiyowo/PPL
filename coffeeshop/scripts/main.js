let orders = [];

// Function to add item to the order
function addItem(button) {
  const container = button.parentElement;
  const quantityElement = container.querySelector('.quantity');

  // Show increment and decrement buttons
  container.querySelector('.add-btn').style.display = 'none';
  container.querySelector('.minus-btn').style.display = 'inline-block';
  container.querySelector('.quantity').style.display = 'inline-block';
  container.querySelector('.plus-btn').style.display = 'inline-block';

  // Set initial quantity to 1 if 0
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

// Function to increment item quantity
function increment(button) {
  const container = button.parentElement;
  const quantity = container.querySelector('.quantity');
  quantity.textContent = parseInt(quantity.textContent) + 1;

  updateOrderSummary();
}

// Function to decrement item quantity
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

// Function to update customization options
function updateCustomization(checkbox) {
  const container = checkbox.closest('.menu-item');

  // Get customization checkboxes
  const iceCheckbox = container.querySelector('[id="ice"]');
  const hotCheckbox = container.querySelector('[id="hot"]');
  const lessIceCheckbox = container.querySelector('[id="lessIce"]');

  // Disable Ice and Less Ice if Hot is selected
  if (hotCheckbox && hotCheckbox.checked) {
    if (iceCheckbox) iceCheckbox.disabled = true;
    if (lessIceCheckbox) lessIceCheckbox.disabled = true;
  } else {
    if (iceCheckbox) iceCheckbox.disabled = false;
  }

  // Enable Less Ice if Ice is selected
  if (iceCheckbox && iceCheckbox.checked) {
    if (lessIceCheckbox) lessIceCheckbox.disabled = false;
  } else {
    if (lessIceCheckbox) lessIceCheckbox.disabled = true;
    if (lessIceCheckbox) lessIceCheckbox.checked = false;
  }

  // Update item price with customization
  const basePrice = parseInt(container.getAttribute('data-price'), 10);
  let totalPrice = basePrice;
  
  // Calculate price based on selected customizations
  const checkboxes = container.querySelectorAll('input[type="checkbox"]:checked');
  checkboxes.forEach(cb => {
    const value = parseInt(cb.value, 10);
    if (!isNaN(value)) {
      totalPrice += value;
    }
  });

  // Update price on the menu item
  const priceElement = container.querySelector('.price');
  if (priceElement) {
    priceElement.textContent = `Rp ${totalPrice.toLocaleString('id-ID')}`;
  }

  updateOrderSummary();
}

// Function to update order summary
function updateOrderSummary() {
  const items = document.querySelectorAll('.menu-item');
  const orderList = document.getElementById('orderList');
  const totalPriceEl = document.getElementById('totalPrice');
  let total = 0;

  // Clear order summary list
  orderList.innerHTML = '';

  items.forEach(item => {
    const quantity = parseInt(item.querySelector('.quantity').textContent || '0');
    if (quantity > 0) {
      const name = item.getAttribute('data-name');
      let basePrice = parseInt(item.getAttribute('data-price'), 10);

      // Get selected customizations
      const customizations = item.querySelectorAll('.customization input[type="checkbox"]:checked');
      let customizationPrice = 0;
      let customizationList = []; // List of customizations

      customizations.forEach(cust => {
        customizationPrice += parseInt(cust.value, 10);
        customizationList.push(cust.parentElement.textContent.trim());
      });

      // Final item price including customizations
      const itemPrice = (basePrice + customizationPrice) * quantity;
      total += itemPrice;

      // Add item to order summary
      const li = document.createElement('li');
      li.textContent = `${name} x${quantity} - Rp ${itemPrice.toLocaleString()}`;

      // Add customizations to the order summary
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

  // Update total price
  totalPriceEl.textContent = total.toLocaleString();
}

// Function to show order summary
function showOrderSummary() {
  const items = document.querySelectorAll('.menu-item');
  let itemAdded = false;

  // Check if any items are added to the order (quantity > 0)
  items.forEach(item => {
    const quantity = parseInt(item.querySelector('.quantity').textContent || '0');
    if (quantity > 0) {
      itemAdded = true;
    }
  });

  if (!itemAdded) {
    document.getElementById('addOrderPopup').style.display = 'flex';
    return; // Exit if no items are added
  }

  // Show order summary if items are added
  const summary = document.getElementById('orderPopup');
  summary.style.display = 'flex';
}

// Function to close add order popup
function closeAddOrderPopup() {
  document.getElementById('addOrderPopup').style.display = 'none';
}

// Function to close order popup
function closePopup() {
  document.getElementById('orderPopup').style.display = 'none';
}

function showAlert(message) {
  console.log("showAlert dipanggil dengan pesan:", message); // Debugging log
  const alert = document.getElementById('successAlert');
  if (alert) {
    alert.textContent = message; // Set the alert message
    alert.style.display = 'block'; // Show the alert

    // Hide the alert automatically after 3 seconds
    setTimeout(() => {
      alert.style.display = 'none';
      console.log("Alert disembunyikan");
    }, 3000);
  } else {
    console.error("Elemen #successAlert tidak ditemukan");
  }
}


// Function to download the order as a PDF
function downloadPDF() {
  console.log("downloadPDF dipanggil");
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF();
  const pageHeight = doc.internal.pageSize.height; // Page height
  const margin = 10; // Page margin
  let y = 20; // Initial vertical position

  // Function to check page space and move to the next page if needed
  function checkPageSpace(doc, currentY, extraSpace = 10) {
    if (currentY + extraSpace > pageHeight - margin) {
      doc.addPage();
      return margin; // Reset position to top margin
    }
    return currentY;
  }

  // Header
  const restaurantName = "Coffee Shop";
  const restaurantAddress = "Jl. Ketintang No. 123, Kota Surabaya";
  const restaurantPhone = "Telp: 012-3456-7890";
  const orderDate = new Date().toLocaleDateString('id-ID', {
    weekday: 'long',
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  });

  doc.setFontSize(16);
  doc.text(restaurantName, 20, y);
  y += 8;
  doc.setFontSize(12);
  doc.text(restaurantAddress, 20, y);
  y += 6;
  doc.text(restaurantPhone, 20, y);
  y += 6;
  doc.text(`Tanggal: ${orderDate}`, 20, y);
  y += 6;

  // Separator line
  doc.line(20, y, 190, y);
  y += 6;

  // Order details header
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

  // Order items
  const orderList = document.getElementById("orderList");
  const items = orderList?.children || [];
  const totalPrice = document.getElementById("totalPrice")?.textContent || "0";

  Array.from(items).forEach(item => {
    const text = item.textContent.split(" - ")[0];
    const totalPriceText = item.textContent.split(" - ")[1];

    // Split item name, quantity, and price
    const [name, quantity] = text.split(" x");
    const quantityValue = parseInt(quantity.trim(), 10);
    const basePrice = parseInt(totalPriceText.replace("Rp ", "").replace(/\./g, ""), 10) / quantityValue;

    // Show data in columns
    doc.text(name.trim(), 20, y);
    doc.text(quantity.trim(), 100, y);
    doc.text(`Rp ${basePrice.toLocaleString("id-ID")}`, 130, y);
    doc.text(`Rp ${parseInt(totalPriceText.replace("Rp ", "").replace(/\./g, ""), 10).toLocaleString("id-ID")}`, 160, y);

    y += 8;
    y = checkPageSpace(doc, y);

    // Add customizations if any
    const customizationList = item.querySelectorAll("ul li");
    customizationList.forEach(cust => {
      doc.setFontSize(10);
      doc.text(`  - ${cust.textContent.trim()}`, 25, y); // Indentation for customization
      y += 6; // Spacing between customizations
      y = checkPageSpace(doc, y, 6);
    });

    y += 4; // Spacing between items
    y = checkPageSpace(doc, y);
  });

  // Separator line before total price
  y += 4;
  doc.line(20, y, 190, y);
  y += 6;

  // Total price
  doc.setFontSize(14);
  doc.text(`Total Harga: Rp ${totalPrice}`, 20, y);
  y += 20;
  y = checkPageSpace(doc, y);

  // Footer
  doc.setFontSize(12);
  doc.text("Terima kasih atas kunjungan Anda!", 20, y);
  y += 6;
  doc.text("Semoga hari Anda menyenangkan!", 20, y);

  // Save PDF
  doc.save("struk_pesanan.pdf");

  // Show success message
  showAlert("Pesanan berhasil dibuat"); // Show alert

  // Optionally reset order details
  resetOrderDetails();
}


// Function to reset order details after printing
function resetOrderDetails() {
  // Reset order list and total price
  const orderList = document.getElementById('orderList');
  const totalPrice = document.getElementById('totalPrice');
  const menuItems = document.querySelectorAll('.menu-item');

  if (orderList) orderList.innerText = "";
  if (totalPrice) totalPrice.textContent = "0";

  // Reset each menu item
  menuItems.forEach(item => {
    const quantityElement = item.querySelector('.quantity');
    if (quantityElement) quantityElement.textContent = "0";

    // Hide quantity control buttons
    const addBtn = item.querySelector('.add-btn');
    const minusBtn = item.querySelector('.minus-btn');
    const plusBtn = item.querySelector('.plus-btn');
    const customization = item.querySelector('.customization');

    if (addBtn) addBtn.style.display = 'inline-block';
    if (minusBtn) minusBtn.style.display = 'none';
    if (plusBtn) plusBtn.style.display = 'none';
    if (customization) customization.style.display = 'none';

    // Reset customization checkboxes
    const checkboxes = item.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach(cb => {
      cb.checked = false;
      cb.disabled = false;
    });

    // Reset price to base price
    const basePrice = parseInt(item.getAttribute('data-price'), 10);
    const priceElement = item.querySelector('.price');
    if (priceElement) {
      priceElement.textContent = `Rp ${basePrice.toLocaleString('id-ID')}`;
    }
  });

  // Close popup if open
  closePopup();
}




// Function to close popup
function closePopup() {
  const popup = document.getElementById('orderPopup');
  if (popup) {
    popup.style.display = 'none';
  }
}

// Function to filter menu by name or alphabet
function filterMenuByNameOrAlphabet() {
  const input = document.getElementById('searchInput');
  const filter = input.value.toLowerCase();
  const menuItems = document.querySelectorAll('.menu-item');

  menuItems.forEach(item => {
    const name = item.getAttribute('data-name').toLowerCase();

    // Check if menu name contains or starts with the search text
    if (name.includes(filter) || name.startsWith(filter)) {
      item.style.display = ''; // Show item
    } else {
      item.style.display = 'none'; // Hide item
    }
  });
}

// Function to handle search event
function handleSearch(event) {
  if (event.type === 'keyup' && event.key === 'Enter') {
    filterMenuByNameOrAlphabet(); // Call search function
  }
}
