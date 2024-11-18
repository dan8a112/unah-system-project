<?php
    include_once "../../../../src/Helper/Validator.php";
    
    class ApplicationDAO{

        private $mysqli;

        public function __construct(string $server, string $user, string $pass, string $dbName) {
            $this->mysqli = new mysqli($server, $user, $pass, $dbName);
        }

        /**
         * author: dorian.contreras@unah.hn
         * version: 0.2.0
         * date: 12/11/24
         */
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
        public function setApplication(string $identityNumber,string $firstName,string $secondName,string $firstLastName, string $secondLastName, $pathSchoolCertificate, string $telephoneNumber,
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
                    $query1= "SELECT b.admissionTest, d.description
                            FROM Application a
                            INNER JOIN AdmissionDegree b ON a.firstDegreeProgramChoice = b.degree
                            INNER JOIN AdmissionTest d ON b.admissionTest = d.id
                            WHERE a.id = ?
                            UNION
                            SELECT c.admissionTest, e.description
                            FROM Application a
                            INNER JOIN AdmissionDegree c ON a.secondDegreeProgramChoice = c.degree
                            INNER JOIN AdmissionTest e ON c.admissionTest = e.id
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
                                    $exams[] = $row['description'];
                                };

                                return [
                                    "status" => true,
                                    "message" => "Inscription hecha correctamente",
                                    "exams"=> $exams
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

        /**
         * author: dorian.contreras@unah.hn
         * version: 0.1.0
         * date: 11/11/24
         */
        public function getInfoCurrentAdmission(){

            $query = 'CALL InfoCurrentProcessAdmission();';
            $query1 = 'CALL AmountInscription(?);';
            $query2 = 'CALL LastestInscription(?);';

            $result = $this->mysqli->execute_query($query);

            foreach($result as $row){
                $idProcess = $row["idAcademicEvent"];
                $infoProcess = [
                    "name"=>$row["processName"],
                    "start"=>$row["start"],
                    "end"=>$row["final"],
                    "idProcessState"=> $row["idProcessState"],
                    "processState"=> $row["processState"],
                ] ;
            }
            
            $result1 = $this->mysqli->execute_query($query1, [$idProcess]);

            foreach($result1 as $row){
                $amountInscription = $row['amountInscriptions'];
            }

            $result2 = $this->mysqli->execute_query($query2, [$idProcess]);

            foreach($result2 as $row){
                $lastestInscrptions[] = [
                    "id" => $row["id"],
                    "name"=>implode(" ",[$row["firstName"], $row["secondName"], $row["firstLastName"], $row["secondLastName"]]),
                    "career"=>$row["description"],
                    "inscriptionDate"=>$row["applicationDate"],
                ] ;
            }

            return [
                "infoProcess"=> $infoProcess,
                "amountInscription"=> $amountInscription,
                "lastestInscriptions"=> $lastestInscrptions
            ];
        }

        /**
         * author: dorian.contreras@unah.hn
         * version: 0.1.0
         * date: 12/11/24
         */
        public function getInfoHistoricAdmission(int $id){

            $query="SELECT CONCAT(b.description,' ', CONCAT(UPPER(LEFT(DATE_FORMAT(a.startDate, '%M'), 1)), SUBSTRING(DATE_FORMAT(a.startDate, '%M'), 2)), ' ', YEAR(a.startDate)) as processName, DATE_FORMAT(a.startDate, '%d de %M, %Y') as start, DATE_FORMAT(a.finalDate, '%d de %M, %Y') as final
                    FROM AcademicEvent a
                    INNER JOIN AcademicProcess b ON (a.process = b.id)
                    WHERE a.id = ?;";

            $query1 = 'CALL AmountInscription(?);';

            $query2= "SELECT a.id, CONCAT(b.firstName, ' ', b.secondName,' ', b.firstLastName) as name, c.description as career, d.grade
                    FROM Application a
                    INNER JOIN Applicant b
                    ON (a.idApplicant = b.id)
                    INNER JOIN DegreeProgram c 
                    ON (a.firstDegreeProgramChoice = c.id)
                    INNER JOIN Results d
                    ON(a.id = d.application)
                    WHERE a.academicEvent = ? AND admissionTest=1 ORDER BY d.grade DESC LIMIT 5;";

            $query3= "SELECT b.acronym, COUNT(*) as amount
                    FROM Application a
                    INNER JOIN RegionalCenter b
                    ON (a.regionalCenterChoice=b.id)
                    WHERE academicEvent =?
                    GROUP BY b.id;";

            $query4= "SELECT COUNT(*) as approved
                    FROM Application
                    WHERE academicEvent=? AND (approvedFirstChoice=true OR approvedSecondChoice=true);";

            $result = $this->mysqli->execute_query($query, [$id]);

            foreach($result as $row){
                $infoProcess = [
                    "name"=>$row["processName"],
                    "start"=>$row["start"],
                    "end"=>$row["final"]
                ] ;
            }

            $result1 = $this->mysqli->execute_query($query1, [$id]);

            foreach($result1 as $row){
                $amountInscription = $row['amountInscriptions'];
            }

            $result2 = $this->mysqli->execute_query($query2, [$id]);

            foreach($result2 as $row){
                $higherScores[] = [
                    "id" => $row["id"],
                    "name"=>$row["name"],
                    "career"=>$row["career"],
                    "score"=>$row["grade"],
                ] ;
            }

            $result3 = $this->mysqli->execute_query($query3, [$id]);

            foreach($result3 as $row){
                $amountCentersInscripctions[]= [
                    "name"=>$row["acronym"],
                    "amount"=>$row["amount"],
                ] ;
            }

            $result4 = $this->mysqli->execute_query($query4, [$id]);

            foreach($result4 as $row){
                $amount= $row['approved'];
            }

            return [
                "infoProcess"=> $infoProcess,
                "amountApproved"=> $amount,
                "amountInscriptions"=> $amountInscription,
                "higherScores"=> $higherScores,
                "amountCentersInscriptions"=>$amountCentersInscripctions
            ];

        }

        /**
         * author: dorian.contreras@unah.hn
         * version: 0.1.0
         * date: 12/11/24
         */
        public function isActiveInscriptionProcess() {

            $query = "SELECT a.id 
                    FROM AcademicEvent a
                    INNER JOIN AcademicEvent b ON (a.id = b.parentId)
                    WHERE a.process=1 AND a.active=true AND b.active=true AND b.process=3;";
            $result = $this->mysqli->execute_query($query);
        
            if ($result->num_rows > 0) {
                return true; 
            } else {
                return false;
            }
        }
        
        /**
         * author: dorian.contreras@unah.hn
         * version: 0.1.0
         * date: 12/11/24
        */
        public function insertResults($path){
            $expectedHeaders = ['dni', 'idTest', 'grade'];
            $incorrectData = [];
            $counter = 1;

            if (($handle = fopen($path, 'r')) !== false) {
                // Leer la primera línea (encabezados)
                $headers = fgetcsv($handle, 1000, ',');
                
                if ($headers === $expectedHeaders) {
                    // Leer cada línea del archivo
                    while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                        // Mapear los datos a variables
                        $dni = $data[0];
                        $id_test = $data[1];
                        $grade = $data[2];

                        if (filter_var($data[1], FILTER_VALIDATE_INT) === false || filter_var($data[2], FILTER_VALIDATE_FLOAT) === false) {
                            $incorrectData []= [
                                $counter,
                                $dni,
                                $data[1],
                                $data[2],
                                'Tipo de dato incorrecto en alguna columna.'
                            ];
                            continue;
                        }
                
                        // update los datos en la base de datos
                        $query= "CALL updateResults(?, ?, ?)";

                        try{
                            $result = $this->mysqli->execute_query($query, [$dni, (int) $id_test, (float) $grade]);
                            
                            if ($row = $result->fetch_assoc()) {

                                $resultJson = $row['resultJson'];

                                $resultArray = json_decode($resultJson, true);

                                if (!$resultArray['status']) {
                                    $incorrectData []= [
                                        $counter,
                                        $dni,
                                        $data[1],
                                        $data[2],
                                        $resultArray['message']
                                    ];
                                }
                            }else {
                                $incorrectData []= [
                                    $counter,
                                    $dni,
                                    $data[1],
                                    $data[2],
                                    "Error al ejecutar el procedimiento: " . $conexion->error
                                ];
                            }
                            
                        }catch (Exception $e){
                            $incorrectData []= [
                                $counter,
                                $dni,
                                $data[1],
                                $data[2],
                                "No existe el IdTest."
                            ];
                        }

                       $counter++;
                    }
                
                    fclose($handle);

                    $missingData = [];
                    $query1 = 'SELECT  d.id as dni, a.admissionTest, a.grade
                                FROM Results a 
                                INNER JOIN Application b ON(a.application=b.id)
                                INNER JOIN AcademicEvent c ON(b.academicEvent=c.id)
                                INNER JOIN Applicant d ON(b.idApplicant=d.id)
                                WHERE c.active = true AND a.grade IS NULL;';
        
                    $result1 = $this->mysqli->execute_query($query1);
                    $counter2= 1;

                    foreach($result1 as $row){
                        $missingData[] = [
                            $counter2,
                            $row["dni"],
                            $row["admissionTest"],
                            $row["grade"]
                        ];

                        $counter2++;
                    };

                    return [
                        "status" => true,
                        "message" => "CSV leido",
                        "incorrectData"=> $incorrectData,
                        "missingData"=> $missingData
                    ];
                } else {
                    fclose($handle);
                    return [
                        'status' => false,
                        'message' => 'El formato del archivo CSV no es válido. Encabezados esperados: ' 
                                     . implode(', ', $expectedHeaders) 
                                     . '. Encabezados recibidos: ' 
                                     . implode(', ', $headers)
                    ];
                }
            } else {
                return [
                    "status" => false,
                    "message" => "Error al abrir CSV.",
                ];
            }
            
        }

        // Método para cerrar la conexión
        public function closeConnection() {
            $this->mysqli->close();
        }

    }
?>