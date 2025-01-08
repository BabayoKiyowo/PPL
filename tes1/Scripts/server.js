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
    database: 'coffee_shop'
});

db.connect(err => {
    if (err) {
        console.error('Error connecting to the database:', err);
    } else {
        console.log('Connected to the database.');
    }
});

// Konfigurasi multer untuk unggahan gambar
const upload = multer({ dest: 'public/uploads/' });

// API untuk mendapatkan data menu
app.get('/api/menu', (req, res) => {
    db.query('SELECT * FROM menu', (err, results) => {
        if (err) {
            res.status(500).json({ success: false, message: 'Error fetching menu data' });
        } else {
            res.json({ success: true, menu: results });
        }
    });
});

// API untuk memperbarui menu
app.put('/api/menu/:id', upload.single('image'), (req, res) => {
    const { id } = req.params;
    const { name, price, customization } = req.body;
    let image_url = null;

    if (req.file) {
        image_url = `/uploads/${req.file.filename}`;
    }

    const updateQuery = `UPDATE menu SET name = ?, price = ?, customization = ? ${image_url ? ', image_url = ?' : ''} WHERE id = ?`;
    const params = image_url ? [name, price, customization, image_url, id] : [name, price, customization, id];

    db.query(updateQuery, params, (err, results) => {
        if (err) {
            res.status(500).json({ success: false, message: 'Error updating menu' });
        } else {
            res.json({ success: true, message: 'Menu updated successfully' });
        }
    });
});

// API untuk mendapatkan data pesanan
app.get('/api/orders', (req, res) => {
    db.query('SELECT * FROM orders', (err, results) => {
        if (err) {
            res.status(500).json({ success: false, message: 'Error fetching orders' });
        } else {
            res.json({ success: true, orders: results });
        }
    });
});

// API untuk menyimpan pesanan
app.post('/api/orders', (req, res) => {
    const { totalPrice, orderItems } = req.body;
    db.query(
        'INSERT INTO orders (total_price, order_items) VALUES (?, ?)',
        [totalPrice, JSON.stringify(orderItems)],
        (err, results) => {
            if (err) {
                res.status(500).json({ success: false, message: 'Error saving order' });
            } else {
                res.json({ success: true, message: 'Order saved successfully' });
            }
        }
    );
});

// Jalankan server
app.listen(3000, () => {
    console.log('Server running on port 3000.');
});
