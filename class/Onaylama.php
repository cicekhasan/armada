<?php
	class Onaylama{

		private $_tamam   =false,
			      $_hatalar = array(),
			      $_db      = null;

		public function __construct(){
			$this->_db = DB::baglan();
		}

		public function kontrol($kaynak, $bolumler=array()){

			foreach ($bolumler as $bolum => $kurallar) {
				foreach ($kurallar as $kural => $kural_deger) {
					//echo "{$bolum} {$kural} : {$kural_deger} olmalıdır! <br />";
					$deger = trim($kaynak[$bolum]);
					$bolum = filtrele($bolum);

					if ($kural === 'zorunlu' && empty($deger)) {
						$this->hataEkle("{$bolum} alanı zorunludur.");
					}else if(!empty($deger)){
						switch ($kural) {
							case 'min':
								if (strlen($deger)<$kural_deger) {
									$this->hataEkle("{$bolum} en az {$kural_deger} karakter olmalıdır!");
								}
								break;
							case 'max':
								if (strlen($deger)>$kural_deger) {
									$this->hataEkle("{$bolum} en fazla {$kural_deger} karakter olmalıdır!");
								}
								break;
							case 'eslesme':
								if ($deger!=$kaynak[$kural_deger]) {
									$this->hataEkle("{$kural_deger} ile {$bolum} aynı olmalı!");
								}
								break;
							case 'benzersiz':
								$kontrol = $this->_db->getir($kural_deger, array("$bolum", "=", "$deger"));
								if ($kontrol->sayac()) {
									$this->hataEkle("{$bolum} daha önce alınmış!");
								}
								break;
							
							default:
								# code...
								break;
						}
					}
				}
			}

			if (empty($this->_hatalar)){
				$this->_tamam = true;
			}
			return $this;

		}

		public function hataEkle($hatalar){
			$this->_hatalar[]=$hatalar;
		}

		public function hatalar(){
			return $this->_hatalar;
		}

		public function tamam(){
			return $this->_tamam;
		}

	}
?>