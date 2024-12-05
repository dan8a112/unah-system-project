<?php
    header("Content-Type: application/json");

    include_once "../../../../src/SessionValidation/SessionValidation.php";
    
    if (isset($_GET["portal"])) {

        if(SessionValidation::closeSession($_GET["portal"])){
            $json = [
                "message"=> "Se cerró la sesión exitosamente",
                "status"=> true 
            ];
        }else{
            $json = [
                "message"=> "No se pudo cerrar las sesión, intente de nuevo",
                "status"=> false,                
            ];
        }
    }else{
        $json = [
            "message"=> "No se envio el parametro correcto. Debe enviarse un parametro 'Portal' indicando desde donde se hace el cierre de sesion",
            "status"=> false,                
        ];
    }
    
    echo json_encode($json);