<?php
    class GenericGetDAO{

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
                $professorTypes[] = $row["description"];
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

    }
?>