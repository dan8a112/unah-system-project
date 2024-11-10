<?php
    class Validator{

        public static function isPhoneNumber(string $number){
            if(preg_match("/(\(\+504\))?\s*[23789]\d{3}-?\d{4}/", $number)){
                return true;

            }else{
                return false;
            }
        }

        public static function isAccountNumber(string $number){
            if(preg_match("/((19([89]\d))|(2\d\d\d))(1\d\d)(\d{4})/", $number)){
                return true;

            }else{
                return false;
            }
        }
        
        public static function isHondurasIdentityNumber(string $number) {
            // Expresión regular para validar el formato ####-####-##### o ######### (sin guiones)
            if (preg_match("/\d{4}-?\d{4}-?\d{5}/", $number)) {
                return true;
            } else {
                return false;
            }
        }

        public static function isEmail(string $email) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return true;
            } else {
                return false;
            }
        }
        
        
    }


?>