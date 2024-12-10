<?php
    class GenericGetDAO{

        private $mysqli;

        public function __construct(string $server, string $user, string $pass, string $dbName) {
            $this->mysqli = new mysqli($server, $user, $pass, $dbName);
        }

        /**
         * author: dorian.contreras@unah.hn
         * version: 0.2.0
         * date: 5/11/24
         */
        public function getDegrees() : array {

            $degrees = [];
            $query = 'SELECT * FROM DegreeProgram';

            $result = $this->mysqli->execute_query($query);

            foreach($result as $row){
                $degrees[] = [
                    "idCareer" => $row["id"],
                    "description"=>$row["description"]
                ] ;
            }

            return $degrees;
            
        }

        /**
         * author: dorian.contreras@unah.hn
         * version: 0.1.0
         * date: 4/11/24
         */
        public function getProfessorTypes() : array {

            $professorTypes = [];
            $query = 'SELECT * FROM ProfessorType';

            $result = $this->mysqli->execute_query($query);

            foreach($result as $row){
                $professorTypes[] = [
                    "professorTypeId" => $row["id"],
                    "name" => $row["description"]
                ];
            }

            return $professorTypes;
            
        }

        /**
         * author: dorian.contreras@unah.hn
         * version: 0.1.0
         * date: 4/11/24
         */
        public function getCenters() : array {

            $centers = [];
            $query = 'SELECT * FROM RegionalCenter';

            $result = $this->mysqli->execute_query($query);

            foreach($result as $row){
                $centers[] = [
                    "idRegionalCenter" => $row["id"],
                    "description"=>$row["description"]
                ];
            }

            return $centers;
            
        }

        /**
         * author: dorian.contreras@unah.hn
         * version: 0.2.0
         * date: 5/11/24
         */
        public function getDegreesInCenter() : array {

            $centers = $this->getCenters(); 
            $query = "CALL GetDegreeProgramsByRegionalCenter(?);";

            foreach($centers as &$center){
                $careers = [];
                $result = $this->mysqli->execute_query($query, [$center["idRegionalCenter"]]);
                foreach($result as $row){
                    $careers[] = $row["degreeProgramId"];
                }
                
                $center["careers"] = $careers;
    
            }
            

            return $centers;
            
        }

        /**
         * author: dorian.contreras@unah.hn
         * version: 0.1.0
         * date: 6/11/24
         */
        public function getDepartments() : array {

            $professorTypes = [];
            $query = 'SELECT * FROM Department';

            $result = $this->mysqli->execute_query($query);

            foreach($result as $row){
                $professorTypes[] = [
                    "departmentId"=>$row["id"],
                    "name"=>$row["description"]
                ];
            }

            return $professorTypes;
            
        }

        /**
         * author: dorian.contreras@unah.hn
         * version: 0.1.0
         * date: 11/11/24
         */

        public function getAllProcess(int $typeProcess) : array {

            $process = [];
            $query = 'SELECT id, startDate, finalDate FROM AcademicEvent WHERE process=?';

            $result = $this->mysqli->execute_query($query, [$typeProcess]);

            foreach($result as $row){
                $process[] = [
                    "id"=>$row["id"],
                    "start"=>$row["startDate"],
                    "end"=>$row["finalDate"]
                ];
            }

            return $process;  
        }

        /**
         * author: dorian.contreras@unah.hn
         * version: 0.1.0
         * date: 11/11/24
         */

        public function getProcess(int $id) {

            $process = [];
            $query = 'SELECT id, startDate, finalDate FROM AcademicEvent WHERE id=?';

            $result = $this->mysqli->execute_query($query, [$id]);

            foreach($result as $row){
                $process = [
                    "id"=>$row["id"],
                    "start"=>$row["startDate"],
                    "end"=>$row["finalDate"]
                ];
            }

            return $process;  
        }

        /**
         * author: afcastillof@unah.hn
         * version: 0.1.2
         * date: 10/12/24
         */
        public function getCurrentProcess() {
            $query = "SELECT 
                            main.id,
                            main.year,
                            main.process_order
                        FROM (
                            SELECT 
                                id,
                                process,
                                YEAR(startDate) AS year,
                                ROW_NUMBER() OVER(PARTITION BY YEAR(startDate) ORDER BY startDate) AS process_order,
                                active
                            FROM
                                AcademicEvent 
                            WHERE process=1
                        ) AS main
                        WHERE 
                            main.active = 1
                        ORDER BY 
                            main.year;
                        ";
            
            $result = $this->mysqli->execute_query($query);
        
            if ($row = $result->fetch_assoc()) {
                return [
                    "id" => $row["id"],
                    "name" => sprintf("%s proceso, %s", $row["process_order"], $row["year"])
                ];
            }
            
            return null;
        }

        /**
         * author: afcastillof@unah.hn
         * version: 0.1.0
         * date: 12/11/24
         */
        public function getSummaryProcess() {
            $processSummary = [];
            $query = "SELECT 
                        main.id,
                        main.year,
                        main.process_order,
                        COUNT(a.AcademicEvent) AS applications
                    FROM (
                        SELECT 
                            id,
                            process,
                            YEAR(startDate) AS year,
                            ROW_NUMBER() OVER(PARTITION BY YEAR(startDate) ORDER BY startDate) AS process_order,
                            active
                        FROM 
                            AcademicEvent
                    ) AS main
                    INNER JOIN Application AS a
                    ON main.id = a.AcademicEvent
                    WHERE 
                        main.active != 1
                    GROUP BY 
                        main.id, main.year, main.process_order
                    ORDER BY 
                        main.year DESC
                    LIMIT 7;
                    ";
        
            $result = $this->mysqli->execute_query($query);
        
            foreach ($result as $row) {
                $processSummary[] = [
                    "id" => $row["id"],
                    "name" => sprintf("%s %s", $row["process_order"], $row["year"]),
                    "applications" => $row["applications"]
                ];
            }
        
            return $processSummary;
        }

        public function getAllProcessInYears() {
            $allProcess = [];
            $query = "SELECT 
                        main.id,
                        YEAR(main.year) AS year,
                        main.process_order
                        FROM (
                            SELECT 
                                id,
                                process,
                                startDate AS year,
                                ROW_NUMBER() OVER(PARTITION BY YEAR(startDate) ORDER BY startDate) AS process_order,
                                active
                            FROM 
                                AcademicEvent 
                            WHERE process = 1
                        ) AS main
                        INNER JOIN Application AS a
                        ON main.id = a.AcademicEvent
                        WHERE 
                            main.active != 1
                        GROUP BY 
                            main.id, year, main.process_order
                        ORDER BY 
                            year DESC;";
        
            $result = $this->mysqli->execute_query($query);
            $organizedData = [];
        
            foreach ($result as $row) {
                $year = $row["year"];
                $processOrder = $row["process_order"];
                $processId = $row["id"];
                
                if (!isset($organizedData[$year])) {
                    $organizedData[$year] = [
                        "year" => $year,
                        "processes" => []
                    ];
                }
                
                $organizedData[$year]["processes"][] = [
                    "id" => $processId,
                    "title" => sprintf("%s Proceso %s", $processOrder, $year)
                ];
            }
        
            $allProcess = array_values($organizedData);
            
            return $allProcess;
        }

        /**
         * author: dorian.contreras@unah.hn
         * version: 0.1.0
         * date: 09/12/24
         * 
         * Funcion de para obtener los dias
         */
        public function getDays(){
            $days = [];
            $query = 'SELECT * FROM Days';

            $result = $this->mysqli->execute_query($query);

            foreach($result as $row){
                $days[] = [
                    "id"=>$row["id"],
                    "name"=>$row["description"],
                    "amountDays"=> $row['amountDays']
                ];
            }

            return $days;
        }

        /**
         * author: dorian.contreras@unah.hn
         * version: 0.1.0
         * date: 09/12/24
         * 
         * Funcion de para obtener las clases de un departamento, se envia el id del jefe de departamento o cualquier profesor que pertenezca a ese departamentp
         */
        public function getSubjectsDepartment($id){
            $classes = [];
            $query = 'SELECT a.id, a.description, a.uv
                    FROM Subject a
                    INNER JOIN Professor b ON (a.department = b.department)
                    WHERE b.id = ?;';

            $result = $this->mysqli->execute_query($query, [$id]);

            foreach($result as $row){
                $classes[] = [
                    "id"=>$row["id"],
                    "class"=>$row["description"],
                    "uv"=>$row['uv']
                ];
            }

            return $classes;
        }

        /**
         * author: dorian.contreras@unah.hn
         * version: 0.1.0
         * date: 09/12/24
         * 
         * Funcion de para obtener todos los periodos academicos.
         */
        public function getPeriods(){
            $periods = [];

            $query = 'SELECT a.id, CONCAT(b.description, " ", year(startDate)) as name 
                FROM AcademicEvent a
                INNER JOIN AcademicProcess b ON (a.process = b.id)
                WHERE b.id IN (8,9,10)
                ORDER BY startDate DESC';

            $result = $this->mysqli->execute_query($query);

            if($result){
                while($row = $result->fetch_assoc()){
                    $periods[] = $row;
                }
            }

            return $periods;
        }

        // Método para cerrar la conexión
        public function closeConnection() {
            $this->mysqli->close();
        }
        
    }
?>