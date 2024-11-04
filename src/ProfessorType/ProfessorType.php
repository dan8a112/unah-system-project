<?php
    class ProfessorTypeDAO{

        public function __construct(string $server, string $user, string $pass, string $dbName) {
            $this->mysqli = new mysqli($server, $user, $pass, $dbName);
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
    }
?>