<?php
class ActiveRecord{
 //	private $_errors = false;
 public static function get($uslov="")
	    {
			$db = Db::getInstance();
			$kljuc=static::$key; // iz tabele DrzaveLjeto uzeo sam $key u koji mi je smesten id, kako se ne bi pokazivao u upitima
			$tabela =static::$tabela; // pomocu ove metode mozemo da odaberemo bazu
			if ($uslov !="") {
				$res=$db->query("select * from {$tabela} where {$uslov}");
				$res->setFetchMode(PDO::FETCH_CLASS, get_called_class());
				return $res->fetch();
			}
				$res=$db->query("select * from {$tabela}");
				$res->setFetchMode(PDO::FETCH_CLASS, get_called_class());
				$output=[];
		       
				while($row=$res->fetch()){
					$output[]=$row;
				}
				return $output;
		}
        // metoda koja generise upit za insert i save
		public function generisiUpdateInsert()
		{
			$polja ="";
			$kljuc=static::$key; // iz tabele DrzaveLjeto uzeo sam $key u koji mi je smesten id, kako se ne bi pokazivao u upitima

			foreach ($this as $poljeKljuc => $poljeVrednost) {
				if($poljeKljuc == $kljuc) continue;
				$polja .=$poljeKljuc." = '".$poljeVrednost."', ";
			}
               // brisemo zarez na poslednjoj stavki upita
			   $polja = rtrim($polja,", ");
			   return $polja;

		}
         public function save()
		{
			$db = Db::getInstance();
		    $tabela =static::$tabela; // pomocu ove metode mozemo da odaberemo bazu
			$upit = "insert into {$tabela} ";
			$polja ="";
			$kolona= "";
			$vrednost ="";
            $kljuc=static::$key; // iz tabele DrzaveLjeto uzeo sam $key u koji mi je smesten id, kako se ne bi pokazivao u upitima
			foreach ($this as $poljeKljuc => $poljeVrednost) {
			 if($poljeKljuc == $kljuc) continue;
				$kolona .= $poljeKljuc.", ";
                $vrednost .="'".$poljeVrednost."'";
                $vrednost .=", ";

				
				}
			  // brisemo zarez na poslednjoj stavki upita
               $kolona = rtrim($kolona,", ");
               $vrednost = rtrim($vrednost,", ");
				$upit .="(id, " .$kolona.") values ( null, ".$vrednost." );";
              
			 
			   echo $upit .=$polja;
			   $db->exec($upit);
			   // iz baze uzima tacan naziv id kolone
			   $kljuc = static::$key;
			   $this->$kljuc = $db->lastInsertId();
		}


        // ovo je drugi nacin kako mozemo insertovati podatke
/*
		public function save()
		{
			$db = Db::getInstance();
			$tabela =static::$tabela; // pomocu ove metode mozemo da odaberemo bazu
			$upit = "insert into {$tabela} set ";
			echo $upit .=$this->generisiUpdateInsert();
			$db->exec($upit);
			
			// iz baze uzima tacan naziv id kolone
			$kljuc = static::$key;
			$this->$kljuc = $db->lastInsertId();
		}
		*/
        public function update($uslov)
        {
            $db = Db::getInstance();
            $tabela =static::$tabela; // pomocu ove metode mozemo da odaberemo bazu
            $upit = "update {$tabela} set ";
            $upit .=$this->generisiUpdateInsert(); 
            $upit .=" where $uslov ;";
          //   echo $upit;  // za prikaz upita
			$db->exec($upit);
		
        }
        
	    public static function delete($uslov)
	    {
	    	 $db = Db::getInstance();
	    	  $tabela =static::$tabela; // pomocu ove metode mozemo da odaberemo bazu
              $upit = "delete from {$tabela} ";
              $upit .=" where $uslov ;";
            echo $upit;
			  $db->exec($upit);
	    }

	    public static function direct_sql ($sql) {
          
               $db = Db::getInstance();

               $res=$db->query($sql);
				$res->setFetchMode(PDO::FETCH_CLASS, get_called_class());
				$output=[];
		       
				while($row=$res->fetch()){
					$output[]=$row;
				}
				return $output;
			}

		public function uploadImg($upl = array())
            {

          echo "<br>";
             $_errors = false;
            $_FILES  = $upl;
	        if (isset($_FILES)) {
	         $errors= [];
            


          echo "<br>";
            
	        
	      	 $image = $_FILES['name'];
	      	 $type = $_FILES['type'];
	      	 $tmp_name = $_FILES['tmp_name'];
	      	 $size = $_FILES['size'];
	      	 $error = $_FILES['error'];
	          echo "<br>";
	        // echo $img = pathinfo($image,PATHINF_BASENAME);
	        	$target_file =  basename($image);
		   
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
             $target_dir = "../images/uploads/2017/".$image;
			 if ($_FILES["size"] > 500000) {
                $_errors[]="slika  je prevelika !!!<br> velicina ne sme da prelazi 50kb";
                
              } 
              if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                 && $imageFileType != "pdf" ) {
                  $_errors = "Format nije odgovajrajuc";
                   $uploadOk = 0;
               } 

              if (empty($_errors) ==  true) {
              	echo "<h2 style='color:blue;margin-left:300px;'>Uspesno ste uradili upload slike</h2>";
                   return $uploadFoto = 	move_uploaded_file($tmp_name, $target_dir);
              }
                 echo "<h2 style='color:red; margin-left:30px;'>".$_errors[0]."</h2>";
            
               
               }
             
      }

}



