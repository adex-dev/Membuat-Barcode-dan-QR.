<?php
include '../phpqrcode/qrlib.php';
if (isset($_POST['upload'])) {
    if ($_FILES['csvFile']['error'] === UPLOAD_ERR_OK) {
        $path ='../src/qr/';
        $targetFile = $path . basename($_FILES['csvFile']['name']);
        $fileType = pathinfo($targetFile, PATHINFO_EXTENSION);

        if ($fileType === 'csv') {
            if (move_uploaded_file($_FILES['csvFile']['tmp_name'], $targetFile)) {
               // Process the CSV file
                $csvData = array_map('str_getcsv', file($targetFile));
                $header = array_shift($csvData);  // skip header
                foreach ($csvData as $row) {
                    $data = $row[0]; // Replace index according to column 1 of CSV
                    $name = $row[1]; // Replace index according to column 2 of CSV
                    if (!empty($data) AND !empty($name) ) {
                        $filename = $name . '.png';
                        $qr = QRcode::png($data, $path . $filename,$errorCorrectionLevel, 4);
                        // Buat gambar barcode dari data string
                        $im_barcode = imagecreatefrompng($path . $filename);
                        $barcode_width = imagesx($im_barcode);
                        $barcode_height = imagesy($im_barcode)-11;
                    
                        // Buat gambar teks
                        $im_text = imagecreatetruecolor($barcode_width, 50); // Adjust text size
                        $background = imagecolorallocate($im_text, 255, 255, 255);  // White background
                        $textColor = imagecolorallocate($im_text, 0, 0, 0);// Black text
                        $barcodeText = $_POST['namafile'];// Replace with the text you want
                        $font = './Poppins-Bold.ttf'; // Replace with appropriate font path
                        $fontSize = 12;
                    
                         // Add a white background to the text image
                        imagefill($im_text, 0, 0, $background);
                    
                        // Tambahkan teks ke gambar teks
                        imagettftext($im_text, $fontSize, 0, 0, 12, $textColor, $font, $barcodeText);
                        $text_width = imagesx($im_text);
                    
                        // Buat gambar kosong untuk menggabungkan gambar barcode dan gambar teks
                        $combined_width = $barcode_width;
                        $combined_height = $barcode_height + imagesy($im_text)-30; // Tambahkan nilai padding bawah di sini
                        $im_combined = imagecreatetruecolor($combined_width, $combined_height);
                    
                        // Tambahkan latar belakang putih pada gambar gabungan
                        imagefill($im_combined, 0, 0, $background);
                    
                        // Hitung posisi y untuk teks agar berada persis di bawah QR code
                        $text_y = $barcode_height; // Tambahkan nilai padding bawah di sini
                        $text_x = 20; 
                    
                        // Gabungkan gambar barcode dan gambar teks dengan padding
                        imagecopy($im_combined, $im_barcode, 0, 0, 0, 0, $barcode_width, $barcode_height);
                        imagecopy($im_combined, $im_text,$text_x, $text_y, 0, 0,$text_width, imagesy($im_text));
                    
                        // Simpan gambar yang telah digabungkan
                        imagepng($im_combined, $path . $filename);
                        imagedestroy($im_barcode);
                        imagedestroy($im_text);
                        imagedestroy($im_combined);
                    }
                }
                // Hapus file setelah selesai
                unlink($targetFile);
                sleep(3);  //3 detik waktu tunggu
                header("Location: ../index.php");  //mengembalikan kehalaman index
            } else {
                header("Location: ../index.php");
            }
        } else {
            header("Location: ../index.php");
        }
    } else {
        header("Location: ../index.php");
    }
}
