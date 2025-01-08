<?php
// Menghubungkan ke database
include_once '../db_config.php';

// Cek apakah ID menu ada dalam parameter GET
if (isset($_GET['id_menu'])) {
    // Mendapatkan ID menu dari URL
    $id_menu = $_GET['id_menu'];

    // Membuat query untuk mengambil detail menu berdasarkan ID
    $query = "SELECT * FROM menu WHERE id_menu = ?";
    
    // Menyiapkan statement
    if ($stmt = $conn->prepare($query)) {
        // Binding parameter
        $stmt->bind_param("i", $id_menu);

        // Menjalankan query
        $stmt->execute();

        // Menyimpan hasil query
        $result = $stmt->get_result();

        // Cek apakah data ditemukan
        if ($result->num_rows > 0) {
            // Mengambil data menu
            $menu_details = $result->fetch_assoc();

            // Mengembalikan data sebagai format JSON
            echo json_encode(array(
                'status' => 'success',
                'data' => $menu_details
            ));
        } else {
            // Jika menu tidak ditemukan
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Menu tidak ditemukan'
            ));
        }

        // Menutup statement
        $stmt->close();
    } else {
        // Error pada query
        echo json_encode(array(
            'status' => 'error',
            'message' => 'Error saat mempersiapkan query'
        ));
    }
} else {
    // Jika ID menu tidak diberikan
    echo json_encode(array(
        'status' => 'error',
        'message' => 'ID menu tidak diberikan'
    ));
}

// Menutup koneksi ke database
$conn->close();
?>
