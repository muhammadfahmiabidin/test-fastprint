<?php
require_once('konekDB.php');

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://recruitment.fastprint.co.id/tes/api_tes_programmer',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('username' => 'tesprogrammer','password' => '463c11c20c54be3e9dcc1466193b18a0'),
  CURLOPT_HTTPHEADER => array(
    'Cookie: ci_session=h3q60hpm4rlagioqk746dtnu8pe7qqr3'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
// echo $response;

$resDecode = json_decode($response, true);// digunakan untuk decode json data yang diambil dari api

foreach ($resDecode['data'] as $dataJson) { //karena didalamnya ada dua yaitu error dan data jadi saya mengambil hanya datanya saja
    foreach ($dataJson as $key=>$value) {//untuk mengambil data dan dimasukan kemasing-masing variabe;l yang nantinya digunakan untuk insert ke database 
        if ($key =='id_produk') {
            $id = $value;
        }
        if ($key =='nama_produk') {
            $produk = $value;
        }
        if ($key =='harga') {
            $harga = $value;
        }
        if ($key =='kategori') {
            $kategori = $value;
        }
        if ($key =='status') {
            $status = $value;
        }

        $insertDB = "INSERT INTO fast_print (id_produk, nama_produk, harga, kategori, status) VALUES ('$id','$produk','$harga','$kategori','$status' )";
        $sql_insertDB = mysqli_query($koneksi,$insertDB);   // sql untuk insertnya
    }
}
?>