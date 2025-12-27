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

    public function read(){
           $stmt =  $this->pdo->query( "SELECT d.id , d.name , d.specialty , depr.name AS depr
                       FROM doctors d
                       JOIN departments depr ON d.department_id = depr.id "
           );
           foreach($stmt as $d){
            echo "{$d['id']} | {$d['name']} |{$d['specialty']} |{$d['depr']} |\n" ;
           }
         }

    public function update($id , $name , $spec , $dep){
          $this->pdo->prepare(
            "UPDATE doctors SET name=? , specialty=? , department_id=? where id = ?"
          )->execute([$name,$spec,$dep,$id]);
    }

    public function delete($id){
        $this->pdo->prepare(
            "DELETE FROM doctors WHERE id=? "
        )->execute([$id]);
    }
}

class patient extends basemodel{
    
    public function create($name,$age,$doctorID){
        $this->pdo->prepare(
            "INSERT INTO patients(name,age,doctor_id) VALUES (?,?,?)"
        )->execute([$name,$age,$doctorID]);
    }


    public function read(){
        $stmt = $this->pdo->query(
            " SELECT p.id , p.name ,p. age  , d.name AS doctor
              FROM patients p
              JOIN doctors d ON p.doctor_id = d.id 
              "
        );
        foreach($stmt as $p){
            echo "{$p['id']} | {$p['name']} | {$p['age']} | {$p['doctor']} \n";
        }
    }

}

$database = new database() ;
$doctor = new doctor($database->pdo);
$patient = new patient($database->pdo);


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
         if($chosedoctor=="2"){
            $doctor->read();
         }
         if($chosedoctor=="3"){
            echo "id : " ; $id = trim(fgets(STDIN)); 
            echo "name : " ; $name = trim(fgets(STDIN)); 
            echo "specyalite : " ; $specyalite = trim(fgets(STDIN)); 
            echo "departement : " ; $departement = trim(fgets(STDIN)); 
            $doctor->update($id , $name , $specyalite ,$departement);
         }
         if($chosedoctor=="4"){
            echo "entrer ID pour supremer :"; $id = trim(fgets(STDIN));
            $doctor->delete($id);
         }
    }elseif($main=="2"){
         echo "***********patients**********\n";
         echo "1-add patient\n2-show patient\n3-update patient\n4-delet patient\n0-exit\nchose:";
         $chosepatient = trim(fgets(STDIN));
         if($chosepatient=="1"){
            echo "name : " ; $name = trim(fgets(STDIN));
            echo "age  : " ; $age = trim(fgets(STDIN));
            echo "doctor ID : " ; $doctorID = trim(fgets(STDIN));
             $patient->create($name,$age,$doctorID);
         }
         if($chosepatient=="2"){
            $patient->read();
         }
    }elseif($main=="3"){
         echo "***********departements**********\n";
         echo "1-add departement\n2-show departement\n3-update departement\n4-delet departement\n0-exit\nchose:";
         $chosedepartement = trim(fgets(STDIN));
    }
}