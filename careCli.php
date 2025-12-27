<?php


class Database {
    public $pdo;

    public function __construct(){
        try {
            $this->pdo = new PDO(
                "mysql:host=localhost;dbname=CARE_CLINIC_MANAGMENT_CLI;charset=utf8",
                "root",
                ""
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e){
            die("DB Error: " . $e->getMessage());
        }
    }
}


class basemodel{
     protected $pdo;

     public function __construct($pdo){
        $this->pdo = $pdo ; 
     }
     
}
class doctor extends basemodel{
    
    public function create($na,$spe,$depID){
         $this->pdo->prepare(
            "INSERT INTO doctors (name,specialty,department_id) VALUES (?,?,?)"
         )->execute([$na,$spe,$depID]);
    }
}

$database = new database() ;
$doctor = new doctor($database->pdo);
// $doctor = new doctor();


while(true){
    echo "***************menu*****************\n";
    echo "1-doctors\n2-patients\n3-departements\n0-exit\nchose :" ;
    $main = trim(fgets(STDIN));
    if($main=="1"){
         echo "***********doctors***********\n";
         echo "1-add doctor\n2-show doctor\n3-update doctor\n4-delet doctor\n0-exit\nchose:";
         $chosedoctor = trim(fgets(STDIN));
         if($chosedoctor=="1"){
            echo "name : "  ; $name = trim(fgets(STDIN));
            echo "specyalite : " ; $spec =   trim(fgets(STDIN));
            echo "departement ID : "  ; $depID =  trim(fgets(STDIN));

            $doctor->create($name,$spec,$depID);
            
         }
    }elseif($main=="2"){
         echo "***********patients**********\n";
         echo "1-add patient\n2-show patient\n3-update patient\n4-delet patient\n0-exit\nchose:";
         $chosepatient = trim(fgets(STDIN));
    }elseif($main=="3"){
         echo "***********departements**********\n";
         echo "1-add departement\n2-show departement\n3-update departement\n4-delet departement\n0-exit\nchose:";
         $chosedepartement = trim(fgets(STDIN));
    }
}