<?php
include('db_config.php');

// Ambil data yang dikirim dari JavaScript (cart)
$data = json_decode(file_get_contents("php://input"), true);

// Simpan data transaksi
$total = 0;
foreach ($data as $item) {
    $total += $item['harga'] * $item['qty'];
}

// Simpan transaksi
$query = "INSERT INTO transaksi (nomor, total, nama) VALUES ('TR" . rand(1000, 9999) . "', $total, 'Customer')";
mysqli_query($conn, $query);
$id_transaksi = mysqli_insert_id($conn);

// Simpan detail transaksi
foreach ($data as $item) {
    $query = "INSERT INTO transaksi_detail (id_transaksi, id_barang, qty, total) 
              VALUES ($id_transaksi, {$item['id_menu']}, {$item['qty']}, {$item['harga']} * {$item['qty']})";
    mysqli_query($conn, $query);
}

echo json_encode(['status' => 'success']);
?>
