<?php
    header("Content-Type: application/json");


    session_start();
    //Se destruye la sesion
    session_destroy();

    //Si el estatus de la sesion es 2 significa que no se destruyó correctamente
    if (session_status()==2) {

        $json = [
            "message"=> "No se pudo cerrar la sesion actual" ,
            "status"=> false
                
        ];
        
    }else{

        $json = [
            "message"=> "Se cerró la sesion actual" ,
            "status"=> true
                
        ];  
    }
    
    
    echo json_encode($json);