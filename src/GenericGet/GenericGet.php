<?php
    class GenericGetDAO{

        public function __construct(string $server, string $user, string $pass, string $dbName) {
            $this->mysqli = new mysqli($server, $user, $pass, $dbName);
        }

        public function getDegrees() : array {

            $degrees = [];
            $query = 'SELECT * FROM DegreeProgram';

            $result = $this->mysqli->execute_query($query);

            foreach($result as $row){
                $degrees[] = $row["description"];
            }

            return $degrees;
            
        }

        public function getProfessorTypes() : array {

            $professorTypes = [];
            $query = 'SELECT * FROM ProfessorType';

            $result = $this->mysqli->execute_query($query);

            foreach($result as $row){
                $professorTypes[] = $row["description"];
            }

            return $professorTypes;
            
        }

        public function getCenters() : array {

            $centers = [];
            $query = 'SELECT description, location FROM RegionalCenter';

            $result = $this->mysqli->execute_query($query);

            foreach($result as $row){
                $centers[] = $row["description"];
            }

            return $centers;
            
        }

    }
?>