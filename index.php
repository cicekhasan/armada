<?php
require_once 'core/init.php';

if (Session::varsa('basari')) {
  echo Session::flash('basari');
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <title>PDO</title>
  <style type="text/css" media="screen">
    ul { list-style: none outside none; }
    li { position: relative; display: inline; margin: 10px; }
  </style>
</head>
<body>
  <small>
    <ul>
      <li><a href="index.php">Anasayfa</a></li>
      <li><a href="uye_ol.php">Üye Ol</a></li>
      <li><a href="profil.php">Profil</a></li>
      <li><a href="sifre_degistir.php">Şifre Değiştir</a></li>
      <li><a href="giris.php">Giriş</a></li>
      <li><a href="cikis.php">Çıkış</a></li>
    </ul> 
  </small>  
  <p>
    <?php
    echo "MERHABA ANASAYFA <br />"; 
    ?>
  </p>
</body>
</html>
