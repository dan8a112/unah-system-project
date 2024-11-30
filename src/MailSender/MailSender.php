<?php

    Class MailSenderDAO{

        private $mysqli;

        public function __construct(string $server, string $user, string $pass, string $dbName) {
            $this->mysqli = new mysqli($server, $user, $pass, $dbName);
        }

        /**
         * author: wamorales@unah.hn
         * version: 0.1.0
         * date: 12/11/24
         */
        public function sendMail($name, $result, $testsResults, $mail, $firstChoice, $secondChoice){

            // Configuración del correo
            $subject = "Resultado de proceso de admision.";
            $from = "noreply@unah.com";
            $date = date("d/m/Y");
            $link= "http://3.138.199.65";
            $to = $mail;

            // Crear el contenido del mensaje HTML con encabezados
            $message = <<<EOD
            Subject: $subject
            From: $from
            Reply-To: $from
            MIME-Version: 1.0
            Content-Type: text/html; charset=UTF-8

            <html>
            <head>
                <title>Correo HTML Formateado</title>
            </head>
            <body style="font-family: Arial, sans-serif; color: #333;">
                <h1 style="color: #007BFF;">¡Hola, $name!</h1>
                <p>Por este medio la Direccion de Admisiones de la UNAH le informa sus resultados para el
                proceso de admision realizado recientemente, en el cual usted aplicó para la carrera de <strong>$firstChoice</strong> como su primera opción y la carrera de <strong>$secondChoice</strong> como su segunda opción.</p>
                <p>$result</p>
                $testsResults
                <p>Este correo fue enviado el <strong>$date</strong> y contiene un enlace a <a href="$link">nuestro sitio web</a>.</p>
                <footer>
                    <p style="font-size: 0.9em; color: #555;">Gracias por elegir nuestro servicio.</p>
                </footer>
            </body>
            </html>
            EOD;

            // Guardar el mensaje en un archivo temporal
            $tempFile = tempnam(sys_get_temp_dir(), 'msmtp_email');
            file_put_contents($tempFile, $message);

            // Enviar el correo usando msmtp con el archivo temporal
            $command = "msmtp $to < $tempFile";
            $output = shell_exec($command);

            // Eliminar el archivo temporal
            unlink($tempFile);

            // Confirmación de envío
            if ($output === null) {
                return true;
            } else {
                return false;
            }

        }


        /**
         * author: dorian.contreras@unah.hn
         * version: 0.1.0
         * date: 12/11/24
         */
        public function sendAllMails(int $offset){
            //  Obtener los primeros 500 estudiantes para enviar correos
            $query = 'CALL ResultsActualProcess(?);';
            $result = $this->mysqli->execute_query($query, [$offset]);

            $bodyGrades= '';
            $testsResults='';

            foreach($result as $row){
                $students[] = [
                    "idApplication" => $row["idApplication"],
                    "name"=>$row["name"],
                    "personalEmail"=>$row["personalEmail"],
                    "firstCareer"=>$row["firstCareer"],
                    "secondCareer"=>$row["secondCareer"],
                    "approvedFirstChoice"=>$row["approvedFirstChoice"],
                    "approvedSecondChoice"=>$row["approvedSecondChoice"],
                ] ;
            }

            foreach($students as $student){
                $exams = [];
                // Dar dictamen de los resultados
                $query1 = 'SELECT a.id as idApplication,c.description, b.grade 
                    FROM Application a 
                    INNER JOIN Results b ON (a.id = b.application)
                    INNER JOIN AdmissionTest c ON(b.admissionTest = c.id)
                    WHERE a.id = ?;';
                $result1 = $this->mysqli->execute_query($query1, [$student["idApplication"]]);
                foreach($result1 as $row){
                    if($row["grade"] === NULL){
                        $grade=0;
                    }else{
                        $grade=$row["grade"];
                    }
                    $exams[] = [
                        "idApplication" => $row["idApplication"],
                        "description"=>$row["description"],
                        "grade"=>$grade,
                    ];

                    if ($student["approvedFirstChoice"] && $student["approvedSecondChoice"]) {
                        $bodyGrades = '<strong>Nos complace anunciarle que ha aprobado para <strong>AMBAS</strong> de sus opciones.<strong>';
                    } elseif ($student["approvedFirstChoice"] && !$student["approvedSecondChoice"]) {
                        $bodyGrades = 'Nos complace anunciarle que has aprobado para tu <strong>PRIMERA</strong> opción, pero no has aprobado para tu segunda opción.';
                    } elseif (!$student["approvedFirstChoice"] && $student["approvedSecondChoice"]) {
                        $bodyGrades = 'Nos complace anunciarle que has aprobado para tu <strong>SEGUNDA</strong> opción, pero no has aprobado para tu primera opción.';
                    } else {
                        $bodyGrades = 'Lamentablemente, no has aprobado para <strong>NINGUNA</strong> de tus opciones.';
                    }

                    foreach($exams as $exam){
                        $description = $exam["description"];
                        $grade = $exam["grade"];
                        $testsResults.= "<p>Obteniendo un puntaje de <strong>$grade<strong/> en la <strong>$description</strong>.</p>";
                    };

                    $sent = $this->sendMail($student['name'], $bodyGrades, $testsResults, $student['personalEmail'], $student['firstCareer'], $student['secondCareer']);
                    if(!$sent){
                        return false;
                    }
                    $testsResults=" ";
                }
            }

            return true;
        }

        public function programEmailSend(){

            //Validar que no se hayan enviado los correos
            $query0 = "SELECT active FROM SendedEmail
                    WHERE academicProcess = (SELECT id FROM AcademicEvent WHERE active = true AND process=1);";
            $result0 = $this->mysqli->execute_query($query0);

            if($result0){
                foreach($result0 as $row){
                    if($row['active'] === 0){

                        // Obtener la cantidad total de inscripciones
                        $query2 = "SELECT COUNT(*) as amount FROM Application WHERE 
                            academicEvent = (SELECT id FROM AcademicEvent WHERE active = true AND process=1);";
                        $result2 = $this->mysqli->execute_query($query2);

                        $amount = 0; // Valor predeterminado en caso de que no haya resultados

                        if ($result2) {
                            $row = $result2->fetch_assoc(); // Obtener la fila como un array asociativo
                            $amount = $row['amount']; //COnvertirlo en offset
                            $offset = 0;

                            // Obtener la fecha y hora actual
                            date_default_timezone_set('America/Tegucigalpa');
                            $now = new DateTime();
            
                            // Crear un objeto DateTime para las 1 AM de hoy
                            $today1AM = new DateTime('today 1:00 AM');

                            // Comprobar si la fecha actual es mayor o igual a la 1 AM de hoy
                            if ($now >= $today1AM) {
                                // Si la fecha actual es mayor o igual, obtenemos el día siguiente a las 1 AM
                                $today1AM->modify('+1 day');
                            }
                            // Clonar el objeto DateTime
                            $firstTime = clone $today1AM;
                            $formattedDate = $firstTime->format('Y-m-d H:i:s');
                            
                            // Obtener limite para enviar correos 
                            $limit5AM = clone $today1AM;
                            // Sumar 4 horas al clon
                            $limit5AM->modify('+4 hour');
                            
                            while($amount>0){
                                $dateString = $today1AM->format("H:i Y-m-d");
            
                                // URL del `curl`
                                $url = "http://localhost:3000/api/get/admission/sendMails/?offset=$offset";
            
                                // Comando `curl` a ejecutar
                                $comando = "/usr/bin/curl -X GET '$url'";
            
                                // Programar con `at`
                                exec("echo '$comando' | at $dateString", $output, $returnVar);
            
                                // Verificar el resultado de la ejecución
                                if ($returnVar != 0) {
                                    return [
                                        'status' => false,
                                        'mensaje' => "Error al programar la tarea. Salida: " . implode("\n", $output)
                                    ];
            
                                }else{
                                    if ($today1AM->modify('+1 hour') >= $limit5AM) {
                                        // Si excede las 5 AM, ajustar a las 1 AM del día siguiente
                                        $date = $today1AM->format('Y-m-d');
                                        $today1AM = new DateTime("$date +1 day 1:00 AM");

                                        //nuevo limite
                                        $limit5AM = clone $today1AM;
                                        // Sumar 4 horas al clon
                                        $limit5AM->modify('+4 hour');

                                    }else{
                                        $today1AM->modify('+1 hour');
                                    }
                                    $amount = $amount - 2;
                                    $offset = $offset + 2;
                                }
                            }

                            //Hacer update del active que dice si se enviaron los correos
                            $query = "UPDATE SendedEmail
                                SET active=true, programmingDate =?
                                WHERE academicProcess = (SELECT id FROM AcademicEvent WHERE active = true AND process=1);";
                            $result = $this->mysqli->execute_query($query, [$formattedDate]);
                            if($result){
                                return [
                                    'status'=> true,
                                    'message'=> 'Correos programados correctamente. Empezaran a enviarse a las ' . $formattedDate
                                ];
                            }else{
                                return [
                                    'status' => false,
                                    'mensaje' => "Error al hacer update"
                                ];

                            }
 
                        }
    
                    }else{
                        return [
                            'status' => false,
                            'mensaje' => "Los correos ya fueron programados"
                        ];
                    }

                }
                

            }else{
                return [
                    'status' => false,
                    'mensaje' => "Error al hacer la consulta"
                ]; 
            }
            
        }

        // Método para cerrar la conexión
        public function closeConnection() {
            $this->mysqli->close();
        }

    }
?>
