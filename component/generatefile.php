<?php
include '../phpqrcode/qrlib.php';
if (isset($_POST['idproduct'])) {
// The data you want to include in the QR code
    $data = $_POST['idproduct'];

  // The name of the QR code file (in this case, "qrcode.png")
    $filename = $_POST['namafile'] . '.png';

 // Configure the QR code
    $size = 35; // Size QR code
    $errorCorrectionLevel = 'H'; // Error correction code (L, M, Q, H)

    // Generate QR code
    $path = '../src/qr/';;
    // Save the QR code image into a file
    $qr = QRcode::png($data, $path . $filename,$errorCorrectionLevel, 4);
    // Create Image QR from Path
    $im_qr = imagecreatefrompng($path . $filename);
    $qr_width = imagesx($im_qr);
    $qr_height = imagesy($im_qr)-11;

 // Create a text image
    $im_text = imagecreatetruecolor($qr_width, 50); // Adjust text size
    $background = imagecolorallocate($im_text, 255, 255, 255); // White background
    $textColor = imagecolorallocate($im_text, 0, 0, 0); // Black text
    $qrText = $_POST['namafile'];  // Replace with the text you want
    $font = './Poppins-Bold.ttf'; // Replace with appropriate font path
    $fontSize = 12;

    // Add a white background to the text image
    imagefill($im_text, 0, 0, $background);

 // Add text to the text image
    imagettftext($im_text, $fontSize, 0, 0, 12, $textColor, $font, $qrText);
    $text_width = imagesx($im_text);

  // Create an empty image to combine the barcode image and text image
    $combined_width = $qr_width;
    $combined_height = $qr_height + imagesy($im_text)-30; // Tambahkan nilai padding bawah di sini
    $im_combined = imagecreatetruecolor($combined_width, $combined_height);

     // Add a white background to the merged image
    imagefill($im_combined, 0, 0, $background);

     // Compute the y position for the text to be just below the barcode
    $text_y = $qr_height;
    $text_x = 20;  //text padding left 

        // Combine barcode image and text image with new margins and dimensions
    imagecopy($im_combined, $im_qr, 0, 0, 0, 0, $qr_width, $qr_height);
    imagecopy($im_combined, $im_text,$text_x, $text_y, 0, 0,$text_width, imagesy($im_text));

      // Save the merged image
    imagepng($im_combined, $path . $filename);
    imagedestroy($im_qr);
    imagedestroy($im_text);
    imagedestroy($im_combined);
    header("Location: ../index.php");
} else {
    header("Location: ../index.php");
}
?>