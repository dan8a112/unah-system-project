<?php

    class SessionValidation{

        static function isValid($session, $user){

            if (isset($session["auth"]) && $session["auth"]==$user) {
                return true;
            }
            return false;
        }
    }