<?php
require_once 'core/init.php';

if (Input::varsa()) {
	if (Token::kontrol(Input::getir('token'))) {
		$onaylama = new Onaylama();
		$onaylama = $onaylama->kontrol($_POST, array(
			'kullanici_adi' => array('zorunlu' => true),
			'parola'        => array('zorunlu' => true)
		));
		if ($onaylama->tamam()) {
			$kullanici = new Kullanici();
			$giris = $kullanici->giris(Input::getir('kullanici_adi'), Input::getir('parola'));
			echo "Giriş işlemi başarılı...";
		}else{
			foreach ($onaylama->hatalar() as $hata) {
				echo $hata, '<br />';
			}
		}
	}
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
	<meta charset="UTF-8">
	<title>Giriş</title>
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
    <?php echo "GİRİŞ SAYFASI <br />"; ?>
  </p>
  <form action="" method="POST">
    <div class="alan">
     <label for="kullanici_adi">Kullanıcı Adı:</label>
     <input type="text" name="kullanici_adi" id="kullanici_adi" autocomplate="off">
   </div>
   <div class="alan">
     <label for="parola">Parola:</label>
     <input type="password" name="parola" id="parola" autocomplate="off">
   </div>
		<!--
		<div class="alan">
			<label for="hatirla">Beni Hatırla:</label>
			<input type="checkbox" name="hatirla" id="hatirla" autocomplate="off">
		</div>
	  -->
	<input type="hidden" name="token" value="<?php echo Token::tokenOlustur(); ?>">
	<input type="submit" value="Giriş Yap">
</form>
</body>
</html>
