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
        public function sendMail($name, $result, $testsResults, $mail){

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
                proceso de admision realizado recientemente: </p>
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
        public function sendAllMails(){
            $query = 'CALL ResultsActualProcess();';
            $query1 = 'SELECT a.id as idApplication,c.description, b.grade 
                    FROM Application a 
                    INNER JOIN Results b ON (a.id = b.application)
                    INNER JOIN AdmissionTest c ON(b.admissionTest = c.id)
                    WHERE a.id = ?;';

            $result = $this->mysqli->execute_query($query);
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
                $result1 = $this->mysqli->execute_query($query1, [$student["idApplication"]]);
                foreach($result1 as $row){
                    $exams[] = [
                        "idApplication" => $row["idApplication"],
                        "description"=>$row["description"],
                        "grade"=>$row["grade"],
                    ];

                    if ($student["approvedFirstChoice"] && $student["approvedSecondChoice"]) {
                        $bodyGrades = '<strong>Nos complace anunciarle que has aprobado para <strong>AMBAS</strong> de sus opciones.<strong>';
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

                    $sent = $this->sendMail($student['name'], $bodyGrades, $testsResults, $student['personalEmail']);
                    if(!$sent){
                        return false;
                    }
                    $testsResults=" ";
                }
            }

            return true;
        }

        // Método para cerrar la conexión
        public function closeConnection() {
            $this->mysqli->close();
        }

    }
?>
