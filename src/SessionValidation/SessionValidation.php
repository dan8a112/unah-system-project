<?php

    class SessionValidation{

        static function isValid($session, $portalKey){
            
            if (isset($session['portals'][$portalKey]["user"])) {
                return true;
            }
            return false;
        }

        static function closeSession($portalKey){

            session_start();
            //verifica si existe la sesion para ese portal, si es asi, la elimina se la $_SESSION
            if (isset($_SESSION['portals'][$portalKey]["user"])) {
                //Elimina el portal de la lista de portales en la sesion
                unset($_SESSION['portals'][$portalKey]);
                //Retorna true si ya no existe y false si existe
                return !isset($_SESSION['portals'][$portalKey]["user"]);
            }
        }
    }