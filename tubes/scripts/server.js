const express = require('express');
const multer = require('multer');
const bodyParser = require('body-parser');
const mysql = require('mysql2');
const path = require('path');

const app = express();
app.use(bodyParser.json());
app.use(express.static('public'));

// Konfigurasi koneksi database
const db = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'CoffeeShopAdmin' // Sesuai dengan nama database
});

db.connect(err => {
    if (err) {
        console.error('Error connecting to the database:', err);
    } else {
        console.log('Connected to the database.');
    }
});

// Konfigurasi multer untuk unggahan gambar (opsional jika diperlukan di masa depan)
const upload = multer({ dest: 'public/uploads/' });

// API untuk mendapatkan data penjualan
app.get('/api/sales', (req, res) => {
    const query = 'SELECT * FROM sales';
    db.query(query, (err, results) => {
        if (err) {
            res.status(500).json({ success: false, message: 'Error fetching sales data' });
        } else {
            res.json({ success: true, sales: results });
        }
    });
});

// API untuk menyimpan data penjualan
app.post('/api/sales', (req, res) => {
    const { menu_name, base_price, customization_detail, total_price } = req.body;

    const query = `INSERT INTO sales (menu_name, base_price, customization_detail, total_price) 
                   VALUES (?, ?, ?, ?)`;
    const params = [menu_name, base_price, customization_detail, total_price];

    db.query(query, params, (err, results) => {
        if (err) {
            res.status(500).json({ success: false, message: 'Error saving sales data' });
        } else {
            res.json({ success: true, message: 'Sales data saved successfully' });
        }
    });
});

// API untuk mendapatkan data admin
app.get('/api/admin', (req, res) => {
    const query = 'SELECT id, name, email, username, created_at FROM admin';
    db.query(query, (err, results) => {
        if (err) {
            res.status(500).json({ success: false, message: 'Error fetching admin data' });
        } else {
            res.json({ success: true, admins: results });
        }
    });
});

// API untuk menambah admin baru
app.post('/api/admin', (req, res) => {
    const { name, email, username, password } = req.body;

    const query = `INSERT INTO admin (name, email, username, password) 
                   VALUES (?, ?, ?, ?)`;
    const params = [name, email, username, password]; // Pastikan password sudah di-hash sebelum disimpan

    db.query(query, params, (err, results) => {
        if (err) {
            res.status(500).json({ success: false, message: 'Error adding admin' });
        } else {
            res.json({ success: true, message: 'Admin added successfully' });
        }
    });
});

// API untuk login admin
app.post('/api/admin/login', (req, res) => {
    const { username, password } = req.body;

    const query = `SELECT * FROM admin WHERE username = ?`;
    db.query(query, [username], (err, results) => {
        if (err || results.length === 0) {
            res.status(401).json({ success: false, message: 'Invalid username or password' });
        } else {
            const admin = results[0];
            // Verifikasi password di sini jika menggunakan hash
            if (password === admin.password) { // Sesuaikan dengan metode hashing jika digunakan
                res.json({ success: true, message: 'Login successful', admin });
            } else {
                res.status(401).json({ success: false, message: 'Invalid username or password' });
            }
        }
    });
});

// Jalankan server
app.listen(3000, () => {
    console.log('Server running on port 3000.');
});
