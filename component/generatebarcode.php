<?php
require '../vendor/autoload.php';

if (isset($_POST['idproduct'])) {
    $data = $_POST['idproduct'];
    $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
    $barcode = $generator->getBarcode($data, $generator::TYPE_CODE_128);

    $filename = $_POST['namafile'] . '.png';
    $path = '../src/barcode/';

    // Create barcode image from string data
    $im_barcode = imagecreatefromstring($barcode);
    $barcode_width = imagesx($im_barcode);
    $barcode_height = imagesy($im_barcode);
    $namafile =$_POST['namafile'];
    $ukuran = 11.5;
    if (strlen($namafile) <= 17) {
        $ukuran =12;
    }
   // Create a text image
    $im_text = imagecreatetruecolor($barcode_width, 40); // Adjust text size
    $background = imagecolorallocate($im_text, 255, 255, 255); // White background
    $textColor = imagecolorallocate($im_text, 0, 0, 0); // Black text
    $barcodeText =$namafile; // Replace with the text you want
    $font = './Poppins-Bold.ttf'; // Replace with appropriate font path
    $fontSize =$ukuran;
    
  // Add a white background to the text image
    imagefill($im_text, 0, 0, $background);

// Add text to the text image
    imagettftext($im_text, $fontSize, 0, 0, 14, $textColor, $font, $barcodeText);
    $text_width = imagesx($im_text)+20;

    // Dimensions and margins of the barcode image
    $barcode_margin_left = 6;
    $barcode_margin_right = 6;
    $barcode_margin_top = 2;
    $barcode_margin_bottom = 0;
    $barcode_new_width = 200;
    $barcode_new_height = 90;

   // Create an empty image to combine the barcode image and text image
    $combined_width = $barcode_new_width + $barcode_margin_left + $barcode_margin_right;
    $combined_height = $barcode_new_height + $barcode_margin_top + $barcode_margin_bottom + imagesy($im_text);

    $im_combined = imagecreatetruecolor($combined_width, $combined_height);

 // Add a white background to the merged image
    imagefill($im_combined, 0, 0, $background);

   // Compute the y position for the text to be just below the barcode
    $text_y = $barcode_new_height + $barcode_margin_top + imagesy($im_barcode)-20 + $barcode_margin_bottom;
    $text_x =10;  //text padding left 
    // Combine barcode image and text image with new margins and dimensions
    $im_barcode_resized = imagecreatetruecolor($barcode_new_width, $barcode_new_height);
    imagecopyresampled($im_combined, $im_barcode, $barcode_margin_left, $barcode_margin_top, 0, 0, $barcode_new_width, $barcode_new_height, $barcode_width, $barcode_height);
    imagecopy($im_combined, $im_text, $text_x, $text_y, 0, 0, imagesx($im_text), imagesy($im_text));

   // Save the merged image
    imagepng($im_combined, $path . $filename);
    imagedestroy($im_barcode);
    imagedestroy($im_text);
    imagedestroy($im_combined);
    header("Location: ../barcode.php");
} else {
    header("Location: ../barcode.php");
}
