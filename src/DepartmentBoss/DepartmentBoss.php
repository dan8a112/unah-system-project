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
                    a.startHour as hour
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
                $row = $result->fetch_assoc();

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

                    return[
                        "status"=> true,
                        "message"=> "Petición realizada con exito.",
                        "data"=> [
                            "period"=>$period,
                            "department"=> $row['department'],
                            "amountSections"=> $sectionsInfo['amountSections'],
                            "sections"=> $sectionsInfo['sectionList']
                        ]
                        ];
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
                    $query2 = 'SELECT DISTINCT a.id as classroomId, CONCAT(a.description, " ", d.description) as name
                            FROM Classroom a
                            LEFT JOIN Section b ON (b.classroom = a.id)
                            LEFT JOIN Building d ON (a.building = d.id)
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

                        return[
                            "status"=> true,
                            "message"=> 'Petición realizada correctamente.',
                            "data"=>[
                                'professors'=> $professors,
                                'classrooms'=> $classrooms
                            ]
                        ];

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
         * author: dorian.contreras@unah.hn
         * version: 0.1.0
         * date: 9/12/24
         * 
         * Funcion para insertar una seccion
         */
        public function setSection(){

        }

        // Método para cerrar la conexión
        public function closeConnection() {
            $this->mysqli->close();
        }
        
    }
?>