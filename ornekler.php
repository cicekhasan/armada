<?php
	// init.php dosyasından veri çekme...
	echo Config::getir('mysql/host');

	// ilk() fonksiyonu kullanımı...
	$kullanici = DB::baglan()->getir('uyeler', array('kullanici_adi', '=', 'hasancicek'));
	echo $kullanici->ilk()->kullanici_adi."<br />";

	// Veritabanından veri çekme...
	$kullanici = DB::baglan()->getir('uyeler', array('kullanici_adi', '=', 'hasancicek'));
	if ($kullanici->sayac()) {
		foreach ($kullanici-> sonuc() as $kullanici) {
			echo $kullanici->isim;
		}
	}else{
		echo "Kullanıcı yok";
	}

	// Veri ekleme örneği...
	$kullanici = DB::baglan()->ekle('uyeler', array(
		'kullanici_adi' => 'fatmaBeyza18',
		'parola'        => 'parola',
		'isim'          => 'Fatma Beyza Çiçek'
	));

	// Veri güncelleme örneği. ip si 2 olanı günceller...
	$kullanici = DB::baglan()->guncelle('uyeler', 2, array(
		'kullanici_adi' => 'beyza18',
		'parola'        => 'parola',
		'isim'          => 'Fatma Beyza Çiçek'
	));


	//echo Input::getir('kullanici_adi');
?>