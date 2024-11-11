<?php
    include_once "../../../../src/Helper/Validator.php";
    
    class ApplicationDAO{

        private $mysqli;

        public function __construct(string $server, string $user, string $pass, string $dbName) {
            $this->mysqli = new mysqli($server, $user, $pass, $dbName);
        }

        public function applicationInCurrentProcess(string $identityNumber){
            $query= "CALL ApplicationInCurrentEvent(?);";

            try{
                $result = $this->mysqli->execute_query($query, [$identityNumber]);
                
                if ($row = $result->fetch_assoc()) {

                    $resultJson = $row['resultJson'];

                    $resultArray = json_decode($resultJson, true);

                    if ($resultArray !== null) {
                        return $resultArray;
                    } else {
                        return [
                            "status" => false,
                            "message" => "Error al decodificar el JSON."
                        ];
                    }

                }else {
                    echo "Error al ejecutar el procedimiento: " . $conexion->error;
                }
                
            }catch (Exception $e){
                return [
                    "status" => false,
                    "message" => "Error al hacer la consulta"
                ];
            }
        }

        /**
         * author: dorian.contreras@unah.hn
         * version: 0.3.0
         * date: 11/11/24
         */
        public function setApplication(string $identityNumber,string $firstName,string $secondName,string $firstLastName, string $secondLastName, string $pathSchoolCertificate, string $telephoneNumber,
            string $personalEmail, int $firstDegreeProgramChoice,int $secondDegreeProgramChoice,int $regionalCenterChoice){

            $currentProcess = $this->applicationInCurrentProcess($identityNumber);

            if($currentProcess['status']){
                return [
                    "status" => false,
                    "message" => $currentProcess['message']
                ];
            }else{
                //hacer validaciones en el if
                if(
                    Validator::isHondurasIdentityNumber($identityNumber) &&
                    Validator::isPhoneNumber($telephoneNumber) &&
                    Validator::isEmail($personalEmail)
                ){
                    $query= "CALL insertApplicant(?,?,?,?,?,?,?,?,?,?,?);";
                    $query1= "SELECT b.admissionTest AS admissionTest
                                FROM Application a
                                INNER JOIN AdmissionDegree b ON a.firstDegreeProgramChoice = b.degree
                                WHERE a.id = ?
                                UNION
                                SELECT c.admissionTest
                                FROM Application a
                                INNER JOIN AdmissionDegree c ON a.secondDegreeProgramChoice = c.degree
                                WHERE a.id = ?";
                    $query2= "INSERT INTO Results(application, admissionTest) VALUES (?,?)";

                    try{
                        $result = $this->mysqli->execute_query($query, [$identityNumber, $firstName, $secondName, $firstLastName, $secondLastName, $pathSchoolCertificate, $telephoneNumber,
                            $personalEmail, $firstDegreeProgramChoice,$secondDegreeProgramChoice,$regionalCenterChoice]);
                        
                        if ($row = $result->fetch_assoc()) {

                            $resultJson = $row['resultJson'];

                            $resultArray = json_decode($resultJson, true);

                            if ($resultArray !== null) {

                                //INSERTAR EXAMENES
                                $result1 = $this->mysqli->execute_query($query1, [$resultArray['idApplication'],$resultArray['idApplication']]);
                                foreach($result1 as $row){
                                    $result2 = $this->mysqli->execute_query($query2, [$resultArray['idApplication'],$row['admissionTest']]);
                                };

                                return [
                                    "status" => true,
                                    "message" => "Inscription hecha correctamente"
                                ];

                            } else {
                                return [
                                    "status" => false,
                                    "message" => "Error al decodificar el JSON."
                                ];
                            }

                        }else {
                            echo "Error al ejecutar el procedimiento: " . $conexion->error;
                        }
                        
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
            
        }

        // Método para cerrar la conexión
        public function closeConnection() {
            $this->mysqli->close();
        }

    }
?>