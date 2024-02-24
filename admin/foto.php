<?php
    session_start();
    include '../config/koneksi.php';
    if ($_SESSION['status'] != 'login' ){
        echo "<script>alert('anda belum login');
        location.href='../index.php';</script>";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <title>Web Galeri Foto</title>
</head>

<body>
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container">
            <a class="navbar-brand" href="index.php">WEB Galeri Foto</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse mt-2" id="navbarNavAltMarkup">
                <div class="navbar-nav me-auto">
                    <a href="galeri.php" class="nav-link">Galeri</a>
                    <a href="album.php" class="nav-link">Album</a>
                    <a href="foto.php" class="nav-link">Foto</a>
                </div>
                <a href="../config/aksi_logout.php" class="btn btn-danger m-1">Keluar</a>
            </div>
        </div>
    </nav>
    <!-- content -->
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card mt-2">
                    <div class="card-header">Tambah Foto</div>
                    <div class="card-body">
                        <form action="../config/aksi_foto.php" method="POST" enctype="multipart/form-data" >
                            <label for="" class="form-label">Judul Foto</label>
                            <input type="text" name="JudulFoto" class="form-control" required>
                            <label for="" class="form-label">Deskripsi</label>
                            <textarea name="DeskripsiFoto" class="form-control" required></textarea>
                            <label class="form-label">Album</label>
                            <select name="AlbumID" class="form-control" required>
                                <?php
                                    $sql_album = mysqli_query($koneksi, "SELECT * FROM album WHERE userid='$userid'");
                                    while($data_album = mysqli_fetch_array($sql_album)){ ?>
                                        <option value="<?php echo $data_album['AlbumID'] ?>"><?php echo $data_album['namaalbum'] ?></option>
                                    <?php }  
                                ?>
                            </select>
                            <label for="" class="form-label">File</label>
                            <input type="file" name="LokasiFile" class="form-control" required>
                            <button class="btn btn-primary mt-2" name="tambah" type="submit" >Tambah Data</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card mt-2">
                    <div class="card-header">Data Album</div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Foto</th>
                                    <th>Judul Foto</th>
                                    <th>Deskripsi</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $no = 1;
                                    $userid = $_SESSION['userid'];
                                    $sql = mysqli_query($koneksi, "SELECT * FROM foto WHERE userid='$userid'");
                                    while ($data = mysqli_fetch_array($sql)) {
                                ?>
                                <tr>
                                    <td><?php echo $no++ ?></td>
                                    <td><img src="../assets/img/<?php echo $data['LokasiFile'] ?>" width="100" ></td>
                                    <td><?php echo $data['JudulFoto'] ?></td>
                                    <td><?php echo $data['DeskripsiFoto'] ?></td>
                                    <td><?php echo $data['TanggalUnggah'] ?></td>
                                    <td>
                                        <!-- Button edit-->
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit<?php echo $data['FotoID'] ?>">
                                        Edit
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="edit<?php echo $data['FotoID'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="../config/aksi_foto.php" method="POST" enctype="multipart/form-data" >
                                                    <input type="hidden" name="FotoID" value="<?php echo $data['FotoID'] ?>" >
                                                    <label for="" class="form-label">Judul Foto</label>
                                                    <input type="text" name="JudulFoto" value="<?php echo $data['JudulFoto'] ?>" class="form-control">
                                                    <label for="" class="form-label" >Deskripsi</label>
                                                    <textarea name="DeskripsiFoto" class="form-control"><?php echo $data['DeskripsiFoto']; ?></textarea>
                                                    <label for="" class="form-label">Album</label>
                                                    <select name="AlbumID" class="form-control">
                                                        <?php
                                                            $sql_album = mysqli_query($koneksi, "SELECT * FROM album WHERE userid='$userid'");
                                                            while($data_album = mysqli_fetch_array($sql_album)){ ?>
                                                                <option <?php if($data_album['AlbumID'] == $data['AlbumID'] ) {
                                                                    ?> selected= "selected" <?php
                                                                } ?> value="<?php echo $data_album['AlbumID'] ?>"><?php echo $data_album['namaalbum'] ?></option>
                                                            <?php }  
                                                        ?>
                                                    </select>
                                                    <label for="" class="form-label">Foto</label>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <img src="../assets/img/<?php echo $data['LokasiFile'] ?>" width="100" >
                                                        </div>
                                                        <div class="col-md-8">
                                                            <label for="" class="form-label">Ganti File</label>
                                                            <input type="file" name="LokasiFile" class="form-control">
                                                        </div>
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                            <button class="btn btn-primary mt-2" name="edit" type="submit" >Simpan Data</button>
                                            </form>
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapus<?php echo $data['FotoID'] ?>">
                                        Hapus
                                        </button>
                                        <div class="modal fade" id="hapus<?php echo $data['FotoID'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="../config/aksi_foto.php" method="post">
                                                    <input type="hidden" name="FotoID" value="<?php echo $data['FotoID'] ?>" > 
                                                    Apakah anda yakin ingin menghapus data   <strong><?php echo $data['JudulFoto'] ?></strong> ?    
                                            </div>
                                            <div class="modal-footer">
                                            <button class="btn btn-danger mt-2" name="hapus" type="submit" >Hapus Data</button>
                                            </form>
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr>
    <footer class="d-flax justify-content-center border-top mt-3 bg-light fixed-bottom">
        <div class="container" style="text-align: center;">
            <p> UKK RPL 2024 || Ali Abdul Rokhim</p>
        </div>
    </footer>

    <script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>

</body>

</html>