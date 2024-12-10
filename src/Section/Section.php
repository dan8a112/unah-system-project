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
            $query = 'SELECT b.account, CONCAT(b.name, " ", b.lastName) as name, a.grade as calification, c.observation
                        FROM StudentSection a
                        INNER JOIN Student b ON (a.studentAccount = b.account)
                        INNER JOIN Observation c ON (c.id = a.observation)
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
            $query = 'SELECT b.account, CONCAT(b.name, " ", b.lastName) as name, b.email
                    FROM StudentSection a
                    INNER JOIN Student b ON (a.studentAccount = b.account)
                    INNER JOIN Observation c ON (c.id = a.observation)
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
                        "className"=> $info['subjectName'],
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

        // Método para cerrar la conexión
        public function closeConnection() {
            $this->mysqli->close();
        }

    }
?>
