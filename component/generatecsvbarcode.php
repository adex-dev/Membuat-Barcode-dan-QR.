<?php
require '../vendor/autoload.php';
if (isset($_POST['upload'])) {
    $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
    if ($_FILES['csvFile']['error'] === UPLOAD_ERR_OK) {
        $path = '../src/barcode/';
        $targetFile = $path . basename($_FILES['csvFile']['name']);
        $fileType = pathinfo($targetFile, PATHINFO_EXTENSION);

        if ($fileType === 'csv') {
            if (move_uploaded_file($_FILES['csvFile']['tmp_name'], $targetFile)) {
                // Proses file CSV
                $csvData = array_map('str_getcsv', file($targetFile));
                $header = array_shift($csvData); // mengabaikan header
                $path = '../src/barcode/';
                foreach ($csvData as $row) {
                    $data = $row[0]; // Ganti indeks sesuai dengan kolom 1 CSV
                    $name = $row[1]; // Ganti indeks sesuai dengan kolom 2 CSV
                    if (!empty($data) and !empty($name)) {
                        $filename = $name . '.png';
                        $barcode = $generator->getBarcode($data, $generator::TYPE_CODE_128);
                        // Buat gambar barcode dari data string
                        $im_barcode = imagecreatefromstring($barcode);
                        $barcode_width = imagesx($im_barcode);
                        $barcode_height = imagesy($im_barcode);
                        $namafile =$name;
                        $ukuran = 11.5;
                        if (strlen($namafile) <= 17) { //maximal string
                            $ukuran = 12;
                        }
                        // Buat gambar teks
                        $im_text = imagecreatetruecolor($barcode_width, 40); // Sesuaikan ukuran teks
                        $background = imagecolorallocate($im_text, 255, 255, 255); // Latar belakang putih
                        $textColor = imagecolorallocate($im_text, 0, 0, 0); // Teks hitam
                        $barcodeText = $namafile; // Ganti dengan teks yang Anda inginkan
                        $font = './Poppins-Bold.ttf'; // Ganti dengan path font yang sesuai
                        $fontSize = $ukuran;

                        // Tambahkan latar belakang putih pada gambar teks
                        imagefill($im_text, 0, 0, $background);

                        // Tambahkan teks ke gambar teks
                        imagettftext($im_text, $fontSize, 0, 0, 14, $textColor, $font, $barcodeText);
                        $text_width = imagesx($im_text) + 20;

                        // Dimensi dan margin gambar barcode
                        $barcode_margin_left = 6;
                        $barcode_margin_right = 6;
                        $barcode_margin_top = 2;
                        $barcode_margin_bottom = 0;
                        $barcode_new_width = 200;
                        $barcode_new_height = 90;

                        // Buat gambar kosong untuk menggabungkan gambar barcode dan gambar teks
                        $combined_width = $barcode_new_width + $barcode_margin_left + $barcode_margin_right;
                        $combined_height = $barcode_new_height + $barcode_margin_top + $barcode_margin_bottom + imagesy($im_text);

                        $im_combined = imagecreatetruecolor($combined_width, $combined_height);

                        // Tambahkan latar belakang putih pada gambar gabungan
                        imagefill($im_combined, 0, 0, $background);

                        // Hitung posisi y untuk teks agar berada persis di bawah barcode
                        $text_y = $barcode_new_height + $barcode_margin_top + imagesy($im_barcode) - 20 + $barcode_margin_bottom;
                        $text_x = 10;
                        // Gabungkan gambar barcode dan gambar teks dengan margin dan dimensi baru
                        $im_barcode_resized = imagecreatetruecolor($barcode_new_width, $barcode_new_height);
                        imagecopyresampled($im_combined, $im_barcode, $barcode_margin_left, $barcode_margin_top, 0, 0, $barcode_new_width, $barcode_new_height, $barcode_width, $barcode_height);
                        imagecopy($im_combined, $im_text, $text_x, $text_y, 0, 0, imagesx($im_text), imagesy($im_text));

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
                header("Location: ../barcode.php"); //mengembalikan kehalaman barcode
            } else {
                header("Location: ../barcode.php");
            }
        } else {
            header("Location: ../barcode.php");
        }
    } else {
        header("Location: ../barcode.php");
    }
}
