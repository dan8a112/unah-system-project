<?php
    class ProfessorDAO{

        public function __construct(string $server, string $user, string $pass, string $dbName) {
            $this->mysqli = new mysqli($server, $user, $pass, $dbName);
        }

        /**
         * author: dorian.contreras@unah.hn
         * version: 0.1.0
         * date: 6/11/24
         */
        public function getProfessors() : array {

            $professors = [];
            $query = 'SELECT a.id, a.firstName, a.secondName, a.firstLastName, a.secondLastName, a.personalEmail, a.dni, c.description as professorType
                 FROM Employee a
                 INNER JOIN Professor b
                 ON a.id = b.id
                 INNER JOIN ProfessorType c
                 ON b.professorType = c.id';

            $result = $this->mysqli->execute_query($query);

            foreach($result as $row){
                $professors[] = [
                    "professorId" => $row["id"],
                    "name"=>implode(" ",[$row["firstName"], $row["secondName"], $row["firstLastName"], $row["secondLastName"]]),
                    "email" => $row["personalEmail"],
                    "dni"=>$row["dni"],
                    "professorType" => $row["professorType"]
                ] ;
            }

            return $professors;
            
        }

        /**
         * author: dorian.contreras@unah.hn
         * version: 0.1.0
         * date: 6/11/24
         */
        public function getAmountProfessors() : int {

            $amount = 0;
            $query = 'SELECT COUNT(*) as amount FROM Professor;';

            $result = $this->mysqli->execute_query($query);

            if($result && $row = $result->fetch_assoc()){
                $amount = $row["amount"];
            }

            return $amount;
            
        }

        
    }
?>