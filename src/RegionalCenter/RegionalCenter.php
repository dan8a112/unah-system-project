<?php
    class RegionalCenterDAO{

        public function __construct(string $server, string $user, string $pass, string $dbName) {
            $this->mysqli = new mysqli($server, $user, $pass, $dbName);
        }

        public function getCenters() : array {

            $centers = [];
            $query = 'SELECT description, location FROM RegionalCenter';

            $result = $this->mysqli->execute_query($query);

            foreach($result as $row){
                //Push
                $centers[] = $row["description"];
            }

            echo $centers;

            return $centers;
            
        }
    }
?>