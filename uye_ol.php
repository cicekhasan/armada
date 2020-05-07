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
				'parola' => array(
					'zorunlu' => true,
					'min'     => 6
				),
				'parola_tekrar' => array(
					'zorunlu' => true,
					'eslesme' => 'parola'
				),
				'isim' => array(
					'zorunlu' => true,
					'min'     => 3,
					'max'     => 50
				)
			));

			if ($onaylama->tamam()) {

				$kullanici = new Kullanici();
				$salt = Hash::salt(32);

				try{

					$kullanici->olustur(array(
						'kullanici_adi' => Input::getir('kullanici_adi'),
						'parola'        => Hash::yap(Input::getir('parola'), $salt),
						'salt'          => $salt,
						'isim'          => Input::getir('isim'),
						'uyelik_tarihi' => date('g-m-Y H:i:s'),
						'grup'          => '1'				
					));

				Session::flash('basari', 'Başarılı bir şekilde üye oldunuz!');
				Yonlendir::yon('index.php');

				}catch(Exception $e){
					die($e->getMessage());
				}

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
</head>
<body>
	<form action="" method="POST">
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
			<input type="hidden" name="token" value="<?php echo Token::tokenOlustur(); ?>">
			<input type="text" name="isim" id="isim" value="<?php echo filtrele(Input::getir('isim')); ?>">
		</div>

		<input type="submit" value="Üye Ol">
	</form>
</body>
</html>