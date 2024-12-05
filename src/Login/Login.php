<?php

    session_start();

    class LoginDAO{

        public function __construct(string $server, string $user, string $pass, string $dbName) {
            $this->mysqli = new mysqli($server, $user, $pass, $dbName);
        }

        /**
         * author: dorian.contreras@unah.hn
         * version: 0.1.0
         * date: 5/11/24
         */
        public function loginSEDP(string $user, string $password) : bool{

            $query = "SELECT a.personalEmail, a.password 
                    FROM Employee a  
                    INNER JOIN Administrative b
                    ON a.id = b.id
                    WHERE a.personalEmail = ? AND b.administrativeType = 1;";

            try{
                $result = $this->mysqli->execute_query($query, [$user]);
                
                foreach($result as $row){
                    if(password_verify($password, $row["password"])){
                        return true;
                    }
                }

                return false;
                
            }catch (Exception $e){
                return false;
            }
        }

        /**
         * author: dorian.contreras@unah.hn
         * version: 0.1.0
         * date: 12/11/24
         */
        public function loginAdmission(string $user, string $password) : bool{

            $query = "SELECT a.personalEmail, a.password 
                    FROM Employee a  
                    INNER JOIN Administrative b
                    ON a.id = b.id
                    WHERE a.personalEmail = ? AND b.administrativeType = 2;";

            try{
                $result = $this->mysqli->execute_query($query, [$user]);
                
                foreach($result as $row){
                    if(password_verify($password, $row["password"])){
                        return true;
                    }
                }

                return false;
                
            }catch (Exception $e){
                return false;
            }
            
            
        }

        /**
         * author: dorian.contreras@unah.hn
         * version: 0.1.0
         * date: 24/11/24
         */
        public function loginCRI(string $user, string $password) : array{

            $query = "SELECT personalEmail, password, id
                    FROM Reviewer
                    WHERE personalEmail = ? AND active=true";
            
            $query1 = "SELECT a.id 
                    FROM AcademicEvent a
                    INNER JOIN AcademicEvent b ON (a.id = b.parentId)
                    WHERE a.process=1 AND a.active=true AND b.active=true AND b.process=4;";
                    
            $result1 = $this->mysqli->execute_query($query1);

            if ($result1->num_rows > 0) {
                try{
                    $result = $this->mysqli->execute_query($query, [$user]);
                    
                    foreach($result as $row){
                        if(password_verify($password, $row["password"])){
                            return [
                                "status"=> true,
                                "id"=> $row['id'],
                                "message"=> 'Usuario autenticado'
                            ];
                        }
                    }
    
                    return [
                        "status"=> false,
                        "message"=> 'El correo o la contraseña es incorrecto, vuelva a intentarlo.'
                    ];
                    
                }catch (Exception $e){
                    return [
                        "status"=> false,
                        "message"=> 'Ocurrio un error: ' . $e
                    ];
                }
            
            } else {
                return [
                    "status"=> false,
                    "message"=> 'No hay un proceso de revisión de inscripciones activo.'
                ];
            }        
            
        }

        /**
         * author: dorian.contreras@unah.hn
         * version: 0.1.0
         * date: 03/12/24
         * 
         * Login para los diferentes tipos de docentes
         */
        public function loginProfessor(string $user, string $password) : array{

            $query = "SELECT a.id, a.professorType, b.personalEmail, b.password, a.changePassword
                FROM Professor a
                INNER JOIN Employee b ON (a.id = b.id)
                WHERE b.personalEmail = ? AND a.active = true;";
            
            try{
                $result = $this->mysqli->execute_query($query, [$user]);
                
                foreach($result as $row){
                    if(password_verify($password, $row["password"])){
                        return [
                            "status"=> true,
                            "message"=> 'Usuario autenticado',
                            "data"=>[
                                "id"=> $row['id'],
                                "changePassword"=> $row['changePassword']
                            ]
                        ];
                    }
                }
                return [
                    "status"=> false,
                    "message"=> 'El correo o la contraseña es incorrecto, vuelva a intentarlo.'
                ];
                
            }catch (Exception $e){
                return [
                    "status"=> false,
                    "message"=> 'Ocurrio un error: ' . $e
                ];
            }
            
        }
       
        /**
         * author: dorian.contreras@unah.hn
         * version: 0.1.0
         * date: 05/12/24
         * 
         * Login para coordinadores
         */
        public function loginCoordinator(string $user, string $password) : array{

            $query = "SELECT a.id, a.professorType, b.personalEmail, b.password, a.changePassword
                    FROM Professor a
                    INNER JOIN Employee b ON (a.id = b.id)
                    WHERE b.personalEmail = ? AND a.active = true AND a.professorType = 3;";
            
            try{
                $result = $this->mysqli->execute_query($query, [$user]);
                
                foreach($result as $row){
                    if(password_verify($password, $row["password"])){
                        return [
                            "status"=> true,
                            "message"=> 'Usuario autenticado',
                            "data"=>[
                                "id"=> $row['id'],
                                "changePassword"=> $row['changePassword']
                            ]
                        ];
                    }
                }
                return [
                    "status"=> false,
                    "message"=> 'El correo o la contraseña es incorrecto, vuelva a intentarlo.'
                ];
                
            }catch (Exception $e){
                return [
                    "status"=> false,
                    "message"=> 'Ocurrio un error: ' . $e
                ];
            }
            
        }

        // Método para cerrar la conexión
        public function closeConnection() {
            $this->mysqli->close();
        }

    }
?>