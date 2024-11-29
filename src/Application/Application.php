<?php
    if (file_exists("../../../../src/Helper/Validator.php")) {
        include_once("../../../../src/Helper/Validator.php");
    }
    
    class ApplicationDAO{

        private $mysqli;

        public function __construct(string $server, string $user, string $pass, string $dbName) {
            $this->mysqli = new mysqli($server, $user, $pass, $dbName);
        }

        /**
         * author: dorian.contreras@unah.hn
         * version: 0.2.0
         * date: 12/11/24
         * 
         * Función para saber si un aplicante ya tiene una inscripcion en proceso de admisión actual
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
                    return [
                        "status" => false,
                        "message" => "Error al ejecutar el procedimiento: " . $conexion->error
                    ];
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
         * version: 0.1.0
         * date: 28/11/24
         * 
         * Funcion para paginar el total de inscripciones de un proceso
         */
        public function getApplications(int $idProcess, int $offset){
            $query = "SELECT a.id, CONCAT(b.names, ' ', b.lastNames) as name, c.description, a.applicationDate
                    FROM Application a
                    INNER JOIN Applicant b
                    ON (a.idApplicant = b.id)
                    INNER JOIN DegreeProgram c 
                    ON (a.firstDegreeProgramChoice = c.id)
                    WHERE a.academicEvent = ? ORDER BY a.id DESC 
                    LIMIT 10 OFFSET ?;";
            $result = $this->mysqli->execute_query($query, [$idProcess, $offset]);
            $applications = [];
            if ($result) {
                foreach($result as $row){
                    $applications[] = [
                        $row["id"],
                        $row["name"],
                        $row["description"],
                        $row["applicationDate"]
                    ];
                } 
            } 
            return $applications;
        }

        /**
         * author: dorian.contreras@unah.hn
         * version: 0.1.0
         * date: 28/11/24
         * 
         * Funcion para paginar el total de revisores
         */
        public function getReviewers(int $idProcess, int $offset){
            $query = "SELECT a.id, CONCAT(a.firstName,' ', a.firstLastName) AS name, COUNT(b.id) AS amountReview
                    FROM Reviewer a
                    LEFT JOIN Application b ON a.id = b.idReviewer AND b.academicEvent = ?
                    WHERE a.active = true
                    GROUP BY a.id, CONCAT(a.firstName,' ', a.firstLastName)
                    LIMIT 10 OFFSET ?;";
            $result = $this->mysqli->execute_query($query, [$idProcess, $offset]);
            $reviewers = [];
            if ($result) {
                foreach($result as $row){
                    $reviewers[] = [
                        $row["id"],
                        $row["name"],
                        $row["amountReview"],
                    ] ;
                } 
            } 
            return $reviewers;
        }

        /**
         * author: dorian.contreras@unah.hn
         * version: 0.1.0
         * date: 28/11/24
         * 
         * Funcion para paginar el total de inscripciones APROBADAS de un proceso
         */
        public function getApprovedApplications(int $idProcess, int $offset){
            $query = "SELECT a.id, CONCAT(b.names, ' ', b.lastNames) as name, c.description as career, d.grade
                    FROM Application a
                    INNER JOIN Applicant b
                    ON (a.idApplicant = b.id)
                    INNER JOIN DegreeProgram c 
                    ON (a.firstDegreeProgramChoice = c.id)
                    INNER JOIN Results d
                    ON(a.id = d.application)
                    WHERE a.academicEvent = ? AND admissionTest=1 AND (a.approvedFirstChoice = 1 OR a.approvedSecondChoice = 1) ORDER BY d.grade DESC 
                    LIMIT 10 OFFSET ?;";
            $result = $this->mysqli->execute_query($query, [$idProcess, $offset]);
            $applications = [];
            if ($result) {
                foreach($result as $row){
                    $applications[] = [
                        "id" => $row["id"],
                        "name"=>$row["name"],
                        "career"=>$row["career"],
                        "score"=>$row["grade"],
                    ];
                } 
            } 
            return $applications;
        }

        /**
         * author: dorian.contreras@unah.hn
         * version: 0.1.0
         * date: 28/11/24
         * 
         * Funcion para paginar las inscripciones a las que no se les inserto resultados
         */
        public function getMissingResults(int $offset, int $counter){
            $query = "SELECT  d.id as dni, a.admissionTest, a.grade
                    FROM Results a 
                    INNER JOIN Application b ON(a.application=b.id)
                    INNER JOIN AcademicEvent c ON(b.academicEvent=c.id)
                    INNER JOIN Applicant d ON(b.idApplicant=d.id)
                    WHERE c.active = true AND a.grade IS NULL
                    LIMIT 10 OFFSET ?;";
            $result = $this->mysqli->execute_query($query, [$offset]);
            $applications = [];
            if ($result) {
                foreach($result as $row){
                    $applications[] = [
                        $counter,
                        $row["dni"],
                        $row["admissionTest"],
                        $row["grade"]
                    ];
                    $counter ++;
                } 
            } 
            return $applications;
        }


        /**
         * author: dorian.contreras@unah.hn
         * version: 0.3.0
         * date: 20/11/24
         * 
         * Función para insertar una inscripción en la tabla 'Application'
         */
        public function setApplication(string $identityNumber,string $names,string $lastNames, $schoolCertificate, string $telephoneNumber,
            string $personalEmail, int $firstDegreeProgramChoice,int $secondDegreeProgramChoice,int $regionalCenterChoice){

            $names = mb_convert_case($names, MB_CASE_TITLE, "UTF-8");
            $lastNames = mb_convert_case($lastNames, MB_CASE_TITLE, "UTF-8");
            //validación de que no exista una aplicacion del aplicante con este dni
            $currentProcess = $this->applicationInCurrentProcess($identityNumber);

            if($currentProcess['status']){
                return [
                    "status" => false,
                    "code"=> 0,
                    "message" => $currentProcess['message']
                ];
            }else{

                //hacer validaciones integridad de datos
                if(!Validator::isHondurasIdentityNumber($identityNumber)){
                    return [
                        "status" => false,
                        "code"=> 0,
                        "message" => "EL número de identidad no es válido."
                    ];
                }

                if(!Validator::isPhoneNumber($telephoneNumber)){
                    return [
                        "status" => false,
                        "code"=> 0,
                        "message" => "Número de teléfono inválido"
                    ];
                }

                if(!Validator::isEmail($personalEmail)){
                    return [
                        "status" => false,
                        "code"=> 0,
                        "message" => "Email inválido"
                    ];
                }

                if(!Validator::isValidName($names)){
                    return [
                        "status" => false,
                        "code"=> 0,
                        "message" => "Nombres inválidos. Recuerde no usar números."
                    ];
                }

                if(!Validator::isValidName($lastNames)){
                    return [
                        "status" => false,
                        "code"=> 0,
                        "message" => "Apellidos inválidos. Recuerde no usar números."
                    ];
                }

                //Procedimiento almacenado para insertar la inscripcion
                $query= "CALL insertApplicant(?,?,?,?,?,?,?,?,?);";

                //Obtener los examenes que tiene que hacer el aplicante
                $query1= 
                "SELECT b.admissionTest, d.description
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
                
                //Insertar en la tabla de resultados los examenes que tiene que hacer el aplicante
                $query2= "INSERT INTO Results(application, admissionTest) VALUES (?,?)";

                try{
                    //Insertar inscripcion
                    $result = $this->mysqli->execute_query($query, [$identityNumber, $names, $lastNames, $schoolCertificate, $telephoneNumber,
                        $personalEmail, $firstDegreeProgramChoice,$secondDegreeProgramChoice,$regionalCenterChoice]);
                    
                    if ($row = $result->fetch_assoc()) {

                        $resultJson = $row['resultJson'];

                        $resultArray = json_decode($resultJson, true);

                        if ($resultArray['status']) {

                            //Obtener examenes
                            $result1 = $this->mysqli->execute_query($query1, [$resultArray['idApplication'],$resultArray['idApplication']]);

                            //Insertar examenes en Result
                            foreach($result1 as $row){
                                $result2 = $this->mysqli->execute_query($query2, [$resultArray['idApplication'],$row['admissionTest']]);
                                $exams[] = $row['description'];
                            };

                            return [
                                "status" => true,
                                "message" => "Inscription hecha correctamente",
                                "code"=> 3,
                                "exams"=> $exams
                            ];

                        } else {

                            return [
                                "status" => false,
                                "message" => $resultArray['message'],
                                "code"=> $resultArray['code']
                            ];
                        }

                    }else {

                        return [
                            "status" => false,
                            "message" => "Error al ejecutar el procedimiento: " . $conexion->error,
                            "code"=> 1
                        ];
                    }
                    
                }catch (Exception $e){
                    return [
                        "status" => false,
                        "message" => "Error al hacer la consulta: " . $e
                    ];
                }

            }
            
        }

        /**
         * author: dorian.contreras@unah.hn
         * version: 0.2.0
         * date: 23/11/24
         */
        public function getInfoCurrentAdmission(){

            //Obtener información sobre el proceso de admision actual y el subproceso en el que esta
            $query = 'CALL InfoCurrentProcessAdmission();';
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
            
            //Obtener estadisticas de las inscripciones
            $query1 = 'CALL AmountInscription(?);';
            $result1 = $this->mysqli->execute_query($query1, [$idProcess]);

            if ($row = $result1->fetch_assoc()) {

                $resultJson = $row['resultJson'];

                $resultArray = json_decode($resultJson, true);

                if ($resultArray !== null) {

                    $inscriptionInfo = [
                        "amountInscriptions" => $resultArray['amountInscriptions'],
                        "approvedInscriptions" => $resultArray['approvedInscriptions'],
                        "missingReviewInscriptions" => $resultArray['missingReviewInscriptions']
                    ];

                } else {
                    return [
                        "status" => false,
                        "message" => "Error al decodificar el JSON."
                    ];
                }

            }else {
                return [
                    "status" => false,
                    "message" => "Error al ejecutar el procedimiento: " . $conexion->error
                ];
            }

            //Dependiendo el subproceso de admisiones se va a enviar la siguiente información
            if($infoProcess['idProcessState']==3){ //proceso de inscripciones
                //Obtener las ultimas 5 inscripciones
                $inscriptions= $this->getApplications($idProcess, 0);;
                return [
                    "status" => true,
                    "message" => "Petición realizada con exito.",
                    "data" => [
                        "idAcademicEvent"=> $idProcess,
                        "infoProcess"=> $infoProcess,
                        "amountInscription"=> $inscriptionInfo,
                        "inscriptions"=> $inscriptions
                    ]
                ];

            }elseif($infoProcess['idProcessState']==4){ //proceso de revision de inscripciones
                
                //Obtener información sobre los revisadores
                $reviewers= $this->getReviewers($idProcess, 0);

                return [
                    "status" => true,
                    "message" => "Petición realizada con exito.",
                    "data" => [
                        "idAcademicEvent"=> $idProcess,
                        "infoProcess"=> $infoProcess,
                        "amountInscription"=> $inscriptionInfo,
                        "reviewers"=> $reviewers
                    ]
                ];

            }elseif($infoProcess['idProcessState']==5){ //subir calificaciones
                //Obtener los examenes de admision
                $query6= "SELECT * FROM AdmissionTest";
                $result6 = $this->mysqli->execute_query($query6);

                $admissionTests=[];
                foreach($result6 as $row){
                    $admissionTests[] = [
                        "id" => $row["id"],
                        "name"=>$row["description"],
                        "points"=>$row["points"],
                    ] ;
                }

                return [
                    "status" => true,
                    "message" => "Petición realizada con exito.",
                    "data" => [
                        "idAcademicEvent"=> $idProcess,
                        "infoProcess"=> $infoProcess,
                        "amountInscription"=> $inscriptionInfo,
                        "admissionTests"=> $admissionTests
                    ]
                ];

            }elseif($infoProcess['idProcessState']==6 || $infoProcess['idProcessState']==7){ //Enviar correos o creacion de expedientes
                //Obtener información sobre las estadisticas en los centros regionales
                $query4 = 'CALL RegionalCentersStadistics(?);';

                $result4 = $this->mysqli->execute_query($query4, [$idProcess]);

                $regionalCenters = [];
                foreach($result4 as $row){
                    $regionalCenters[] = [
                        "acronym"=>$row["acronym"],
                        "amountInscriptions"=>$row["amountInscriptions"],
                        "approvedReview"=> $row["approvedReview"],
                        "approvedApplicants"=> $row["approvedApplicants"]
                    ] ;
                }

                $query6 = 'SELECT COUNT(*) as amount FROM Application
                            WHERE academicEvent=? AND (approvedFirstChoice=true OR approvedSecondChoice=true);';

                $result6 = $this->mysqli->execute_query($query6, [$idProcess]);

                foreach($result6 as $row){
                    $approvedStudents= $row['amount'];
                }

                $applications = $this->getApprovedApplications($idProcess, 0);

                $query7 = 'SELECT active FROM SendedEmail
                            WHERE academicProcess=?;';

                $result7 = $this->mysqli->execute_query($query7, [$idProcess]);

                foreach($result7 as $row){
                    $sendedEmail= $row['active'];
                }

                return [
                    "status" => true,
                    "message" => "Petición realizada con exito.",
                    "data" => [
                        "idAcademicEvent"=> $idProcess,
                        "infoProcess"=> $infoProcess,
                        "amountInscription"=> $inscriptionInfo,
                        "regionalCenters" => $regionalCenters,
                        "applications" => $applications,
                        "approvedStudents"=> $approvedStudents,
                        "sendedEmail"=> $sendedEmail
                    ]
                ];
            }else{
                return [
                    "status" => false,
                    "message" => "EL id del subproceso no existe o hubo algun error con ese id."
                ];
            }
        }

        /**
         * author: dorian.contreras@unah.hn
         * version: 0.2.0
         * date: 24/11/24
         */
        public function getInfoHistoricAdmission(int $id){

            //Pasar los meses a español
            $query="SET lc_time_names = 'es_ES';";
            $result= $this->mysqli->execute_query($query);

            //Obtener estadisticas de las inscripciones
            $query1 = 'CALL AmountInscription(?);';
            $result1 = $this->mysqli->execute_query($query1, [$id]);

            if ($row = $result1->fetch_assoc()) {

                $resultJson = $row['resultJson'];

                $resultArray = json_decode($resultJson, true);

                if ($resultArray !== null) {

                    $inscriptionInfo = [
                        "amountInscriptions" => $resultArray['amountInscriptions'],
                        "approvedInscriptions" => $resultArray['approvedInscriptions'],
                        "missingReviewInscriptions" => $resultArray['missingReviewInscriptions']
                    ];

                } else {
                    return [
                        "status" => false,
                        "message" => "Error al decodificar el JSON."
                    ];
                }

            }else {
                return [
                    "status" => false,
                    "message" => "Error al ejecutar el procedimiento: " . $conexion->error
                ];
            }

            //Obtener información sobre las estadisticas en los centros regionales
            $query3 = 'CALL RegionalCentersStadistics(?);';

            $result3 = $this->mysqli->execute_query($query3, [$id]);

            foreach($result3 as $row){
                $regionalCenters[] = [
                    "acronym"=>$row["acronym"],
                    "amountInscriptions"=>$row["amountInscriptions"],
                    "approvedReview"=> $row["approvedReview"],
                    "approvedApplicants"=> $row["approvedApplicants"]
                ] ;
            }

            $result3 = $this->mysqli->execute_query($query3, [$id]);

            //Obtener informacion general del proceso
            $query4="SELECT a.id, CONCAT(b.description,' ', CONCAT(UPPER(LEFT(DATE_FORMAT(a.startDate, '%M'), 1)), SUBSTRING(DATE_FORMAT(a.startDate, '%M'), 2)), ' ', YEAR(a.startDate)) as processName, DATE_FORMAT(a.startDate, '%d de %M, %Y') as start, DATE_FORMAT(a.finalDate, '%d de %M, %Y') as final
                    FROM AcademicEvent a
                    INNER JOIN AcademicProcess b ON (a.process = b.id)
                    WHERE a.id = ?;";
            $result4 = $this->mysqli->execute_query($query4, [$id]);

            foreach($result4 as $row){
                $infoProcess = [
                    "id"=> $row['id'],
                    "name"=>$row["processName"],
                    "start"=>$row["start"],
                    "end"=>$row["final"]
                ] ;
            }

            //Obtener inscripciones
            $applications = $this->getApprovedApplications((int) $infoProcess['id'], 0);

            $query6 = 'SELECT COUNT(*) as amount FROM Application
                        WHERE academicEvent=? AND (approvedFirstChoice=true OR approvedSecondChoice=true);';

            $result6 = $this->mysqli->execute_query($query6, [$id]);

            foreach($result6 as $row){
                $approvedStudents= $row['amount'];
            }

            return [
                "infoProcess"=> $infoProcess,
                "inscriptionInfo"=> $inscriptionInfo,
                "applications"=> $applications,
                "regionalCenters"=>$regionalCenters,
                "approvedStudents"=> $approvedStudents,
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
                            $counter++;
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

                    $missingData = $this->getMissingResults(0, 1);

                    $query1 = "SELECT COUNT(*) as amount
                        FROM Results a 
                        INNER JOIN Application b ON(a.application=b.id)
                        INNER JOIN AcademicEvent c ON(b.academicEvent=c.id)
                        WHERE c.active = true AND a.grade IS NULL;";
                    $result1 = $this->mysqli->execute_query($query1);
                    $reviewers = [];
                    if ($result1) {
                        foreach($result1 as $row){
                            $missingTotalAmount = $row['amount'];
                        } 

                        return [
                            "status" => true,
                            "message" => "CSV leido",
                            "incorrectData"=> $incorrectData,
                            "missingData"=> $missingData,
                            "missingAmount"=> $missingTotalAmount
                        ];

                    }else{
                        return [
                            "status" => true,
                            "message" => "Error al obtener cantidad total de inscripciones faltantes.",
                            "incorrectData"=> $incorrectData,
                            "missingData"=> $missingData,
                            "missingAmount"=> 0
                        ];
                    }

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

        /**
         * author: dorian.contreras@unah.hn
         * version: 0.1.0
         * date: 24/11/24
        */
        public function toReview(int $idReviwer) {
            // Inicializar variables
            $dailyGoal = 0;
            $lowerLimit = NULL;
            $amountReviewed = 0;
            $applications = [];
            $countUnreviewed = 0;
            $countReviewed = 0;
            $unreviewedInscriptions= [];
            $reviewedInscriptions= [];
        
            // Obtener la meta diaria
            $query1 = "SELECT dailyGoal FROM Reviewer WHERE id = ?;";
            $result1 = $this->mysqli->execute_query($query1, [$idReviwer]);
            if ($row = $result1->fetch_assoc()) {
                $dailyGoal = (int) $row['dailyGoal'];
            }
        
            // Obtener aplicaciones revisadas
            $query2 = "SELECT COUNT(*) as amount 
                       FROM Application 
                       WHERE academicEvent = (SELECT id FROM AcademicEvent WHERE active = true AND process = 1) 
                         AND approved IS NOT NULL 
                         AND idReviewer = ?;";
            $result2 = $this->mysqli->execute_query($query2, [$idReviwer]);
            if ($row = $result2->fetch_assoc()) {
                $amountReviewed = (int) $row['amount'];
            }
        
            // Obtener las aplicaciones que va a revisar
            $query = 'CALL ToReview(?);';
            $result = $this->mysqli->execute_query($query, [$idReviwer]);
        
            if($result!= NULL){
                foreach($result as $row){

                    if($row['approved']=== NULL){
                        $unreviewedInscriptions[]=[
                            "id" => $row['id'],
                            "name" => $row['name'],
                            "career" => $row['firstCareer'],
                            "inscriptionDate" => $row['applicationDate']
                        ];
                    }else{
                        $reviewedInscriptions[] = [
                            "id" => $row['id'],
                            "name" => $row['name'],
                            "career" => $row['firstCareer'],
                            "inscriptionDate" => $row['applicationDate'],
                            "dictum"=> $row['approved']                            
                        ];
                    }
                }
            }

            //Obtener información sobre el proceso de admision actual y el subproceso en el que esta
            $query3 = 'CALL InfoCurrentProcessAdmission();';
            $result3 = $this->mysqli->execute_query($query3);

            foreach($result3 as $row){
                //Se recorta para solo mostrar el mes y año del proceso
                $period = substr($row["processName"],22);
            }
            
            if(count($unreviewedInscriptions) > 10){
                $unreviewedList = array_slice($unreviewedInscriptions,count($unreviewedInscriptions)-11, count($unreviewedInscriptions)-1);
            }else{
                $unreviewedList = $unreviewedInscriptions;
            }

            if(count($reviewedInscriptions) > 10){
                $reviewedList = array_slice($reviewedInscriptions,count($reviewedInscriptions)-11, count($reviewedInscriptions)-1);
            }else{
                $reviewedList = $reviewedInscriptions;
            }

            // Retornar los resultados
            return [
                "status" => true,
                "message" => "Petición hecha correctamente.",
                "data" => [
                    "period"=> $period,
                    "stats"=>[
                        "dailyGoal" => $dailyGoal,
                        "amountReviewed" => $amountReviewed
                    ],
                    "unreviewedInscriptions" => [
                        "amountUnreviewed"=> count($unreviewedInscriptions),
                        "unreviewedList"=> $unreviewedList
                    ],
                    "reviewedInscriptions" =>  [
                        "amountReviewed"=> count($reviewedInscriptions),
                        "reviewedList"=> $reviewedList
                    ]
                ]
            ];
        }        

        /**
         * author: dorian.contreras@unah.hn
         * version: 0.1.0
         * date: 25/11/24
        */
        public function getApplication(int $id, int $idAdmissionProcess) {
            $applicant = [];
            $insciption = [];
            $file = NULL;
            $mimeType = NULL;

            if($idAdmissionProcess>0){
                // Obtener la información de la base
                $query = "SELECT a.id as idApplication, CONCAT(b.names, ' ', b.lastNames) as name, 
                    b.id as dni, b.telephoneNumber, b.personalEmail, 
                    c.description as firstCareer, d.description as secondCareer, e.description as regionalCenter, 
                    b.schoolCertificate
                    FROM Application a
                    INNER JOIN Applicant b ON(a.idApplicant=b.id)
                    INNER JOIN DegreeProgram c ON(a.firstDegreeProgramChoice = c.id)
                    INNER JOIN DegreeProgram d ON(a.secondDegreeProgramChoice = d.id)
                    INNER JOIN RegionalCenter e ON(a.regionalCenterChoice = e.id)
                    WHERE a.academicEvent = ? AND a.id = ?;";

                $result = $this->mysqli->execute_query($query, [$idAdmissionProcess, $id]);

                foreach ($result as $row) {
                    // Construir la información del solicitante y la inscripción
                    $applicant = [
                    "name" => $row['name'],
                    "dni" => $row['dni'],
                    "phoneNumber" => $row['telephoneNumber'],
                    "email" => $row['personalEmail']
                    ];
                    $insciption = [
                    "firstOption" => $row['firstCareer'],
                    "secondOption" => $row['secondCareer'],
                    "campus" => $row['regionalCenter'],
                    ];

                    // Procesar el archivo BLOB
                    $file = $row['schoolCertificate']; // BLOB directamente de la base de datos
                }

            }else{
                // Obtener la información de la base
                $query = "SELECT a.id as idApplication, CONCAT(b.names, ' ', b.lastNames) as name, 
                    b.id as dni, b.telephoneNumber, b.personalEmail, 
                    c.description as firstCareer, d.description as secondCareer, e.description as regionalCenter, 
                    b.schoolCertificate
                    FROM Application a
                    INNER JOIN Applicant b ON(a.idApplicant=b.id)
                    INNER JOIN DegreeProgram c ON(a.firstDegreeProgramChoice = c.id)
                    INNER JOIN DegreeProgram d ON(a.secondDegreeProgramChoice = d.id)
                    INNER JOIN RegionalCenter e ON(a.regionalCenterChoice = e.id)
                    WHERE a.academicEvent = (SELECT id FROM AcademicEvent WHERE active = true AND process=1) AND a.id = ?;";

                $result = $this->mysqli->execute_query($query, [$id]);

                foreach ($result as $row) {
                    // Construir la información del solicitante y la inscripción
                    $applicant = [
                    "name" => $row['name'],
                    "dni" => $row['dni'],
                    "phoneNumber" => $row['telephoneNumber'],
                    "email" => $row['personalEmail']
                    ];
                    $insciption = [
                    "firstOption" => $row['firstCareer'],
                    "secondOption" => $row['secondCareer'],
                    "campus" => $row['regionalCenter'],
                    ];

                    // Procesar el archivo BLOB
                    $file = $row['schoolCertificate']; // BLOB directamente de la base de datos
                }

            }
        
            if ($file) {
                $finfo = finfo_open(FILEINFO_MIME_TYPE); // Obtener el tipo MIME
                $mimeType = finfo_buffer($finfo, $file); // Detectar el tipo del archivo
                finfo_close($finfo);

                // Codificar en base64 para la respuesta
                $fileBase64 = base64_encode($file);
            } else {
                $fileBase64 = null;
                $mimeType = null;
            }
            // Retornar los resultados
            if($applicant['dni'] != NULL){
                return [
                    "status" => true,
                    "message" => "Petición hecha correctamente.",
                    "data" => [
                        "applicant" => $applicant,
                        "inscription" => $insciption,
                        "certificate" => [
                            "type" => $mimeType,
                            "content" => $fileBase64 // Archivo codificado en base64
                        ]
                    ]
                ]; 
            }
            
            return [
                "status" => false,
                "message" => "No se encontró la aplicación con el ID proporcionado.",
                "data" => []
            ];
            
        }

        /**
         * author: dorian.contreras@unah.hn
         * version: 0.1.0
         * date: 26/11/24
         * 
         * Funcion para enviar correo en caso se que se invalide una inscripcion
         */
        public function sendAdmissionProcessMail($name, $mail){

            // Configuración del correo
            $subject = "Invalidación de su inscripción de admisión par la UNiversidad Nacional Autónoma de Honduras";
            $from = "noreply@unah.com";
            $date = date("d/m/Y");
            $link= "http://3.138.199.65";
            $to = $mail;

            // Crear el contenido del mensaje HTML con encabezados
            $message = <<<EOD
            Subject: $subject
            From: $from
            Reply-To: $from
            MIME-Version: 1.0
            Content-Type: text/html; charset=UTF-8

            <html>
            <head>
                <title>Correo HTML Formateado</title>
            </head>
            <body style="font-family: Arial, sans-serif; color: #333;">
                <h1 style="color: #007BFF;">¡Hola, $name!</h1>
                <p>Por este medio la Direccion de Admisiones de la UNAH le informa que su inscripción fue invalidada por nuestro comité de revisión de inscripciones
                por no cumplir con los requerimientos especificados al momento de hacer su inscripción. Esto debido a que subió un archivo incorrecto de su certificación
                de estudios.</p>
                <p>Le recordamos que para futuras inscripciones valide que su archivo sea legible.</p>
                <p>Este correo fue enviado el <strong>$date</strong> y contiene un enlace a <a href="$link">nuestro sitio web</a>.</p>
                <footer>
                    <p style="font-size: 0.9em; color: #555;">Gracias por elegir nuestro servicio.</p>
                </footer>
            </body>
            </html>
            EOD;

            // Guardar el mensaje en un archivo temporal
            $tempFile = tempnam(sys_get_temp_dir(), 'msmtp_email');
            file_put_contents($tempFile, $message);

            // Enviar el correo usando msmtp con el archivo temporal
            $command = "msmtp $to < $tempFile";
            $output = shell_exec($command);

            // Eliminar el archivo temporal
            unlink($tempFile);

            // Confirmación de envío
            if ($output === null) {
                return true;
            } else {
                return false;
            }

        }

        /**
         * author: dorian.contreras@unah.hn
         * version: 0.1.0
         * date: 25/11/24
        */
        public function setApprovedApplication(int $idApplication, int $idReviewer, int $approved, string $name, string $email){

            //Update en la tabla de temporal
            $query = 'UPDATE TempTableApplication
                    SET approved=?
                    WHERE id=?;';
            $result = $this->mysqli->execute_query($query, [$approved, $idApplication]);

            if(!$result){
                return [
                    "status"=> false,
                    "message"=> "Hubo un error al hacer update en la tabla temporal."
                ];
            }

            //update en la tabla application
            $query1 = 'UPDATE Application
                    SET approved=?, idReviewer=?
                    WHERE id=?;';
            $result1 = $this->mysqli->execute_query($query1, [$approved, $idReviewer, $idApplication]);

            if(!$result1){
                return [
                    "status"=> false,
                    "message"=> "Hubo un error al hacer update en la tabla Application."
                ];
            }

            if($approved === 0){

                //Eliminar los datos en Results
                $query2 = "DELETE FROM Results where application = ?;";
                $result2 = $this->mysqli->execute_query($query2, [$idApplication]);

                if(!$result2){
                    return [
                        "status"=> false,
                        "message"=> "Hubo un error al borrar los registros de la tabla result."
                    ];
                }

                $statusEmail = $this->sendAdmissionProcessMail($name, $email);

                //Enviar correo
                if($statusEmail){
                    return [
                        "status"=> true,
                        "message"=> "Incripción verificada y correo enviado."
                    ];
                }else{
                    return [
                        "status"=> false,
                        "message"=> "Hubo un error al enviar correo al postulante."
                    ];
                }
            }   
            
                            
            return [
                "status"=> true,
                "message"=> "Incripción verificada."
            ];
            
        }
        

        // Método para cerrar la conexión
        public function closeConnection() {
            $this->mysqli->close();
        }

    }
?>