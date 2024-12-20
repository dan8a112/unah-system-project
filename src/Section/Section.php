<?php

    Class SectionDAO{

        private $mysqli;

        public function __construct(string $server, string $user, string $pass, string $dbName) {
            $this->mysqli = new mysqli($server, $user, $pass, $dbName);
        }

        /**
         * author: dorian.contreras@unah.hn
         * version: 0.1.0
         * date: 6/12/24
         * 
         * Funcion para obtener los primeros 10 estudiantes de una seccion
         */
        public function getStudentsSection(int $id, int $offset){
            $query = 'SELECT b.account, b.name, a.grade as calification, c.observation
                        FROM StudentSection a
                        INNER JOIN Student b ON (a.studentAccount = b.account)
                        LEFT JOIN Observation c ON (c.id = a.observation)
                        WHERE a.section = ? AND a.waiting = false
                        ORDER BY b.account ASC
                        LIMIT 10 OFFSET ?;';
            $result = $this->mysqli->execute_query($query, [$id, $offset]);
            $students = [];
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $students [] = $row;
                }
            } 

            $query1 = "SELECT COUNT(*) as amount FROM StudentSection WHERE section = ? AND waiting = false;";

            $result1 = $this->mysqli->execute_query($query1, [$id]);

            $amount = 0;
            if ($result1) {
               $amount = $result1->fetch_assoc();
            } 

            return  [
                "studentsList"=> $students,
                "amountStudents"=> $amount['amount']
            ];
        }

        /**
         * author: dorian.contreras@unah.hn
         * version: 0.1.0
         * date: 6/12/24
         * 
         * Funcion para obtener los primeros 10 estudiantes en lista de espera de una seccion
         */
        public function getWaitingStudents(int $id, int $offset){
            $query = 'SELECT b.account, b.name, b.email
                    FROM StudentSection a
                    INNER JOIN Student b ON (a.studentAccount = b.account)
                    LEFT JOIN Observation c ON (c.id = a.observation)
                    WHERE a.section = ? AND a.waiting = true
                    ORDER BY b.account ASC
                    LIMIT 10 OFFSET ?;';
            $result = $this->mysqli->execute_query($query, [$id, $offset]);
            $students = [];
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $students [] = $row;
                }
            } 

            $query1 = "SELECT COUNT(*) as amount FROM StudentSection WHERE section = ? AND waiting = true;";

            $result1 = $this->mysqli->execute_query($query1, [$id]);

            $amount = 0;
            if ($result1) {
               $amount = $result1->fetch_assoc();
            } 

            return  [
                "waitingStudentList"=> $students,
                "amountWaitingStudents"=> $amount['amount']
            ];
        }

        /**
         * author: dorian.contreras@unah.hn
         * version: 0.1.0
         * date: 6/12/24
         * 
         * Funcion para ver las calificaciones de los estudiantes de una seccion en especifico
         */

        public function getGradesSection(int $id){
            //Obtener información de la seccion y el periodo
            $query = 'SELECT b.description as subjectName, CONCAT(f.names, " ", f.lastNames) as professor, CONCAT(LPAD(CAST(a.section AS CHAR), 4, "0"), " | ", b.id )as denomination, 
                            a.academicEvent as periodId, CONCAT(d.description, " ", year(startDate)) as periodName
                    FROM Section a
                    INNER JOIN Subject b ON (a.subject = b.id)
                    INNER JOIN AcademicEvent c ON (a.academicEvent = c.id)
                    INNER JOIN AcademicProcess d ON (d.id = c.process)
                    INNER JOIN Employee f ON (a.professor = f.id)
                    WHERE a.id = ?;';
            $result = $this->mysqli->execute_query($query, [$id]);
            
            if($result){
                $info = $result->fetch_assoc();
                $students = $this->getStudentsSection($id, 0);
                return [
                    "status"=> true,
                    "message"=> "Petición realizada con exito",
                    "data"=> [
                        "sectionInfo"=>[
                            "name"=> $info['subjectName'],
                            "professor"=>$info['professor'],
                            "denomination"=>$info['denomination'],
                        ],
                        "students"=> $students,
                        "period"=>[
                            "id"=>$info['periodId'],
                            "name"=> $info['periodName']
                        ]
                    ]
                ];

            }else{
                return [
                    "status"=> false,
                    "message"=> "Error al consultar la información de la sección y el periodo"
                ];
            }

        }

        /**
         * author: dorian.contreras@unah.hn
         * version: 0.1.0
         * date: 6/12/24
         * 
         * Funcion para obtener la informacion de una sección
         */
        public function getSectionBossDepartment(int $id){

            //Obtener detalle de la seccion
            $query= 'SELECT a.id as sectionId, 
                            LPAD(CAST(a.section AS CHAR), 4, "0") as code, 
                            b.description as subjectName,
                            b.id as subjectId,
                            a.section, 
                            c.description as days, 
                            c.id as idDays,
                            b.uv, 
                            a.startHour, 
                            a.finishHour, d.id as classroomId, 
                            d.description as classroom, 
                            d.building as classroomBuilding,
                            CONCAT(f.names, " ", f.lastNames) as professorName, 
                            f.id as professorId,
                            a.maximumCapacity,
                            e.id as idBuilding,
                            e.description as building
                    FROM Section a
                    INNER JOIN Subject b ON (a.subject = b.id)
                    INNER JOIN Days c ON (a.days = c.id)
                    INNER JOIN Classroom d ON (a.classroom = d.id)
                    INNER JOIN Building e ON (d.building = e.id)
                    INNER JOIN Employee f ON (a.professor = f.id)
                    WHERE a.id = ?;';
            $result = $this->mysqli->execute_query($query, [$id]);
            
            if($result){
                $info = $result->fetch_assoc();
                //obtener estudiantes en lista de espera
                $waiting = $this->getWaitingStudents($id, 0);
                $students = $this ->getStudentsSection($id, 0);
                return [
                    "status"=> true,
                    "message"=> "Petición realizada con exito",
                    "data"=> [
                        "code"=> $info['code'],
                        "professor"=>[
                            "id"=> $info['professorId'],
                            "name"=>$info['professorName']
                        ],
                        "places"=>$info['maximumCapacity'],
                        "classrom"=>[
                            "id"=>$info['classroomId'],
                            "name"=> $info['classroom'],
                            "idBuilding"=> $info['classroomBuilding']
                        ],
                        "building"=>[
                            "id"=>$info['idBuilding'],
                            "name"=> $info['building']
                        ],
                        "amountWaitingStudents"=>$waiting['amountWaitingStudents'],
                        "waitingStudentList"=> $waiting['waitingStudentList'],
                        'amountStudents'=> $students['amountStudents'],
                        "studentsList"=> $students['studentsList'],
                        "days" => [
                            "id" => $info['idDays'],
                            "name" => $info['days']
                        ],
                        "class"=> [
                            "id" => $info['subjectId'],
                            "name" =>$info['subjectName']
                        ],
                        "uv"=> $info['uv'],
                        "startHour"=> $info['startHour'],
                        "finishHour"=> $info['finishHour'],
                    ]
                ];

            }else{
                return [
                    "status"=> false,
                    "message"=> "Error al consultar la información de la sección."
                ];
            }
        }

        /**
         * author: dorian.contreras@unah.hn
         * version: 0.1.0
         * date: 9/12/24
         * 
         * Funcion para crear una sección
         */

        public function setSection($class, $professor, $days, $startHour, $finishHour, $classroom, $places){
            //obtener el horario para formatearlo => '%Lu%Ju%'
            $query= 'SELECT description FROM Days WHERE id=?;';
            $result= $this->mysqli->execute_query($query, [$days]);

            if($result){
                $stringDays = $result->fetch_assoc();
                $output = preg_replace('/([A-Z][a-z]*)/', '%$1', $stringDays['description']) . '%';
                
                //Llamar al procedimiento almacenado de las query
                $query1 = 'CALL insertSection(?, ?, ?, ?, ?, ?, ?, ?);';
                $result1 = $this->mysqli->execute_query($query1, [$class, $professor, $days, $startHour, $finishHour, $classroom, $places, $output]);
                if($result1){
                    $row = $result1->fetch_assoc();

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
                    

                }else{
                    return [
                        "status"=> false,
                        "message"=> "Error al chacer el insert de la sección."
                    ];
                }

            }else{
                return [
                    "status"=> false,
                    "message"=> "Error al consultar el horario seleccionado."
                ];
            }
        }

        /**
         * author: dorian.contreras@unah.hn
         * version: 0.1.0
         * date: 9/12/24
         * 
         * Funcion para modificar una sección
         */

         public function updateSection($id, $class, $professor, $days, $startHour, $finishHour, $classroom, $places){
            //obtener el horario para formatearlo => '%Lu%Ju%'
            $query= 'SELECT description FROM Days WHERE id=?;';
            $result= $this->mysqli->execute_query($query, [$days]);

            if($result){
                $stringDays = $result->fetch_assoc();
                $output = preg_replace('/([A-Z][a-z]*)/', '%$1', $stringDays['description']) . '%';
                
                //Llamar al procedimiento almacenado de las query
                $query1 = 'CALL updateSection(?, ?, ?, ?, ?, ?, ?, ?, ?);';
                $result1 = $this->mysqli->execute_query($query1, [$id, $class, $professor, $days, $startHour, $finishHour, $classroom, $places, $output]);
                if($result1){
                    $row = $result1->fetch_assoc();

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
                    

                }else{
                    return [
                        "status"=> false,
                        "message"=> "Error al chacer el insert de la sección."
                    ];
                }

            }else{
                return [
                    "status"=> false,
                    "message"=> "Error al consultar el horario seleccionado."
                ];
            }
        }

        /**
         * author: dorian.contreras@unah.hn
         * version: 0.1.0
         * date: 9/12/24
         * 
         * Funcion para cancelar seccion validando unicamente la cantidad de estudiantes
         */
        public function canceledSection(int $id){
            $query = 'Call canceledSection(?);';
            $result = $this->mysqli->execute_query($query, [$id]);

            if($result){
                $row = $result->fetch_assoc();

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

            }else{
                return [
                    'status'=> false,
                    'message'=> "Error al hacer la consulta."
                ];
            }

        }

        /**
         * author: dorian.contreras@unah.hn
         * version: 0.1.0
         * date: 10/12/24
         * 
         * Funcion para obtener detalle de una seccion para un docente
         */
        public function getSectionProfessor(int $id){

            //Obtener detalle de la seccion
            $query= 'SELECT a.id as sectionId,  
                            LPAD(CAST(a.section AS CHAR), 4, "0") as code,  
                            b.description as subjectName, 
                            b.id as subjectId, 
                            a.section,  
                            CONCAT(g.description, " ", year(f.startDate)) as period,
                            c.description as days, 
                            b.uv,  
                            a.startHour,  
                            a.finishHour, d.id as classroomId,  
                            CONCAT(d.description, " ", e.description ) as classroom,
                            a.presentationVideo, a.academicEvent 
                    FROM Section a 
                    INNER JOIN Subject b ON (a.subject = b.id) 
                    INNER JOIN Days c ON (a.days = c.id) 
                    INNER JOIN Classroom d ON (a.classroom = d.id) 
                    INNER JOIN Building e ON (d.building = e.id) 
                    INNER JOIN AcademicEvent f ON (a.academicEvent = f.id) 
                    INNER JOIN AcademicProcess g ON (f.process = g.id) 
                    WHERE a.id = ?;';
            $result = $this->mysqli->execute_query($query, [$id]);
            
            if($result){
                $section = $result->fetch_assoc();

                if($section['presentationVideo'] === NULL){
                    $video = false;
                }else{
                    $video = true;
                }
                $students = $this ->getStudentsSection($id, 0);
                
                //obtener informacion del subproceso
                $query1 = 'SELECT a.id as processId, CONCAT(d.description, " ", year(a.startDate)) as period, c.id as subprocessId, c.description, DATE(b.startDate) as startDate, DATE(b.finalDate) as finalDate
                        FROM AcademicEvent a
                        INNER JOIN AcademicEvent b ON (a.id = b.parentId)
                        INNER JOIN AcademicProcess c ON (b.process = c.id)
                        INNER JOIN AcademicProcess d ON (a.process = d.id)
                        WHERE b.parentId = (SELECT actualAcademicPeriod())
                        AND b.active=true;';
                $result1 = $this->mysqli->execute_query($query1);
                if($result1){
                    $period = $result1->fetch_assoc();

                    if($section['academicEvent']==$period['processId']){
                        $inActualPeriod = true;
                    }else{
                        $inActualPeriod = false;
                    }

                    $response = [
                        "status" => true,
                        "message" => "Petición realizada con éxito",
                        "data" => [
                            "stateProcess" => $period['subprocessId'],
                            "processName" => $period['description'],
                            "infoSection" => [
                                "start" => $period['startDate'],
                                "end" => $period['finalDate'],
                                "sectionDetails" => [
                                    "id" => $section['sectionId'],
                                    "name" => $section['subjectName'],
                                    "denomination" => $section['section'],
                                    "code" => $section['subjectId'],
                                    "valueUnits" => $section['uv'],
                                    "start" => $section['startHour'],
                                    "end" => $section['finishHour'],
                                    "days" => $section['days'],
                                    "classroom" => $section['classroom'],
                                    "period" => $section['period']
                                ],
                                "students" => $students,
                                "video" => $video,
                                "inActualPeriod"=> $inActualPeriod
                            ]
                        ]
                    ];                    

                    if($period['subprocessId']==17){
                        //Obtener la informacion de la tabla de observaciones
                        $observations = [];
                        $query2 = "SELECT * FROM Observation WHERE id!=5;";
                        $result2 = $this->mysqli->execute_query($query2);
                        if ($result2) {
                            while ($row = $result2->fetch_assoc()) {
                                $observations [] = $row;
                            }
                        }
                        $response['observations']= $observations;
                    }

                    return $response;

                }else{
                    return [
                        "status"=> false,
                        "message"=> "Error al consultar la información sobre el periodo academico."
                    ];
                }
                

            }else{
                return [
                    "status"=> false,
                    "message"=> "Error al consultar la información de la sección."
                ];
            }
        }

         /**
         * author: dorian.contreras@unah.hn
         * version: 0.1.0
         * date: 12/11/24
         * 
         * Funcion para leer el csv de las notas
        */
        public function insertGrades($path, int $idSection){
            $expectedHeaders = ['account', 'grade', 'obs'];
            $incorrectData = [];
            $counter = 1;

            if (($handle = fopen($path, 'r')) !== false) {
                // Leer la primera línea (encabezados)
                $headers = fgetcsv($handle, 1000, ',');
                
                if ($headers === $expectedHeaders) {
                    // Leer cada línea del archivo
                    while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                        // Mapear los datos a variables
                        $account = $data[0];
                        $grade = $data[1];
                        $obs = $data[2];

                        if (filter_var($grade, FILTER_VALIDATE_FLOAT) === false || filter_var($obs, FILTER_VALIDATE_INT) === false) {
                            $incorrectData []= [
                                $counter,
                                $account,
                                $grade,
                                $obs,
                                'Tipo de dato incorrecto en alguna columna.'
                            ];
                            $counter++;
                            continue;
                        }
                
                        // update los datos en la base de datos
                        $query= "CALL updateGradeStudent(?, ?, ?, ?);";

                        try{
                            $result = $this->mysqli->execute_query($query, [$account, (float) $grade, (int) $obs, $idSection]);
                            
                            if ($row = $result->fetch_assoc()) {

                                $resultJson = $row['resultJson'];

                                $resultArray = json_decode($resultJson, true);

                                if (!$resultArray['status']) {
                                    $incorrectData []= [
                                        $counter,
                                        $account,
                                        $grade,
                                        $obs,
                                        $resultArray['message']
                                    ];
                                }
                            }else {
                                $incorrectData []= [
                                    $counter,
                                    $account,
                                    $grade,
                                    $obs,
                                    "Error al ejecutar el procedimiento: " . $conexion->error
                                ];
                            }
                            
                        }catch (Exception $e){
                            $incorrectData []= [
                                $counter,
                                $account,
                                $grade,
                                $obs,
                                "Error-> ". $e
                            ];
                        }

                       $counter++;
                    }
                
                    fclose($handle);

                    $query1 = "SELECT b.account, b.name FROM StudentSection a
                        INNER JOIN Student b ON (a.studentAccount = b.account) 
                        WHERE section=? AND (grade IS NULL OR observation IS NULL);";
                    $result1 = $this->mysqli->execute_query($query1, [$idSection]);
                    $missingData = [];
                    if ($result1) {
                        while ($row = $result1->fetch_assoc()){
                            $missingData[]= $row;
                        }

                        return [
                            "status" => true,
                            "message" => "CSV leido",
                            "incorrectData"=> $incorrectData,
                            "missingData"=> $missingData
                        ];

                    }else{
                        return [
                            "status" => true,
                            "message" => "Error al obtener los estudiantes faltantes.",
                            "incorrectData"=> $incorrectData,
                            "missingData"=> $missingData
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

        // Método para cerrar la conexión
        public function closeConnection() {
            $this->mysqli->close();
        }

    }
?>
