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
        public function getProfessors($offset) : array {

            $professors = [];
            $query = 'SELECT a.id, a.names, a.lastNames, a.personalEmail, a.dni, c.description as professorType, b.active
                 FROM Employee a
                 INNER JOIN Professor b
                 ON a.id = b.id
                 INNER JOIN ProfessorType c
                 ON b.professorType = c.id
                 LIMIT 10 OFFSET ?';

            $result = $this->mysqli->execute_query($query, [$offset]);

            foreach($result as $row){
                $professors[] = [
                    "professorId" => $row["id"],
                    "name"=>implode(" ",[$row["names"], $row["lastNames"]]),
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
        public function setProfessor($dni, $names, $lastNames, $telephoneNumber, $address, $dateOfBirth, $professorType, $department){
            $namesCapital = mb_convert_case($names, MB_CASE_TITLE, "UTF-8");
            $lastNamesCapital = mb_convert_case($lastNames, MB_CASE_TITLE, "UTF-8");

            if(!Validator::isHondurasIdentityNumber($dni)){
                return [
                    "status" => false,
                    "message" => "EL número de identidad no es válido."
                ];
            }

            if(!Validator::isPhoneNumber($telephoneNumber)){
                return [
                    "status" => false,
                    "message" => "Número de teléfono inválido"
                ];
            }

            if(!Validator::isValidName($namesCapital)){
                return [
                    "status" => false,
                    "message" => "Nombres inválidos. Recuerde no usar números o caracteres especiales."
                ];
            }

            if(!Validator::isValidName($lastNamesCapital)){
                return [
                    "status" => false,
                    "message" => "Apellidos inválidos. Recuerde no usar números o caracteres especiales."
                ];
            }
                 
            $query= "CALL insertProfessor(?,?,?,?,?,?,?,?,?);";
            $password= $this->generatePassword();
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            try{
                $result = $this->mysqli->execute_query($query, [$dni, $namesCapital, $lastNamesCapital, $telephoneNumber, $hashedPassword, $address, $dateOfBirth, $professorType, $department]);
                
                if ($row = $result->fetch_assoc()) {

                    $resultJson = $row['resultJson'];

                    $resultArray = json_decode($resultJson, true);

                    if ($resultArray !== null && $resultArray['status']) {
                        $data = [
                            "id"=>$resultArray['idProfessor'],
                            "name"=>$namesCapital.' '.$lastNamesCapital,
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
            $query = 'SELECT a.id, a.dni, a.names, a.lastNames, a.telephoneNumber, a.address, a.dateOfBirth, a.personalEmail, b.professorType, b.department, b.active
                FROM Employee a
                INNER JOIN Professor b 
                ON (a.id = b.id)
                WHERE a.id=?;';

            $result = $this->mysqli->execute_query($query,[$id]);

            foreach($result as $row){
                $professor = [
                    "id" => $row["id"],
                    "identityNumber"=>$row["dni"],
                    "names"=>$row["names"],
                    "lastNames"=>$row["lastNames"],
                    "phoneNumber"=>$row["telephoneNumber"],
                    "address"=>$row["address"],
                    "birthDate"=>$row["dateOfBirth"],
                    "personalEmail"=>$row["personalEmail"],
                    "departmentId"=>$row["department"],
                    "professorTypeId"=>$row["professorType"],
                    "active"=>$row["active"],
                ];
            }

            return $professor;
        }

        /**
         * author: dorian.contreras@unah.hn
         * version: 0.1.0
         * date: 16/11/24
         */
        public function updateProfessor($id, $dni, $names, $lastNames, $telephoneNumber, $address, $dateOfBirth, $professorType, $department, $active){
            $names = mb_convert_case($names, MB_CASE_TITLE, "UTF-8");
            $lastNames = mb_convert_case($lastNames, MB_CASE_TITLE, "UTF-8");

            if(!Validator::isHondurasIdentityNumber($dni)){
                return [
                    "status" => false,
                    "message" => "EL número de identidad no es válido."
                ];
            }

            if(!Validator::isPhoneNumber($telephoneNumber)){
                return [
                    "status" => false,
                    "message" => "Número de teléfono inválido"
                ];
            }

            if(!Validator::isValidName($names)){
                return [
                    "status" => false,
                    "message" => "Nombres inválidos. Recuerde no usar números o caracteres especiales."
                ];
            }

            if(!Validator::isValidName($lastNames)){
                return [
                    "status" => false,
                    "message" => "Apellidos inválidos. Recuerde no usar números o caracteres especiales."
                ];
            }
            $query="CALL updateProfessor(?,?,?,?,?,?,?,?,?,?);";
            
            if($active){
                $bool=1;
            }else{
                $bool=0;
            }

            try{
                $result = $this->mysqli->execute_query($query,[$id, $dni, $names, $lastNames, $telephoneNumber, $address, $dateOfBirth, $professorType, $department, $bool]);
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

        /**
         * author: dorian.contreras@unah.hn
         * version: 0.1.0
         * date: 03/12/24
         * 
         * Login para los diferentes tipos de docentes
         */
        public function setPassword(int $id, string $newPassword, string $currentPassword){
            //Obtener la informacion del profesor
            $query = "SELECT b.password, a.changePassword
                    FROM Professor a
                    INNER JOIN Employee b ON (a.id = b.id)
                    WHERE a.id=?;";

            $result = $this->mysqli->execute_query($query,[$id]);

            //Validar la nueva contraseña
            if(!Validator::isPassword($newPassword)){
                return [
                    "status"=> false,
                    "message"=> "La contraseña no cumple con los requisitos."
                ];
            }

            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            foreach($result as $row){
                //Validar si es la primera vez que cambia la contraseña
                if($row['changePassword'] == 1){
                    //actualizar nueva contraseña
                    $query1 = "UPDATE Employee
                            SET password=?
                            WHERE id=?";

                    $result1 = $this->mysqli->execute_query($query1,[$hashedPassword, $id]);
                    
                    if($result1){
                        //foreach ($result1 as $row) {
                            $query2 = "UPDATE Professor
                                    SET changePassword=0
                                    WHERE id=?";

                            $result2 = $this->mysqli->execute_query($query2,[$id]);
                            if($result2){
                                return [
                                    "status"=> true,
                                    "message"=> "Contraseña actualizada correctamente."
                                ];
                            }
                        //}

                        return [
                            "status"=> false,
                            "message"=> "Hubo un error al actualizar la contraseña."
                        ];

                    }
                }else{
                    //Validar que la contraseña actual sea la correcta
                    if(password_verify($currentPassword, $row["password"])){

                        //Hacer el update en Professor y Employee
                        $query1 = "UPDATE Employee
                            SET password=?
                            WHERE id=?";

                        $result1 = $this->mysqli->execute_query($query1,[$hashedPassword, $id]);
                        
                        if($result1){
                            //foreach($result1 as $row) {
                                return [
                                    "status"=> true,
                                    "message"=> "Contraseña actualizada correctamente."
                                ];
                                
                            //}
                        }

                        return [
                            "status"=> false,
                            "message"=> "La contraseña actual y la nueva son las mismas."
                        ];

                    }else{
                        return [
                            "status"=> false,
                            "message"=> "La contraseña actual no es la correcta."
                        ];
                    }
                }
            }

            return [
                "status"=> false,
                "message"=> "Error al actualizar la contraseña."
            ];
        }

        // Método para cerrar la conexión
        public function closeConnection() {
            $this->mysqli->close();
        }
        
    }
?>