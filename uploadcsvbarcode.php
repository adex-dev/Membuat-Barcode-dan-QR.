<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</head>

<body style="min-height: 100vh;">
    <div style="min-height: 100vh;" class="container mt-5">
        <div class="row w-100 d-flex justify-content-center align-items-center">
            <div class="col-12">
                <h1>Generate Barcode Via Upload</h1>
                <div class="d-flex">
                    <a href="index.php" class="btn btn-info mx-2">Buat QR</a>
                    <a href="barcode.php" class="btn btn-info mx-2">Buat Barcode</a>
                    <a href="uploadcsv.php" class="btn btn-info mx-2">Via Upload QR</a>
                    <a href="src/sampeldata.xlsx" download="" class="btn btn-info mx-2">Download Sampel</a>
                    <a href="index.php" class="btn btn-warning">Home</a>
                </div>
                <form method="POST" action="./component/generatecsvbarcode.php" enctype="multipart/form-data" class="w-100 " autocomplete="off">
                    <div class="mb-3 ">
                        <label for="csvFile" class="form-label">Upload File CSV</label>
                        <input accept=".csv" type="file" class="form-control form-control-sm" required id="csvFile" name="csvFile">
                    </div>
                    <button type="submit" name="upload" class="btn btn-primary w-100">Upload</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>