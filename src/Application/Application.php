<?php
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
            string $personalEmail, int $firstDegreeProgramChoice,int $secondDegreeProgramChoice,int $regionalCenterChoice) : bool{

            //hacer validaciones en el if
            if(true){
                $query= "CALL insertApplicant(?,?,?,?,?,?,?,?,?,?,?);";

                try{
                    $result = $this->mysqli->execute_query($query, [$identityNumber, $firstName, $secondName, $firstLastName, $secondLastName, $pathSchoolCertificate, $telephoneNumber,
                        $personalEmail, $firstDegreeProgramChoice,$secondDegreeProgramChoice,$regionalCenterChoice]);
                    return true;
                    
                }catch (Exception $e){
                    return false;
                }
            }else{
                return false;
            }
            
            
            
        }

    }
?>