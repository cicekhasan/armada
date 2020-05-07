<?php
	class DB{
		private static $_baglan = null;
		private $_pdo,
				$_query,
				$_hatalar = false,
				$_sonuc,
				$_sayac = 0;

		private function __construct(){
			try{
				$this->_pdo = new PDO('mysql:host=' . Config::getir('mysql/host') . ';dbname=' . Config::getir('mysql/db'), Config::getir('mysql/kullanici_adi'), Config::getir('mysql/parola'));
				//echo "Veritabanına bağlanıldı.";
			}catch(PDOException $e){
				die($e->getMessage());
			}
		}

		public static function baglan(){
			if (!isset(self::$_baglan)) {
				self::$_baglan = new DB();
				return self::$_baglan;
			}
		}

		public function hatalar(){
			return $this->_hatalar;
		}

		public function query($sql, $degerler = array()){
			$this->_hatalar = false;
			if ($this->_query = $this->_pdo->prepare($sql)) {
				$x = 1;
				if (count($degerler)) {
					foreach ($degerler as $deger) {
						$this->_query->bindValue($x, $deger);
						$x++;
					}
				}
				if ($this->_query->execute()) {
					$this->_sonuc = $this->_query->fetchAll(PDO::FETCH_OBJ);
					$this->_sayac = $this->_query->rowCount();
				}else{
					$this->_hatalar = true;
				}
			}
			return $this;
		}

		public function eylem($eylem, $tablo, $where=array()){

			if (count($where)===3) {

				$operatorler = array('=', '>', '<', '>=', '<=');

				$alan     = $where[0];
				$operator = $where[1];
				$deger    = $where[2];

				if (in_array($operator, $operatorler)) {
					$sql = "{$eylem} FROM {$tablo} WHERE {$alan} {$operator} ?";
					if (!$this->query($sql, array($deger))->hatalar()) {
						return $this;
					}
				}
			}
			return false;
		}

		public function getir($tablo, $where){
			return $this->eylem('SELECT * ', $tablo, $where);
		}

		public function ekle($tablo, $alanlar = array()) {
			if (isset($tablo) && isset($alanlar)) {
				echo $tablo."<br />";
				print_r($alanlar);
			}
		}
		/*
		public function ekle($tablo, $alanlar = array()) {
			$anahtar = array_keys($alanlar);
			$degerler = '';
			$x = 1;
			foreach ($alanlar as $alan) {
				$degerler .= "?";
				if ($x < count($alanlar)) {
					$degerler .= ', ';
				}
				$x++;
			}

			$sql = "INSERT INTO {$tablo} (`".implode('`, `', $anahtar)."`) VALUES ({$degerler})";
			if (!$this->query($sql, $alanlar)->hatalar()) {
				return true;
			}
			return false;
		}
*/
		public function guncelle($tablo, $id, $alanlar) {
			$set = '';
			$x = 1;
			foreach ($alanlar as $anahtar => $deger) {
				$set .= "{$anahtar} = ?";
				if ($x < count($alanlar)) {
					$set .= ', ';
				}
				$x++;
			}

			$sql = "UPDATE {$tablo} SET {$set} WHERE id = {$id}";
			if (!$this->query($sql, $alanlar)->hatalar()) {
				return true;
			}
			return false;
		}

		public function sil(){
			return $this->eylem('DELETE ', $tablo, $where);
		}

		public function ilk(){
			return $this->_sonuc[0];
		}

		public function sayac(){
			return $this->_sayac;
		}

		public function sonuc(){
			return $this->_sonuc;
		}

	}
?>