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

    }
?>