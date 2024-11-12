<?php


// Configuración del correo

$subject = "Resultado de proceso de admision.";
$from = "noreply@unah.com";

// Variables dinámicas para el mensaje

$mensajePersonalizado = "Este es un mensaje HTML de prueba enviado usando msmtp. Bendiciones.";
$enlace = "https://example.com";
$fecha = date("d/m/Y");

public function sendMail(){

$nombre = "Wilmer Adonay Morales Cantarero";
$to = "wilmer01morales@gmail.com";

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
    <p>Este correo fue enviado el <strong>$date</strong> y contiene un enlace a <a href="$enlace">nuestro sitio web</a>.</p>
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
    echo "Correo enviado correctamente.";
} else {
    echo "Error al enviar el correo: $output";
}

}
?>
