<?php
require_once('konekDB.php');

// ===============================================================
    if (isset($_GET['ed'])) {
        $ed = $_GET['ed'];
    }
    else {
        $ed = '';
    }
// ================ EDIT DATA ========================
    if($ed =='edit'){
        $id = $_GET['id'];
        $lihat = "SELECT * FROM produk WHERE id_produk = '$id'";
        $sql_lihat = mysqli_query($koneksi,$lihat);
        $cekLihat = mysqli_fetch_array($sql_lihat);
        // echo $id;
        // echo $cekLihat['id_produk'];

        if ($cekLihat['id_produk'] == NULL || $cekLihat['id_produk'] != $id) {
            $gagal = "data tidak ditemukan";
        }else {
            $produk = $cekLihat['nama_produk'];
            $harga = $cekLihat['harga'];
            $kategori = $cekLihat['kategori'];
            $status = $cekLihat['status'];        
        }
    }
    // ================ HAPUS DATA ========================
    elseif ($ed =='hapus') {
        $id = $_GET['id'];
        $hapus = "DELETE FROM produk WHERE id_produk = '$id'";
        $sql_hapus = mysqli_query($koneksi,$hapus);
        if ($sql_hapus) {
            $berhasil = "Data Berhasil Dihapus";
        }else {
            $gagal = "Gagal Menghapus Data";
        }
    }

// =========== SIMPAN DATA KE DATABASE ==========
if (isset($_POST['simpan'])) {
    $produk = $_POST['produk'];
    $harga = $_POST['harga'];
    $kategori = $_POST['kategori'];
    $status = $_POST['status'];

    if ($produk && $harga && $kategori && $status) {
        
        if ($ed == "edit") {
            $update = "UPDATE produk SET nama_produk = '$produk',harga = '$harga', kategori = '$kategori', status = '$status' WHERE id_produk = '$id'";
                $sql_update = mysqli_query($koneksi,$update);
                if ($sql_update) {
                    $berhasil = "Data Berhasil Diupdate";
                }else {
                    $gagal = "Data Gagal Diupdate";
                }
        }else {
            $insert = "INSERT INTO produk (nama_produk, harga, kategori, status) VALUES ('$produk','$harga','$kategori','$status' )";
            $sql_insert = mysqli_query($koneksi,$insert);
            
            if ($sql_insert) {
                $berhasil = "berhasil ditambahkan";
            }else{
                $gagal = "belum berhasil";
            }    
        }
        
    }else{
        $gagal = "masukan data";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Junior Back End Fast Print</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="bootstrap.min.css">
    <script src="jquery.min.js"></script>
    <script src="bootstrap.min.js"></script>
</head>

<body>
    <?php
    if ($gagal) {
    ?>
    <div class="alert alert-danger" role="alert">
        <?php echo $gagal;  ?>
    </div>
    <?php }?>
    <?php
    if ($berhasil) {
    ?>
    <div class="alert alert-success" role="alert">
        <?php echo $berhasil;  ?>
    </div>
    <?php }?>
    <div class="container">
        <h1 class="text-center">TEST JUNIOR BACKEND FAST PRINT</h1>
        <form class="form-horizontal form-input" action="" method="POST">
            <div class="form-group">
                <label class="control-label col-sm-2" for="produk">Produk:</label>
                <div class="col-sm-4">
                    <input type="text" name="produk" class="form-control" id="produk" placeholder="Masukan Nama Produk"
                        value="<?php echo($produk);?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="harga">Harga:</label>
                <div class="col-sm-4">
                    <input type="number" name="harga" class="form-control" id="harga" pattern="[0-9]"
                        placeholder="Masukan Harga Produk" value="<?php echo($harga);?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="kategori">Kategori:</label>
                <div class="col-sm-4">
                    <input type="text" name="kategori" class="form-control" id="kategori"
                        placeholder="Masukan Kategori Produk" value="<?php echo($kategori);?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="status">Status:</label>
                <div class="col-sm-4">
                    <input type="text" name="status" class="form-control" id="status"
                        placeholder="Masukan Status Produk" value="<?php echo($status);?>">
                </div>
            </div>
            <div class="form-group">
                <label for="#" class="col-sm-2"></label>
                <div class="col-sm-4">
                    <button type="submit" name="simpan" class="btn btn-success" value="tambah data">Simpan</button>
                </div>
            </div>
        </form>

        <div class="container">
            <div class="row">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Nama produk</th>
                            <th>Harga</th>
                            <th>Kategori</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $read = "SELECT * FROM produk WHERE status = 'bisa dijual'";
                        $sql_read = mysqli_query($koneksi,$read);
                        
                    while($tampil = mysqli_fetch_array($sql_read)){
                        $id = $tampil['id_produk'];
                        $produk = $tampil['nama_produk'];
                        $harga = $tampil['harga'];
                        $kategori = $tampil['kategori'];
                        $status = $tampil['status'];
                        ?>
                        <tr>
                            <td><?php echo $id ?></td>
                            <td><?php echo $produk ?></td>
                            <td><?php echo $harga ?></td>
                            <td><?php echo $kategori ?></td>
                            <td><?php echo $status ?></td>
                            <td>
                                <a href="config.php?ed=edit&id=<?php echo $id ?>"><button type="submit" name="edit"
                                        class="btn btn-warning">Edit</button></a>
                                <a href="config.php?ed=hapus&id=<?php echo $id ?>"
                                    onclick="return confirm('Data Yang Anda Pilih Akan Dihapus, Apakah Anda Yakin?')">
                                    <button type="submit" name="hapus" class="btn btn-danger">Hapus</button></a>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

</body>

</html>