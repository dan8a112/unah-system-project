<?php
    include_once "../../../../src/Helper/Validator.php";
    
    class ApplicationDAO{

        private $mysqli;

        public function __construct(string $server, string $user, string $pass, string $dbName) {
            $this->mysqli = new mysqli($server, $user, $pass, $dbName);
        }

        /**
         * author: dorian.contreras@unah.hn
         * version: 0.1.0
         * date: 5/11/24
         */
        public function setApplication(string $identityNumber,string $firstName,string $secondName,string $firstLastName, string $secondLastName, string $pathSchoolCertificate, string $telephoneNumber,
            string $personalEmail, int $firstDegreeProgramChoice,int $secondDegreeProgramChoice,int $regionalCenterChoice) : array{

            //hacer validaciones en el if
            if(
                Validator::isHondurasIdentityNumber($identityNumber) &&
                Validator::isPhoneNumber($telephoneNumber) &&
                Validator::isEmail($personalEmail)
            ){
                $query= "CALL insertApplicant(?,?,?,?,?,?,?,?,?,?,?);";

                try{
                    $result = $this->mysqli->execute_query($query, [$identityNumber, $firstName, $secondName, $firstLastName, $secondLastName, $pathSchoolCertificate, $telephoneNumber,
                        $personalEmail, $firstDegreeProgramChoice,$secondDegreeProgramChoice,$regionalCenterChoice]);
                    return [
                        "status" => true,
                        "message" => "Se inserto correctamente"
                    ];
                    
                }catch (Exception $e){
                    return [
                        "status" => false,
                        "message" => "Error al hacer la consulta"
                    ];
                }
            }else{
                return [
                        "status" => false,
                        "message" => "Alguno de los campos no cumple el formato necesario"
                    ];
            } 
            
        }

        // Método para cerrar la conexión
        public function closeConnection() {
            $this->mysqli->close();
        }

    }
?>