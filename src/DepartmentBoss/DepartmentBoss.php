<?php

    class DepartmentBossDAO{

        public function __construct(string $server, string $user, string $pass, string $dbName) {
            $this->mysqli = new mysqli($server, $user, $pass, $dbName);
        }

        /**
         * author: dorian.contreras@unah.hn
         * version: 0.1.0
         * date: 5/12/24
         * 
         * Funcion para paginar el total de secciones de un proceso sin incluir las secciones canceladas 
         */
        public function getSections(int $idProcess, int $offset, int $idBoss){
            $query = 'SELECT a.id as id, LPAD(CAST(a.section AS CHAR), 4, "0") as denomination, b.description as class, a.maximumCapacity as places, 
                    CONCAT(a.startHour, ":00") as hour
                FROM Section a
                INNER JOIN Subject b ON (a.subject = b.id) 
                INNER JOIN Professor c ON (c.department = b.department)
                WHERE academicEvent = ? AND a.canceled = false AND c.id = ?
                ORDER BY b.id ASC
                LIMIT 10 OFFSET ?;';
            $result = $this->mysqli->execute_query($query, [$idProcess, $idBoss, $offset]);
            $sections = [];
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $sections [] = $row;
                }
            } 

            $query1 = "SELECT COUNT(*) as amount
                    FROM Section a
                    INNER JOIN Subject b ON (a.subject = b.id)
                    INNER JOIN Professor c ON (c.department = b.department)
                    WHERE academicEvent = ? AND a.canceled = false AND c.id = ?;";

            $result1 = $this->mysqli->execute_query($query1, [$idProcess, $idBoss]);

            $amountSections = 0;
            if ($result1) {
               $amountSections = $result1->fetch_assoc();
            } 

            return  [
                "sectionList"=> $sections,
                "amountSections"=> $amountSections['amount']
            ];
        }

        /**
         * author: dorian.contreras@unah.hn
         * version: 0.1.0
         * date: 5/12/24
         * 
         * Funcion para obtener la información para el home page del jefe de departamento
         */
        public function ratingsDepartmentBoss(int $id){

            //Obtener periodos pasados
            $query = 'SELECT a.id, CONCAT(b.description, " ", year(startDate)) as name 
                FROM AcademicEvent a
                INNER JOIN AcademicProcess b ON (a.process = b.id)
                WHERE b.id IN (8,9,10) AND a.active = false;';
            $result = $this->mysqli->execute_query($query);
            if ($result) {
                $periods = [];
                while ($row = $result->fetch_assoc()) {
                    $periods [] = $row;
                }

                //obtener el periodo actual
                $query1 = 'SELECT a.id, CONCAT(b.description, " ", year(startDate)) as description 
                    FROM AcademicEvent a
                    INNER JOIN AcademicProcess b ON (a.process = b.id)
                    WHERE a.id = (SELECT actualAcademicPeriod());';
                $result1 = $this->mysqli->execute_query($query1);
                if ($result1) {
                    $currentPeriod = $result1->fetch_assoc();
                    $sections = [];
                    if($currentPeriod!=NULL){
                        //Obtener secciones
                        $sections = $this->getSections($currentPeriod['id'], 0, $id);
                    }
                    return [
                        "status"=> true,
                        "message"=> "Petición realizada con exito",
                        "periods"=> $periods,
                        "currentPeriod"=> $currentPeriod,
                        "sections"=> $sections
                    ];

                } else{
                    return [
                        "status"=> false,
                        "message"=> "Error al traer periodo actual."
                    ];
                }

            } else{
                return [
                    "status"=> false,
                    "message"=> "Error al traer los periodos historicos."
                ];
            }
            
        }

        /**
         * author: dorian.contreras@unah.hn
         * version: 0.1.0
         * date: 6/12/24
         * 
         * Funcion para la administración de secciones
         */
        public function sectionAdministration(int $id){
            //obtener departamento
            $query= 'SELECT CONCAT("Departamento de ", b.description) as department FROM Professor a
                    INNER JOIN Department b ON (a.department = b.id) WHERE a.id=?;';
            $result= $this->mysqli->execute_query($query, [$id]);

            if($result){
                $department = $result->fetch_assoc();

                //obtener info del periodo actual
                $query1= 'SELECT a.id, CONCAT(b.description, " ", year(startDate)) as description 
                    FROM AcademicEvent a
                    INNER JOIN AcademicProcess b ON (a.process = b.id)
                    WHERE a.id = (SELECT actualAcademicPeriod());';
                $result1= $this->mysqli->execute_query($query1);

                if($result1){
                    $period= $result1 ->fetch_assoc();

                    //Traer las primeras 10 secciones
                    $sectionsInfo = $this->getSections($period['id'], 0, $id);
                    
                    //Ver si se esta en matricula, prematricula o planificacion academica para poder crear secciones
                    $query2 = 'SELECT 1 as active 
                        FROM AcademicEvent a
                        INNER JOIN AcademicEvent b ON (b.parentId = a.id)
                        WHERE a.id = (SELECT actualAcademicPeriod()) AND b.process IN (11, 12, 13) AND b.active = true;';
                    $result2 = $this->mysqli->execute_query($query2);

                    if($result2){
                        $row= $result2 ->fetch_assoc();
                        if($row['active'] === 1){
                            $isActive = true;
                        }else{
                            $isActive = false;
                        }
                        return[
                            "status"=> true,
                            "message"=> "Petición realizada con exito.",
                            "data"=> [
                                "period"=>$period,
                                "department"=> $department['department'],
                                "amountSections"=> $sectionsInfo['amountSections'],
                                "sections"=> $sectionsInfo['sectionList'],
                                'isActive'=> $isActive
                            ]
                        ];

                    }
                }else{
                    return [
                        "status"=> false,
                        "message"=> "Error al traer la información del periodo académico actual."
                    ];
                }
            }else{
                return [
                    "status"=> false,
                    "message"=> "Error al consultar el departamento del jefe"
                ];
            }
        }

        /**
         * author: dorian.contreras@unah.hn
         * version: 0.1.0
         * date: 9/12/24
         * 
         * Funcion para insertar una seccion
         */
        public function getProfessorsClassroomsAvailable(int $idDays, int $startHour, int $finishHour){
            //obtener el horario para formatearlo => '%Lu%Ju%'
            $query= 'SELECT description FROM Days WHERE id=?;';
            $result= $this->mysqli->execute_query($query, [$idDays]);

            if($result){
                $stringDays = $result->fetch_assoc();
                $output = preg_replace('/([A-Z][a-z]*)/', '%$1', $stringDays['description']) . '%';
                
                //Obtener docentes
                $query1 = 'SELECT DISTINCT a.id, CONCAT(d.names, " ", d.lastNames) as name
                    FROM Professor a
                    LEFT JOIN Section b ON (b.professor = a.id)
                    LEFT JOIN Employee d ON (a.id = d.id)
                    WHERE a.id NOT IN (
                        SELECT b.professor
                        FROM Section b
                        LEFT JOIN Days c ON b.days = c.id
                        WHERE c.description LIKE ? AND b.startHour>=? AND b.finishHour<=? AND b.academicEvent = (SELECT actualAcademicPeriod())
                    ) AND a.active = true;';
                $result1 = $this->mysqli->execute_query($query1, [$output, $startHour, $finishHour]);
                if($result1){
                    $professors = [];
                    while ($row = $result1->fetch_assoc()) {
                        $professors [] = $row;
                    };

                    //Obtener aulas
                    $query2 = 'SELECT DISTINCT a.id as classroomId, a.description as name, a.building as idBuilding
                            FROM Classroom a
                            LEFT JOIN Section b ON (b.classroom = a.id)
                            WHERE a.id NOT IN (
                                SELECT b.classroom
                                FROM Section b
                                LEFT JOIN Classroom c ON b.classroom = c.id
                                LEFT JOIN Days d ON b.days = d.id
                                WHERE d.description LIKE ? AND b.startHour>=? AND b.finishHour<=? AND b.academicEvent = (SELECT actualAcademicPeriod())
                            );';
                    $result2 = $this->mysqli->execute_query($query2, [$output, $startHour, $finishHour]);

                    if($result2){
                        $classrooms = [];
                        while ($row = $result2->fetch_assoc()) {
                            $classrooms [] = $row;
                        };

                        //obtener edificios
                        $query3 = "SELECT id, description  as building FROM Building;";
                        $result3 = $this->mysqli->execute_query($query3);

                        if($result3){
                            $buildings = [];
                            while($row = $result3->fetch_assoc()){
                                $buildings[] = $row;
                            }

                            return[
                                "status"=> true,
                                "message"=> 'Petición realizada correctamente.',
                                "data"=>[
                                    'professors'=> $professors,
                                    'buildings'=> $buildings,
                                    'classrooms'=> $classrooms
                                ]
                            ];

                        }else{
                            return [
                                "status"=> false,
                                "message"=> "Error al consultar los edificios."
                            ];
                        }

                    }else{
                        return [
                            "status"=> false,
                            "message"=> "Error al consultar las clases disponibles."
                        ];
                    }
                    

                }else{
                    return [
                        "status"=> false,
                        "message"=> "Error al consultar los profesores disponibles."
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
         * author: wamorales@unah.hn
         * version: 0.1.0
         * date: 10/12/24
         *
         * Función para obtener las secciones asignadas a un docente dado su id.
         */
        public function getProfessorSections(int $professorId, int $periodId) {
            // Consulta para obtener la información del profesor
            $queryProfessorInfo = "SELECT CONCAT(Employee.names, ' ', Employee.lastNames) AS professorName
                                    FROM Professor 
                                    INNER JOIN Employee ON Professor.id=Employee.id
                                    WHERE Professor.id=?;
            ";
            
            $resultProfessorInfo = $this->mysqli->execute_query($queryProfessorInfo, [$professorId]);

            if (!$resultProfessorInfo) {
                return [
                    "status" => false,
                    "message" => "Error al obtener la información del profesor."
                ];
            }

            $professorInfo = $resultProfessorInfo->fetch_assoc();

            // Consulta para obtener las secciones del profesor
            $querySections = 'SELECT a.id as id, CONCAT(LPAD(CAST(a.section AS CHAR), 4, "0"))as code, b.description as class, b.id as classCode 
                            FROM Section a
                            INNER JOIN Subject b ON (a.subject = b.id)
                            WHERE a.professor = ? AND academicEvent = ?;';

            $resultSections = $this->mysqli->execute_query($querySections, [$professorId, $periodId]);

            $sectionsList = [];
            if ($resultSections) {
                while ($row = $resultSections->fetch_assoc()) {
                    $sectionsList[] = $row;
                }
            }

            // Retorno de los datos
            return [
                "status" => true,
                "message" => "Petición realizada con éxito.",
                "data" => [
                    "professorName" => $professorInfo['professorName'],
                    "sections" => $sectionsList
                ]
            ];
        }

        /**
         * author: dorian.contreras@unah.hn
         * version: 0.1.0
         * date: 11/12/24
         *
         * Función para obtener la cantidad de secciones que tuvo un docente en un periodo academico
         */
        public function getProfessorsAmountSections($idPeriod, $offset){
            $query2 = 'SELECT DISTINCT a.id, 
                CONCAT(c.names, " ", c.lastNames) AS name, 
                c.personalEmail,
                COUNT(b.id) AS sectionCount
            FROM Professor a
            INNER JOIN Section b ON a.id = b.professor
            INNER JOIN Employee c ON a.id = c.id
            WHERE b.academicEvent = ?
            GROUP BY a.id, c.names, c.lastNames, c.personalEmail
            LIMIT 10 OFFSET ?;';

            $result2 = $this->mysqli->execute_query($query2, [$idPeriod, $offset]);

            $professors = [];
            if($result2){
                while($row = $result2->fetch_assoc()){
                    $professors []= $row;
                }
            }  
            
            $amountProfessors = 0;
            $query = 'SELECT COUNT(DISTINCT a.id) AS amount
                FROM Professor a
                INNER JOIN Section b ON a.id = b.professor
                INNER JOIN Employee c ON a.id = c.id
                WHERE b.academicEvent = ?;';
            $result = $this->mysqli->execute_query($query, [$idPeriod]);

            if ($result) {
                $amountProfessors = $result->fetch_assoc();
            } 
 
            return  [
                "professors"=> $professors,
                "amountProfessors"=> $amountProfessors['amount']
            ];

        }

        /**
         * author: dorian.contreras@unah.hn
         * version: 0.1.0
         * date: 11/12/24
         *
         * Función para obtener informacion de los docentes y cuantas clases impartieron en deterinado periodo
         */
        public function getProfessorsForEvaluations($id){
            //obtener info del periodo
            if($id===0){ //periodo actual
                $query= 'SELECT a.id, CONCAT(b.description, " ", year(startDate)) as name 
                    FROM AcademicEvent a
                    INNER JOIN AcademicProcess b ON (a.process = b.id)
                    WHERE a.id = (SELECT actualAcademicPeriod());';
                
                $result = $this->mysqli->execute_query($query);
            }else{ //cualquier otro periodo
                $query= 'SELECT a.id, CONCAT(b.description, " ", year(startDate)) as name
                    FROM AcademicEvent a
                    INNER JOIN AcademicProcess b ON (a.process = b.id)
                    WHERE a.id = ?;';
                $result = $this->mysqli->execute_query($query, [$id]);
            }
            if($result){
                $period = $result->fetch_assoc();
                $professors = $this->getProfessorsAmountSections($period['id'], 0);
                return [
                    "status"=> true,
                    "message"=> "Peticion realizada correctamente.",
                    "data"=>[
                        'amountProfessors'=> $professors['amountProfessors'],
                        'period'=>$period,
                        'professors'=> $professors['professors']
                    ]
                ];

            }else{
                return [
                    "status"=> false,
                    "message"=> "Error al consultar informacion del periodo."
                ];
            }

        }

        // Método para cerrar la conexión
        public function closeConnection() {
            $this->mysqli->close();
        }
        
    }
?>