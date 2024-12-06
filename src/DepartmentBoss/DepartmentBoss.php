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
         * Funcion para paginar el total de secciones de un proceso
         */
        public function getSections(int $idProcess, int $offset){
            $query = 'SELECT a.id as id, LPAD(CAST(a.section AS CHAR), 4, "0") as denomination, b.description as class, a.maximumCapacity as places, 
                    CONCAT(a.startHour, ":00") as hour
                FROM Section a
                INNER JOIN Subject b ON (a.subject = b.id)
                WHERE academicEvent = ?
                ORDER BY b.id ASC
                LIMIT 10 OFFSET ?;';
            $result = $this->mysqli->execute_query($query, [$idProcess, $offset]);
            $sections = [];
            if ($result) {
                while ($row = $result1->fetch_assoc()) {
                    $sections [] = $row;
                }
            } 
            return $sections;
        }

        /**
         * author: dorian.contreras@unah.hn
         * version: 0.1.0
         * date: 5/12/24
         * 
         * Funcion para obtener la información para el home page del jefe de departamento
         */
        public function homeDepartmentBoss(int $id){

        }

        // Método para cerrar la conexión
        public function closeConnection() {
            $this->mysqli->close();
        }
        
    }
?>