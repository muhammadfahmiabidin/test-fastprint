<?php
$host = "localhost";
$user = "root";
$psw = "";
$db = "fast_print";

$koneksi = mysqli_connect($host,$user,$psw,$db);
if(!$koneksi){
    die("tidak terhubung dengan database");
}
// else{
//     echo("sukses terkoneksi dengan database");
// }

$id = 0;
$produk = "";
$harga = 0;
$kategori = "";
$status = "";

$berhasil = "";
$gagal = "";
?>