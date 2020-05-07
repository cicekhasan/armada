<?php
	class Kullanici{

		private $_db,
			      $_veri;

		public function __construct(){
			$this->_db = DB::baglan();
		}

		public function olustur($alanlar=array()) {
			if (!$this->_db->ekle('uyeler', $alanlar)) {
				throw new Exception('Hesap oluşturulamadı!');				
			}
		}

		public function bul($kullanici = null) {
			if ($kullanici) {
				$alan = (is_numeric($kullanici)) ? 'id' : 'kullanici_adi';
				$veri = $this->_db->getir('uyeler', array($alan, '=', $kullanici));
				if ($veri->sayac()) {
					$this->_veri = $veri->ilk();
					return true;
				}
			}
			return false;
		}

		public function giris($kullanici_adi = null, $parola = null) {
			$kullanici = $this->bul($kullanici_adi);
			if ($kullanici) {
				if ($this->veri()->parola === Hash::yap($sifre, $this->veri()->salt)) {
					# code...
				}
			}
			return false;
		}

		public function veri() {
			return $this->_veri;
		}

	}
?>