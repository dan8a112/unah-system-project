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
                    "message"=> 'Usuario inválido.'
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