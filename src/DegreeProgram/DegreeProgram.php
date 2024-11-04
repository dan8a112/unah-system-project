<?php
    class DegreeProgramDAO{

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
    }
?>