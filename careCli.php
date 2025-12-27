<?php


class Database {
    public $pdo;

    public function __construct(){
        try {
            $this->pdo = new PDO(
                "mysql:host=localhost;dbname=clinic_full;charset=utf8",
                "root",
                ""
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e){
            die("DB Error: " . $e->getMessage());
        }
    }
}



while(true){
    echo "***************menu*****************\n";
    echo "1-doctors\n2-patients\n0-exit\nchose :" ;
    $main = trim(fgets(STDIN));
    if($main=="1"){
         echo "***********doctors***********\n";
         echo "1-add doctor\n2-show doctor\n3-update doctor\n4-delet doctor\n0-exit\nchose:";
         $chosedoctor = trim(fgets(STDIN));
    }elseif($main=="2"){
         echo "***********patients**********\n";
         echo "1-add patient\n2-show patient\n3-update patient\n4-delet patient\n0-exit\nchose:";
         $chosepatient = trim(fgets(STDIN));
    }
}