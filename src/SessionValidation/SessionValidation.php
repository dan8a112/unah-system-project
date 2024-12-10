<?php
/**
 * author: dochoao@unah.hn
 * version: 0.1.0
 * date: nov 2024
 * 
 * Funcion validar las sesiones activas
 */

    class SessionValidation{

        static function isValid($session, $portalKey){
            
            if (isset($session['portals'][$portalKey]["user"])) {
                return true;
            }
            return false;
        }

        /**
         * Valida si el parametro de la url coincide con el valor en la URL
         */
        static function validateParam($param, $value){

            //Si no existe el parametro, esta vacío o es distinto al de la sesión retorna falso
            if (!isset($_GET[$param]) || empty($_GET[$param]) ||$_GET[$param] != $value){
                return false;
            }
            return true;
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