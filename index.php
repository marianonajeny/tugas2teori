<?php
$host   ="localhost";
$user   ="root";
$pass   ="";
$db     ="vendor";

$koneksi = mysqli_connect($host,$user,$pass,$db);
if(!$koneksi){//cek koneksi
die("tidak bisa terkoneksi ke database");
}
$kode              = "";
$alamat            = "";
$namaperusahan     = "";
$keterangan        = "";
$sukses            = "";
$error             = "";

if(isset($_GET['op'])){
  $op = $_GET['op'];
}else{
  $op = "";
}
if($op == 'delete'){
  $id   = $_GET['id'];
  $sql1 = "delete from data vendor where id = '$id'";
  $sq1  = mysqli_query($koneksi,$sql1);
}
if($op == 'edit' ){
  $id             = $_GET['id'];
  $sql1           = "select * from datavendor where id = '$id'";
  $q1             = mysqli_query($koneksi,$sql1);
  $r1             = mysqli_fetch_array($q1);
  $kode           = $r1['kode'];
  $alamat         = $r1['alamat'];
  $namaperusahan  = $r1['namaperusahan'];
  $keterangan     = $r1['keterangan'];

  if($kode == ''){
    $error = "data tidak ditemukan";
  }
}

if(isset($_POST['simpan'])){ //untuk create
    $kode                 = $_POST['kode'];
    $alamat               = $_POST['alamat'];
    $namaperusahan        = $_POST['namaperusahan'];
    $keterangan           = $_POST['keterangan'];
  
    if($kode && $alamat && $namaperusahan && $keterangan){
      if($op == 'edit'){ //untuk update
        $sql1   = "update datavendor set kode ='$kode', alamat= '$alamat', namaperusahan='$namaperusahan', keterangan='$keterangan' where id = '$id'";
        $q1     = mysqli_query($koneksi,$sql1);
        if($q1){
          $sukses = "data berhasil diupdate";
        }else{
          $error  = "data gagal di update";
        }
      }else{ //untuk insert
        $sql1 = "insert into datavendor(kode,alamat,namaperusahan,keterangan) values ('$kode','$alamat','$namaperusahan','$keterangan')";
        $q1   = mysqli_query($koneksi,$sql1);
        if($q1){
            $sukses   = "berhasil memasukan data baru";
        }else{
            $error    = "gagal memasukan data";
        }
      }
    }else{
    $error   = "silakan masukan semua data";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>data vendor</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        .mx-auto {
          width:800px 
        }
        .card {
          margin-top: 10px;
        }
    </style>
</head>
<body>
    <!--untuk memasukan data-->
    <div class="max-auto">
    <div class="card">
  <div class="card-header text-white bg-info">
    masukan data vendor
  </div>
  <div class="card-body">
    <?php
     if($error){
        ?>
          <div class="alert alert-danger" role="alert">
          <?php echo $error ?>
    </div>
    <?php
      header("refresh:5;url=index.php"); //5 adalah detik
     }
    ?>

     <?php
     if($sukses){
        ?>
          <div class="alert alert-success" role="alert">
          <?php echo $sukses ?>
    </div>
    <?php
     header("refresh:5;url=index.php");
     }
    ?>
    <form action="" method="POST">
    <form>
       <div class="mb-3 row">
         <label for="kode" class="col-sm-2-form-label">kode</label>
         <div class="col-sm-10">
         <input type="text" class="form-control" id="kode" name="kode" value="<?php echo $kode ?>">
  </div>
  </div>
  <div class="mb-3 row">
         <label for="alamat" class="col-sm-2-form-label">alamat</label>
         <div class="col-sm-10">
         <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $alamat ?>">
  </div>
  </div>
  <div class="mb-3 row">
         <label for="namaperusahan" class="col-sm-2-form-label">namaperusahan</label>
         <div class="col-sm-10">
         <input type="text" class="form-control" id="namaperusahan" name="namaperusahan" value="<?php echo $namaperusahan ?>">
  </div>
  </div>
  <div class="mb-3 row">
         <label for="keterangan" class="col-sm-2-form-label">keterangan</label>
         <div class="col-sm-10">
        <select class="form-control" name="keterangan" id="keterangan">
            <option value="">pilih keterangan</option>
            <option value="baik"                 <?php if ($keterangan == "baik") echo "selected"?>>baik</option>
            <option value="tidak ada keterangan" <?php if ($keterangan == "tidak ada keterangan") echo "selected"?>>tidak ada keterangan</option>
        </select>
  </div>
  </div>
   <div class="col-12">
    <input type="submit" name="simpan" value="simpan data" class="btn-btn-primary">
   </div>
    </form>

    </form>
</div>
    </div>

    <!--untuk mengeluarkan data-->
    <div class="card">
  <div class="card-header text-white bg-dark">
   datavendor
  </div>
  <div class="card-body">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">kode</th>
          <th scope="col">alamat</th>
          <th scope="col">namaperusahan</th>
          <th scope="col">keterangan</th>
          <th scope="col">Aksi</th>
        </tr>
        <tbody>
          <?php
          $sql2  = "select * from datavendor order by id desc";
          $q2    = mysqli_query($koneksi,$sql2);
          $surut = 1;
          while($r2 = mysqli_fetch_array($q2)){
          $id            = $r2['id'];
          $kode          = $r2['kode'];
          $alamat        = $r2['alamat'];
          $namaperusahan = $r2['namaperusahan'];
          $keterangan    = $r2['keterangan'];

          ?>

          <tr>
            <th scope="row"><?php echo $surut++ ?></th>
            <td scope="row"><?php echo $kode?></td>
            <td scope="row"><?php echo $alamat?></td>
            <td scope="row"><?php echo $namaperusahan?></td>
            <td scope="row"><?php echo $keterangan?></td>
            <td scope="row">
              <a href="index.php?op=edit&id=<?php echo $id?>"><button type="button" class="btn btn-warning">edit</button></a>
              <a href="index.php?op=delete&id=<?php echo $id?>" onclick="return confirm('yakin mau delete data?')"><button type="button" class="btn btn-danger">delete</button></a>
          </td>
          </tr>
          <?php
          }
          ?> 
        </tbody>
      </thead>
    </table>
    </div>
        </div>
        </div>
</body>
</html>