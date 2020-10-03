<?php
    //db connection
    $conn = mysqli_connect(
        $server = "localhost",
        $user = "root",
        $password = "",
        $database = "arkademy"
    )or die(mysqli_error($conn));

    if(isset($_POST['add'])) {

        // update
        if($_GET['page'] == "edit") {
            $update = mysqli_query($conn, "UPDATE produk set
                                           nama_produk = '$_POST[nama_produk]',
                                           keterangan  = '$_POST[keterangan]',
                                           harga       = '$_POST[harga]',
                                           jumlah      = '$_POST[jumlah]' WHERE id='$_GET[id]'
                                           ");
            if($update) {
                echo "<script>
                        alert('Update Success');
                        document.location = 'index.php';
                     </script>";
            } else {
                echo "<script>
                        alert('Update Failed');
                        document.location = 'index.php';
                     </script>";
            };
        } 
        
        // create
        else {
            $add = mysqli_query($conn, "INSERT INTO produk (nama_produk, keterangan, harga, jumlah) 
                                        VALUE ('$_POST[nama_produk]',
                                               '$_POST[keterangan]',
                                               '$_POST[harga]',
                                               '$_POST[jumlah]')
                                        ");
            if($add) {
                echo "<script>
                        alert('Done');
                        document.location = 'index.php';
                     </script>";
            } else {
                echo "<script>
                        alert('Failed');
                        document.location = 'index.php';
                     </script>";
            };
        }

    };

    //Show data on form field when edit clicked
    if(isset($_GET['page'])) {
        if($_GET['page'] == "edit") {
            $get = mysqli_query($conn, "SELECT * FROM produk WHERE id=$_GET[id]");
            $data = mysqli_fetch_array($get);
            if($data) {
                $nama_produk = $data['nama_produk'];
                $keterangan  = $data['keterangan'];
                $harga       = $data['harga'];
                $jumlah      = $data['jumlah'];
            };
        }
        elseif($_GET['page'] == "delete") {
            $delete = mysqli_query($conn, "DELETE FROM produk WHERE id='$_GET[id]'") ;
        }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arkademy</title>

     <!-- bootstrap -->
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="container mt-5">
                    <!-- Awal card form -->
                    <div class="card">
                        <div class="card-header bg-dark text-white text-center">
                            Tambah Produk
                        </div>
                        <div class="card-body">
                        <form method="POST">
                            <div class="form-group">
                                <label for="nama_produk">Nama Produk</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="nama_produk" 
                                       name="nama_produk" 
                                       value="<?=@$nama_produk?>"
                                       required>
                            </div>
                            <div class="form-group">
                                <label for="keterangan">Keterangan</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="keterangan" 
                                       name="keterangan" 
                                       value="<?=@$keterangan?>"
                                       required>
                            </div>
                            <div class="form-group">
                                <label for="harga">Harga</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="harga" 
                                       name="harga"
                                       value="<?=@$harga?>" 
                                       required>
                            </div>
                            <div class="form-group">
                                <label for="jumlah">Jumlah</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="jumlah" 
                                       name="jumlah"
                                       value="<?=@$jumlah?>" 
                                       required>
                            </div>
                            <button type="submit" class="btn btn-success" name="add">Save</button>
                        </form>
                        </div>
                    </div>
                    <!-- Akhir card form -->
                </div>
            </div>
            <div class="col">
                <div class="container mt-5">
                    <!-- Awal card table -->
                    <div class="card">
                        <div class="card-header bg-dark text-white text-center">
                            Daftar Product Arkademy
                        </div>
                        <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>Nama Produk</th>
                                <th>Keterangan</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Aksi</th>
                            </tr>
                            <?php
                                $get = mysqli_query($conn, "SELECT * FROM produk");
                                while($data = mysqli_fetch_array($get)):
                            ?>
                            <tr>
                                <td><?=$data['nama_produk'] ?></td>
                                <td><?=$data['keterangan'] ?></td>
                                <td><?=$data['harga'] ?></td>
                                <td><?=$data['jumlah'] ?></td>
                                <td>
                                    <a href="index.php?page=edit&id=<?=$data['id']?>" 
                                       class="btn btn-warning text-white">Edit</a>
            
                                    <a href="index.php?page=delete&id=<?=$data['id']?>" 
                                       class="btn btn-danger text-white" id="btn-delete"
                                       onclick="return confirm('Sure?')">Delete</a>
                                </td>
                            </tr>
                            <?php endwhile ?>
                        </table>
                    </div>
                    <!-- Akhir card table -->
                </div>
            </div>
        </div>
    </div>


    <!-- bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

</body>
</html>