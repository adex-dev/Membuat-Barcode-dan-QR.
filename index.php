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
                <h1>Buat Generate File Qr</h1>
                <div class="d-flex">
                <a href="barcode.php" class="btn btn-info mx-2">Buat Barcode</a>
                <a href="uploadcsv.php" class="btn btn-info mx-2">Via Upload QR</a>
                <a href="uploadcsvbarcode.php" class="btn btn-info mx-2">Via Upload BARCODE</a>
                </div>
                <form method="POST" action="./component/generatefile.php" class="w-100 " autocomplete="off">
                    <div class="mb-3 ">
                        <label for="idproduct" class="form-label">Id Product</label>
                        <input required type="text" name="idproduct" class="form-control" id="idproduct" placeholder="Masukan id product">
                    </div>
                    <div class="mb-3">
                        <label for="namafile" class="form-label">Nama File</label>
                        <input required type="text" maxlength="17" name="namafile" class="form-control" id="namafile" placeholder="Masukan nama File">
                        <span>Maximum 17 characters, more will be truncated</span>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Generate</button>
                </form>
            </div>
            <div class="col-12  mt-5">
                <hr>
                <h1>Hasil Generate File Barcode</h1>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">File</th>
                            <th scope="col">Download</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $path = 'src/qr/'; // Specify the folder path
                        $files1 = array_slice(scandir($path), 2);
                        $no=1;
                        foreach ($files1 as $rs) {
                            if (str_contains($rs, '.png')) {
                        ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $rs ?></td>
                                    <td><a href="./component/downloadfile.php?download=1&filename=<?= $rs ?>" >download</a></td>
                                </tr>
                        <?php }
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>