<?php
	class Kullanici{

		private $_db,
			      $_veri,
			      $_sessionIsmi,
			      $_girisYapti;

		public function __construct($kullanici = null){
			$this->_db = DB::baglan();
			$this->_sessionIsmi = Config::getir('session/session_ismi');

			if (!$kullanici) {
				if (Session::varsa($this->_sessionIsmi)) {
					$kullanici = Session::getir($this->_sessionIsmi);
					//1 echo $kullanici;
				}
			}
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
					// echo 'Tamam';
					Session::yerlestir($this->_sessionIsmi, $this->veri()->id);
					return true;
				}
			}
			return false;
		}

		public function veri() {
			return $this->_veri;
		}

		public function varsa() {
			return (!empty($this->_veri)) ? true : false;
		}


		public function girisYapti() {
			return $this->_girisYapti;
		}

	}
?>