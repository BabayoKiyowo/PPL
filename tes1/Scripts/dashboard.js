document.addEventListener("DOMContentLoaded", () => {
    const loginForm = document.getElementById("login-form");
    const dashboard = document.getElementById("dashboard");
    const loginPage = document.getElementById("login-page");
    const logoutBtn = document.getElementById("logout-btn");
  
    const catalogTable = document.getElementById("catalog-table");
    const salesTable = document.getElementById("sales-table");
    const itemFormModal = document.getElementById("item-form-modal");
    const itemForm = document.getElementById("item-form");
  
    const mockUsers = [
      { username: "admin", password: "admin123" } // Replace with real authentication in production
    ];
  
    // Login Logic
    loginForm.addEventListener("submit", (event) => {
      event.preventDefault();
      const username = document.getElementById("username").value;
      const password = document.getElementById("password").value;
  
      const user = mockUsers.find(u => u.username === username && u.password === password);
      if (user) {
        loginPage.style.display = "none";
        dashboard.style.display = "block";
      } else {
        document.getElementById("login-error").textContent = "Invalid username or password.";
      }
    });
  
    // Logout Logic
    logoutBtn.addEventListener("click", () => {
      dashboard.style.display = "none";
      loginPage.style.display = "block";
    });
  
    // Load Catalog
    const loadCatalog = () => {
      const mockCatalog = [
        { id: 1, name: "Latte", price: 20000, customizations: "Milk, Ice" },
        { id: 2, name: "Espresso", price: 15000, customizations: "Double Shot" }
      ];
      catalogTable.innerHTML = mockCatalog.map(item => `
        <tr>
          <td>${item.id}</td>
          <td>${item.name}</td>
          <td>${item.price}</td>
          <td>${item.customizations}</td>
          <td>
            <button>Edit</button>
            <button>Delete</button>
          </td>
        </tr>
      `).join('');
    };
  
    // Load Sales
    const loadSales = () => {
      const mockSales = [
        { orderId: 101, customer: "John Doe", date: "2023-12-01", total: 45000 },
        { orderId: 102, customer: "Jane Smith", date: "2023-12-02", total: 30000 }
      ];
      salesTable.innerHTML = mockSales.map(sale => `
        <tr>
          <td>${sale.orderId}</td>
          <td>${sale.customer}</td>
          <td>${sale.date}</td>
          <td>${sale.total}</td>
        </tr>
      `).join('');
    };
  
    // Initialize
    loadCatalog();
    loadSales();
  });
  