<?php
session_start();
$userid = $_SESSION['userid'];
include '../config/koneksi.php';
if ($_SESSION['status'] != 'login') {
    echo "<script>alert('Anda Belum Login');location.href='../index.php'</script>";
}

//  echo $_SESSION['username'];
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Web galeri foto</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container">
            <a class="navbar-brand" href="../admin/galei.php">WEB Galeri Foto</a>
            <div class="collapse navbar-collapse mt-2" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="galeri.php">Galeri</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="album.php">Album</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="foto.php">Foto</a>
                    </li>
                </ul>
            </div>
            <a href="../config/aksi_logout.php" class="btn btn-danger m-1">Keluar</a>

        </div>
        </nav>
 
    <div class="container mt-3">
        Album :
        <?php
        $album = mysqli_query($koneksi, "SELECT * FROM album WHERE userid='$userid'");
        while ($row = mysqli_fetch_array($album)) { ?>
            <a href="galeri.php?albumid=<?php echo $row['AlbumID'] ?>" class="btn btn-outline-secondary"><?php echo $row['namaalbum'] ?></a>
        <?php } ?>

        <div class="row">
            <?php
            if (isset($_GET['albumid'])) {
                $albumid = $_GET['albumid'];
                $query = mysqli_query($koneksi, "SELECT * FROM foto WHERE userid='$userid' AND albumid='$albumid'");
                while ($data = mysqli_fetch_array($query)) { ?>
                    <div class="col-md-3 mt-2">
                        <div class="card">
                            <img src="../assets/img/<?= $data['LokasiFile'] ?>" class="card-img-top" title="" style="height: 12rem;" alt="">
                            <div class="card-footer text-center">
                                <?php
                                $fotoid = $data['FotoID'];
                                $ceksuka = mysqli_query($koneksi, "SELECT * FROM likefoto WHERE FotoID='$fotoid' AND UserID='$userid'");

                                if (mysqli_num_rows($ceksuka) == 1) { ?>
                                    <a href="../config/aksi_like.php?fotoid=<?= $data['fotoid'] ?>" type="submit" name="batalsuka"><i class="fa fa-heart"></i></a>
                                <?php } else { ?>
                                    <a href="../config/aksi_like.php<?= $data['FotoID'] ?>" type="submit" name="suka"><i class="fa-regular fa-heart"></i></a>
                                <?php }
                                $like = mysqli_query($koneksi, "SELECT * FROM likefoto WHERE FotoID='$fotoid'");
                                echo mysqli_num_rows($like) . ' Suka';
                                ?>
                                <a href="komentar.php?fotoid=<?= $data['FotoID'] ?>"><i class="fa-regular fa-comment"></i></a>Komentar
                            </div>
                        </div>
                        <br>
                    </div>
                <?php }
            } else {
                $sql = mysqli_query($koneksi, "SELECT * FROM foto WHERE userid='$userid'");
                while ($data = mysqli_fetch_array($sql)) {
                ?>
                    <div class="col-md-3 mt-2">
                        <div class="card">
                            <img src="../assets/img/<?= $data['LokasiFile'] ?>" class="card-img-top" title="" style="height: 12rem;" alt="">
                            <div class="card-footer text-center">
                                <?php
                                $fotoid = $data['FotoID'];
                                $ceksuka = mysqli_query($koneksi, "SELECT * FROM likefoto WHERE fotoid='$fotoid' AND userid='$userid'");
                                if (mysqli_num_rows($ceksuka) == 1) { ?>
                                    <a href="../config/aksi_like.php<?= $data['FotoID'] ?>" name="batalsuka"><i class="fa fa-heart"></i></a>
                                <?php } else { ?>
                                    <a href="../config/aksi_like.php<?= $data['FotoID'] ?>" name="suka"><i class="fa-regular fa-heart"></i></a>
                                <?php }
                                $like = mysqli_query($koneksi, "SELECT * FROM likefoto WHERE fotoid='$fotoid'");
                                echo mysqli_num_rows($like) . ' Suka';
                                ?>
                                <a href="komentar.php?fotoid=<?= $data['FotoID'] ?>"><i class="fa-regular fa-comment"></i></a> Komentar
                            </div>
                        </div>
                        <br>
                    </div>
            <?php }
            } ?>
        </div>
    </div>

    <footer class="d-flex justify-content-center border-top mt-3 bg-light fixed-bottom">
        <p> UKK RPL 2024 || Ali Abdul Rokhim</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>