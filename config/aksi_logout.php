<?php
session_start();
session_destroy();
echo "<script>
    alert('LogOut Berhasil');
    location.href='../index.php';
    </script>";
?>