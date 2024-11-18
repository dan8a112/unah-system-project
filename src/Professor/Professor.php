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
            $query = 'SELECT a.id, a.firstName, a.secondName, a.firstLastName, a.secondLastName, a.personalEmail, a.dni, c.description as professorType, b.active
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
                    "professorType" => $row["professorType"],
                    "active"=> $row['active']
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

        /**
         * author: dorian.contreras@unah.hn
         * version: 0.1.0
         * date: 16/11/24
         */
        public function generatePassword($length=10){

            $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_+=<>?';
            $charactersLength = strlen($characters);
            $randomPassword = '';

            // Generar la contraseña
            for ($i = 0; $i < $length; $i++) {
                $randomIndex = random_int(0, $charactersLength - 1); 
                $randomPassword .= $characters[$randomIndex];
            }

            return $randomPassword;
        }

        /**
         * author: dorian.contreras@unah.hn
         * version: 0.1.0
         * date: 16/11/24
         */
        public function setProfessor($dni, $firstName, $secondName, $firstLastName, $secondLastName, $telephoneNumber, $address, $dateOfBirth, $professorType, $department){
            $query= "CALL insertProfessor(?,?,?,?,?,?,?,?,?,?,?,?);";
            $email=strtolower($firstName).'.'.strtolower($firstLastName).'@unah.edu.hn';
            $password= $this->generatePassword();
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            try{
                $result = $this->mysqli->execute_query($query, [$dni, $firstName, $secondName, $firstLastName, $secondLastName, $telephoneNumber,
                    $email, $hashedPassword, $address, $dateOfBirth, $professorType, $department]);
                
                if ($row = $result->fetch_assoc()) {

                    $resultJson = $row['resultJson'];

                    $resultArray = json_decode($resultJson, true);

                    if ($resultArray !== null && $resultArray['status']) {
                        $data = [
                            "id"=>$resultArray['idProfessor'],
                            "name"=>$firstName.' '.$secondName.' '.$firstLastName.' '.$secondLastName,
                            "password"=>$password,
                            "personalEmail"=>$resultArray['personalEmail']

                        ];
                        return [
                            "status" => true,
                            "message" => $resultArray['message'] ,
                            "data"=> $data
                        ];

                    } else {
                        return [
                            "status" => false,
                            "message" => $resultArray['message']
                        ];
                    }

                }else {
                    return ['status'=>false,
                        'message'=> "Error al ejecutar el procedimiento: " . $conexion->error
                    ];
                }
                
            }catch (Exception $e){
                return [
                    "status" => false,
                    "message" => "Error al hacer la consulta".$e
                ];
            }

        }

        /**
         * author: dorian.contreras@unah.hn
         * version: 0.1.0
         * date: 16/11/24
         */
        public function getProfessor($id){
            $query = 'SELECT a.id, a.dni, a.firstName, a.secondName, a.firstLastName, a.secondLastName, a.telephoneNumber, a.address, a.dateOfBirth, a.personalEmail, b.professorType, b.department
                FROM Employee a
                INNER JOIN Professor b 
                ON (a.id = b.id)
                WHERE a.id=?;';

            $result = $this->mysqli->execute_query($query,[$id]);

            foreach($result as $row){
                $professor[] = [
                    "id" => $row["id"],
                    "dni"=>$row["dni"],
                    "firstName"=>$row["firstName"],
                    "secondName"=>$row["secondName"],
                    "firstLastName"=>$row["firstLastName"],
                    "secondLastName"=>$row["secondLastName"],
                    "telephoneNumber"=>$row["telephoneNumber"],
                    "address"=>$row["address"],
                    "dateOfBirth"=>$row["dateOfBirth"],
                    "personalEmail"=>$row["personalEmail"],
                    "department"=>$row["department"],
                    "professorType"=>$row["professorType"],

                ];
            }

            return $professor;
        }

        /**
         * author: dorian.contreras@unah.hn
         * version: 0.1.0
         * date: 16/11/24
         */
        public function updateProfessor($id, $dni, $firstName, $secondName, $firstLastName, $secondLastName, $telephoneNumber, $address, $dateOfBirth, $professorType, $department, $active){
            $query="CALL updateProfessor(?,?,?,?,?,?,?,?,?,?,?,?);";
            
            if($active){
                $bool=1;
            }else{
                $bool=0;
            }

            try{
                $result = $this->mysqli->execute_query($query,[$id, $dni, $firstName, $secondName, $firstLastName, $secondLastName, $telephoneNumber, $address, $dateOfBirth, $professorType, $department, $bool]);
                if ($row = $result->fetch_assoc()) {
    
                    $resultJson = $row['resultJson'];
    
                    $resultArray = json_decode($resultJson, true);
    
                    return $resultArray;
    
                }else {
                    return ['status'=>false,
                            'message'=> "Error al ejecutar el procedimiento: " . $conexion->error
                    ];
                }
            }catch (Exception $e){
                return [
                    "status" => false,
                    "message" => "Error al hacer la consulta".$e
                ];
            }
            
           
        }

        // Método para cerrar la conexión
        public function closeConnection() {
            $this->mysqli->close();
        }
        
    }
?>