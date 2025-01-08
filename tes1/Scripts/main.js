let cart = [];

// Fungsi untuk menambahkan item ke keranjang
function addToCart(id_menu) {
    // Mengambil data menu dari server berdasarkan ID menu
    fetch(`../database/getMenuDetails.php?id_menu=${id_menu}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Gagal mengambil data menu.');
            }
            return response.json();
        })
        .then(data => {
            // Mengecek apakah item sudah ada di keranjang
            let existingItem = cart.find(item => item.id_menu === data.id_menu);
            if (existingItem) {
                existingItem.qty += 1; // Jika sudah ada, tambahkan kuantitas
                alert(`${existingItem.nama} telah diperbarui di keranjang (Qty: ${existingItem.qty}).`);
            } else {
                // Jika belum ada, tambahkan ke keranjang
                let item = {
                    id_menu: data.id_menu,
                    nama: data.nama,
                    harga: data.harga,
                    qty: 1
                };
                cart.push(item);
                alert(`${item.nama} berhasil ditambahkan ke keranjang.`);
            }
            console.log(cart); // Debugging untuk memantau isi keranjang
        })
        .catch(error => {
            console.error(error);
            alert('Terjadi kesalahan saat menambahkan item ke keranjang.');
        });
}

// Fungsi untuk melihat daftar pesanan atau checkout
function checkout() {
    if (cart.length === 0) {
        alert('Keranjang masih kosong. Tambahkan item terlebih dahulu.');
        return;
    }

    // Kirim data transaksi ke server untuk disimpan
    fetch('../database/checkout.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(cart)
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Gagal memproses pesanan.');
            }
            return response.json();
        })
        .then(data => {
            alert('Pesanan berhasil dilakukan!');
            console.log('Data pesanan:', data); // Debugging data yang dikembalikan oleh server
            cart = []; // Reset keranjang jika berhasil
        })
        .catch(error => {
            console.error(error);
            alert('Terjadi kesalahan saat memproses pesanan.');
        });
}

// Optional: Fungsi untuk menampilkan isi keranjang (misalnya, untuk debugging atau fitur tambahan)
function showCart() {
    if (cart.length === 0) {
        alert('Keranjang masih kosong.');
        return;
    }

    let cartDetails = 'Isi Keranjang:\n';
    cart.forEach(item => {
        cartDetails += `- ${item.nama}: ${item.qty} x Rp ${item.harga.toLocaleString()} = Rp ${(item.harga * item.qty).toLocaleString()}\n`;
    });
    alert(cartDetails);
}
