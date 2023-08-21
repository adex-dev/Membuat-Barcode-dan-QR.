<?php
$path = '../src/barcode/';

if (isset($_GET['download'])) {
    $filename = $_GET['filename'];
    $file = $path . $filename;

    if (file_exists($file) && pathinfo($file, PATHINFO_EXTENSION) === 'png') {
         // Specify the file content type.
        // Set header to allow download
        header("Content-Type: image/png");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Length: " . filesize($file));

           // Read the file and send its contents to the output
        readfile($file);

        // Delete the file once it has been successfully downloaded
        unlink($file);
        sleep(3);
    } else {
        header("Location: ../index.php" );
    }
} else {
    header("Location: ../index.php" );
}
?>
