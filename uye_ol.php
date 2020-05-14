<?php
require_once 'core/init.php';

if (Input::varsa()) {
  if (Token::kontrol(Input::getir('token'))) {

    $onaylama = new Onaylama();
    $onaylama = $onaylama->kontrol($_POST, array(
      'kullanici_adi' => array(
        'zorunlu'   => true,
        'min'       => 3,
        'max'       => 20,
        'benzersiz' => 'uyeler'
      ),
      'parola'        => array(
        'zorunlu'   => true,
        'min'       => 6
      ),
      'parola_tekrar' => array(
        'zorunlu'   => true,
        'min'       => 6,
        'eslesme'   => 'parola'
      ),
      'isim'          => array(
        'zorunlu'   => true,
        'min'       => 3,
        'max'       => 50
      )
    ));

    if ($onaylama->tamam()) {
      $kullanici = new Kullanici();
      $kullanici_adi = Input::getir('kullanici_adi');
      $salt          = Hash::salt(32);
      $salt          = bin2hex($salt);
      $parola        = Hash::yap(Input::getir('parola'), $salt);
      $isim          = Input::getir('isim');
      $tarih         = date('g-m-Y H:i:s');
      $parola        = Hash::yap(Input::getir('parola'), $salt);

      $kullanici->olustur(array(
        'kullanici_adi' => Input::getir('kullanici_adi'),
        'parola'        => Hash::yap(Input::getir('parola'), $salt),
        'salt'          => $salt,
        'isim'          => Input::getir('isim'),
        'uyelik_tarihi' => $tarih,
        'grup'          => '1'   
      ));

      Session::flash('basari', 'Başarılı bir şekilde üye oldunuz!');
        //header('Location: index.php');
      Yonlendir::yon('index.php');

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
	<title>Document</title>
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
  <p> <?php echo "ÜYE OL SAYFASI <br />"; ?> </p>
  <form action="" method="post">
    <div class="alan">
      <label for="kullanici_adi">Kullanıcı Adı</label>
      <input type="text" name="kullanici_adi" id="kullanici_adi" value="<?php echo filtrele(Input::getir('kullanici_adi')); ?>" autocomplate="off">
    </div>
    <div class="alan">
      <label for="parola">Parola</label>
      <input type="password" name="parola" id="parola">
    </div>
    <div class="alan">
      <label for="parola_tekrar">Parola Tekrarı</label>
      <input type="password" name="parola_tekrar" id="parola_tekrar">
    </div>
    <div class="alan">
      <label for="isim">Adı ve Soyadı</label>
      <input type="hidden" name="token" value="<?php echo Token::olustur(); ?>">
      <input type="text" name="isim" id="isim" value="<?php echo filtrele(Input::getir('isim')); ?>">
    </div>
    <input type="submit" value="Üye Ol">
  </form>
</body>
</html>
