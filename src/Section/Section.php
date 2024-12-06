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
         * Funcion para obtener los primeros 10 estudiantes para ver sus calificaciones
         */
        public function getStudentsGrades(int $id, int $offset){
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
                $students = $this->getStudentsGrades($id, 0);
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
        
        // Método para cerrar la conexión
        public function closeConnection() {
            $this->mysqli->close();
        }

    }
?>
