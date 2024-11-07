<?php
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

            //hacer validaciones en el if
            if(true){
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
            }else{
                return false;
            }
            
        }

        // Método para cerrar la conexión
        public function closeConnection() {
            $this->mysqli->close();
        }

    }
?>